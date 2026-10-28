<?php
/**
 * The questions on the project brief at /start/. The theme renders them; the plugin validates
 * answers against the same lists, so a value the form never offered is never stored.
 *
 * @package Banks_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Choice lists for the brief, keyed by field. Each list maps a stored key to its label.
 *
 * @return array<string, array<string, string>>
 */
function banks_core_brief_options() {
	$options = array(
		'needs'    => array(
			'website'    => 'A website',
			'store'      => 'An online store',
			'web-app'    => 'A web app or custom solution',
			'automation' => 'Automation & CRM',
			'ai'         => 'AI for a specific job',
			'care'       => 'Looking after what I have',
			'seo'        => 'Getting found on Google and in AI',
			'not-sure'   => 'Not sure yet',
		),
		'industry' => array(
			'finance'      => 'Finance and microfinance',
			'legal'        => 'Legal',
			'hospitality'  => 'Hotels and hospitality',
			'education'    => 'Education',
			'health'       => 'Health',
			'non-profit'   => 'Non-profit',
			'fashion'      => 'Fashion',
			'retail'       => 'Retail and e-commerce',
			'professional' => 'Professional services',
			'other'        => 'Something else',
		),
		'budget'   => array(
			'under-500k' => 'Under ₦500,000',
			'500k-1m'    => '₦500,000 to ₦1 million',
			'1m-3m'      => '₦1 million to ₦3 million',
			'3m-10m'     => '₦3 million to ₦10 million',
			'over-10m'   => 'Over ₦10 million',
			'not-sure'   => 'Not sure yet',
		),
		'timeline' => array(
			'asap'      => 'As soon as possible',
			'month'     => 'Within a month',
			'quarter'   => 'In the next 1 to 3 months',
			'exploring' => 'Just exploring for now',
		),
	);
	/**
	 * Filters the brief's choice lists.
	 *
	 * @param array $options Field => [ key => label ].
	 */
	return apply_filters( 'banks_core_brief_options', $options );
}

/** Where the brief form posts when JavaScript is off. */
function banks_core_brief_action_url() {
	return admin_url( 'admin-post.php' );
}

/** The REST route the brief form posts to when JavaScript is on. */
function banks_core_brief_rest_url() {
	return rest_url( 'banks/v1/briefs' );
}
