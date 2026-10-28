<?php
/**
 * Briefs in WordPress's privacy tools (Tools > Export / Erase Personal Data), so a request
 * under the Nigeria Data Protection Act can be met from the dashboard.
 *
 * @package Banks_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Briefs sent from one email address.
 *
 * @param string $email Address.
 * @return int[]
 */
function banks_core_briefs_for( $email ) {
	return get_posts(
		array(
			'post_type'      => 'banks_brief',
			'post_status'    => 'any',
			'posts_per_page' => 100,
			'fields'         => 'ids',
			'meta_key'       => '_banks_brief_email', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- privacy requests are rare.
			'meta_value'     => $email, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
		)
	);
}

add_filter(
	'wp_privacy_personal_data_exporters',
	function ( $exporters ) {
		$exporters['banks-briefs'] = array(
			'exporter_friendly_name' => 'Project briefs',
			'callback'               => function ( $email ) {
				$items = array();
				foreach ( banks_core_briefs_for( $email ) as $id ) {
					$items[] = array(
						'group_id'    => 'banks-briefs',
						'group_label' => 'Project briefs',
						'item_id'     => 'brief-' . $id,
						'data'        => array(
							array(
								'name'  => 'Reference',
								'value' => get_post_meta( $id, '_banks_brief_ref', true ),
							),
							array(
								'name'  => 'Brief',
								'value' => banks_core_brief_text( (array) get_post_meta( $id, '_banks_brief', true ) ),
							),
						),
					);
				}
				return array(
					'data' => $items,
					'done' => true,
				);
			},
		);
		return $exporters;
	}
);

add_filter(
	'wp_privacy_personal_data_erasers',
	function ( $erasers ) {
		$erasers['banks-briefs'] = array(
			'eraser_friendly_name' => 'Project briefs',
			'callback'             => function ( $email ) {
				$ids = banks_core_briefs_for( $email );
				foreach ( $ids as $id ) {
					wp_delete_post( $id, true );
				}
				return array(
					'items_removed'  => count( $ids ) > 0,
					'items_retained' => false,
					'messages'       => array(),
					'done'           => true,
				);
			},
		);
		return $erasers;
	}
);
