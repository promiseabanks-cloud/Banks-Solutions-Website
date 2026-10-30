<?php
/**
 * Project briefs: the form at /start/ posts here, by REST when JavaScript is on and through
 * admin-post.php when it is off. Each brief is saved as a private post, emailed to the studio
 * and acknowledged to the client with a reference number.
 *
 * The form is public, so there is no nonce (page caching would break one, and forging a brief
 * gains an attacker nothing). Spam is handled by a honeypot, a minimum fill time and a per-visitor
 * rate limit.
 *
 * @package Banks_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'banks_brief',
			array(
				'labels'          => array(
					'name'          => 'Briefs',
					'singular_name' => 'Brief',
					'edit_item'     => 'Brief',
					'search_items'  => 'Search briefs',
					'not_found'     => 'No briefs yet',
					'menu_name'     => 'Briefs',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_rest'    => false,
				'menu_position'   => 25,
				'menu_icon'       => 'dashicons-clipboard',
				'supports'        => array( 'title' ),
				'capability_type' => 'post',
				'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
				'map_meta_cap'    => true,
				'rewrite'         => false,
				'query_var'       => false,
			)
		);
	}
);

/**
 * Validate and save one brief.
 *
 * @param array $raw Unslashed request fields.
 * @return array|WP_Error { ref, name } on success.
 */
function banks_core_submit_brief( array $raw ) {
	$opts = banks_core_brief_options();

	// Spam checks first: a filled honeypot, or a form completed faster than a person could.
	if ( ! empty( $raw['banks_hp'] ) ) {
		return new WP_Error( 'spam', 'Something went wrong. Please try again.' );
	}
	$started = isset( $raw['banks_t'] ) ? (int) $raw['banks_t'] : 0;
	if ( $started && time() - $started < 4 ) {
		return new WP_Error( 'too_fast', 'That was quick. Please check your answers and send again.' );
	}
	$limit_key = 'banks_brief_' . md5( banks_core_visitor() . wp_salt( 'nonce' ) );
	$count     = (int) get_transient( $limit_key );
	if ( $count >= 5 ) {
		return new WP_Error( 'rate_limited', 'We have several briefs from you already. Please email us instead.' );
	}

	$text = function ( $key, $max ) use ( $raw ) {
		$v = isset( $raw[ $key ] ) && is_scalar( $raw[ $key ] ) ? sanitize_text_field( (string) $raw[ $key ] ) : '';
		return mb_substr( $v, 0, $max );
	};
	$area = function ( $key, $max ) use ( $raw ) {
		$v = isset( $raw[ $key ] ) && is_scalar( $raw[ $key ] ) ? sanitize_textarea_field( (string) $raw[ $key ] ) : '';
		return mb_substr( $v, 0, $max );
	};
	$pick = function ( $key ) use ( $raw, $opts ) {
		$v = isset( $raw[ $key ] ) && is_scalar( $raw[ $key ] ) ? sanitize_key( (string) $raw[ $key ] ) : '';
		return isset( $opts[ $key ][ $v ] ) ? $v : '';
	};

	// People type a site as plain "banks.com" or "www.banks.com"; add the https:// for them.
	$site = $text( 'website', 200 );
	if ( '' !== $site && ! preg_match( '#^[a-z][a-z0-9+.-]*://#i', $site ) ) {
		$site = 'https://' . ltrim( $site, '/' );
	}

	$needs = isset( $raw['needs'] ) ? array_map( 'sanitize_key', (array) $raw['needs'] ) : array();
	$brief = array(
		'needs'    => array_values( array_intersect( $needs, array_keys( $opts['needs'] ) ) ),
		'business' => $text( 'business', 120 ),
		'industry' => $pick( 'industry' ),
		'website'  => esc_url_raw( $site ),
		'problem'  => $area( 'problem', 4000 ),
		'success'  => $area( 'success', 2000 ),
		'budget'   => $pick( 'budget' ),
		'timeline' => $pick( 'timeline' ),
		'name'     => $text( 'name', 100 ),
		'email'    => sanitize_email( $text( 'email', 200 ) ),
		'phone'    => preg_replace( '/[^0-9+ ()-]/', '', $text( 'phone', 30 ) ),
	);

	$missing = array();
	foreach ( array( 'business', 'industry', 'problem', 'budget', 'timeline', 'name' ) as $k ) {
		if ( '' === $brief[ $k ] ) {
			$missing[] = $k;
		}
	}
	if ( ! $brief['needs'] ) {
		$missing[] = 'needs';
	}
	if ( ! is_email( $brief['email'] ) ) {
		$missing[] = 'email';
	}
	if ( empty( $raw['consent'] ) ) {
		$missing[] = 'consent';
	}
	if ( $missing ) {
		return new WP_Error( 'missing', 'A few answers are missing. Please check the highlighted questions.', array( 'fields' => $missing ) );
	}

	$id = wp_insert_post(
		array(
			'post_type'   => 'banks_brief',
			'post_status' => 'private',
			'post_title'  => $brief['business'] . ' (' . $brief['name'] . ')',
		),
		true
	);
	if ( is_wp_error( $id ) ) {
		return new WP_Error( 'save_failed', 'We could not save your brief. Please email us instead.' );
	}
	$ref = 'BS-' . wp_date( 'ymd' ) . '-' . str_pad( (string) $id, 4, '0', STR_PAD_LEFT );
	update_post_meta( $id, '_banks_brief', $brief );
	update_post_meta( $id, '_banks_brief_ref', $ref );
	update_post_meta( $id, '_banks_brief_email', $brief['email'] );
	update_post_meta( $id, '_banks_brief_status', 'new' );
	set_transient( $limit_key, $count + 1, HOUR_IN_SECONDS );

	banks_core_brief_emails( $id, $ref, $brief );

	/**
	 * Fires after a brief is saved. The portal will hook in here to open a project.
	 *
	 * @param int    $id    Brief post ID.
	 * @param string $ref   Reference shown to the client.
	 * @param array  $brief Clean answers.
	 */
	do_action( 'banks_core_brief_saved', $id, $ref, $brief );

	return array(
		'ref'  => $ref,
		'name' => $brief['name'],
	);
}

