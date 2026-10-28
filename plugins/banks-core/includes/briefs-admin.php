<?php
/**
 * Briefs in the dashboard: a list with the essentials, and each brief shown in full with a
 * status the studio can move along.
 *
 * @package Banks_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** The stages a brief moves through. */
function banks_core_brief_statuses() {
	return array(
		'new'      => 'New',
		'replied'  => 'Replied',
		'proposal' => 'Proposal sent',
		'won'      => 'Won',
		'not-fit'  => 'Not a fit',
	);
}

add_filter(
	'manage_banks_brief_posts_columns',
	function () {
		return array(
			'cb'           => '<input type="checkbox">',
			'title'        => 'Business',
			'banks_ref'    => 'Reference',
			'banks_needs'  => 'Needs',
			'banks_budget' => 'Budget',
			'banks_status' => 'Status',
			'date'         => 'Received',
		);
	}
);

add_action(
	'manage_banks_brief_posts_custom_column',
	function ( $column, $id ) {
		$brief = (array) get_post_meta( $id, '_banks_brief', true );
		$opts  = banks_core_brief_options();
		switch ( $column ) {
			case 'banks_ref':
				echo esc_html( get_post_meta( $id, '_banks_brief_ref', true ) );
				break;
			case 'banks_needs':
				$needs = isset( $brief['needs'] ) ? (array) $brief['needs'] : array();
				echo esc_html( implode( ', ', array_filter( array_map( function ( $k ) use ( $opts ) { return $opts['needs'][ $k ] ?? ''; }, $needs ) ) ) );
				break;
			case 'banks_budget':
				echo esc_html( $opts['budget'][ $brief['budget'] ?? '' ] ?? '' );
				break;
			case 'banks_status':
				$all = banks_core_brief_statuses();
				echo esc_html( $all[ get_post_meta( $id, '_banks_brief_status', true ) ] ?? 'New' );
				break;
		}
	},
	10,
	2
);

add_action(
	'add_meta_boxes_banks_brief',
	function () {
		remove_meta_box( 'submitdiv', 'banks_brief', 'side' );
		add_meta_box( 'banks_brief_answers', 'The brief', 'banks_core_brief_box', 'banks_brief', 'normal', 'high' );
		add_meta_box( 'banks_brief_status', 'Status', 'banks_core_brief_status_box', 'banks_brief', 'side', 'high' );
	}
);

/**
 * Every answer, read-only.
 *
 * @param WP_Post $post The brief.
 */
function banks_core_brief_box( $post ) {
	$brief = (array) get_post_meta( $post->ID, '_banks_brief', true );
	echo '<p><strong>' . esc_html( get_post_meta( $post->ID, '_banks_brief_ref', true ) ) . '</strong> · ' . esc_html( get_the_date( 'j F Y, g:i a', $post ) ) . '</p>';
	echo '<pre style="white-space:pre-wrap;font:14px/1.6 -apple-system,BlinkMacSystemFont,sans-serif;margin:0">' . esc_html( banks_core_brief_text( $brief ) ) . '</pre>';
	if ( ! empty( $brief['email'] ) ) {
		$ref = get_post_meta( $post->ID, '_banks_brief_ref', true );
		echo '<p><a class="button button-primary" href="' . esc_url( 'mailto:' . $brief['email'] . '?subject=' . rawurlencode( 'Your brief (' . $ref . ')' ) ) . '">Reply by email</a></p>';
	}
}

/**
 * Status picker and save button.
 *
 * @param WP_Post $post The brief.
 */
function banks_core_brief_status_box( $post ) {
	wp_nonce_field( 'banks_brief_status', 'banks_brief_status_nonce' );
	$now = get_post_meta( $post->ID, '_banks_brief_status', true );
	echo '<select name="banks_brief_status" style="width:100%">';
	foreach ( banks_core_brief_statuses() as $k => $label ) {
		echo '<option value="' . esc_attr( $k ) . '"' . selected( $now, $k, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select><p><button class="button button-primary" type="submit">Save status</button></p>';
}

add_action(
	'save_post_banks_brief',
	function ( $id ) {
		if ( ! isset( $_POST['banks_brief_status_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['banks_brief_status_nonce'] ) ), 'banks_brief_status' ) || ! current_user_can( 'edit_post', $id ) ) {
			return;
		}
		$status = isset( $_POST['banks_brief_status'] ) ? sanitize_key( wp_unslash( $_POST['banks_brief_status'] ) ) : '';
		if ( isset( banks_core_brief_statuses()[ $status ] ) ) {
			update_post_meta( $id, '_banks_brief_status', $status );
		}
	}
);

/** Saving from the status box must not publish the brief; it stays private. */
add_filter(
	'wp_insert_post_data',
	function ( $data ) {
		if ( 'banks_brief' === $data['post_type'] && 'trash' !== $data['post_status'] ) {
			$data['post_status'] = 'private';
		}
		return $data;
	}
);
