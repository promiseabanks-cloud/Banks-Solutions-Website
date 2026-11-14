<?php
/*
 * Homepage, built as scenes: hero (one enquiry through a connected system), clients, the problem, what we build (pinned
 * horizontal run), numbers, how a project runs, products, questions, closing call.
 * Copy: "Banks Solutions website: sitemap and copy" doc. Motion lives in home.js;
 * everything here reads in full with JavaScript off.
 */
get_header();

$b_start = banks_route( '/start/', '/contact/' );

$b_clients = array( 'Cedrus Microfinance Bank', 'Peakstone Law', 'AUA Legal', 'Legacy Legal', 'Amor Hotels', '67BC Academy', 'Stanley Jegede Foundation', 'Dr. Bimbo Mesele' );

$b_build = array(
	array(
		'title' => 'Websites & e-commerce',
		'text'  => 'Fast sites built around how your customers decide, including online stores with Paystack.',
		'meta'  => 'From ₦499,000 · about 5 weeks',
		'url'   => banks_route( '/solutions/websites/', '/services/digital-foundation/' ),
	),
	array(
		'title' => 'Web apps & custom solutions',
		'text'  => 'Client portals, booking systems, dashboards, internal tools and custom features for your website, built for how your team works.',
		'meta'  => 'Priced from a written spec',
		'url'   => banks_route( '/solutions/web-apps/', '/services/' ),
	),
	array(
		'title' => 'Automation & CRM',
		'text'  => 'Every enquiry captured and followed up, from WhatsApp to invoice, without spreadsheets.',
		'meta'  => 'From ₦800,000 + ₦250,000 a month',
		'url'   => banks_route( '/solutions/automation-crm/', '/services/automation-crm/' ),
	),
	array(
		'title' => 'AI solutions',
		'text'  => 'Practical AI for named jobs: answering routine questions, sorting enquiries, drafting documents.',
		'meta'  => 'Scoped to one job at a time',
		'url'   => banks_route( '/solutions/ai/', '/services/ai-custom-solutions/' ),
	),
	array(
		'title' => 'Care plans',
		'text'  => 'Updates, backups, security and changes, handled by a named person who knows your setup.',
		'meta'  => 'From ₦150,000 a month',
		'url'   => banks_route( '/solutions/care-plans/', '/services/managed-technology/' ),
	),
	array(
		'title' => 'SEO & AI search',
		'text'  => 'Found on Google and cited by ChatGPT, Gemini and Perplexity when people ask about your field.',
		'meta'  => 'SEO and AEO, built together',
		'url'   => banks_route( '/solutions/seo-aeo/', '/aeo/' ),
	),
);

$b_steps = array(
	array( 'Brief', 'You answer a short guided brief. It takes about 10 minutes.' ),
	array( 'Diagnose', 'We look at your market, your customers and what you already have, then recommend what the problem calls for.' ),
	array( 'Build', 'You watch progress live in your client portal, upload files there and pay in stages: in full, or half now and half on delivery.' ),
	array( 'Launch and stay', 'We launch, test, and keep it running on a care plan if you want one.' ),
);

$b_products = array(
	array( 'Banks Business Engine', 'An AI assistant and lead dashboard that answers, qualifies and follows up every enquiry.', 'See the product', banks_route( '/banks-business-engine/', '/services/ai-custom-solutions/' ) ),
	array( 'Shop', 'Ready-made software for businesses, starting with Banks Business Engine, with a booking platform coming next.', 'Browse the shop', banks_route( '/shop/' ) ),
	array( 'Labs', 'Free tools: a website cost calculator in naira, a speed check for Nigerian networks and an AI-search check.', 'Try a tool', banks_route( '/labs/' ) ),
);


