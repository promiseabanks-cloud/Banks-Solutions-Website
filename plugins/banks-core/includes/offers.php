<?php
/**
 * Offer leads: the form on /offer/ posts here (REST with JavaScript, admin-post without).
 * Each lead is a private post. The studio and the lead are emailed straight away; the lead is
 * asked to confirm ("Yes, start my website"), and unconfirmed leads get two follow-up emails.
 * A confirmed lead gets the deposit instructions. WhatsApp can hook into the same events later.
 *
 * Settings (options): banks_offer_ends (e.g. 2026-12-31 23:59:00, Lagos time),
 * banks_offer_deposit_link (Paystack payment link for the deposit), banks_offer_slots (optional).
 *
 * @package Banks_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** When the offer ends, as a timestamp. */
function banks_core_offer_ends() {
	$raw = get_option( 'banks_offer_ends', '2026-12-31 23:59:00' );
	$dt  = date_create( (string) $raw, new DateTimeZone( 'Africa/Lagos' ) );
	return $dt ? $dt->getTimestamp() : 0;
}

/** True while the offer is running. */
function banks_core_offer_active() {
	return time() < banks_core_offer_ends();
}

add_action(
	'init',
	function () {
		register_post_type(
			'banks_offer_lead',
			array(
				'labels'          => array(
					'name'          => 'Offer leads',
					'singular_name' => 'Offer lead',
					'edit_item'     => 'Offer lead',
					'not_found'     => 'No offer leads yet',
					'menu_name'     => 'Offer leads',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_rest'    => false,
				'menu_position'   => 26,
				'menu_icon'       => 'dashicons-megaphone',
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

/** Status column in the dashboard list. */
add_filter(
	'manage_banks_offer_lead_posts_columns',
	function ( $cols ) {
		return array(
			'cb'       => $cols['cb'],
			'title'    => 'Lead',
			'status_b' => 'Status',
			'phone'    => 'WhatsApp',
			'email_b'  => 'Email',
			'date'     => 'Date',
		);
	}
);
add_action(
	'manage_banks_offer_lead_posts_custom_column',
	function ( $col, $id ) {
		$lead = get_post_meta( $id, '_banks_offer_lead', true );
		if ( 'status_b' === $col ) {
			echo esc_html( (string) get_post_meta( $id, '_banks_offer_status', true ) );
		} elseif ( 'phone' === $col ) {
			echo esc_html( is_array( $lead ) ? $lead['phone'] : '' );
		} elseif ( 'email_b' === $col ) {
			echo esc_html( is_array( $lead ) ? $lead['email'] : '' );
		}
	},
	10,
	2
);

/**
 * Validate and save one lead.
 *
 * @param array $raw Unslashed request fields.
 * @return array|WP_Error
 */
function banks_core_submit_offer( array $raw ) {
	if ( ! banks_core_offer_active() ) {
		return new WP_Error( 'ended', 'This offer has ended. Send us a brief and we will quote you.' );
	}
	if ( ! empty( $raw['banks_hp'] ) ) {
		return new WP_Error( 'spam', 'Something went wrong. Please try again.' );
	}
	$started = isset( $raw['banks_t'] ) ? (int) $raw['banks_t'] : 0;
	if ( $started && time() - $started < 3 ) {
		return new WP_Error( 'too_fast', 'That was quick. Please check your details and send again.' );
	}
	$limit_key = 'banks_offer_' . md5( banks_core_visitor() . wp_salt( 'nonce' ) );
	$count     = (int) get_transient( $limit_key );
	if ( $count >= 4 ) {
		return new WP_Error( 'rate_limited', 'We have several requests from you already. Please email us instead.' );
	}

	$text = function ( $key, $max ) use ( $raw ) {
		$v = isset( $raw[ $key ] ) && is_scalar( $raw[ $key ] ) ? sanitize_text_field( (string) $raw[ $key ] ) : '';
		return mb_substr( $v, 0, $max );
	};
	$lead = array(
		'name'     => $text( 'name', 100 ),
		'phone'    => preg_replace( '/[^0-9+ ()-]/', '', $text( 'phone', 30 ) ),
		'email'    => sanitize_email( $text( 'email', 200 ) ),
		'business' => $text( 'business', 160 ),
		'plan'     => in_array( $text( 'plan', 20 ), array( 'starter', 'growth', 'max' ), true ) ? $text( 'plan', 20 ) : 'starter',
	);
	$missing = array();
	foreach ( array( 'name', 'business' ) as $k ) {
		if ( '' === $lead[ $k ] ) {
			$missing[] = $k;
		}
	}
	if ( strlen( preg_replace( '/\D/', '', $lead['phone'] ) ) < 8 ) {
		$missing[] = 'phone';
	}
	if ( ! is_email( $lead['email'] ) ) {
		$missing[] = 'email';
	}
	if ( empty( $raw['consent'] ) ) {
		$missing[] = 'consent';
	}
	if ( $missing ) {
		return new WP_Error( 'missing', 'A few details are missing. Please check the highlighted fields.', array( 'fields' => $missing ) );
	}

	$id = wp_insert_post(
		array(
			'post_type'   => 'banks_offer_lead',
			'post_status' => 'private',
			'post_title'  => $lead['name'] . ' (' . $lead['business'] . ')',
		),
		true
	);
	if ( is_wp_error( $id ) ) {
		return new WP_Error( 'save_failed', 'We could not save your details. Please email us instead.' );
	}
	$token = wp_generate_password( 24, false );
	update_post_meta( $id, '_banks_offer_lead', $lead );
	update_post_meta( $id, '_banks_offer_token', $token );
	update_post_meta( $id, '_banks_offer_email', strtolower( $lead['email'] ) );
	update_post_meta( $id, '_banks_offer_status', 'new' );
	set_transient( $limit_key, $count + 1, HOUR_IN_SECONDS );

	banks_core_offer_emails_new( $id, $lead, $token );
	wp_schedule_single_event( time() + DAY_IN_SECONDS, 'banks_core_offer_followup', array( $id, 1 ) );
	wp_schedule_single_event( time() + 3 * DAY_IN_SECONDS, 'banks_core_offer_followup', array( $id, 2 ) );
	// The offer ending soon is a reason to act: one last reminder the day before it closes.
	$last = banks_core_offer_ends() - DAY_IN_SECONDS;
	if ( $last > time() + 4 * DAY_IN_SECONDS ) {
		wp_schedule_single_event( $last, 'banks_core_offer_followup', array( $id, 3 ) );
	}

	/**
	 * Fires after a lead is saved. WhatsApp automation hooks in here.
	 *
	 * @param int   $id   Lead post ID.
	 * @param array $lead Clean details.
	 */
	do_action( 'banks_core_offer_lead_saved', $id, $lead );

	return array( 'name' => $lead['name'] );
}

/** The link a lead clicks to say "Yes, start my website". */
function banks_core_offer_link( $token, $action = 'confirm' ) {
	return add_query_arg( 'offer_' . $action, rawurlencode( $token ), home_url( '/offer/' ) );
}

function banks_core_offer_footer( $token ) {
	return "\n\nBanks Solutions\n" . home_url( '/' ) . "\nNot interested? Tell us here and we will stop: " . banks_core_offer_link( $token, 'stop' );
}

function banks_core_offer_emails_new( $id, array $lead, $token ) {
	$studio = banks_core_brief_recipient();
	wp_mail(
		$studio,
		'New offer lead: ' . $lead['name'] . ' (' . $lead['business'] . ')',
		"Plan: " . $lead['plan'] . "\nName: " . $lead['name'] . "\nWhatsApp: " . $lead['phone'] . "\nEmail: " . $lead['email'] . "\nBusiness: " . $lead['business'] . "\n\nOpen it: " . admin_url( 'post.php?post=' . $id . '&action=edit' ),
		array( 'Reply-To: ' . $lead['name'] . ' <' . $lead['email'] . '>' )
	);
	wp_mail(
		$lead['email'],
		'Your website offer: one click to start',
		'Hi ' . $lead['name'] . ",\n\n" .
		"Thanks for your interest in the year-end website offer for " . $lead['business'] . ".\n\n" .
		"Are you ready to start now? Click here to confirm and we will send your deposit details and open your project:\n" .
		banks_core_offer_link( $token ) . "\n\n" .
		"You pay nothing until you confirm. The deposit is \u{20A6}50,000 and you pay the rest only when you are happy with the website. The offer ends " . wp_date( 'j F Y', banks_core_offer_ends() ) . '.' .
		banks_core_offer_footer( $token ),
		array( 'Reply-To: Banks Solutions <' . $studio . '>' )
	);
}

/** Two follow-ups for leads who have not confirmed, plus the last-day reminder. */
add_action(
	'banks_core_offer_followup',
	function ( $id, $step ) {
		$status = get_post_meta( $id, '_banks_offer_status', true );
		$lead   = get_post_meta( $id, '_banks_offer_lead', true );
		$token  = get_post_meta( $id, '_banks_offer_token', true );
		if ( 'new' !== $status || ! is_array( $lead ) || ! $token || ! banks_core_offer_active() ) {
			return;
		}
		$studio = banks_core_brief_recipient();
		$copy   = array(
			1 => array( 'Still thinking about your website, ' . $lead['name'] . '?', "Most people have the same three questions: will it work for my business, why is it priced like this, and how long will it take. The short answers are on the offer page, and you can reply to this email with any other question.\n\nReady? Confirm here and we will start:\n" ),
			2 => array( 'Your website slot, ' . $lead['name'], "Just checking in. If you would like us to build the website for " . $lead['business'] . " at the offer price, confirm here and we will send the deposit details:\n" ),
			3 => array( 'The website offer ends tomorrow', 'The year-end offer closes tomorrow. If you want your website at the offer price, confirm here today:' . "\n" ),
		);
		if ( ! isset( $copy[ $step ] ) ) {
			return;
		}
		wp_mail(
			$lead['email'],
			$copy[ $step ][0],
			'Hi ' . $lead['name'] . ",\n\n" . $copy[ $step ][1] . banks_core_offer_link( $token ) . banks_core_offer_footer( $token ),
			array( 'Reply-To: Banks Solutions <' . $studio . '>' )
		);
	},
	10,
	2
);

/** Confirm and stop links, handled before the page renders. */
add_action(
	'template_redirect',
	function () {
		$confirm = isset( $_GET['offer_confirm'] ) ? sanitize_text_field( wp_unslash( $_GET['offer_confirm'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- the token is the credential.
		$stop    = isset( $_GET['offer_stop'] ) ? sanitize_text_field( wp_unslash( $_GET['offer_stop'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$token   = $confirm ? $confirm : $stop;
		if ( ! $token || ! preg_match( '/^[A-Za-z0-9]{24}$/', $token ) ) {
			return;
		}
		$found = get_posts(
			array(
				'post_type'      => 'banks_offer_lead',
				'post_status'    => 'private',
				'meta_key'       => '_banks_offer_token', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'     => $token, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		$back = home_url( '/offer/' );
		if ( ! $found ) {
			wp_safe_redirect( $back, 302 );
			exit;
		}
		$id   = (int) $found[0];
		$lead = get_post_meta( $id, '_banks_offer_lead', true );
		if ( $stop ) {
			update_post_meta( $id, '_banks_offer_status', 'stopped' );
			wp_safe_redirect( add_query_arg( 'offer_state', 'stopped', $back ), 302 );
			exit;
		}
		if ( 'confirmed' !== get_post_meta( $id, '_banks_offer_status', true ) && is_array( $lead ) ) {
			update_post_meta( $id, '_banks_offer_status', 'confirmed' );
			update_post_meta( $id, '_banks_offer_confirmed_at', time() );
			$link   = get_option( 'banks_offer_deposit_link', '' );
			$studio = banks_core_brief_recipient();
			wp_mail(
				$lead['email'],
				'You are in: your deposit details',
				'Hi ' . $lead['name'] . ",\n\n" .
				"Thank you. Your place is reserved for " . $lead['business'] . ".\n\n" .
				( $link ? "Pay the \u{20A6}50,000 deposit here:\n" . $link . "\n\n" : "A member of the team will send your \u{20A6}50,000 deposit link within the hour.\n\n" ) .
				"Once the deposit is in, we send a short form for your business details, logo, colours and photos. Your build starts when we have them, and takes 5 to 7 working days for the Starter website.\n\n" .
				'You pay the rest only when you are happy with the website.' .
				"\n\nBanks Solutions\n" . home_url( '/' ),
				array( 'Reply-To: Banks Solutions <' . $studio . '>' )
			);
			wp_mail( $studio, 'CONFIRMED: ' . $lead['name'] . ' (' . $lead['business'] . ')', "They said yes. Send the deposit link if it was not automatic.\n\nWhatsApp: " . $lead['phone'] . "\nEmail: " . $lead['email'] . "\n\n" . admin_url( 'post.php?post=' . $id . '&action=edit' ) );
			do_action( 'banks_core_offer_confirmed', $id, $lead );
		}
		wp_safe_redirect( add_query_arg( 'offer_state', 'confirmed', $back ), 302 );
		exit;
	},
	1
);

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'banks/v1',
			'/offer',
			array(
				'methods'             => 'POST',
				'permission_callback' => '__return_true',
				'callback'            => function ( WP_REST_Request $request ) {
					$result = banks_core_submit_offer( $request->get_params() );
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

/** Without JavaScript the form posts here, then the visitor lands back on /offer/. */
function banks_core_offer_post() {
	$raw    = wp_unslash( $_POST ); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- public form, see briefs.php.
	$back   = home_url( '/offer/' );
	$result = banks_core_submit_offer( $raw );
	$back   = is_wp_error( $result ) ? add_query_arg( 'offer_state', 'error-' . $result->get_error_code(), $back ) : add_query_arg( 'offer_state', 'sent', $back );
	wp_safe_redirect( $back . '#start', 303 );
	exit;
}
add_action( 'admin_post_nopriv_banks_offer', 'banks_core_offer_post' );
add_action( 'admin_post_banks_offer', 'banks_core_offer_post' );

/*
 * Paystack: the deposit. Paystack calls this URL when a payment succeeds; we check the signature
 * with the secret key (option banks_paystack_secret, set under Offer leads > Payments), match the
 * payer's email to a lead and mark the deposit paid.
 */
add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'banks/v1',
			'/paystack',
			array(
				'methods'             => 'POST',
				'permission_callback' => '__return_true',
				'callback'            => 'banks_core_paystack_webhook',
			)
		);
	}
);

function banks_core_paystack_webhook( WP_REST_Request $request ) {
	$secret = (string) get_option( 'banks_paystack_secret', '' );
	$body   = $request->get_body();
	$sig    = (string) $request->get_header( 'x-paystack-signature' );
	if ( '' === $secret || '' === $sig || ! hash_equals( hash_hmac( 'sha512', $body, $secret ), $sig ) ) {
		return new WP_REST_Response( array( 'ok' => false ), 401 );
	}
	$event = json_decode( $body, true );
	if ( ! is_array( $event ) || 'charge.success' !== ( $event['event'] ?? '' ) ) {
		return new WP_REST_Response( array( 'ok' => true ), 200 );
	}
	$data   = isset( $event['data'] ) && is_array( $event['data'] ) ? $event['data'] : array();
	$email  = strtolower( sanitize_email( $data['customer']['email'] ?? '' ) );
	$amount = (int) ( $data['amount'] ?? 0 ); // Kobo.
	$ref    = sanitize_text_field( (string) ( $data['reference'] ?? '' ) );
	$studio = banks_core_brief_recipient();
	$found  = $email ? get_posts(
		array(
			'post_type'      => 'banks_offer_lead',
			'post_status'    => 'private',
			'meta_key'       => '_banks_offer_email', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'     => $email, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			'posts_per_page' => 1,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'fields'         => 'ids',
		)
	) : array();
	if ( ! $found ) {
		wp_mail( $studio, 'Paystack payment with no matching lead', "A payment arrived that matches no offer lead.\n\nEmail: $email\nAmount: " . ( $amount / 100 ) . "\nReference: $ref" );
		return new WP_REST_Response( array( 'ok' => true ), 200 );
	}
	$id = (int) $found[0];
	if ( 'paid' === get_post_meta( $id, '_banks_offer_status', true ) || get_post_meta( $id, '_banks_offer_paystack_ref', true ) === $ref ) {
		return new WP_REST_Response( array( 'ok' => true ), 200 ); // Paystack retries; do it once.
	}
	$lead = get_post_meta( $id, '_banks_offer_lead', true );
	update_post_meta( $id, '_banks_offer_status', 'paid' );
	update_post_meta( $id, '_banks_offer_paystack_ref', $ref );
	update_post_meta( $id, '_banks_offer_paid_amount', $amount / 100 );
	update_post_meta( $id, '_banks_offer_paid_at', time() );
	if ( is_array( $lead ) ) {
		$short = $amount < 5000000 ? "\n\nNote: this is less than the \u{20A6}50,000 deposit, so we will confirm the balance with you." : '';
		wp_mail(
			$lead['email'],
			'Deposit received: let\'s build your website',
			'Hi ' . $lead['name'] . ",\n\nWe have received your deposit of \u{20A6}" . number_format( $amount / 100 ) . ". Thank you.\n\n" .
			"Next, reply to this email with your business details, logo, colours and photos. If you do not have all of them yet, send what you have and we will guide you. Your build starts as soon as we have them.\n\n" .
			'You pay the rest only when you are happy with the website.' . $short . "\n\nBanks Solutions\n" . home_url( '/' ),
			array( 'Reply-To: Banks Solutions <' . $studio . '>' )
		);
		wp_mail( $studio, 'DEPOSIT PAID: ' . $lead['name'] . ' (' . $lead['business'] . ')', "Amount: \u{20A6}" . number_format( $amount / 100 ) . "\nReference: $ref\nWhatsApp: " . $lead['phone'] . "\nEmail: " . $lead['email'] . "\n\n" . admin_url( 'post.php?post=' . $id . '&action=edit' ) );
		do_action( 'banks_core_offer_paid', $id, $lead, $amount / 100 );
	}
	return new WP_REST_Response( array( 'ok' => true ), 200 );
}

/** Offer leads > Payments: where the secret key and the deposit link are pasted. */
add_action(
	'admin_menu',
	function () {
		add_submenu_page( 'edit.php?post_type=banks_offer_lead', 'Payments', 'Payments', 'manage_options', 'banks-offer-payments', 'banks_core_offer_payments_page' );
	}
);
function banks_core_offer_payments_page() {
	if ( isset( $_POST['banks_pay_save'] ) && check_admin_referer( 'banks_pay' ) && current_user_can( 'manage_options' ) ) {
		$new = isset( $_POST['banks_paystack_secret'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['banks_paystack_secret'] ) ) ) : '';
		if ( '' !== $new ) {
			update_option( 'banks_paystack_secret', $new, false );
		}
		update_option( 'banks_offer_deposit_link', isset( $_POST['banks_offer_deposit_link'] ) ? esc_url_raw( wp_unslash( $_POST['banks_offer_deposit_link'] ) ) : '', false );
		echo '<div class="updated"><p>Saved.</p></div>';
	}
	$has = '' !== (string) get_option( 'banks_paystack_secret', '' );
	?>
	<div class="wrap">
		<h1>Offer payments</h1>
		<form method="post">
			<?php wp_nonce_field( 'banks_pay' ); ?>
			<table class="form-table">
				<tr><th>Webhook URL (paste into Paystack)</th><td><code><?php echo esc_html( rest_url( 'banks/v1/paystack' ) ); ?></code></td></tr>
				<tr><th><label for="s">Paystack secret key</label></th><td><input id="s" type="password" name="banks_paystack_secret" class="regular-text" autocomplete="off" placeholder="<?php echo $has ? 'Saved. Paste a new one to replace it' : 'sk_live_...'; ?>"></td></tr>
				<tr><th><label for="d">Deposit payment link</label></th><td><input id="d" type="url" name="banks_offer_deposit_link" class="regular-text" value="<?php echo esc_attr( get_option( 'banks_offer_deposit_link', '' ) ); ?>"><p class="description">The ₦50,000 Paystack payment page link emailed to people who say yes.</p></td></tr>
			</table>
			<p><button class="button button-primary" name="banks_pay_save" value="1">Save</button></p>
		</form>
	</div>
	<?php
}
