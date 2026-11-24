<?php
/**
 * Copy for the two city pages (/web-design-lagos/ and /web-developer-ilorin/), which answer the
 * "website design in Lagos" and "web developer in Ilorin" searches. Rendered by page-city.php
 * using the industry page styles and motion.
 *
 * @package Banks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The city pages, keyed by page slug.
 *
 * @return array[]
 */
function banks_cities() {
	$areas = array( 'Nigeria', 'United States', 'United Kingdom', 'Canada', 'Kenya', 'Australia' );
	return array(
		'web-design-lagos'    => array(
			'name'   => 'Lagos',
			'h1'     => 'Website design and web apps in Lagos',
			'answer' => 'Banks Solutions is a Lagos web design and development company. We build business websites from ₦499,000, online stores from ₦750,000, and web apps, CRM and AI tools priced from a written spec, for businesses in Lagos and across Nigeria.',
			'feed'   => array(
				array( 'Enquiry from Lekki', 'Captured, answered and logged in seconds' ),
				array( 'Order from Ikeja', 'Paid by transfer, receipt sent' ),
				array( 'Booking for Saturday', 'Confirmed, reminder queued' ),
			),
			'pains'  => array(
				array( 'Customers search on a phone, on mobile data.', 'A slow or heavy site loses a Lagos customer before it loads. We build for a mid-range Android on 4G.' ),
				array( 'Enquiries live in WhatsApp and DMs.', 'Leads are scattered across chats, so follow-up depends on someone remembering.' ),
				array( 'Payments are manual.', 'Bank transfers, screenshots and "send your account number" slow down every sale.' ),
				array( 'The website does not bring in business.', 'It looks fine but nobody can find it, and visitors do not know what to do next.' ),
			),
			'builds' => array(
				array( 'websites', 'Websites and online stores', 'Fast, clear sites that show up in Google and turn visitors into enquiries and orders. From ₦499,000; stores from ₦750,000.' ),
				array( 'web-apps', 'Web apps for how you work', 'Booking systems, client portals, dashboards and internal tools scoped from a short brief and paid in stages.' ),
				array( 'automation-crm', 'CRM and follow-up', 'Every enquiry captured and followed up automatically, from first message to invoice.' ),
			),
			'care'   => array(
				array( 'Naira first', 'Prices in naira, Paystack and bank transfer built in, VAT shown on invoices.' ),
				array( 'Built for mobile data', 'Light pages that stay usable on a weak connection, tested on mid-range phones.' ),
				array( 'A named person after launch', 'Updates, backups and monthly changes handled from ₦150,000 a month.' ),
			),
			'faqs'   => array(
				array( 'How much does website design cost in Lagos?', 'Business websites with Banks Solutions start from ₦499,000 and online stores from ₦750,000. Web apps and custom systems are priced from a written spec after a short brief.' ),
				array( 'How long does a website take to build?', 'A typical business website is live in about five weeks. We confirm the timeline in writing before you pay anything.' ),
				array( 'Do you work with businesses outside Lagos?', 'Yes. We work with businesses across Nigeria and have clients in the United States, United Kingdom, Canada, Kenya and Australia. The work is done remotely.' ),
				array( 'Can I meet you in person?', 'We are based in Lagos and Ilorin. Start with a brief on the Start page and we will arrange a call or a meeting if it helps.' ),
			),
		),
		'web-developer-ilorin' => array(
			'name'   => 'Ilorin',
			'h1'     => 'Web developer and software company in Ilorin',
			'answer' => 'Banks Solutions has a team in Ilorin, Kwara State. We build business websites from ₦499,000, online stores from ₦750,000, and web apps, CRM and AI tools priced from a written spec, for Ilorin businesses, schools, clinics and organisations.',
			'feed'   => array(
				array( 'Admission enquiry', 'Received online, parent told what happens next' ),
				array( 'Order from Tanke', 'Paid, receipt emailed, stock updated' ),
				array( 'Appointment request', 'Booked and confirmed by message' ),
			),
			'pains'  => array(
				array( 'Customers look you up before they call.', 'If your business does not show up properly on Google and look trustworthy, they move on to the next name.' ),
				array( 'Everything runs through one phone.', 'Orders, enquiries and payments sit in chats that only one person can see.' ),
				array( 'Local developers vanish after launch.', 'A site with no updates, backups or support turns into a risk within a year.' ),
				array( 'You need more than a brochure site.', 'Admissions, bookings, orders or a client portal need a system, not just pages.' ),
			),
			'builds' => array(
				array( 'websites', 'Websites that get found', 'Clear, fast sites with the pages and Google listing details local customers look for. From ₦499,000.' ),
				array( 'web-apps', 'Web apps and portals', 'Admissions, booking, ordering and client portals built around how your organisation works.' ),
				array( 'ai', 'Practical AI', 'Answer routine questions and sort enquiries automatically, for named jobs that save real time.' ),
			),
			'care'   => array(
				array( 'Written scope and price', 'You know what you are getting, what it costs and when, before work starts.' ),
				array( 'Support after launch', 'Backups, security and updates handled by a named person, from ₦150,000 a month.' ),
				array( 'Part of a bigger team', 'Ilorin-based, with the same process and standards as our Lagos work.' ),
			),
			'faqs'   => array(
				array( 'Do you have an office in Ilorin?', 'Yes. Banks Solutions works from Lagos and Ilorin. Send a brief on the Start page and we will arrange a call or a meeting.' ),
				array( 'How much does a website cost in Ilorin?', 'Business websites start from ₦499,000 and online stores from ₦750,000. Web apps and custom systems are priced from a written spec.' ),
				array( 'Can you build for a school or clinic?', 'Yes. We build websites, admission and fee-payment flows, appointment booking and intake for schools and health providers. We will not claim past clients we do not have, but we will show the work we have done.' ),
				array( 'Will you look after the site after launch?', 'Yes. Care plans cover updates, verified backups, security, monitoring and monthly changes from ₦150,000 a month.' ),
			),
		),
	);
}

/** The city entry for the page being viewed, or null. */
function banks_city() {
	if ( ! is_page() || wp_get_post_parent_id( get_queried_object_id() ) ) {
		return null;
	}
	$all  = banks_cities();
	$slug = get_post_field( 'post_name', get_queried_object_id() );
	return $all[ $slug ] ?? null;
}