$b_faqs = array(
	array( 'What does Banks Solutions do?', 'Banks Solutions is a Nigerian technology company based in Lagos and Ilorin that designs and builds websites, web apps and custom solutions, automation and AI systems. We work with businesses in any industry, in Nigeria and abroad, and also sell our own software, starting with the Banks Business Engine AI assistant.' ),
	array( 'How much does a website cost in Nigeria?', 'A business website from Banks Solutions starts at ₦499,000 and an online store at ₦750,000. Web apps and custom solutions are priced from a written spec, because the cost depends on what the system has to do. Every price includes structure, copy guidance, mobile performance and launch support.' ),
	array( 'Do you work with businesses outside Nigeria?', 'Yes. We have built for clients in 6 countries: Nigeria, the United States, the United Kingdom, Canada, Kenya and Australia. Projects run through the client portal, so you can track progress, share files and pay online from anywhere.' ),
	array( 'Can I pay in instalments?', 'Yes. Most projects are paid half at the start and half on delivery, or in full upfront. You pay securely by card or bank transfer through Paystack in your client portal.' ),
	array( 'How long does a project take?', 'A website takes about 5 weeks, an online store about 8 weeks, and a website with automation about 8 weeks. Web apps and custom solutions are scoped individually; you see the timeline before you commit.' ),
);
?>
<section class="h-hero" data-dark data-hero>
	<div class="h-hero__stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap h-hero__inner">
			<div class="h-hero__copy">
				<p class="b-eyebrow h-hero__eyebrow"><span class="s-live" aria-hidden="true"></span>Digital systems for businesses ready to work better</p>
				<h1 class="h-hero__title" data-split-hero>Make every customer enquiry count<span class="s-dot">.</span></h1>
				<p class="h-hero__lede">We build the websites and connected business systems that help your business attract the right customers, respond faster, keep follow-ups moving, and manage work without relying on scattered tools or someone’s memory.</p>
				<div class="h-hero__actions">
					<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>" data-magnetic>Start with a Digital Systems Audit</a>
					<a class="b-btn b-btn--line b-btn--lg" href="<?php echo esc_url( banks_route( '/solutions/', '/services/' ) ); ?>">See what we build</a>
				</div>
				<p class="h-hero__assure">A clear diagnosis first. The right solution next. No pressure to buy everything.</p>
				<ul class="h-hero__proof">
					<li><strong>9.0</strong> client rating</li>
					<li><strong>7+</strong> brands built</li>
					<li><strong>6</strong> countries served</li>
				</ul>
			</div>

			<?php // One enquiry moving through a connected system. Sample data only, no real customers. ?>
			<figure class="h-sys">
				<figcaption class="b-sr">Example: an enquiry from your website becomes a lead in your CRM, automation tells your team and the customer, and AI prepares the next step for a person to approve.</figcaption>
				<span class="h-sys__rail" aria-hidden="true"><span></span></span>
				<ol class="h-sys__list" aria-hidden="true">
					<li class="h-node h-node--web" data-node>
						<p class="h-node__tag"><i>01</i>Website</p>
						<div class="h-card">
							<div class="h-web__bar"><b></b><b></b><b></b><span>yourbusiness.com/quote</span></div>
							<div class="h-web__form">
								<p class="h-field"><small>Name</small><span>Daniel Okafor</span></p>
								<p class="h-field"><small>Location</small><span>Toronto, Canada</span></p>
								<p class="h-field h-field--wide"><small>What do you need?</small><span>Fit-out for a 3-floor office, start in March</span></p>
								<p class="h-web__send"><span class="h-web__send-a">Send enquiry</span><span class="h-web__send-b">Sent ✓</span></p>
							</div>
						</div>
					</li>
					<li class="h-node h-node--crm" data-node>
						<p class="h-node__tag"><i>02</i>CRM</p>
						<div class="h-card">
							<div class="h-crm__head"><span class="h-crm__av">DO</span><div><b>Daniel Okafor</b><small>New lead · from website · Toronto</small></div><em>Owner: Sade</em></div>
							<ol class="h-crm__stages"><li>New</li><li class="is-on">Qualified</li><li>Proposal</li><li>Won</li></ol>
						</div>
					</li>
					<li class="h-node h-node--auto" data-node>
						<p class="h-node__tag"><i>03</i>Automation</p>
						<div class="h-card">
							<p class="h-auto__row"><span class="h-ico h-ico--wa"><svg viewBox="0 0 24 24"><path d="M12 3.5a8.5 8.5 0 0 0-7.3 12.8L3.5 20.5l4.3-1.1A8.5 8.5 0 1 0 12 3.5Z"/></svg></span><span><b>WhatsApp to Sade</b>New lead assigned: Daniel Okafor</span></p>
							<p class="h-auto__row"><span class="h-ico h-ico--mail"><svg viewBox="0 0 24 24"><path d="M4 7.5 12 13l8-5.5M5 6h14a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1Z"/></svg></span><span><b>Email to Daniel</b>Enquiry received, with a link to book a call</span></p>
							<p class="h-auto__row"><span class="h-ico h-ico--time"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"/><path d="M12 8v4l2.5 2"/></svg></span><span><b>Follow-up set</b>Reminder for Sade if no reply in 2 days</span></p>
						</div>
					</li>
					<li class="h-node h-node--ai" data-node>
						<p class="h-node__tag"><i>04</i>AI</p>
						<div class="h-card">
							<p class="h-ai__label"><span>✦</span>Summary for Sade</p>
							<p class="h-ai__text">Daniel needs a 3-floor office fit-out from March and prefers a call. A reply with three times for this week is drafted.</p>
							<p class="h-ai__btns"><span class="is-primary">Approve and send</span><span>Edit</span></p>
						</div>
					</li>
				</ol>
			</figure>
		</div>
	</div>
