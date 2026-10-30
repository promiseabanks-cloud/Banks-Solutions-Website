<?php
/**
 * Work: the portfolio shown at /work/ and the case study at /work/<project>/. Each project is a
 * post with its live address, field, what was built, and the recordings that play inside the
 * device frames. The theme reads projects through banks_core_work_items() and never stores them.
 *
 * Recordings: one desktop and one phone MP4 per project, 20 to 30 seconds of a slow scroll, about
 * 1 to 2 MB each, with a poster frame (the first frame, as a JPG or WebP) for each.
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
			'banks_work',
			array(
				'labels'          => array(
					'name'          => 'Work',
					'singular_name' => 'Project',
					'add_new_item'  => 'Add project',
					'edit_item'     => 'Edit project',
					'search_items'  => 'Search projects',
					'not_found'     => 'No projects yet',
					'menu_name'     => 'Work',
				),
				'public'          => true,
				'show_in_rest'    => true,
				'menu_position'   => 24,
				'menu_icon'       => 'dashicons-portfolio',
				'supports'        => array( 'title', 'editor', 'excerpt', 'page-attributes' ),
				'has_archive'     => false,
				'rewrite'         => array(
					'slug'       => 'work',
					'with_front' => false,
				),
				'capability_type' => 'post',
			)
		);
	}
);

/** The fields kept for each project, with their labels in the dashboard. */
function banks_core_work_fields() {
	return array(
		'url'          => 'Live address',
		'industry'     => 'Field',
		'built'        => 'What we built',
		'platform'     => 'Platform',
		'year'         => 'Year',
		'place'        => 'Where they are',
		'result'       => 'The result, in one line',
		'video'        => 'Desktop recording (MP4)',
		'poster'       => 'Desktop poster frame',
		'video_phone'  => 'Phone recording (MP4)',
		'poster_phone' => 'Phone poster frame',
	);
}

/**
 * One project, ready for a template.
 *
 * @param WP_Post|int $post Project.
 * @return array
 */
function banks_core_work_item( $post ) {
	$post = get_post( $post );
	$meta = wp_parse_args( (array) get_post_meta( $post->ID, '_banks_work', true ), array_fill_keys( array_keys( banks_core_work_fields() ), '' ) );
	$host = $meta['url'] ? wp_parse_url( $meta['url'], PHP_URL_HOST ) : '';

	return array_merge(
		$meta,
		array(
			'id'      => $post->ID,
			'slug'    => $post->post_name,
			'title'   => get_the_title( $post ),
			'excerpt' => has_excerpt( $post ) ? get_the_excerpt( $post ) : '',
			'link'    => get_permalink( $post ),
			'domain'  => $host ? preg_replace( '/^www\./', '', $host ) : '',
		)
	);
}

/**
 * Every published project, in the order set in the dashboard.
 *
 * @return array[]
 */
function banks_core_work_items() {
	$posts = get_posts(
		array(
			'post_type'      => 'banks_work',
			'post_status'    => 'publish',
			'posts_per_page' => 60,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
			'no_found_rows'  => true,
		)
	);
	return array_map( 'banks_core_work_item', $posts );
}

add_action(
	'add_meta_boxes_banks_work',
	function () {
		add_meta_box( 'banks_work_details', 'Project details', 'banks_core_work_box', 'banks_work', 'normal', 'high' );
	}
);

/**
 * The details box: plain fields, with a media picker beside each recording and poster.
 *
 * @param WP_Post $post Project.
 */
function banks_core_work_box( $post ) {
	$item  = banks_core_work_item( $post );
	$media = array( 'video', 'poster', 'video_phone', 'poster_phone' );
	wp_nonce_field( 'banks_work_save', 'banks_work_nonce' );
	echo '<p>The excerpt is the line shown under the project on /work/. The main text is the case study.</p>';
	echo '<table class="form-table" role="presentation">';
	foreach ( banks_core_work_fields() as $key => $label ) {
		$id = 'banks_work_' . $key;
		echo '<tr><th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label></th><td>';
		echo '<input type="' . ( in_array( $key, array( 'url', 'video', 'poster', 'video_phone', 'poster_phone' ), true ) ? 'url' : 'text' ) . '" class="large-text" id="' . esc_attr( $id ) . '" name="banks_work[' . esc_attr( $key ) . ']" value="' . esc_attr( $item[ $key ] ) . '">';
		if ( in_array( $key, $media, true ) ) {
			echo ' <button type="button" class="button banks-work-pick" data-for="' . esc_attr( $id ) . '" data-kind="' . ( 0 === strpos( $key, 'video' ) ? 'video' : 'image' ) . '">Choose file</button>';
		}
		echo '</td></tr>';
	}
	echo '</table>';
}

add_action(
	'admin_enqueue_scripts',
	function ( $hook ) {
		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) || 'banks_work' !== get_current_screen()->post_type ) {
			return;
		}
		wp_enqueue_media();
		wp_add_inline_script(
			'media-editor',
			"jQuery(function($){\$(document).on('click','.banks-work-pick',function(){var b=\$(this),f=wp.media({library:{type:b.data('kind')},multiple:false});f.on('select',function(){\$('#'+b.data('for')).val(f.state().get('selection').first().get('url'));});f.open();});});"
		);
	}
);

add_action(
	'save_post_banks_work',
	function ( $id ) {
		if ( ! isset( $_POST['banks_work_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['banks_work_nonce'] ) ), 'banks_work_save' ) || ! current_user_can( 'edit_post', $id ) ) {
			return;
		}
		$raw  = isset( $_POST['banks_work'] ) ? (array) wp_unslash( $_POST['banks_work'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- each field is sanitized below.
		$keep = array();
		foreach ( array_keys( banks_core_work_fields() ) as $key ) {
			$v            = isset( $raw[ $key ] ) && is_scalar( $raw[ $key ] ) ? (string) $raw[ $key ] : '';
			$keep[ $key ] = in_array( $key, array( 'url', 'video', 'poster', 'video_phone', 'poster_phone' ), true ) ? esc_url_raw( $v ) : sanitize_text_field( $v );
		}
		update_post_meta( $id, '_banks_work', $keep );
	}
);

add_filter(
	'manage_banks_work_posts_columns',
	function ( $columns ) {
		return array(
			'cb'             => $columns['cb'],
			'title'          => 'Project',
			'banks_industry' => 'Field',
			'banks_media'    => 'Recordings',
			'date'           => $columns['date'],
		);
	}
);

add_action(
	'manage_banks_work_posts_custom_column',
	function ( $column, $id ) {
		$item = banks_core_work_item( $id );
		if ( 'banks_industry' === $column ) {
			echo esc_html( $item['industry'] );
		}
		if ( 'banks_media' === $column ) {
			echo esc_html( ( $item['video'] ? 'Desktop' : 'No desktop' ) . ', ' . ( $item['video_phone'] ? 'phone' : 'no phone' ) );
		}
	},
	10,
	2
);
