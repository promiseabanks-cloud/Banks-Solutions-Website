<?php
/*
 * Web apps & custom solutions (/solutions/web-apps/), a new page.
 * Copy: "Banks Solutions website: sitemap and copy" doc. Layout and motion:
 * template-parts/solution.php and solution.{css,js}.
 */
get_header();

get_template_part(
	'template-parts/solution',
	null,
	array(
		'slug'         => 'web-apps',
		'name'         => 'Web apps & custom solutions',
		'service_type' => 'Custom web application development',
		'start'        => banks_route( '/start/', '/contact/' ),
		'h1'           => 'Software that fits the way you already work',
		'answer'       => 'Banks Solutions builds custom web apps for businesses: client portals, booking and scheduling systems, dashboards, membership sites, internal tools and custom features for an existing website. Each one is scoped from a short brief and paid in stages, and you can track the build live in your client portal.',
		'facts'        => array(
			array( 'Spec', 'fixed price, upfront' ),
			array( 'Staged', 'payments as it ships' ),
			array( '100%', 'your code, documented' ),
		),
		'check_title'  => 'You’ve outgrown the workaround.',
		'check_text'   => 'Most custom software starts as a workaround that got too expensive to keep. If two or more of these sound familiar, it is probably time.',
		'symptoms'     => array(
			array( 'You pay for four apps and still use a spreadsheet to join them up.', 'Every tool does its part, and someone spends Friday copying between them.' ),
			array( 'Clients email files back and forth.', 'There is nowhere to put them, so they live in inboxes and get lost.' ),
			array( 'Bookings live in someone’s phone.', 'When that person is busy or away, nobody knows who is coming when.' ),
			array( 'You were told “there’s an app for that”.', 'It almost fits. The gap costs you a little every single week.' ),
			array( 'Staff type the same details in three places.', 'Every copy is a chance for a mistake a customer will notice.' ),
			array( 'You can’t see what’s happening without asking.', 'The numbers exist, but only in someone’s head or a report from last month.' ),
		),
		'say_label'    => 'Why custom',
		'say'          => 'Off-the-shelf software asks you to change how you work to fit it. Custom software is built around how you already work, then makes that faster.',
		'say_text'     => array(
			'We start with the work, not the technology: who does what, where it slows down and what it costs you each week. Then we build the smallest system that removes the slow part, and grow it only when the first piece pays for itself.',
			'We use WordPress or a custom stack, whichever is cheaper to run and easier to own. Either way you own the code, it is documented, and another developer could take over without starting again.',
		),
		'inc_title'    => 'What we build, and how it connects.',
		'inc_text'     => 'Every web app comes with a written spec, a clickable prototype before the build, staged payments and handover notes. These are the things we build most often.',
		'included'     => array(
			array(
				'title' => 'Systems for your customers',
				'items' => array(
					array( 'Client and member portals', 'A private login where clients see progress, share files, approve work and pay.' ),
					array( 'Booking and scheduling', 'Appointments, rooms, classes or rentals, with reminders and deposits taken upfront.' ),
					array( 'Custom features for your website', 'Quote calculators, application forms, directories and anything else your site needs to do.' ),
				),
			),
			array(
				'title' => 'Systems for your team',
				'items' => array(
					array( 'Order and inventory tools', 'Stock, orders and deliveries in one place instead of three spreadsheets.' ),
					array( 'Dashboards and reports', 'The numbers you ask about every week, live, without anyone pulling them together.' ),
					array( 'Internal tools', 'Approvals, checklists and workflows built around how your team already works.' ),
				),
			),
			array(
				'title' => 'Payments and connections',
				'items' => array(
					array( 'Paystack and Flutterwave', 'Card, bank transfer and USSD payments, deposits, instalments and receipts.' ),
					array( 'WhatsApp, Zoho, HubSpot, Google Workspace', 'Your app talks to the tools you already use, so nothing gets typed twice.' ),
				),
			),
		),
		'run_title'    => 'How a web app gets built.',
		'run_text'     => 'Each project is scoped individually, and you see the timeline before you commit. You pay in stages, and each stage ends with something working you can try.',
		'steps'        => array(
			array( 'Start', 'Brief', 'You answer a short guided brief about how the work runs today and where it breaks.' ),
			array( 'Before any code', 'Written spec', 'What the system does, who uses it, what it connects to, the price and the timeline, in writing.' ),
			array( 'Before the build', 'Prototype', 'A clickable prototype you can try with your team, so changes happen while they are cheap.' ),
			array( 'In stages', 'Build', 'Built and released in stages you can use and test. You track it live in your client portal and pay as each stage ships.' ),
			array( 'After launch', 'Launch and support', 'We launch, train your team and hand over the code and notes, then look after it on a care plan if you want one.' ),
		),
		'fit_yes'      => array(
			'You can describe how the work runs today, even if it is messy',
			'The problem costs you time or money every week',
			'Someone on your side can test and give feedback as it is built',
			'You would rather own the system than rent it forever',
		),
		'fit_no'       => array(
			'An existing app already does the job and you just need it set up',
			'You need it finished before anyone can say what it should do',
			'You want the cheapest quote and the brief can be vague',
			'Nobody on your side has time to try it while it is built',
		),
		'plans_title'  => 'How much does a custom web app cost in Nigeria?',
		'plans_text'   => 'Every web app is priced from a written spec, because the cost depends on what it has to do. You see the full price and timeline before you commit, and you pay in stages as each part ships.',
		'plans'        => array(
			array(
				'name'  => 'A feature for your website',
				'label' => 'From a spec',
				'when'  => 'Often a few weeks',
				'text'  => 'Add bookings, a client area, a calculator or an application form to the website you already have.',
				'cta'   => 'Describe the feature',
			),
			array(
				'name'     => 'A web app',
				'label'    => 'From a spec',
				'featured' => true,
				'when'     => 'Timeline in the spec',
				'text'     => 'A portal, booking system, dashboard or internal tool built around how your business works, with payments and integrations.',
				'cta'      => 'Start the brief',
			),
			array(
				'name'  => 'Keep it running',
				'naira' => 150000,
				'from'  => true,
				'when'  => 'A month, on a care plan',
				'text'  => 'Updates, backups, monitoring and a monthly allowance for changes and new features after launch.',
				'cta'   => 'Ask about care plans',
			),
		),
		'plans_note'   => 'Every price is fixed in the spec before work starts. Pay in stages through Paystack in your client portal, and own the code from day one.',
		'faqs'         => array(
			array( 'How much does a custom web app cost in Nigeria?', 'At Banks Solutions every web app is priced from a written spec, because the cost depends on what the system has to do. A small feature for an existing website costs far less than a full client portal. You see the fixed price and timeline before you commit, and pay in stages.' ),
			array( 'How long does it take to build a web app?', 'It depends on the scope, and the timeline is in the spec before you commit. Small features for an existing site often take a few weeks. Larger systems are built and released in stages, so you start using the first part well before the last one is finished.' ),
			array( 'Do I own the code?', 'Yes. You own the code and the data from day one. We document how it works, so another developer could take it over, and we never hold your system hostage with a licence you have to keep paying for.' ),
			array( 'Can it take payments?', 'Yes. We connect web apps to Paystack and Flutterwave for card, bank transfer and USSD payments, including deposits, instalments, subscriptions and receipts.' ),
			array( 'Should it be WordPress or a custom stack?', 'Whichever is cheaper to run and easier to own for your case. WordPress suits portals, bookings and memberships close to your website. A custom stack suits systems with heavy data or many users. The spec explains which we recommend and why.' ),
			array( 'What happens after launch?', 'We train your team and hand over the code and notes. Most clients then keep the app on a care plan, from ₦150,000 a month, for updates, backups, monitoring and a monthly allowance for changes and new features.' ),
		),
		'cta_title'    => 'Tell us how the work actually runs',
		'cta_text'     => 'Ten minutes on the brief, and within two working days we’ll tell you what we’d build, what it would replace and what it costs. Sometimes the answer is a tool you already have, set up properly.',
	)
);

get_footer();