</section>

<section class="h-clients" id="h-clients" aria-label="Clients">
	<p class="b-wrap b-eyebrow">Trusted by businesses in 6 countries</p>
	<div class="h-marquee">
		<ul class="h-marquee__track">
			<?php foreach ( $b_clients as $b_c ) : ?>
				<li><?php echo esc_html( $b_c ); ?></li>
			<?php endforeach; ?>
			<?php foreach ( $b_clients as $b_c ) : ?>
				<li class="h-marquee__dupe" aria-hidden="true" hidden><?php echo esc_html( $b_c ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="h-problem">
	<div class="b-wrap">
		<p class="b-eyebrow">The problem</p>
		<h2 class="h-problem__title" data-split>Most businesses don't need more software. They need software that fits.</h2>
		<p class="h-problem__text" data-scrub-words>The website looks fine but brings no enquiries. Leads sit in WhatsApp. Staff copy the same data between three tools. Off-the-shelf apps almost fit, and the gap costs you every week. We start by finding where the work actually breaks, then build the smallest thing that fixes it.</p>
	</div>
</section>

<section class="h-build" id="h-build" data-dark>
	<div class="h-build__pin">
		<div class="b-wrap h-build__head">
			<p class="b-eyebrow">What we build</p>
			<h2 data-split>Six ways we make a business run better.</h2>
		</div>
		<div class="h-build__viewport">
			<ol class="h-build__track">
				<?php foreach ( $b_build as $b_i => $b_s ) : ?>
					<li class="h-panel">
						<a class="h-panel__card" href="<?php echo esc_url( $b_s['url'] ); ?>" data-tilt>
							<span class="h-panel__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span>
							<span class="h-panel__orb" aria-hidden="true"></span>
							<h3 class="h-panel__title"><?php echo esc_html( $b_s['title'] ); ?></h3>
							<p class="h-panel__text"><?php echo esc_html( $b_s['text'] ); ?></p>
							<span class="h-panel__meta"><?php echo esc_html( $b_s['meta'] ); ?></span>
							<span class="h-panel__go">Explore <span aria-hidden="true">→</span></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
		<div class="b-wrap"><div class="h-build__bar" aria-hidden="true"><span></span></div></div>
	</div>
</section>

<section class="h-numbers" aria-label="Banks Solutions in numbers">
	<div class="b-wrap h-numbers__grid">
		<div class="h-stat"><span class="h-stat__rule" aria-hidden="true"></span><span class="h-stat__num" data-count="9.0" data-decimals="1">9.0</span><span class="h-stat__label">client rating out of 10</span></div>
		<div class="h-stat"><span class="h-stat__rule" aria-hidden="true"></span><span class="h-stat__num" data-count="7">7</span><span class="h-stat__plus">+</span><span class="h-stat__label">brands built</span></div>
		<div class="h-stat"><span class="h-stat__rule" aria-hidden="true"></span><span class="h-stat__num" data-count="6">6</span><span class="h-stat__label">countries: Nigeria, US, UK, Canada, Kenya, Australia</span></div>
		<div class="h-stat"><span class="h-stat__rule" aria-hidden="true"></span><span class="h-stat__num" data-count="5">5</span><span class="h-stat__label">weeks to a live website</span></div>
	</div>
</section>

<section class="h-process">
	<div class="b-wrap h-process__grid">
		<div class="h-process__head">
			<p class="b-eyebrow">How we work</p>
			<h2 data-split>How a project runs.</h2>
			<p>From the first brief to launch day, everything lives in your client portal: progress, files, approvals and payments.</p>
			<a class="b-btn b-btn--lagoon" href="<?php echo esc_url( $b_start ); ?>" data-magnetic>Start the brief</a>
		</div>
		<div class="h-steps">
			<span class="h-steps__rail" aria-hidden="true"><span></span></span>
			<ol class="h-steps__list">
			<?php foreach ( $b_steps as $b_i => $b_s ) : ?>
				<li class="h-step">
					<span class="h-step__dot" aria-hidden="true"><?php echo esc_html( $b_i + 1 ); ?></span>
					<h3><?php echo esc_html( $b_s[0] ); ?></h3>
					<p><?php echo esc_html( $b_s[1] ); ?></p>
				</li>
			<?php endforeach; ?>
			</ol>
		</div>
	</div>
</section>

<section class="h-products">
	<div class="b-wrap">
		<p class="b-eyebrow">Products</p>
		<h2 data-split>Things we've built for everyone.</h2>
		<div class="h-products__grid">
			<?php foreach ( $b_products as $b_p ) : ?>
				<?php $b_tag = $b_p[3] ? 'a' : 'div'; ?>
				<<?php echo esc_attr( $b_tag ); ?> class="h-product" data-spot<?php echo $b_p[3] ? ' href="' . esc_url( $b_p[3] ) . '"' : ''; ?>>
					<h3><?php echo esc_html( $b_p[0] ); ?></h3>
					<p><?php echo esc_html( $b_p[1] ); ?></p>
					<span class="h-product__go"><?php echo esc_html( $b_p[3] ? $b_p[2] : 'Coming soon' ); ?><?php echo $b_p[3] ? ' <span aria-hidden="true">→</span>' : ''; ?></span>
				</<?php echo esc_attr( $b_tag ); ?>>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>What people ask before they start.</h2>
		</div>
		<div class="s-faq__list">
			<?php foreach ( $b_faqs as $b_f ) : ?>
				<details class="s-qa">
					<summary><?php echo esc_html( $b_f[0] ); ?><span class="s-qa__icon" aria-hidden="true"></span></summary>
					<div class="s-qa__a"><p><?php echo esc_html( $b_f[1] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="s-cta" data-dark>
	<div class="s-glow" aria-hidden="true"></div>
	<div class="b-wrap s-cta__inner">
		<h2 class="s-cta__title" data-split>Tell us what's slowing the business down<span class="s-dot">.</span></h2>
		<p>Ten minutes on the brief, and we'll come back within two working days with what we'd build, how long it takes and what it costs.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>" data-magnetic="0.45">Start a project</a>
	</div>
</section>

<script type="application/ld+json">
<?php
echo wp_json_encode(
	array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => array_map(
			function ( $f ) {
				return array(
					'@type'          => 'Question',
					'name'           => $f[0],
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => $f[1],
					),
				);
			},
			$b_faqs
		),
	),
	JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG
);
?>
</script>
<?php
get_footer();
