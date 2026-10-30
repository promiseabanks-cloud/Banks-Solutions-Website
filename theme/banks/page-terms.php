<?php
/*
 * Terms (/terms/): using the website, quotes and projects, payments, ownership, software
 * licences, care plans, liability and law. A signed quote or agreement wins where it differs.
 * Layout: template-parts/legal.php.
 */
get_header();

$b_email   = banks_detail( 'email' );
$b_mail    = '<a href="mailto:' . esc_attr( $b_email ) . '">' . esc_html( $b_email ) . '</a>';
$b_privacy = '<a href="' . esc_url( banks_route( '/privacy-policy/', '/contact/' ) ) . '">privacy policy</a>';

get_template_part(
	'template-parts/legal',
	null,
	array(
		'path'     => '/terms/',
		'eyebrow'  => 'Legal · Terms',
		'h1'       => 'Terms of service',
		'lede'     => 'The terms for using bankssolution.ng and for working with Banks Solutions: quotes, projects, payments, ownership and the software licences we sell.',
		'updated'  => '2026-10-28',
		'summary'  => array(
			'Every project starts with a written quote. If a quote or agreement we both accepted says something different from these terms, the quote or agreement wins.',
			'Prices are in naira unless we agree otherwise, and work starts once the first payment is made.',
			'Who owns the finished work is agreed in writing in the quote, before we start.',
			'Software licences cover one website. If one lapses, updates and support stop and its public features pause, but your data stays yours.',
		),
		'sections' => array(
			array(
				'id'    => 'about',
				'title' => 'About these terms',
				'body'  => array(
					'These terms are between you and ' . esc_html( banks_detail( 'legal' ) ) . ' (trading as Banks Solutions), RC ' . esc_html( banks_detail( 'rc' ) ) . ', based in ' . esc_html( banks_detail( 'locations' ) ) . '. They apply when you use this website and when you buy a service or product from us.',
					'For each project we also send a written quote or agreement. Where it differs from these terms, the quote or agreement applies. How we handle personal information is in our ' . $b_privacy . '.',
				),
			),
			array(
				'id'    => 'site',
				'title' => 'Using this website',
				'body'  => array(
					'The information on this website is general. Prices marked “from” are starting points, and your quote is what applies to your project.',
					'Our chat assistant answers from what we have told it. It can make mistakes, so please confirm prices, dates and anything important with our team before relying on it.',
					'Please don’t misuse the website: no attempts to break in or disrupt it, no automated scraping, and no spam through the forms or the assistant.',
				),
			),
			array(
				'id'    => 'quotes',
				'title' => 'Quotes and projects',
				'body'  => array(
					array(
						'list',
						array(
							'A quote sets out the scope, price, payment stages and timeline. It is valid for 30 days unless it says otherwise.',
							'A project starts when you accept the quote and the first payment reaches us.',
							'Timelines depend on getting content, feedback and approvals from you on time. If those are late, the timeline moves with them.',
							'Anything outside the agreed scope is quoted separately before we do it.',
						)
					),
				),
			),
			array(
				'id'    => 'payments',
				'title' => 'Payments',
				'body'  => array(
					array(
						'list',
						array(
							'Prices are in Nigerian naira unless we agree another currency in writing.',
							'We invoice through Paystack, and you can pay by card, bank transfer or USSD.',
							'Projects are paid in the stages set out in the quote. Monthly services such as care plans and licences are paid in advance each month.',
							'If a payment is late, we may pause work, support or a licence until it is paid.',
						)
					),
				),
			),
			array(
				'id'    => 'ownership',
				'title' => 'Ownership of the work',
				'body'  => array(
					'Who owns the finished work, and on what terms, is agreed in writing in the quote before work starts. Until everything due on a project is paid, we keep the rights to the work we have made for it.',
					'Content, logos and materials you give us stay yours. You confirm you have the right to let us use them for your project.',
					'Our own products, tools and code we reuse across projects, such as Banks Business Engine, stay ours. You get a licence to use them as described below.',
				),
			),
			array(
				'id'    => 'licences',
				'title' => 'Software licences',
				'body'  => array(
					'Software from our shop, such as Banks Business Engine, is licensed, not sold:',
					array(
						'list',
						array(
							'One licence covers one website.',
							'While a licence is active you get updates and support from our team.',
							'Please don’t copy, resell or share the software or its licence key.',
							'If a licence lapses, updates and support stop and the software’s public features pause. Your data stays on your website and nothing is deleted.',
						)
					),
					'Some products use services run by others, such as an AI provider, WhatsApp or Paystack, under your own accounts. Their charges and terms are between you and them.',
				),
			),
			array(
				'id'    => 'care',
				'title' => 'Care plans and support',
				'body'  => array(
					'Care plans and support run month to month and cover what the plan or quote describes. Work outside the plan is quoted separately. You can end a monthly plan with written notice before the next month starts.',
				),
			),
			array(
				'id'    => 'third',
				'title' => 'Services run by others',
				'body'  => array(
					'Our work often connects to services run by other companies, such as hosting, domains, payment, messaging and AI providers. We choose and set them up with care, but we don’t control them and aren’t responsible for their outages, changes or charges.',
				),
			),
			array(
				'id'    => 'liability',
				'title' => 'Our responsibility',
				'body'  => array(
					'We do our work with reasonable skill and care, and if something we built doesn’t work as agreed, we fix it.',
					'As far as the law allows, we aren’t responsible for indirect losses such as lost profit or lost data from causes outside our control, and our total responsibility for a project or service is limited to what you paid us for it in the 12 months before the claim. Nothing in these terms limits anything the law doesn’t allow us to limit.',
				),
			),
			array(
				'id'    => 'ending',
				'title' => 'Ending work',
				'body'  => array(
					'Either of us can end a project or service by written notice. You pay for the work done up to that point, and we hand over what has been paid for.',
				),
			),
			array(
				'id'    => 'law',
				'title' => 'Law and disputes',
				'body'  => array(
					'These terms are governed by the laws of the Federal Republic of Nigeria. If we disagree, we will first try to settle it by talking. If that fails, the courts of Lagos State will decide.',
				),
			),
			array(
				'id'    => 'changes',
				'title' => 'Changes and contact',
				'body'  => array(
					'We may update these terms and will change the date at the top when we do. The version in place when you accepted a quote applies to that project. Questions go to ' . $b_mail . '.',
				),
			),
		),
	)
);

get_footer();
