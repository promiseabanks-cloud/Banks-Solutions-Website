<?php
/*
 * AI solutions (/solutions/ai/), replaces /services/ai-custom-solutions/.
 * Copy: "Banks Solutions website: sitemap and copy" doc, middle sections carried over from the
 * old page. Layout and motion: template-parts/solution.php and solution.{css,js}.
 */
get_header();

get_template_part(
	'template-parts/solution',
	null,
	array(
		'slug'         => 'ai',
		'name'         => 'AI solutions',
		'service_type' => 'AI assistants and business process automation',
		'start'        => banks_route( '/start/', '/contact/' ),
		'h1'           => 'AI, aimed at a specific job you can name',
		'answer'       => 'Banks Solutions builds practical AI for businesses: assistants that answer routine customer questions, tools that sort enquiries, and systems that draft documents or find answers in your own files. We’ll also tell you when a simpler fix, like a working CRM, will do more for less.',
		'facts'        => array(
			array( '1 job', 'named before we build' ),
			array( '100%', 'checked by a person' ),
			array( 'Spec', 'fixed price, upfront' ),
		),
		'check_title'  => 'Where AI actually earns its keep.',
		'check_text'   => 'AI is good at repetitive work with words and information. If two or more of these sound familiar, there is probably a job worth handing over, and we can say what it is worth.',
		'symptoms'     => array(
			array( 'You answer the same twenty questions every week.', 'Prices, opening hours, delivery areas, how to pay. Someone types the same answers again and again.' ),
			array( 'Enquiries need sorting before anyone can act.', 'Someone reads every message just to work out who should deal with it.' ),
			array( 'You write the same document repeatedly.', 'Quotes, proposals and reports that are mostly the same, rebuilt each time.' ),
			array( 'Information is buried in messages.', 'Order details, addresses and dates sit in chats and emails, and someone copies them out by hand.' ),
			array( 'Customers wait overnight for simple answers.', 'A question at 10 pm gets a reply the next morning, by which time they have asked someone else.' ),
			array( 'Someone spends hours moving data between systems.', 'Reading one screen and typing into another is a job, and nobody enjoys it.' ),
		),
		'say_label'    => 'Our view',
		'say'          => 'If someone is selling you AI without first asking what your process looks like, they are selling you software, not a solution.',
		'say_text'     => array(
			'AI drafts. A person still signs. Everything we build keeps a human check where it matters: the assistant answers routine questions, and anything unusual, sensitive or expensive goes to a person on your team with the context ready.',
			'Automating a broken process just breaks it faster, and many businesses need a working CRM before they need AI. If that is you, we will say so and point you to the cheaper fix first.',
		),
		'inc_title'    => 'What we build.',
		'inc_text'     => 'Each project starts with one job you can name and measure. Want an assistant that is ready today? Banks Business Engine is our AI assistant and lead dashboard, on a monthly plan.',
		'included'     => array(
			array(
				'title' => 'It answers and sorts',
				'items' => array(
					array( 'Customer question assistant', 'Answers routine questions on your website or WhatsApp from information you approve, day and night, and hands over to a person when it should.' ),
					array( 'Enquiry sorting and routing', 'Reads each incoming message, works out what it is about and how urgent it is, and sends it to the right person or system.' ),
				),
			),
			array(
				'title' => 'It reads and writes',
				'items' => array(
					array( 'Document drafting', 'First drafts of quotes, proposals, reports and replies from your templates and data, ready for a person to check.' ),
					array( 'Summarising and extraction', 'Pulls names, dates, amounts and order details out of messages and files, and summarises long threads into what matters.' ),
					array( 'Content support', 'Product descriptions, social captions and first drafts in your voice, reviewed before anything is published.' ),
				),
			),
			array(
				'title' => 'It connects, and a person signs off',
				'items' => array(
					array( 'Custom builds and integrations', 'AI connected to your website, CRM, WhatsApp, email and files, so it works inside the tools you already use.' ),
					array( 'A human check in the loop', 'Approvals, confidence limits and handover rules, so nothing important goes out without someone on your team seeing it.' ),
				),
			),
		),
		'run_title'    => 'How an AI project runs.',
		'run_text'     => 'Deliberately small at first. We prove one job works, alongside your team, before anything else is automated.',
		'steps'        => array(
			array( 'Start', 'Audit and brief', 'We look at how the work runs today and find the job where AI saves the most time with the least risk.' ),
			array( 'Before any code', 'Pick one job', 'One named task, how it is done now, what it costs each week and how we will measure the result, in writing.' ),
			array( 'Build', 'Build and test', 'We build it on your real questions, documents and data, and test it against the cases that usually go wrong.' ),
			array( 'Trial', 'Run alongside', 'It runs next to your team for a few weeks, with a person checking every output, until the numbers say it is ready.' ),
			array( 'Then', 'Adopt, then extend', 'Once the first job pays for itself, we hand it over properly and look at the next one.' ),
		),
		'fit_yes'      => array(
			'You can name the task and how much time it takes',
			'The process works, it is just manual',
			'You accept that a person checks the important outputs',
			'You want a contained result you can prove, then grow',
		),
		'fit_no'       => array(
			'You want AI because it sounds like the right thing to have',
			'The process behind it is broken or undefined',
			'You expect it to replace judgement, not repetitive work',
			'Nobody on your side has time to review what it produces',
		),
		'plans_title'  => 'What does an AI project cost?',
		'plans_text'   => 'Custom AI is priced from a written spec after the brief, because the cost depends on the job, the data and the systems it touches. If a ready-made assistant will do, Banks Business Engine runs on a monthly plan.',
		'plans'        => array(
			array(
				'name'  => 'Audit and brief',
				'label' => 'Start here',
				'when'  => 'About a week',
				'text'  => 'We map the process, find the job worth handing to AI and tell you plainly whether AI is the right fix at all.',
				'cta'   => 'Start the brief',
			),
			array(
				'name'     => 'A custom AI build',
				'label'    => 'From a spec',
				'featured' => true,
				'when'     => 'Timeline in the spec',
				'text'     => 'One named job built, tested on your real data and run alongside your team, with a human check and clear numbers.',
				'cta'      => 'Describe the job',
			),
			array(
				'name'  => 'Banks Business Engine',
				'label' => 'Monthly plans',
				'when'  => 'Ready to set up',
				'text'  => 'Our AI assistant and lead dashboard: answers routine questions, captures every lead and shows you where they came from.',
				'cta'   => 'Ask about the Engine',
			),
		),
		'plans_note'   => 'Every custom price is fixed in the spec before work starts. AI usage costs, such as model fees, are shown separately and never marked up.',
		'faqs'         => array(
			array( 'How can a small business use AI?', 'The best uses are repetitive jobs with words and information: answering routine customer questions, sorting enquiries, drafting quotes and documents, and pulling details out of messages. Start with one job you can name and measure, prove it works, then extend.' ),
			array( 'Is an AI chatbot worth it?', 'It is worth it when customers ask the same questions often and wait too long for answers. It is not worth it when enquiries are rare or every conversation needs judgement. We look at your message volume and the questions people ask before recommending one.' ),
			array( 'Is this just ChatGPT with our name on it?', 'No. We use leading AI models, but the work is in what surrounds them: your approved information, the rules about what it may say, the handover to a person, and the connection to your website, WhatsApp and CRM. That is what makes it accurate and useful for your business.' ),
			array( 'Will it give customers wrong information?', 'Any AI can make mistakes, which is why we limit it to information you approve, set it to hand over when it is unsure, and keep a person checking anything important. During the trial every answer is reviewed, so problems are found before customers see them.' ),
			array( 'Is my business data safe?', 'We set up access controls, keep data use to what the job needs and choose providers that do not train on your data. Data protection is a legal duty in Nigeria under the Nigeria Data Protection Act 2023. We are not lawyers and this is not legal advice.' ),
			array( 'What does an AI project cost?', 'Custom AI is priced from a written spec after a short audit and brief, because cost depends on the job and the systems involved. Banks Business Engine, our ready-made AI assistant and lead dashboard, runs on monthly plans. Model usage fees are shown separately with no mark-up.' ),
			array( 'Should we do AI before fixing our CRM?', 'Usually not. AI works best on top of organised information, and a working CRM often saves more time for less money. If your enquiries live in phones and spreadsheets, we will usually suggest the CRM first.' ),
		),
		'cta_title'    => 'Find out whether AI is your next move, or a distraction',
		'cta_text'     => 'Tell us the job you would hand over first and how long it takes today. Within two working days we’ll tell you whether AI is the right fix, what it would cost and what it would save.',
	)
);

get_footer();
