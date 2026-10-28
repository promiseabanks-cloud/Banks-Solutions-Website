<?php
/**
 * The shop catalogue: the products Banks Solutions sells and where each one stands.
 *
 * A fixed list for now, because the shop opens with one product. When checkout arrives
 * (licence keys, renewals, Paystack) this is the one place that changes; the theme only
 * reads banks_core_products().
 *
 * @package Banks_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Every product, in shop order.
 *
 * Status is 'available' (can be set up today) or 'soon' (being built). 'version' is the
 * current release, shown on Labs; empty until the first one. 'url' is a path on
 * the main site; leave it empty when the product has no page yet.
 *
 * @return array[]
 */
function banks_core_products() {
	$products = array(
		array(
			'slug'     => 'banks-business-engine',
			'name'     => 'Banks Business Engine',
			'kind'     => 'AI assistant and lead CRM',
			'status'   => 'available',
			'summary'  => 'Answers every website enquiry in real time, qualifies the visitor, books them in and sends you a ready lead with WhatsApp alerts, Paystack links and a CRM.',
			'features' => array( 'AI assistant on your site', 'Bookings and CRM', 'WhatsApp and Paystack', 'Automations and insights' ),
			'price'    => 'Priced on scope, monthly licence per site',
			'version'  => '0.10',
			'url'      => '/banks-business-engine/',
			'need'     => 'ai',
		),
		array(
			'slug'     => 'booking-platform',
			'name'     => 'Booking platform',
			'kind'     => 'Online booking',
			'status'   => 'soon',
			'summary'  => 'Customers book and pay for your services online, at any hour, without a call or a back-and-forth on WhatsApp.',
			'features' => array( 'Online booking', 'Payments', 'Reminders' ),
			'price'    => 'Pricing at launch',
			'version'  => '',
			'url'      => '',
			'need'     => '',
		),
	);

	/**
	 * Filters the shop catalogue.
	 *
	 * @param array[] $products Products in shop order.
	 */
	return apply_filters( 'banks_core_products', $products );
}
