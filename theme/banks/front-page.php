<?php
/*
 * Homepage, built as scenes: hero, clients, the problem, what we build (pinned
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
<section class="h-hero" data-dark>
	<div class="h-hero__stage">
		<div class="h-hero__glow" aria-hidden="true"></div>
		<svg class="h-flow" viewBox="0 0 1440 900" preserveAspectRatio="none" aria-hidden="true">
			<path class="h-flow__bank" d="M-20 140 C 320 120, 420 380, 720 420 S 1180 520, 1460 760"/>
			<path class="h-flow__line" d="M-20 140 C 320 120, 420 380, 720 420 S 1180 520, 1460 760"/>
			<path class="h-flow__line h-flow__line--2" d="M-20 300 C 300 280, 480 520, 760 560 S 1200 640, 1460 900"/>
		</svg>
		<div class="b-wrap h-hero__inner">
			<div class="h-hero__copy">
				<p class="b-eyebrow h-hero__eyebrow"><span class="h-live" aria-hidden="true"></span>Technology company · Lagos &amp; Ilorin · Clients in 6 countries</p>
				<h1 class="h-hero__title">
					<span class="b-sr">We build the websites, web apps, automation and AI your business runs on.</span>
					<span class="h-hero__say" aria-hidden="true" data-split-hero>We build the</span>
					<span class="h-rot" aria-hidden="true"><?php foreach ( array( 'websites', 'web apps', 'online stores', 'automations', 'AI tools' ) as $b_i => $b_w ) : ?><span class="h-rot__word<?php echo 0 === $b_i ? ' is-on' : ''; ?>"><?php echo esc_html( $b_w ); ?></span><?php endforeach; ?></span>
					<span class="h-hero__say" aria-hidden="true" data-split-hero>your business runs on<span class="h-dot">.</span></span>
				</h1>
				<p class="h-hero__lede">Banks Solutions designs, builds and looks after the technology behind growing businesses in any industry. Websites from ₦499,000, live in about 5 weeks. Web apps and custom solutions priced from a written spec.</p>
				<div class="h-hero__actions">
					<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>" data-magnetic>Start a project</a>
					<a class="b-btn b-btn--line b-btn--lg" href="#h-build">See what we build</a>
				</div>
				<ul class="h-hero__proof">
					<li><strong>9.0</strong> client rating</li>
					<li><strong>7+</strong> brands built</li>
					<li><strong>6</strong> countries</li>
				</ul>
			</div>

			<div class="h-sys" aria-hidden="true">
				<div class="h-sys__card h-sys__site" data-depth="0.6">
					<div class="h-sys__chrome"><i></i><i></i><i></i><span>yourbusiness.ng</span></div>
					<div class="h-sys__page">
						<span class="h-sys__bar h-sys__bar--lg"></span>
						<span class="h-sys__bar h-sys__bar--md"></span>
						<span class="h-sys__bar"></span>
						<span class="h-sys__pill">Book a call</span>
						<div class="h-sys__tiles"><span></span><span></span><span></span></div>
					</div>
				</div>
				<div class="h-sys__card h-sys__stats" data-depth="1.1">
					<p class="h-sys__label">Enquiries this month</p>
					<p class="h-sys__big"><span data-sys-count="128">128</span> <em>+34%</em></p>
					<svg class="h-sys__spark" viewBox="0 0 200 56" preserveAspectRatio="none"><path d="M0 48 L22 44 L44 46 L66 36 L88 38 L110 26 L132 30 L154 16 L176 18 L200 6"/></svg>
				</div>
				<div class="h-sys__card h-sys__toast" data-depth="1.6">
					<span class="h-sys__icon">↗</span>
					<div><p class="h-sys__label">New lead · WhatsApp</p><p class="h-sys__msg" data-sys-msg>Ada wants a quote for a new website</p></div>
				</div>
				<div class="h-sys__card h-sys__pay" data-depth="0.9">
					<span class="h-sys__check">✓</span>
					<div><p class="h-sys__label">Invoice #0042 paid · Paystack</p><p class="h-sys__msg">₦375,000 · half on start</p></div>
				</div>
			</div>
		</div>
		<a class="h-hero__scroll" href="#h-clients" aria-label="Scroll to the next section"><span></span></a>
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
		<div class="h-stat" data-reveal><span class="h-stat__num" data-count="9.0" data-decimals="1">9.0</span><span class="h-stat__label">client rating out of 10</span></div>
		<div class="h-stat" data-reveal><span class="h-stat__num" data-count="7">7</span><span class="h-stat__plus">+</span><span class="h-stat__label">brands built</span></div>
		<div class="h-stat" data-reveal><span class="h-stat__num" data-count="6">6</span><span class="h-stat__label">countries: Nigeria, US, UK, Canada, Kenya, Australia</span></div>
		<div class="h-stat" data-reveal><span class="h-stat__num" data-count="5">5</span><span class="h-stat__label">weeks to a live website</span></div>
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
				<li class="h-step" data-reveal>
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
				<<?php echo esc_attr( $b_tag ); ?> class="h-product" data-reveal data-spot<?php echo $b_p[3] ? ' href="' . esc_url( $b_p[3] ) . '"' : ''; ?>>
					<h3><?php echo esc_html( $b_p[0] ); ?></h3>
					<p><?php echo esc_html( $b_p[1] ); ?></p>
					<span class="h-product__go"><?php echo esc_html( $b_p[3] ? $b_p[2] : 'Coming soon' ); ?><?php echo $b_p[3] ? ' <span aria-hidden="true">→</span>' : ''; ?></span>
				</<?php echo esc_attr( $b_tag ); ?>>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="h-faq">
	<div class="b-wrap h-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>What people ask before they start.</h2>
		</div>
		<div class="h-faq__list">
			<?php foreach ( $b_faqs as $b_f ) : ?>
				<details class="h-qa">
					<summary><?php echo esc_html( $b_f[0] ); ?><span class="h-qa__icon" aria-hidden="true"></span></summary>
					<div class="h-qa__a"><p><?php echo esc_html( $b_f[1] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="h-cta" data-dark>
	<div class="h-hero__glow" aria-hidden="true"></div>
	<div class="b-wrap h-cta__inner">
		<h2 class="h-cta__title" data-split>Tell us what's slowing the business down<span class="h-dot">.</span></h2>
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