/** A rough identity for rate limiting only; never stored. */
function banks_core_visitor() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	return $ip;
}

/** Where studio notifications go: the site's contact email, else the admin email. */
function banks_core_brief_recipient() {
	$to = get_option( 'banks_email' );
	return apply_filters( 'banks_core_brief_recipient', is_email( $to ) ? $to : get_option( 'admin_email' ) );
}

/**
 * The answers as plain-text lines, labels and all.
 *
 * @param array $brief Clean answers.
 * @return string
 */
function banks_core_brief_text( array $brief ) {
	$brief          = wp_parse_args( $brief, array_fill_keys( array( 'business', 'industry', 'website', 'problem', 'success', 'budget', 'timeline', 'name', 'email', 'phone' ), '' ) );
	$brief['needs'] = isset( $brief['needs'] ) ? (array) $brief['needs'] : array();
	$opts           = banks_core_brief_options();
	$label          = function ( $field, $key ) use ( $opts ) {
		return $opts[ $field ][ $key ] ?? '';
	};
	$lines          = array(
		'Needs: ' . implode( ', ', array_map( function ( $k ) use ( $label ) { return $label( 'needs', $k ); }, $brief['needs'] ) ),
		'Business: ' . $brief['business'],
		'Industry: ' . $label( 'industry', $brief['industry'] ),
		'Website: ' . ( $brief['website'] ? $brief['website'] : 'None' ),
		'',
		"What's not working:\n" . $brief['problem'],
		'',
		"What success looks like:\n" . ( $brief['success'] ? $brief['success'] : 'Not given' ),
		'',
		'Budget: ' . $label( 'budget', $brief['budget'] ),
		'Timeline: ' . $label( 'timeline', $brief['timeline'] ),
		'',
		'Name: ' . $brief['name'],
		'Email: ' . $brief['email'],
		'Phone or WhatsApp: ' . ( $brief['phone'] ? $brief['phone'] : 'Not given' ),
	);
	return implode( "\n", $lines );
}

/**
 * Tell the studio, and tell the client we have it.
 *
 * @param int    $id    Brief post ID.
 * @param string $ref   Reference.
 * @param array  $brief Clean answers.
 */
function banks_core_brief_emails( $id, $ref, array $brief ) {
	$studio = banks_core_brief_recipient();
	$link   = admin_url( 'post.php?post=' . $id . '&action=edit' );
	wp_mail(
		$studio,
		'New brief ' . $ref . ': ' . $brief['business'],
		banks_core_brief_text( $brief ) . "\n\nOpen it in the dashboard: " . $link,
		array( 'Reply-To: ' . $brief['name'] . ' <' . $brief['email'] . '>' )
	);
	wp_mail(
		$brief['email'],
		'We have your brief (' . $ref . ')',
		'Hi ' . $brief['name'] . ",\n\n" .
		'Thank you for telling us about ' . $brief['business'] . '. Your reference is ' . $ref . ".\n\n" .
		"Within two working days we'll reply with what we'd build, how long it takes and what it costs. If a smaller fix would do, we'll say so.\n\n" .
		"Here is what you sent:\n\n" . banks_core_brief_text( $brief ) . "\n\n" .
		"Banks Solutions\n" . home_url( '/' ),
		array( 'Reply-To: Banks Solutions <' . $studio . '>' )
	);
}

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'banks/v1',
			'/briefs',
			array(
				'methods'             => 'POST',
				'permission_callback' => '__return_true',
				'callback'            => function ( WP_REST_Request $request ) {
					$result = banks_core_submit_brief( $request->get_params() );
					if ( is_wp_error( $result ) ) {
						$data = $result->get_error_data();
						return new WP_REST_Response(
							array(
								'code'    => $result->get_error_code(),
								'message' => $result->get_error_message(),
								'fields'  => is_array( $data ) && isset( $data['fields'] ) ? $data['fields'] : array(),
							),
							'missing' === $result->get_error_code() ? 400 : 422
						);
					}
					return new WP_REST_Response( $result, 201 );
				},
			)
		);
	}
);

/** Without JavaScript the form posts here, then the visitor lands back on /start/. */
function banks_core_brief_post() {
	$raw    = wp_unslash( $_POST ); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- public form, see the note at the top of this file.
	$back   = wp_validate_redirect( isset( $raw['banks_return'] ) ? esc_url_raw( (string) $raw['banks_return'] ) : '', home_url( '/start/' ) );
	$result = banks_core_submit_brief( $raw );
	$back   = is_wp_error( $result ) ? add_query_arg( 'brief_error', $result->get_error_code(), $back ) : add_query_arg( 'brief', rawurlencode( $result['ref'] ), $back );
	wp_safe_redirect( $back . '#brief', 303 );
	exit;
}
add_action( 'admin_post_nopriv_banks_brief', 'banks_core_brief_post' );
add_action( 'admin_post_banks_brief', 'banks_core_brief_post' );
