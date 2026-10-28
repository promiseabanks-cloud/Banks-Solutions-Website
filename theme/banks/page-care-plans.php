<?php
/*
 * Care plans (/solutions/care-plans/), replaces /services/managed-technology/.
 * Copy: "Banks Solutions website: sitemap and copy" doc, middle sections carried over from the
 * old page. Layout and motion: template-parts/solution.php and solution.{css,js}.
 */
get_header();

get_template_part(
	'template-parts/solution',
	null,
	array(
		'slug'         => 'care-plans',
		'name'         => 'Care plans',
		'service_type' => 'Website and web app maintenance and support',
		'start'        => banks_route( '/start/', '/contact/' ),
		'h1'           => 'Someone who already knows your setup',
		'answer'       => 'A Banks Solutions care plan keeps your website or app updated, backed up, secure and monitored, with a monthly allowance for changes. Plans start at ₦150,000 a month, and support requests go through the Support tab in your client portal, so nothing gets lost in WhatsApp.',
		'facts'        => array(
			array( '₦150k', 'a month, from' ),
			array( '24/7', 'uptime monitoring' ),
			array( '1', 'named person to call' ),
		),
		'check_title'  => 'The failures that cost most are the quiet ones.',
		'check_text'   => 'Nobody notices a neglected website until the day it matters. By then it is an emergency, and emergencies are expensive. If two or more of these sound familiar, nobody is looking after it.',
		'symptoms'     => array(
			array( 'Nobody actually owns it.', 'The developer who built it moved on, and nothing has been updated since.' ),
			array( 'Backups exist in theory.', 'Nobody has ever restored one to check it works, which is the only test that counts.' ),
			array( 'It went down and a customer told you.', 'There was no monitoring, so nobody knew until someone complained.' ),
			array( 'It has got slower and nobody noticed.', 'Performance decays gradually, so it never sets off an alarm.' ),
			array( 'Small changes take weeks.', 'Updating a phone number means finding someone who is available.' ),
			array( 'Security is a hope, not a plan.', 'Out-of-date plugins are the most common way small business sites get broken into.' ),
		),
		'say_label'    => 'Why it matters',
		'say'          => 'The cheapest month of care you will ever buy costs less than the first hour of an emergency.',
		'say_text'     => array(
			'Most business websites are not attacked. They quietly rot: plugins go out of date, backups are never tested, and the certificate expires on a Saturday. An update breaks the contact form and enquiries silently stop for three weeks. Google flags the site as unsafe, which takes far longer to undo than to prevent.',
			'None of this is dramatic, and all of it is avoidable with someone doing routine, unglamorous work every month. That is what a care plan is: one person who owns all of it, and who you can call.',
		),
		'inc_title'    => 'What’s covered.',
		'inc_text'     => 'Everything below is in every plan, for websites and for web apps we look after. Plans differ in how much change work is included and how fast we respond.',
		'included'     => array(
			array(
				'title' => 'Nothing breaks quietly',
				'items' => array(
					array( 'Updates, tested first', 'WordPress, plugins and themes updated on a schedule, applied to a copy and checked before they touch your live site.' ),
					array( 'Backups that are verified', 'Automatic off-site backups, with restores actually tested. An untested backup is not a backup.' ),
					array( 'Security monitoring', 'Firewall, login protection, malware scanning and hardening of the things that are attacked most often.' ),
				),
			),
			array(
				'title' => 'It stays fast and online',
				'items' => array(
					array( 'Uptime monitoring', 'We are alerted the moment the site goes down, so you hear it from us, not from a customer.' ),
					array( 'Performance care', 'Caching, image compression and speed checks on a phone, because sites get slower unless somebody is watching.' ),
				),
			),
			array(
				'title' => 'You are never stuck',
				'items' => array(
					array( 'Monthly change work', 'An included allowance for the small edits every business needs: new pages, updated details, a fresh photograph.' ),
					array( 'A support desk in your portal', 'Requests go through the Support tab in your client portal, so you can see what is in progress and nothing is lost in a chat.' ),
					array( 'A named person and plain reports', 'Someone who already knows your setup, and a monthly summary of what was done and what needs attention, in plain English.' ),
				),
			),
		),
		'run_title'    => 'How a care plan runs.',
		'run_text'     => 'Deliberately unexciting. That is the point.',
		'steps'        => array(
			array( 'Week 1', 'Takeover audit', 'We take stock of hosting, domain, plugins, backups and security, and write down the current state, including anything alarming.' ),
			array( 'Weeks 1–3', 'Stabilise', 'We fix what is already broken or dangerous before the plan proper begins. There is no sense monitoring a site that is already compromised.' ),
			array( 'Every month', 'Routine cycle', 'Updates, backup checks, security scans and speed checks, all on a fixed schedule.' ),
			array( 'Any time', 'Change requests', 'You send what you need through the portal. Small changes are done within the included allowance.' ),
			array( 'Every quarter', 'Review', 'A monthly written summary, and a quarterly conversation about what the site should do next.' ),
		),
		'fit_yes'      => array(
			'Your website or app matters to how the business gets customers',
			'Nobody on your team owns the technical side',
			'You would rather pay a predictable monthly fee than emergency rates',
			'You want small changes done without starting a project each time',
		),
		'fit_no'       => array(
			'You already have a capable in-house technical team',
			'The website is decorative and genuinely does not matter',
			'You want unlimited development work under a maintenance fee',
			'You only want the cheapest hosting available',
		),
		'plans_title'  => 'How much does website maintenance cost in Nigeria?',
		'plans_text'   => 'Care plans start at ₦150,000 a month. The exact figure depends on how much we look after, how much change work you need and how fast you need us; we size it after the takeover audit and give you a number, not a range.',
		'plans'        => array(
			array(
				'name'  => 'Takeover audit',
				'label' => 'Start here',
				'when'  => 'About a week',
				'text'  => 'A written picture of what you have and what state it is in, including anything that needs fixing before a plan begins.',
				'cta'   => 'Start the brief',
			),
			array(
				'name'     => 'Care plan',
				'naira'    => 150000,
				'from'     => true,
				'featured' => true,
				'when'     => 'A month',
				'text'     => 'Tested updates, verified backups, security and uptime monitoring, speed care, monthly change work and a named person.',
				'cta'      => 'Ask about a care plan',
			),
			array(
				'name'  => 'Several sites or apps',
				'label' => 'By enquiry',
				'when'  => 'Sized after the audit',
				'text'  => 'Stores, web apps, several websites or faster response times. Tell us what you run and we will size the plan properly.',
				'cta'   => 'Tell us about it',
			),
		),
		'plans_note'   => 'No long lock-in. New features and redesigns are quoted as separate projects, so the plan stays honestly priced.',
		'faqs'         => array(
			array( 'What does website maintenance include?', 'A Banks Solutions care plan includes tested updates, verified off-site backups, security monitoring, uptime monitoring, speed care, a monthly allowance for small changes and a written monthly report, all handled by a named person who knows your setup. Plans start at ₦150,000 a month.' ),
			array( 'How fast do you respond?', 'Response time depends on the plan and is written into your agreement. A site that is down is treated as urgent on every plan, including the entry one. You can follow every request in the Support tab of your client portal.' ),
			array( 'Do you look after sites you didn’t build?', 'Yes. We take over existing websites and apps regularly. It starts with a takeover audit so we know exactly what we are inheriting, and occasionally that audit finds problems serious enough that we fix them before the plan starts.' ),
			array( 'What counts as included change work?', 'Content edits, new or updated pages, swapped images, updated details and small layout changes. New features and redesigns are not included: those are projects, quoted separately, so the monthly fee stays honest.' ),
			array( 'Can I cancel?', 'Yes. There is no long lock-in; we would rather keep the work by being worth it. We do ask for a short first period after a takeover, because the first month or two is usually when the accumulated problems get fixed.' ),
			array( 'What if my site gets hacked while you look after it?', 'We clean it up and restore it from backup as part of the plan. That is exactly the risk you are paying us to carry, and it is why verified backups matter more than anything else on this list.' ),
		),
		'cta_title'    => 'Find out what state your website is actually in',
		'cta_text'     => 'Tell us what you run and who looks after it today. Within two working days we’ll come back with what the takeover audit would cover and what a care plan would cost.',
	)
);

get_footer();
