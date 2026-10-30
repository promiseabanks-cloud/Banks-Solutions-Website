<?php
/**
 * Copy for the industry pages (/industries/ and /industries/<slug>/). One entry per field;
 * the keys match the brief's industry options, so /start/?industry=<slug> picks the field.
 * Projects are matched by their slug in Banks Core (Dashboard > Work).
 *
 * @package Banks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Every field we write a page for, in the order the hub shows them.
 *
 * @return array[] slug => copy
 */
function banks_industries() {
	$list = array(
		'finance'     => array(
			'name'    => 'Finance',
			'label'   => 'Finance and microfinance',
			'short'   => 'Banks, microfinance banks, cooperatives, lenders and investment firms.',
			'h1'      => 'Technology a finance customer can trust',
			'answer'  => 'Banks Solutions builds websites, customer portals, loan and account-opening flows, and internal tools for banks, microfinance banks, cooperatives and lenders in Nigeria. Websites start at ₦499,000; web apps and custom systems are priced from a written spec.',
			'work'    => array( 'cedrus-mfb' ),
			'feed'    => array(
				array( 'Loan application', 'Received online, documents attached' ),
				array( 'KYC check', 'BVN and ID collected, flagged for review' ),
				array( 'Officer assigned', 'Customer told when to expect a call' ),
			),
			'pains'   => array(
				array( 'Customers still queue for things a form could do.', 'Account opening, loan requests and statement requests arrive on paper, by WhatsApp or in the banking hall.' ),
				array( 'The website does not look like a bank.', 'In finance, trust is the product. A dated or slow site makes people wonder what else is out of date.' ),
				array( 'Applications get lost between teams.', 'An enquiry lands in one inbox, the documents in another, and nobody can say where it is.' ),
				array( 'Staff re-type the same details.', 'Information collected once gets copied into a spreadsheet, then a core system, then an email.' ),
			),
			'builds'  => array(
				array( 'websites', 'A website that earns trust', 'Clear products and rates, branch and contact details, and pages your compliance team can sign off.' ),
				array( 'web-apps', 'Online applications and portals', 'Account opening, loan applications and document uploads with status updates, so customers stop calling to ask.' ),
				array( 'automation-crm', 'A pipeline for every application', 'Each request routed to the right officer, with reminders, so nothing waits in an inbox.' ),
				array( 'ai', 'An assistant for first questions', 'Answers about products, requirements and opening hours on your website, day and night, handing real cases to staff.' ),
			),
			'care'    => array(
				array( 'Customer data', 'Handled in line with the Nigeria Data Protection Act 2023: collected for a stated purpose, stored securely and kept no longer than needed.' ),
				array( 'Access', 'Staff see only what their role needs, and every change to an application is logged.' ),
				array( 'Sign-off', 'Rates, terms and disclaimers are your content. We build the pages so your compliance team approves them before launch.' ),
			),
			'faqs'    => array(
				array( 'Can you build an online account opening or loan application form?', 'Yes. We build application flows that collect the details and documents you need, check them for completeness, and route each one to the right officer with a status the customer can follow.' ),
				array( 'Do you connect to our core banking system?', 'Where the core system offers an interface for it, yes. We confirm what your provider allows during the spec, before any price is agreed.' ),
				array( 'How do you protect customer data?', 'Data is collected only for a stated purpose, sent over encrypted connections, kept on secured servers and limited by staff role, in line with the Nigeria Data Protection Act 2023.' ),
				array( 'How much does a website for a microfinance bank cost?', 'Business websites start at ₦499,000. Portals and application systems are priced from a written spec, because the cost depends on what they need to do.' ),
			),
			'seo'     => array( 'Websites & Web Apps for Banks and Microfinance in Nigeria | Banks Solutions', 'Websites, loan and account-opening flows, customer portals and internal tools for banks, microfinance banks and lenders in Nigeria. Websites from ₦499,000.', 'microfinance bank website Nigeria' ),
		),
		'legal'       => array(
			'name'    => 'Legal',
			'label'   => 'Law firms',
			'short'   => 'Law firms, chambers and legal practitioners, in Nigeria and abroad.',
			'h1'      => 'A practice that looks as sharp online as it is in court',
			'answer'  => 'Banks Solutions builds websites, client intake and matter-tracking tools for law firms and chambers in Nigeria and abroad, including Peakstone Law in Canada. Websites start at ₦499,000; client portals and custom tools are priced from a written spec.',
			'work'    => array( 'peakstone-law' ),
			'feed'    => array(
				array( 'New enquiry', 'Property dispute, Lagos. Conflict check queued' ),
				array( 'Consultation booked', 'Thursday, 10:00. Reminder sent' ),
				array( 'Documents received', 'Saved to the matter, not to an inbox' ),
			),
			'pains'   => array(
				array( 'Clients cannot tell what you actually handle.', 'A list of every practice area reads like a firm that does everything and specialises in nothing.' ),
				array( 'Enquiries arrive with none of the facts.', 'Someone calls, a partner calls back, and twenty minutes later it turns out to be outside your practice.' ),
				array( 'Documents travel by email and WhatsApp.', 'Sensitive papers end up scattered across personal phones and inboxes.' ),
				array( 'Clients keep asking for updates.', 'Every “any news on my case?” is a phone call someone has to take.' ),
			),
			'builds'  => array(
				array( 'websites', 'A website that wins the right briefs', 'Practice areas written for the client’s problem, partner profiles and clear next steps, without breaching professional rules on advertising.' ),
				array( 'automation-crm', 'Intake that sorts enquiries for you', 'A short form that collects the facts, flags conflicts for checking and books consultations straight into the diary.' ),
				array( 'web-apps', 'A client portal', 'A private place for documents and matter updates, so clients stop chasing and papers stop living in WhatsApp.' ),
				array( 'seo-aeo', 'Found when people search for help', 'Plain-language guides that answer the questions clients search for, on Google and in AI answers.' ),
			),
			'care'    => array(
				array( 'Confidentiality', 'Client documents sit behind a login, never as open links, and access is limited to the people on the matter.' ),
				array( 'Professional rules', 'Your bar’s rules on advertising and claims apply. We write the copy so you can check it against them before it goes live.' ),
				array( 'Records', 'Every upload and status change is logged, so there is a clear record of what was shared and when.' ),
			),
			'faqs'    => array(
				array( 'Do you build websites for law firms outside Nigeria?', 'Yes. We work with firms abroad, including Peakstone Law in Canada, and write to the advertising rules of the jurisdiction you practise in.' ),
				array( 'Can clients upload documents securely?', 'Yes. We build a client portal where documents are uploaded behind a login and stored against the matter, not sent by email.' ),
				array( 'Can enquiries be screened before a lawyer calls back?', 'Yes. The intake form asks the questions you choose, so a partner sees the facts and the practice area before deciding whether to call.' ),
				array( 'How much does a law firm website cost?', 'Business websites start at ₦499,000. Client portals and intake systems are priced from a written spec.' ),
			),
			'seo'     => array( 'Law Firm Websites & Client Portals in Nigeria | Banks Solutions', 'Websites, client intake and secure client portals for law firms and chambers in Nigeria and abroad. Websites from ₦499,000.', 'law firm website Nigeria' ),
		),
		'hospitality' => array(
			'name'    => 'Hospitality',
			'label'   => 'Hotels and hospitality',
			'short'   => 'Hotels, short-lets, restaurants, lounges and service businesses.',
			'h1'      => 'Direct bookings, not just a pretty lobby photo',
			'answer'  => 'Banks Solutions builds websites, direct booking and payment flows, and operations systems for hotels, short-lets, restaurants and service businesses in Nigeria, including The Amor Hotels and 1904 Solutions. Websites start at ₦499,000; booking and operations systems are priced from a written spec.',
			'work'    => array( 'amor-hotels', '1904-solutions' ),
			'feed'    => array(
				array( 'Booking confirmed', 'Deluxe room, 2 nights. Paid by Paystack' ),
				array( 'Guest message', 'Airport pickup requested, sent to the front desk' ),
				array( 'Review request', 'Sent the morning after checkout' ),
			),
			'pains'   => array(
				array( 'Booking platforms take a cut of every night.', 'Guests find you on a listing site, and the commission comes out of your margin.' ),
				array( 'Bookings come in by DM and get double-sold.', 'Instagram, WhatsApp and phone calls each hold a piece of the calendar.' ),
				array( 'Payment is “send us the transfer”.', 'Guests hesitate, then book somewhere they can pay properly.' ),
				array( 'Your photos sell the place, your website doesn’t.', 'A slow gallery on a phone loses the guest before they see a room.' ),
			),
			'builds'  => array(
				array( 'websites', 'A website that books rooms', 'Rooms, rates and availability up front, fast on a phone, with a booking button on every page.' ),
				array( 'web-apps', 'Direct booking and payment', 'Guests choose dates and pay by card or transfer through Paystack, and the room is held automatically.' ),
				array( 'automation-crm', 'Guest messages that send themselves', 'Confirmations, arrival details and review requests go out on time, without anyone remembering to send them.' ),
				array( 'ai', 'An assistant for guest questions', 'Check-in times, parking, menus and directions answered on your website and handed to staff when it matters.' ),
			),
			'care'    => array(
				array( 'Payments', 'Card and transfer payments run through Paystack, so card details never touch your website.' ),
				array( 'One calendar', 'Every booking lands in one place, so a room cannot be sold twice from two channels.' ),
				array( 'Guest data', 'Guest details are kept for the stay and your records, in line with the Nigeria Data Protection Act 2023.' ),
			),
			'faqs'    => array(
				array( 'Can guests book and pay on our own website?', 'Yes. We build direct booking with Paystack payments, so guests pick dates, pay and get a confirmation without a phone call.' ),
				array( 'Will direct booking replace the booking platforms?', 'Usually not entirely. Most hotels keep the platforms for discovery and use their own site to win repeat and direct guests without paying commission.' ),
				array( 'Do you build systems for restaurants and service businesses?', 'Yes. We built a custom system and web app around how 1904 Solutions, a car wash and hospitality business, actually runs.' ),
				array( 'How much does a hotel website cost?', 'Business websites start at ₦499,000. Booking, payment and operations systems are priced from a written spec.' ),
			),
			'seo'     => array( 'Hotel Websites & Direct Booking Systems in Nigeria | Banks Solutions', 'Hotel and hospitality websites with direct booking, Paystack payments and automated guest messages, built in Nigeria. Websites from ₦499,000.', 'hotel website Nigeria' ),
		),
		'education'   => array(
			'name'    => 'Education',
			'label'   => 'Education',
			'short'   => 'Schools, training providers, tutors, coaches and course creators.',
			'h1'      => 'Admissions, payments and learning, without the paper chase',
			'answer'  => 'Banks Solutions builds websites, admission and enrolment forms, fee payment and learning platforms for schools, training providers, coaches and course creators in Nigeria, including coach Bimbo Mesele. Websites start at ₦499,000; portals and learning platforms are priced from a written spec.',
			'work'    => array( 'bimbo-mesele' ),
			'feed'    => array(
				array( 'Admission form', 'JSS1 application received, birth certificate attached' ),
				array( 'Fees paid', 'First term, by transfer. Receipt sent to parent' ),
				array( 'Class reminder', 'Cohort 4 starts Monday. 38 students notified' ),
			),
			'pains'   => array(
				array( 'Parents queue to collect and return forms.', 'Admissions season means paper, photocopies and a crowded office.' ),
				array( 'Fee payments are hard to match.', 'Transfers arrive with no name or the wrong one, and the bursar spends days reconciling.' ),
				array( 'Your course lives in WhatsApp groups.', 'Lessons, links and files scroll away, and new students can’t find anything.' ),
				array( 'The website says nothing a parent needs.', 'No fees, no dates, no clear way to apply. Parents ask the same questions every term.' ),
			),
			'builds'  => array(
				array( 'websites', 'A website parents and students act on', 'Programmes, fees, dates and how to apply, written for the questions you get every term.' ),
				array( 'web-apps', 'Admissions and enrolment online', 'Application forms with document uploads and a dashboard for your admissions team.' ),
				array( 'automation-crm', 'Fees that match themselves', 'Payments through Paystack tied to each student, with receipts and reminders sent automatically.' ),
				array( 'web-apps', 'A place to learn', 'Courses, lessons and resources behind a login, for a school, a training cohort or a paid programme.' ),
			),
			'care'    => array(
				array( 'Children’s data', 'Pupil details get the strictest handling: collected only for admission and records, and visible only to staff who need them.' ),
				array( 'Payments', 'Fees run through Paystack with a receipt for every payment, so there is a clear trail for parents and the bursar.' ),
				array( 'Slow phones', 'Parents and students often use older phones on mobile data, so every page is built light and tested on one.' ),
			),
			'faqs'    => array(
				array( 'Can parents apply and pay school fees online?', 'Yes. We build admission forms with document uploads and fee payment through Paystack, with a receipt sent to the parent and a record for the school.' ),
				array( 'Can you build a platform to sell an online course?', 'Yes. We build course platforms where students pay, log in and work through lessons, owned by you rather than rented from a platform.' ),
				array( 'Do you work with coaches and training providers?', 'Yes. We built the website for coach Bimbo Mesele, and build booking, payment and course tools for trainers.' ),
				array( 'How much does a school website cost?', 'Business websites start at ₦499,000. Admission portals and learning platforms are priced from a written spec.' ),
			),
			'seo'     => array( 'School Websites, Admission Portals & Course Platforms in Nigeria | Banks Solutions', 'Websites, online admission and fee payment, and course platforms for schools, training providers and coaches in Nigeria. Websites from ₦499,000.', 'school website Nigeria' ),
		),
		'health'      => array(
			'name'    => 'Health',
			'label'   => 'Health',
			'short'   => 'Clinics, hospitals, pharmacies, labs and wellness practices.',
			'h1'      => 'Fewer phone calls, more patients seen',
			'answer'  => 'Banks Solutions builds websites, appointment booking, patient intake and reminder systems for clinics, hospitals, pharmacies, labs and wellness practices in Nigeria. Websites start at ₦499,000; booking and patient systems are priced from a written spec.',
			'work'    => array(),
			'feed'    => array(
				array( 'Appointment booked', 'General consultation, Tuesday 11:30' ),
				array( 'Intake form', 'Completed before arrival, not in the waiting room' ),
				array( 'Reminder sent', 'By WhatsApp, the day before. No-shows down' ),
			),
			'pains'   => array(
				array( 'The phone never stops.', 'Opening hours, prices and “is the doctor in today?” take up the front desk’s whole day.' ),
				array( 'Patients don’t turn up.', 'A missed appointment is an empty slot nobody else could book.' ),
				array( 'Forms are filled in the waiting room.', 'On paper, by hand, and then typed up again.' ),
				array( 'People can’t find you when they need you.', 'Someone searches for a clinic near them and your practice isn’t there.' ),
			),
			'builds'  => array(
				array( 'websites', 'A website patients can use', 'Services, doctors, hours, prices where you publish them, and directions, quick to read on a phone.' ),
				array( 'web-apps', 'Booking and intake online', 'Patients pick a slot and complete their forms before they arrive.' ),
				array( 'automation-crm', 'Reminders that cut no-shows', 'Confirmations and reminders by email or WhatsApp, sent on schedule.' ),
				array( 'seo-aeo', 'Found when it matters', 'A Google Business Profile and pages that show up for “clinic near me” searches.' ),
			),
			'care'    => array(
				array( 'Health data', 'Health information is sensitive personal data under the Nigeria Data Protection Act 2023. We collect only what the practice needs and keep it behind a login.' ),
				array( 'No medical advice', 'An assistant on a health site answers practical questions only, and always points clinical questions to your staff.' ),
				array( 'Your records system', 'We connect to the system you already use where it allows it, rather than asking you to replace it.' ),
			),
			'faqs'    => array(
				array( 'Can patients book appointments on our website?', 'Yes. We build booking that shows your available slots, takes the patient’s details and sends a confirmation and reminder.' ),
				array( 'Is patient information safe?', 'We treat it as sensitive data under the Nigeria Data Protection Act 2023: encrypted in transit, kept behind a login and visible only to the staff who need it.' ),
				array( 'Can an AI assistant answer patient questions?', 'Practical ones, like hours, location, services and how to book. It is set up never to give medical advice and to hand clinical questions to your staff.' ),
				array( 'How much does a clinic website cost?', 'Business websites start at ₦499,000. Booking and patient systems are priced from a written spec.' ),
			),
			'seo'     => array( 'Clinic & Hospital Websites and Appointment Booking in Nigeria | Banks Solutions', 'Websites, online appointment booking, patient intake and reminders for clinics, hospitals, pharmacies and labs in Nigeria. Websites from ₦499,000.', 'clinic website Nigeria' ),
		),
		'non-profit'  => array(
			'name'    => 'Non-profit',
			'label'   => 'Non-profits and foundations',
			'short'   => 'Foundations, NGOs, charities, churches and community groups.',
			'h1'      => 'Show the impact, and make giving easy',
			'answer'  => 'Banks Solutions builds websites, online donation, volunteer and programme application tools for foundations, NGOs, charities and community groups in Nigeria, including The Stanley Jegede Foundation. Websites start at ₦499,000; donation and programme systems are priced from a written spec.',
			'work'    => array( 'stanley-jegede-foundation' ),
			'feed'    => array(
				array( 'Donation received', '₦25,000, monthly. Thank-you email sent' ),
				array( 'Volunteer signed up', 'Saturday outreach, Ilorin' ),
				array( 'Grant application', 'Received, sent to the review panel' ),
			),
			'pains'   => array(
				array( 'Donors can’t see what their money did.', 'Without clear stories and numbers, giving once never turns into giving again.' ),
				array( 'Giving means copying an account number.', 'Every extra step loses a donor, especially one abroad.' ),
				array( 'Applications arrive in a dozen formats.', 'Scholarship and grant applications by email, WhatsApp and paper, impossible to compare.' ),
				array( 'Volunteers fall through the cracks.', 'People offer to help and nobody follows up.' ),
			),
			'builds'  => array(
				array( 'websites', 'A website that shows the work', 'Programmes, stories and results told clearly, with a way to give or get involved on every page.' ),
				array( 'web-apps', 'Online giving', 'One-off and monthly donations by card or transfer through Paystack, with receipts sent automatically.' ),
				array( 'web-apps', 'Applications in one place', 'Grant, scholarship and programme applications collected in one format, with a dashboard for your reviewers.' ),
				array( 'automation-crm', 'Donors and volunteers followed up', 'Thank-yous, updates and volunteer reminders that go out on time, every time.' ),
			),
			'care'    => array(
				array( 'Transparency', 'Impact pages are built so you can update numbers and stories yourself as programmes run.' ),
				array( 'Beneficiary privacy', 'Applicants’ and beneficiaries’ details stay private and are seen only by your reviewers.' ),
				array( 'Low running costs', 'We keep the tools you pay for each month to a minimum, because every naira saved goes to the work.' ),
			),
			'faqs'    => array(
				array( 'Can people donate on our website, including from abroad?', 'Yes. We set up one-off and monthly giving through Paystack, which accepts local and international cards, with a receipt for every gift.' ),
				array( 'Can we collect scholarship or grant applications online?', 'Yes. Applicants fill one form with their documents, and your panel reviews and scores them in one place.' ),
				array( 'Have you built for foundations before?', 'Yes. We built the website for The Stanley Jegede Foundation.' ),
				array( 'How much does a foundation website cost?', 'Business websites start at ₦499,000. Donation and application systems are priced from a written spec.' ),
			),
			'seo'     => array( 'NGO & Foundation Websites with Online Donations in Nigeria | Banks Solutions', 'Websites, online donations, volunteer sign-up and grant applications for foundations, NGOs and charities in Nigeria. Websites from ₦499,000.', 'NGO website Nigeria' ),
		),
		'fashion'     => array(
			'name'    => 'Fashion',
			'label'   => 'Fashion and beauty',
			'short'   => 'Fashion designers, clothing brands, salons and beauty businesses.',
			'h1'      => 'Sell the collection, not just post it',
			'answer'  => 'Banks Solutions builds online stores, lookbook websites, custom order and booking systems for fashion designers, clothing brands, salons and beauty businesses in Nigeria and abroad, including Kuupsy, Umi Hair Braids and EJ’s Hair World. Websites start at ₦499,000 and online stores at ₦750,000.',
			'work'    => array( 'kuupsy', 'umi-hair-braids', 'ejs-hair-world' ),
			'feed'    => array(
				array( 'Order paid', 'Ankara two-piece, size 12. ₦48,000' ),
				array( 'Measurements', 'Saved to the customer’s profile' ),
				array( 'Appointment', 'Knotless braids, Saturday 9:00. Deposit paid' ),
			),
			'pains'   => array(
				array( 'Every sale starts with “DM for price”.', 'Customers want to see the price, pick a size and pay, not wait for a reply.' ),
				array( 'Orders live in your chat history.', 'Sizes, measurements and delivery details scroll away with the conversation.' ),
				array( 'Instagram owns your customers.', 'If the account is restricted tomorrow, so is your shop.' ),
				array( 'Bookings come without deposits.', 'Clients book a slot, don’t show, and the chair sits empty.' ),
			),
			'builds'  => array(
				array( 'websites', 'An online store', 'Your collection with prices, sizes and stock, and checkout by card or transfer through Paystack.' ),
				array( 'web-apps', 'Custom orders and measurements', 'Made-to-order requests with measurements saved to each customer, so repeat orders take a minute.' ),
				array( 'automation-crm', 'Bookings with deposits', 'Salon and fitting appointments booked online with a deposit, plus reminders that cut no-shows.' ),
				array( 'ai', 'An assistant for sizing and orders', 'Answers about sizes, delivery and order status on your website, and hands styling questions to you.' ),
			),
			'care'    => array(
				array( 'Your photos', 'Images are compressed to load fast on mobile data without losing the detail of the fabric.' ),
				array( 'Your customers', 'Your customer list lives on your own site, not only inside a social media account.' ),
				array( 'Payments', 'Checkout runs through Paystack, so card details never touch your website.' ),
			),
			'faqs'    => array(
				array( 'Can you build an online store for my fashion brand?', 'Yes. Online stores start at ₦750,000 and include products with sizes and stock, Paystack checkout and order emails.' ),
				array( 'Can customers order made-to-measure clothes online?', 'Yes. We build custom order flows that collect measurements, save them to the customer and send the order to you with everything in one place.' ),
				array( 'Do you build booking for salons?', 'Yes. We have built for Umi Hair Braids and EJ’s Hair World, and set up online booking with deposits and reminders.' ),
				array( 'Will a website replace selling on Instagram?', 'No, it works alongside it. Instagram brings people in; your own site lets them pay without waiting for a reply, and keeps the customer list yours.' ),
			),
			'seo'     => array( 'Online Stores & Websites for Fashion Brands and Salons in Nigeria | Banks Solutions', 'Online stores, custom order and measurement tools, and salon booking with deposits for fashion and beauty brands in Nigeria. Stores from ₦750,000.', 'fashion online store Nigeria' ),
		),
	);
	return apply_filters( 'banks_industries', $list );
}

/** The solutions an industry page links to: slug => name. */
function banks_industry_solutions() {
	return array(
		'websites'       => 'Websites & e-commerce',
		'web-apps'       => 'Web apps & custom solutions',
		'automation-crm' => 'Automation & CRM',
		'ai'             => 'AI solutions',
		'seo-aeo'        => 'SEO & AI search',
		'care-plans'     => 'Care plans',
	);
}
