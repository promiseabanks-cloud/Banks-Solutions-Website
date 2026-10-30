<?php
/*
 * Automation & CRM (/solutions/automation-crm/), replaces /services/automation-crm/.
 * Copy: "Banks Solutions website: sitemap and copy" doc, middle sections carried over from the
 * old page. Layout and motion: template-parts/solution.php and solution.{css,js}.
 */
get_header();

get_template_part(
	'template-parts/solution',
	null,
	array(
		'slug'         => 'automation-crm',
		'name'         => 'Automation & CRM',
		'service_type' => 'CRM setup and business process automation',
		'start'        => banks_route( '/start/', '/contact/' ),
		'h1'           => 'Systems, not spreadsheets',
		'answer'       => 'Banks Solutions sets up CRMs and automations that capture every enquiry, follow it up and track it to payment. We work with Zoho, HubSpot and custom systems, with WhatsApp first because that’s where Nigerian customers talk. Projects start from ₦800,000 plus ₦250,000 a month for running costs and support.',
		'facts'        => array(
			array( '₦800k', 'setup, from' ),
			array( '24/7', 'every enquiry captured' ),
			array( '1×', 'data typed once' ),
		),
		'check_title'  => 'The tell-tale signs.',
		'check_text'   => 'This is the least understood work we do, so here is what the problem looks like day to day. If two or more sound familiar, the business has hit the ceiling that manual work creates.',
		'symptoms'     => array(
			array( 'Leads go cold because nobody followed up.', 'Not through laziness: there was no system saying whose job it was.' ),
			array( 'The same information is typed three times.', 'Into WhatsApp, then a spreadsheet, then an invoice.' ),
			array( 'Nobody knows how many enquiries came in last month.', 'Any answer is a guess.' ),
			array( 'Work lives in one person’s head.', 'When they travel, things stop.' ),
			array( 'Quotes and invoices are rebuilt from scratch.', 'Every one is a small manual project.' ),
			array( 'Growth means hiring.', 'More customers only ever means more hands, never a better process.' ),
		),
		'say_label'    => 'Why it matters',
		'say'          => 'If the business stops when you stop, you do not have a business yet. You have a demanding job that you own.',
		'say_text'     => array(
			'A business that runs on memory has a ceiling, and the ceiling is you. In a business that runs on a system, an enquiry is captured automatically, assigned to someone and chased on a schedule whether or not anybody remembers. The quote comes from a template, and the numbers exist without anyone assembling them.',
			'Customers notice, even if not consciously: you replied quickly, nothing was forgotten, the invoice was right. One honest warning: automating a broken process just breaks it faster, so part of this work is fixing the process before any of it is automated.',
		),
		'inc_title'    => 'What we build.',
		'inc_text'     => 'Scoped to how you actually operate. Nobody needs all of it on day one, and we will say which parts to leave until later.',
		'included'     => array(
			array(
				'title' => 'Nothing leaks',
				'items' => array(
					array( 'Process mapping', 'How work flows today, from enquiry to payment, written down. Often revealing on its own.' ),
					array( 'Lead capture', 'Website forms, WhatsApp and phone enquiries land in one system automatically, never somewhere nobody is watching.' ),
					array( 'Automatic follow-up', 'Sequences that chase every enquiry on a schedule, so nothing goes cold because someone was busy.' ),
				),
			),
			array(
				'title' => 'You see the whole operation',
				'items' => array(
					array( 'CRM setup', 'One place for every customer, enquiry and conversation, set up around your process rather than the vendor’s.' ),
					array( 'Quotes and invoices', 'Generated from templates, tracked, and chased automatically when they go unpaid.' ),
					array( 'Reporting you trust', 'Enquiries, conversion, revenue and lead sources on a dashboard, not rebuilt by hand each month.' ),
				),
			),
			array(
				'title' => 'It sticks after launch',
				'items' => array(
					array( 'Systems that talk', 'Website, WhatsApp, CRM, email, accounting and payments connected, so information is entered once.' ),
					array( 'Training and running it', 'Your team trained and the process written down, then we keep it running and adjust it as the business changes.' ),
				),
			),
		),
		'run_title'    => 'How a setup runs.',
		'run_text'     => 'Usually six to twelve weeks for the setup, depending on how many processes and systems are involved, then ongoing support.',
		'steps'        => array(
			array( 'Weeks 1–2', 'Brief and mapping', 'We map how the work really flows today, including the informal steps nobody writes down. This is where the real problems surface.' ),
			array( 'Weeks 2–3', 'Design the system', 'The process first, then the software to fit it. Choosing tools before understanding the process is the classic expensive mistake.' ),
			array( 'Weeks 3–8', 'Build and connect', 'Configuration, WhatsApp and website connections, automation rules, templates and dashboards.' ),
			array( 'Weeks 8–10', 'Migrate and test', 'Your existing customer data moved in and cleaned, and everything tested with real cases before anyone relies on it.' ),
			array( 'Then', 'Train and run', 'Your team trained and supported through the first weeks, because adoption, not setup, is where these projects usually fail.' ),
		),
		'fit_yes'      => array(
			'You get consistent enquiries and offer a repeatable service',
			'More than one person needs to see what is happening',
			'You can feel the ceiling that manual work has created',
			'You are willing to change how the team works, not just add software',
		),
		'fit_no'       => array(
			'Enquiries are still low and irregular',
			'You want software installed but no change in process',
			'Nobody on your side will champion it day to day',
			'You only want the cheapest CRM licence and nothing more',
		),
		'plans_title'  => 'What does a CRM and automation setup cost?',
		'plans_text'   => 'A setup project, then ongoing running and support if you want us to keep it working. The exact figure depends on how many processes we automate and how many systems need to talk; you get a fixed number after the brief.',
		'plans'        => array(
			array(
				'name'  => 'Setup',
				'naira' => 800000,
				'from'  => true,
				'when'  => 'Usually 6 to 12 weeks',
				'text'  => 'Process mapping, CRM setup, lead capture, WhatsApp, follow-up sequences, quotes, invoices and dashboards.',
				'cta'   => 'Start the brief',
			),
			array(
				'name'     => 'Running and support',
				'naira'    => 250000,
				'from'     => true,
				'featured' => true,
				'when'     => 'A month',
				'text'     => 'We keep the system running, adjust it as the business changes, train new staff and stop it drifting back into spreadsheets.',
				'cta'      => 'Ask about support',
			),
			array(
				'name'  => 'Larger operations',
				'label' => 'By enquiry',
				'when'  => 'Scoped from the brief',
				'text'  => 'Several teams, branches or systems, data migrations and custom integrations. Tell us how you run and we will size it properly.',
				'cta'   => 'Tell us about it',
			),
		),
		'plans_note'   => 'Software licences, such as Zoho or HubSpot, are paid directly to the vendor. We never mark them up, so we have no reason to recommend expensive tools.',
		'faqs'         => array(
			array( 'What is a CRM and do I need one?', 'A CRM (customer relationship management system) is one place where every customer, enquiry and conversation lives, so nothing depends on memory. You probably need one if enquiries are consistent, more than one person handles them, and leads go cold because nobody followed up.' ),
			array( 'Can you automate WhatsApp?', 'Usually yes, and for most Nigerian businesses it is the most valuable connection, because WhatsApp is where enquiries arrive. We can capture WhatsApp enquiries into the CRM, send replies and reminders, and alert your team. What is possible depends on WhatsApp Business and your volume.' ),
			array( 'Zoho or HubSpot: which is better for a small business?', 'It depends on your process, team and budget. Zoho is often better value for Nigerian small businesses that want CRM, invoicing and more in one suite. HubSpot is easier to start with and strong on marketing. We are not a reseller, so we choose after mapping your process.' ),
			array( 'What does it cost each month?', 'Running and support from Banks Solutions starts at ₦250,000 a month after a setup from ₦800,000. Software licences are separate and paid directly to the vendor, with no mark-up. Some setups run on free or low-cost plans, and we will tell you when that is enough.' ),
			array( 'Will my team actually use it?', 'That is the real risk, which is why training and the first weeks of support are part of the project. Systems fail from people not using them far more often than from bad setup. If nobody on your side will champion it, we will tell you the project is likely to fail.' ),
			array( 'Is my customer data safe?', 'Data protection is a legal duty in Nigeria under the Nigeria Data Protection Act 2023. We set systems up with access controls and consent handling in mind. We are not lawyers and this is not legal advice, but we will not build something that leaves you obviously exposed.' ),
		),
		'cta_title'    => 'Find out what your manual work is actually costing',
		'cta_text'     => 'Tell us how enquiries come in and what is done by hand today. Within two working days we’ll come back with a fixed price for the setup and what running it costs.',
	)
);

get_footer();
