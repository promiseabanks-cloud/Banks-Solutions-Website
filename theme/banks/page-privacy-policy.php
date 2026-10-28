<?php
/*
 * Privacy policy (/privacy-policy/). Written against what this site actually collects: the
 * brief at /start/, the chat assistant, forms, email and WhatsApp, client project records and
 * payments, server logs and two browser-storage keys. Layout: template-parts/legal.php.
 */
get_header();

$b_email = banks_detail( 'email' );
$b_mail  = '<a href="mailto:' . esc_attr( $b_email ) . '">' . esc_html( $b_email ) . '</a>';

get_template_part(
	'template-parts/legal',
	null,
	array(
		'path'     => '/privacy-policy/',
		'eyebrow'  => 'Legal · Privacy',
		'h1'       => 'Privacy policy',
		'lede'     => 'How Banks Solutions collects, uses and protects personal information when you use bankssolution.ng, send us a brief, talk to our assistant or work with us, and the rights you have under the Nigeria Data Protection Act 2023.',
		'updated'  => '2026-10-28',
		'summary'  => array(
			'We collect what you choose to send us, such as a project brief, a chat or a message, plus the basic technical logs every website keeps.',
			'We use it to reply to you, quote, deliver your project and run our business. <strong>We never sell it</strong> and we don’t use advertising or tracking cookies.',
			'Some trusted providers help us, such as our host, email, payments and AI, and only get what they need to do that job.',
			'You can ask to see, correct or delete your information at any time by emailing ' . $b_mail . '.',
		),
		'sections' => array(
			array(
				'id'    => 'who',
				'title' => 'Who we are',
				'body'  => array(
					'This website is run by ' . esc_html( banks_detail( 'legal' ) ) . ' (trading as Banks Solutions), a company registered in Nigeria with RC number ' . esc_html( banks_detail( 'rc' ) ) . ', based in ' . esc_html( banks_detail( 'locations' ) ) . '. For the personal information described here, we are the data controller.',
					'Questions about this policy or your information go to ' . $b_mail . '.',
				),
			),
			array(
				'id'    => 'collect',
				'title' => 'What we collect',
				'body'  => array(
					'We only collect information you give us, or that is created when you use the site:',
					array(
						'list',
						array(
							'<strong>Project briefs.</strong> When you use the brief at /start/: your business name, field, website, what you need, what success looks like, budget, timeline, your name, email and, if you give it, a phone or WhatsApp number.',
							'<strong>Chat with our assistant.</strong> What you type to the assistant on our website, and any name, contact details or booking details you share in the conversation.',
							'<strong>Messages.</strong> What you send through a contact form, by email or on WhatsApp.',
							'<strong>Client records.</strong> If you work with us: contact details, project files you share, agreements, invoices and payment status.',
							'<strong>Technical logs.</strong> Your IP address, browser, the pages requested and the time, recorded by our web host and our login protection to keep the site secure.',
						)
					),
				),
			),
			array(
				'id'    => 'use',
				'title' => 'How we use it, and why we may',
				'body'  => array(
					'We use personal information for these purposes, each with a lawful basis under the Nigeria Data Protection Act 2023:',
					array(
						'list',
						array(
							'To reply to your brief, chat or message and prepare a quote, because you asked us to, which is a step before a contract and is based on your consent.',
							'To deliver a project, support and licences we have agreed, because it is needed to perform our contract with you.',
							'To invoice, keep accounts and meet tax and legal duties, because the law requires it.',
							'To keep the website and our systems secure and working, which is our legitimate interest.',
						)
					),
					'We don’t use your information for automated decisions that have legal or similarly significant effects on you. Our assistant answers questions and collects details for our team, and a person makes every decision about your project.',
				),
			),
			array(
				'id'    => 'share',
				'title' => 'Who we share it with',
				'body'  => array(
					'We never sell personal information. We share it only with providers who help us run our business, and only what each one needs:',
					array(
						'list',
						array(
							'Our web hosting provider, where this website and its data are stored.',
							'Our email delivery provider, which sends the emails this site generates, such as your brief confirmation.',
							'An AI provider (OpenAI or Groq), which processes chat messages so the assistant can reply.',
							'Paystack, which handles payments. We never see or store your full card details.',
							'Meta, which operates WhatsApp, when you message us there.',
							'Google, which serves the fonts this site uses. Your browser asks Google for them, so Google sees your IP address.',
						)
					),
					'We may also disclose information when the law requires it, or to protect our rights, our clients or the public.',
				),
			),
			array(
				'id'    => 'transfers',
				'title' => 'Information sent outside Nigeria',
				'body'  => array(
					'Some of these providers store or process information outside Nigeria, for example in the United States or Europe. When that happens we rely on the safeguards the Nigeria Data Protection Act 2023 allows, such as the provider’s contractual commitments to protect it.',
				),
			),
			array(
				'id'    => 'storage',
				'title' => 'Cookies and browser storage',
				'body'  => array(
					'This website does not use advertising cookies or analytics trackers. It stores two small settings in your own browser, which never leave your device:',
					array(
						'list',
						array(
							'<strong>banks-theme</strong> remembers whether you chose light or dark mode.',
							'<strong>banks-curtain</strong> lasts only until you close the tab and makes page changes look smooth.',
						)
					),
					'If you sign in to a client portal or the site’s dashboard, WordPress sets the cookies it needs to keep you signed in.',
				),
			),
			array(
				'id'    => 'keep',
				'title' => 'How long we keep it',
				'body'  => array(
					'We keep information only as long as we need it:',
					array(
						'list',
						array(
							'Briefs, chats and messages that don’t become a project: up to 24 months after we last spoke.',
							'Client and financial records: six years after the project ends, to meet tax and accounting rules.',
							'Technical logs: kept by our host for a short period for security, then deleted.',
						)
					),
					'You can ask us to delete your information sooner, unless the law requires us to keep it.',
				),
			),
			array(
				'id'    => 'rights',
				'title' => 'Your rights',
				'body'  => array(
					'Under the Nigeria Data Protection Act 2023 you can ask us to:',
					array(
						'list',
						array(
							'tell you what information we hold about you and give you a copy;',
							'correct anything that is wrong or out of date;',
							'delete your information;',
							'restrict or stop using it, or object to how we use it;',
							'send it to you or another provider in a common format;',
							'withdraw your consent at any time, without affecting what we did before.',
						)
					),
					'Email ' . $b_mail . ' with your request. We may ask you to confirm who you are, and we will respond within 30 days. If you are unhappy with how we handle your information, you can complain to the Nigeria Data Protection Commission.',
				),
			),
			array(
				'id'    => 'security',
				'title' => 'How we protect it',
				'body'  => array(
					'This site uses HTTPS. Access to personal information is limited to the people who need it, passwords and API keys are encrypted before they are stored, and logins are protected against repeated guessing. No system is perfectly secure, so if a breach ever affected your information, we would tell you and the regulator as the law requires.',
				),
			),
			array(
				'id'    => 'clients',
				'title' => 'Websites we run for clients',
				'body'  => array(
					'When we build or manage a website, or set up Banks Business Engine, for a client, that client decides how their visitors’ information is used and is the data controller. We act as their data processor and follow their instructions. If you are a visitor to one of our clients’ websites, their own privacy policy applies, and they are the right people to contact first.',
				),
			),
			array(
				'id'    => 'children',
				'title' => 'Children',
				'body'  => array(
					'Our services are for businesses and are not aimed at children under 18. We don’t knowingly collect information from children.',
				),
			),
			array(
				'id'    => 'changes',
				'title' => 'Changes and contact',
				'body'  => array(
					'We will update this policy when what we collect or how we use it changes, and change the date at the top. For anything about your information, email ' . $b_mail . ' or write to ' . esc_html( banks_detail( 'legal' ) ) . ', ' . esc_html( banks_detail( 'locations' ) ) . '.',
				),
			),
		),
	)
);

get_footer();
