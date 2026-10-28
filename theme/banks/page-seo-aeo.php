<?php
/*
 * SEO & AI search (/solutions/seo-aeo/), replaces /aeo/.
 * Copy: "Banks Solutions website: sitemap and copy" doc, middle sections carried over from the
 * old page. Layout and motion: template-parts/solution.php and solution.{css,js}.
 */
get_header();

get_template_part(
	'template-parts/solution',
	null,
	array(
		'slug'         => 'seo-aeo',
		'name'         => 'SEO & AI search',
		'service_type' => 'Search engine optimisation and answer engine optimisation (AEO)',
		'start'        => banks_route( '/start/', '/contact/' ),
		'h1'           => 'Be the answer, on Google and in AI',
		'answer'       => 'Answer engine optimisation (AEO) makes your business the source AI tools like ChatGPT, Gemini and Perplexity quote when people ask about your field. Banks Solutions does AEO and traditional SEO together: clear answers, structured data, consistent business facts and fast pages.',
		'facts'        => array(
			array( '3', 'AI assistants tested' ),
			array( 'Before', 'and after, measured' ),
			array( '1', 'set of facts, everywhere' ),
		),
		'check_title'  => 'The search box is disappearing.',
		'check_text'   => 'Ranking first on Google used to be enough. More and more, the decision is made inside an AI answer instead. If two or more of these sound familiar, you are missing from it.',
		'symptoms'     => array(
			array( 'Your customers ask AI, not a search box.', 'Someone asks ChatGPT for the best option in your city and gets a shortlist. If you are not on it, you never show up in your analytics.' ),
			array( 'AI answers name your competitors.', 'The assistant recommends three businesses by name, and none of them is yours, even though you do the work better.' ),
			array( 'Your website was not written to be quoted.', 'AI tools look for clear, structured, fact-dense content they can quote with confidence. Brochure copy does not quote well.' ),
			array( 'You cannot find yourself on Google either.', 'Searching for what you do in your city turns up directories and competitors first.' ),
			array( 'You have no idea what AI says about you.', 'There is no AI search console. It might be recommending you, describing you wrongly or ignoring you entirely.' ),
			array( 'Your details differ from place to place.', 'Different hours, prices or names across your site, Google profile and directories leave machines unsure who you are.' ),
		),
		'say_label'    => 'Why it matters',
		'say'          => 'If AI is already answering the question your next customer is asking, and you are not in that answer, it does not matter how good your website looks.',
		'say_text'     => array(
			'Search used to hand people ten results and let them decide. AI assistants decide for them, then hand over a shortlist, sometimes a single name. The customer does not scroll past you. They never see you at all, and nobody double-checks a recommendation that sounds confident.',
			'Getting cited is not quite the same discipline as classic SEO, though the two overlap. AI tools favour content that states things plainly, backs them up and is structured so a single fact can be lifted out and trusted. So we do both together, and nothing here works by gaming a system.',
		),
		'inc_title'    => 'What we do.',
		'inc_text'     => 'Structural work, not tricks. It works by giving search engines and AI tools accurate, well-structured information about your business that they can trust and quote.',
		'included'     => array(
			array(
				'title' => 'We make you readable by machines',
				'items' => array(
					array( 'Structured data and schema', 'Your services, prices, locations and credentials marked up the way Google and AI tools read them, not buried in paragraphs.' ),
					array( 'Technical SEO and speed', 'Clean page titles, headings, sitemaps and fast pages on a phone, so nothing stops your pages being found and indexed.' ),
				),
			),
			array(
				'title' => 'We make you quotable',
				'items' => array(
					array( 'Answer-first content', 'Pages rewritten so the answer to a customer’s question appears in the first two sentences, not the sixth paragraph.' ),
					array( 'FAQ and knowledge content', 'Direct answers to the questions your customers type into Google and ask AI, in language that can be quoted with confidence.' ),
					array( 'Consistent business facts', 'Your name, services, hours and claims aligned across your website, Google Business Profile, directories and social profiles.' ),
				),
			),
			array(
				'title' => 'We show you what you cannot see',
				'items' => array(
					array( 'AI visibility checks', 'Regular tests of what ChatGPT, Gemini and Perplexity say about you and your competitors when asked real customer questions.' ),
					array( 'Plain-English gap reports', 'Where you are missing from the answer or the results page, and exactly what to fix next.' ),
				),
			),
		),
		'run_title'    => 'How it runs.',
		'run_text'     => 'Often bundled with a website build or added to the site you already have, then checked every month.',
		'steps'        => array(
			array( 'Start', 'Audit', 'We put the real questions your customers ask to Google, ChatGPT, Gemini and Perplexity, and record exactly what comes back today.' ),
			array( 'Then', 'Structure', 'Your content and markup rebuilt so the facts about your business are clear and machine-readable.' ),
			array( 'Then', 'Publish', 'Answer-first pages and structured data go live, with the SEO work that protects your Google ranking.' ),
			array( 'After', 'Verify', 'We ask the same questions again and show you what changed, side by side.' ),
			array( 'Every month', 'Monitor', 'Ongoing checks, because AI answers change all the time, not once a year.' ),
		),
		'fit_yes'      => array(
			'Customers research before they buy, rather than walking in',
			'You can state clear facts about your business: prices, area, credentials',
			'Someone will keep details like hours and prices up to date',
			'You are building for the next few years, not just this quarter',
		),
		'fit_no'       => array(
			'The website itself is the problem and needs fixing first',
			'You want a one-off trick rather than ongoing visibility work',
			'You expect guaranteed placement in AI answers',
			'Nobody can say what the business should be known for',
		),
		'plans_title'  => 'What does SEO and AEO cost?',
		'plans_text'   => 'It depends on how far off you are today, so we test first and quote from the audit. Every website we build already ships with the search and AI foundations; this is for going further, or for a site you already have.',
		'plans'        => array(
			array(
				'name'  => 'Visibility audit',
				'label' => 'Start here',
				'when'  => 'About a week',
				'text'  => 'What Google and three AI assistants say about you today for your customers’ real questions, and what it would take to change it.',
				'cta'   => 'Start the brief',
			),
			array(
				'name'     => 'SEO and AEO project',
				'label'    => 'From the audit',
				'featured' => true,
				'when'     => 'Timeline in the quote',
				'text'     => 'Structured data, answer-first pages, technical fixes and consistent facts across the web, then the same questions tested again.',
				'cta'      => 'Ask about a project',
			),
			array(
				'name'  => 'Monthly monitoring',
				'label' => 'Monthly',
				'when'  => 'Ongoing, or on a care plan',
				'text'  => 'Monthly checks of what AI and Google say about you and your competitors, with new answers added as customers ask new questions.',
				'cta'   => 'Ask about monitoring',
			),
		),
		'plans_note'   => 'Nobody controls what an AI model says, including us. What we promise is accurate, well-structured information about your business and honest before-and-after tests.',
		'faqs'         => array(
			array( 'What is AEO?', 'AEO, or answer engine optimisation, is the work of making your business the source that AI tools like ChatGPT, Gemini and Perplexity quote when someone asks about your field. It uses clear answers, structured data and consistent business facts so these tools can describe you accurately and with confidence.' ),
			array( 'How is AEO different from SEO?', 'SEO earns you a position on a Google results page. AEO earns you a mention inside an AI-generated answer, which needs a different kind of content and trust. The two overlap a lot, so Banks Solutions does them together rather than replacing one with the other.' ),
			array( 'How long until I see results?', 'Technical and structured data fixes are usually picked up by Google within weeks, while rankings for competitive searches take months. AI answers change on their own schedule. We test the same questions at fixed points after the work, so you see what changed rather than taking it on trust.' ),
			array( 'Can you check how AI tools describe my business today?', 'Yes. That is where every project starts. We put the real questions your customers ask to ChatGPT, Gemini and Perplexity, and to Google, and show you exactly what comes back, including anything that is wrong or out of date.' ),
			array( 'Can you guarantee ChatGPT recommends us?', 'No, and anyone who promises that is not being straight with you. Nobody controls what an AI model says. We make your business clear, accurate and easy to quote, which improves your odds, and we measure the result honestly.' ),
			array( 'Do I need a new website for this?', 'Not necessarily. Much of the work is structure and content that can be added to the site you have. If the site itself has deeper problems, we will say so rather than build on a weak foundation.' ),
		),
		'cta_title'    => 'Find out whether AI already has an answer, and whether it is you',
		'cta_text'     => 'Tell us your website and the questions you wish showed your name. Within two working days we’ll tell you where you stand on Google and in AI, and what it would take to change it.',
	)
);

get_footer();
