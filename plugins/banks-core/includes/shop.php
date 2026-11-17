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
 * Status is 'available' (can be set up today), 'soon' (being built) or 'client' (a system we
 * built for one client, shown on Labs as running in production). 'version' is the current
 * release, shown on Labs; empty until the first one. 'url' is a path on the main site; leave
 * it empty when the product has no page yet. 'shop' false keeps a product on Labs only.
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
			'version'  => '0.12',
			'url'      => '/banks-business-engine/',
			'need'     => 'ai',
		),
		array(
			'slug'     => 'project-desk',
			'name'     => 'Project Desk',
			'kind'     => 'Client portal and studio desk',
			'status'   => 'available',
			'summary'  => 'One app for running client projects: onboarding, signed agreements, phases, files, payments and messages for the client, and money, leads, tasks and insights for the team.',
			'features' => array( 'Client portal app', 'Agreements and e-signing', 'Payments and money dashboard', 'Leads, tasks and insights' ),
			'price'    => 'Pricing on request, one install per business',
			'version'  => '0.3',
			'url'      => '/labs/project-desk/',
			'need'     => 'web-app',
			'shop'     => false,
		),
		array(
			'slug'     => 'invoicenaija',
			'name'     => 'InvoiceNaija',
			'kind'     => 'Invoices and receipts',
			'status'   => 'available',
			'summary'  => 'Naira invoices with VAT, withholding tax and your bank details, a private payment link, and numbered receipts emailed to you and your customer the moment money lands.',
			'features' => array( 'Naira invoices with VAT and WHT', 'Payment link and Paystack', 'Automatic receipts', 'Web app and WordPress plugin' ),
			'price'    => 'Free to use',
			'version'  => '1.0',
			'url'      => '/labs/invoicenaija/',
			'need'     => 'automation',
			'shop'     => false,
		),
		array(
			'slug'     => '1904-car-wash',
			'name'     => '1904 Car Wash system',
			'kind'     => 'Car wash booking and wallet app',
			'status'   => 'client',
			'summary'  => 'The booking app, customer accounts and wallet behind 1904 Solutions in Ogba, Lagos: book a wash in under a minute, keep cars on file and pay from a wallet at the counter.',
			'features' => array( 'Online booking', 'Cars on file', '1904 Wallet', 'Emailed receipts' ),
			'price'    => 'Custom build, priced from a spec',
			'version'  => '',
			'url'      => '/labs/1904-car-wash/',
			'need'     => 'web-app',
			'shop'     => false,
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
