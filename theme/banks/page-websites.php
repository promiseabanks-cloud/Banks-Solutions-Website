<?php
/*
 * Websites & e-commerce (/solutions/websites/), replaces /services/digital-foundation/.
 * Copy: "Banks Solutions website: sitemap and copy" doc, middle sections carried over from the
 * old page. Layout and motion: template-parts/solution.php and solution.{css,js}.
 */
get_header();

get_template_part(
	'template-parts/solution',
	null,
	array(
		'slug'         => 'websites',
		'name'         => 'Websites & e-commerce',
		'service_type' => 'Website design and development',
		'start'        => banks_route( '/start/', '/contact/' ),
		'h1'           => 'A website that does a job, not one that just exists',
		'answer'       => 'Banks Solutions designs and builds business websites and online stores in Nigeria. Business sites start at ₦499,000 and take about 5 weeks; online stores with Paystack start at ₦750,000 and take about 8 weeks.',
		'facts'        => array(
			array( '₦499k', 'websites from' ),
			array( '~5 wks', 'brief to launch' ),
			array( '100%', 'yours to own' ),
		),
		'check_title'  => 'You can usually tell within a minute.',
		'check_text'   => 'These are the symptoms we hear most often. If two or more sound familiar, the problem is structural, not cosmetic.',
		'symptoms'     => array(
			array( 'It gets visitors but no enquiries.', 'People arrive, look, and leave without doing anything. Traffic was never the problem.' ),
			array( 'You avoid sending people to it.', 'When someone asks for your website, you hesitate. That hesitation is the whole diagnosis.' ),
			array( 'It no longer matches the business.', 'You have grown, raised your prices or changed direction, and the site still describes who you were three years ago.' ),
			array( 'It is slow on a phone.', 'Which is where more than eight in ten of your visitors are.' ),
			array( 'Nobody can update it.', 'A change means calling whoever built it, if they are still reachable.' ),
			array( 'You cannot find it on Google.', 'Searching your own business name turns up your competitors first.' ),
		),
		'say_label'    => 'Why it matters',
		'say'          => 'A website is not a brochure. It is the first conversation you have with someone who has not met you yet, and you only get one.',
		'say_text'     => array(
			'By the time someone contacts you, they have already made most of the decision. They found you through a search, a referral or a forwarded link, spent under a minute on your site, and formed a view about how established you are and roughly what you charge.',
			'So we do not start with design. We start with the decision the visitor is trying to make, work out what they need to make it, and build the structure that gets them there. Design comes last, because how something looks can only support a decision the structure has already set up.',
		),
		'inc_title'    => 'What you actually get.',
		'inc_text'     => 'Every build includes all of this. There is no stripped-back tier where the important parts are sold back to you later.',
		'included'     => array(
			array(
				'title' => 'We work out what to say',
				'items' => array(
					array( 'Positioning and message', 'What you do, who it is for and why it matters, said in the language your buyers use rather than your industry’s.' ),
					array( 'Copy written for you', 'Every word written from the brief. Not filled-in template text, and not left for you to write later.' ),
					array( 'Structure before design', 'The page order, the decision path and what each section has to achieve, agreed before anyone opens a design tool.' ),
				),
			),
			array(
				'title' => 'We build it',
				'items' => array(
					array( 'Design and build', 'Built in WordPress so you are never locked in. Fast, responsive, and genuinely editable by a non-technical person.' ),
					array( 'Fast on mobile data', 'Built and tested on a phone on real mobile data first: compressed images, minimal scripts, quick on a slow connection.' ),
					array( 'Forms that work', 'Enquiry forms that reliably reach you, with a confirmation for the visitor and no lost messages.' ),
				),
			),
			array(
				'title' => 'You get found, and you own it',
				'items' => array(
					array( 'Search and AI foundations', 'Page titles, descriptions, headings, structured data and a sitemap, so Google and AI assistants understand what you do.' ),
					array( 'Handover and training', 'A walkthrough of how to update it yourself, plus written notes. You depend on us only if you choose to.' ),
				),
			),
		),
		'run_title'    => 'How a build runs.',
		'run_text'     => 'About 5 weeks for a business website and 8 for a store. The variable is almost always how fast content and feedback come back; the build itself is the predictable part.',
		'steps'        => array(
			array( 'Week 1', 'Brief', 'You answer a short guided brief. We diagnose what is actually wrong before quoting. Sometimes the answer is a smaller job than you expected.' ),
			array( 'Week 1–2', 'Structure', 'Page map, decision path and what each section must achieve, agreed in writing before design begins.' ),
			array( 'Week 2–3', 'Copy', 'We write everything. You review it against one question: does this sound like us, and is it true?' ),
			array( 'Week 3–4', 'Design and build', 'Design applied to the agreed structure, then built. You see it working on a real link, not as flat pictures.' ),
			array( 'Week 5', 'Launch and handover', 'We launch, check everything on real devices, submit it to Google and train you to update it.' ),
		),
		'fit_yes'      => array(
			'You have an established business with real customers',
			'You can say what the website is supposed to achieve',
			'You want to be involved in the thinking, not just approve a design',
			'You accept that good copy takes longer than picking a template',
		),
		'fit_no'       => array(
			'You want the cheapest possible site and nothing else matters',
			'You want a template filled in by Friday',
			'You want it designed first and the message worked out later',
			'The business has not launched and you are not yet sure what you sell',
		),
		'plans_title'  => 'How much does a website cost in Nigeria?',
		'plans_text'   => 'Three starting points, priced upfront. Every site ships ready for Google and for AI search, so people find you whether they type into Google or ask ChatGPT.',
		'plans'        => array(
			array(
				'name'  => 'Business website',
				'naira' => 499000,
				'when'  => 'About 5 weeks',
				'text'  => 'The essentials, done properly: fast, mobile-first and built to turn visitors into enquiries, with SEO and AI-search foundations from day one.',
				'cta'   => 'Start with a website',
			),
			array(
				'name'     => 'Online store',
				'naira'    => 750000,
				'from'     => true,
				'featured' => true,
				'when'     => 'About 8 weeks',
				'text'     => 'A store that sells while you sleep: product pages, checkout and Paystack payments, built to handle real traffic and grow with the catalogue.',
				'cta'      => 'Start a store',
			),
			array(
				'name'  => 'Larger builds',
				'label' => 'By enquiry',
				'when'  => 'Scoped from the brief',
				'text'  => 'Multi-system builds, complex integrations and bespoke requirements. Tell us what you run and we will scope it properly.',
				'cta'   => 'Tell us about it',
			),
		),
		'plans_note'   => 'Every quote is fixed before we start: no hourly rate that drifts, no surprises at invoice time. Pay in full, or half at the start and half on delivery, through Paystack.',
		'faqs'         => array(
			array( 'How much does a website cost in Nigeria?', 'At Banks Solutions a business website starts at ₦499,000 and an online store at ₦750,000. Larger builds with integrations are priced from a written spec. Every quote is fixed before work starts and includes copy, mobile performance, search foundations and launch support.' ),
			array( 'How long does it take to build a website?', 'A business website takes about 5 weeks from brief to launch, and an online store about 8 weeks. The variable is usually how quickly content, photographs and feedback come back; the build itself is the predictable part.' ),
			array( 'Will I be able to update it myself?', 'Yes. We build with an editor a non-technical person can genuinely use, and train you on it at handover. Many clients add a care plan so they do not have to, but that is a choice, not a dependency we design in.' ),
			array( 'Do you build online stores with Paystack?', 'Yes. Our online stores take card and bank transfer payments through Paystack, with product pages, checkout, order emails and stock handled in the store. Stores start at ₦750,000 and take about 8 weeks.' ),
			array( 'Do you write the content?', 'Yes. Copy is part of every build, written from the brief, and you review it for accuracy and voice. Asking clients to write their own copy is the most common reason website projects stall for months.' ),
			array( 'Do I own the website and the domain?', 'Yes, completely. The site is built on WordPress, hosted wherever you choose, with full administrator access, and the domain is registered in your name. Nothing holds your site hostage and no monthly fee is needed to keep it online.' ),
		),
		'cta_title'    => 'Find out whether you need a new website, or just a better one',
		'cta_text'     => 'Ten minutes on the brief, and within two working days we’ll tell you what we’d change, how long it takes and what it costs. If a rebuild would waste your money, we’ll say so.',
	)
);

get_footer();
