<?php
/*
 * Homepage, built as scenes: hero (a pinned scroll story), clients, the problem, what we build (pinned
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

// The hero story: one order followed through everything we build. Tag, headline, line.
$b_beats = array(
	array( 'Your website', 'An order lands', "It's 9:41 on a Friday night. Ada finds what she wants on your website and pays by card. You are nowhere near your phone." ),
	array( 'Automation', 'WhatsApp tells you', 'Seconds later the order is on your WhatsApp, and Ada has her confirmation. Nobody typed either message.' ),
	array( 'Automation & CRM', 'The receipt sends itself', 'A branded email goes out with her invoice and delivery details, and her record is saved for next time.' ),
	array( 'Web apps', 'The dashboard keeps count', "The order is logged, stock drops by one and today's revenue adds up, on a dashboard built around your business." ),
	array( 'AI', 'AI answers the follow-up', 'Ada asks when it will arrive. Your assistant replies in seconds with the answer and a tracking link.' ),
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
				<p class="b-eyebrow h-hero__eyebrow"><span class="s-live" aria-hidden="true"></span>Technology company · Lagos &amp; Ilorin · Clients in 6 countries</p>
				<div class="h-beats">
					<div class="h-beat h-beat--intro" data-beat>
						<h1 class="h-hero__title h-beat__title">
							<span class="b-sr">We build the websites, web apps, automation and AI your business runs on.</span>
							<span aria-hidden="true" data-split-hero>We build what your business runs on<span class="s-dot">.</span></span>
						</h1>
						<p class="h-hero__lede">Banks Solutions designs, builds and looks after the technology behind growing businesses in any industry. Websites from ₦499,000, live in about 5 weeks. Web apps and custom solutions priced from a written spec.</p>
					</div>
					<ol class="h-beats__list" aria-label="One order, start to finish">
						<?php foreach ( $b_beats as $b_i => $b_b ) : ?>
							<li class="h-beat" data-beat>
								<p class="h-beat__tag"><span><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span><?php echo esc_html( $b_b[0] ); ?></p>
								<h2 class="h-hero__title h-beat__title"><span class="h-beat__rise"><?php echo esc_html( $b_b[1] ); ?><span class="s-dot">.</span></span></h2>
								<p class="h-beat__text"><?php echo esc_html( $b_b[2] ); ?></p>
							</li>
						<?php endforeach; ?>
					</ol>
				</div>
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

			<?php // The scene: one order followed from checkout to follow-up. Decorative; the beats above carry the words. ?>
			<div class="h-scene" aria-hidden="true">
				<div class="h-scene__tilt">
					<span class="h-scene__halo"></span>

					<div class="h-prop h-dash">
						<div class="h-dash__chrome"><i></i><i></i><i></i><span>dashboard.yourbusiness.ng</span></div>
						<div class="h-dash__body">
							<div class="h-dash__kpis">
								<div class="h-kpi"><small>Revenue today</small><b>₦<span data-dash-rev>1,284,500</span></b><em>+18%</em></div>
								<div class="h-kpi"><small>Orders</small><b data-dash-ord>37</b></div>
								<div class="h-kpi"><small>Candles in stock</small><b data-dash-stk>11</b></div>
							</div>
							<div class="h-dash__main">
								<div class="h-dash__chart"><span style="--h:34%"></span><span style="--h:52%"></span><span style="--h:41%"></span><span style="--h:66%"></span><span style="--h:58%"></span><span style="--h:79%"></span><span style="--h:96%"></span></div>
								<ul class="h-dash__rows">
									<li class="is-new"><b>#1042</b><span>Ada O.</span><span>₦24,500</span><em>Paid</em></li>
									<li><b>#1041</b><span>Tunde B.</span><span>₦61,000</span><em>Paid</em></li>
									<li><b>#1040</b><span>Grace E.</span><span>₦18,000</span><em>Shipped</em></li>
									<li><b>#1039</b><span>Kemi A.</span><span>₦37,500</span><em>Shipped</em></li>
								</ul>
							</div>
						</div>
					</div>

					<div class="h-phone">
						<div class="h-phone__float">
							<div class="h-phone__body">
								<div class="h-phone__screen">
									<div class="h-scr h-scr--store">
										<div class="h-scr__status"><span>9:41</span><i></i></div>
										<div class="h-scr__url">yourbusiness.ng</div>
										<img class="h-scr__img" src="<?php echo esc_url( banks_img( 'hero-product.webp' ) ); ?>" width="640" height="640" alt="" decoding="async">
										<div class="h-scr__info">
											<p class="h-scr__name">Amber &amp; Oud candle</p>
											<p class="h-scr__meta">Hand poured · 220 g · Delivery nationwide</p>
											<p class="h-scr__price">₦24,500</p>
										</div>
										<div class="h-scr__pay"><span class="h-scr__pay-a">Pay ₦24,500</span><span class="h-scr__pay-b">Paying…</span><i class="h-scr__tap"></i></div>
										<div class="h-scr__sheet"><span class="h-scr__tick">✓</span><p>Payment received</p><small>Order #1042 · ₦24,500</small></div>
									</div>
									<div class="h-scr h-scr--lock">
										<p class="h-lock__day">Friday night</p>
										<p class="h-lock__time">9:41</p>
										<div class="h-note h-note--wa">
											<span class="h-ico h-ico--wa"><svg viewBox="0 0 24 24"><path d="M12 3.5a8.5 8.5 0 0 0-7.3 12.8L3.5 20.5l4.3-1.1A8.5 8.5 0 1 0 12 3.5Z"/></svg></span>
											<div><p class="h-note__app">WhatsApp<em>now</em></p><p class="h-note__title">New order #1042</p><p class="h-note__text">Ada O. paid ₦24,500 for 1 × Amber &amp; Oud candle.</p></div>
										</div>
										<div class="h-note h-note--mail">
											<span class="h-ico h-ico--mail"><svg viewBox="0 0 24 24"><path d="M4 7.5 12 13l8-5.5M5 6h14a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1Z"/></svg></span>
											<div><p class="h-note__app">Mail<em>now</em></p><p class="h-note__title">Receipt sent to Ada</p><p class="h-note__text">Invoice #1042 delivered. Customer record saved.</p></div>
										</div>
									</div>
									<div class="h-scr h-scr--chat">
										<div class="h-chat__bar"><span class="h-chat__av">A</span><div><p>Ada O.</p><small>Order #1042</small></div></div>
										<div class="h-chat__body">
											<p class="h-msg h-msg--in">Hi, when will my candle get to Abuja?</p>
											<p class="h-msg h-msg--typing"><i></i><i></i><i></i></p>
											<p class="h-msg h-msg--out">Hello Ada. Order #1042 leaves Lagos tomorrow morning and reaches Abuja on Saturday. Your tracking link is on its way.<small>AI assistant · 9:43 pm ✓✓</small></p>
										</div>
										<div class="h-chat__input"><span>Message</span><i></i></div>
									</div>
									<span class="h-phone__island"></span>
									<span class="h-phone__glare"></span>
								</div>
							</div>
						</div>
					</div>

					<div class="h-prop h-chip h-chip--paid"><i>✓</i><div><b>₦24,500 paid</b><small>Card · Paystack</small></div></div>

					<div class="h-prop h-wa">
						<div class="h-wa__head"><span class="h-ico h-ico--wa"><svg viewBox="0 0 24 24"><path d="M12 3.5a8.5 8.5 0 0 0-7.3 12.8L3.5 20.5l4.3-1.1A8.5 8.5 0 1 0 12 3.5Z"/></svg></span><b>WhatsApp</b><em>now</em></div>
						<p class="h-wa__title">New order #1042</p>
						<p class="h-wa__text">Ada O. · 1 × Amber &amp; Oud candle<br>Deliver to Wuse 2, Abuja</p>
						<p class="h-wa__paid">₦24,500 paid<span>✓✓</span></p>
					</div>

					<div class="h-prop h-mail">
						<div class="h-mail__head"><span class="h-mail__av">Y</span><div><b>Your Store</b><small>orders@yourbusiness.ng</small></div><em>9:41 pm</em></div>
						<p class="h-mail__subj">Thank you, Ada. Your order is confirmed.</p>
						<ul class="h-mail__rows">
							<li><span>Amber &amp; Oud candle × 1</span><b>₦22,000</b></li>
							<li><span>Delivery to Abuja</span><b>₦2,500</b></li>
							<li class="h-mail__total"><span>Total paid</span><b>₦24,500</b></li>
						</ul>
						<p class="h-mail__foot"><i>✓</i>Paid by card · Invoice #1042 attached</p>
					</div>

					<div class="h-prop h-chip h-chip--ai"><i>✦</i><div><b>Answered in 4 seconds</b><small>AI assistant · no one on shift</small></div></div>
				</div>
			</div>
		</div>

		<div class="b-wrap h-rail" aria-hidden="true">
			<span class="h-rail__line"><span></span></span>
			<ol class="h-rail__steps">
				<?php foreach ( array( 'Start', 'Order', 'WhatsApp', 'Email', 'Dashboard', 'AI reply' ) as $b_i => $b_r ) : ?>
					<li><button type="button" tabindex="-1" data-rail="<?php echo esc_attr( $b_i ); ?>"<?php echo 0 === $b_i ? ' class="is-on"' : ''; ?>><?php echo esc_html( $b_r ); ?></button></li>
				<?php endforeach; ?>
			</ol>
			<span class="h-rail__hint">Scroll to follow one order</span>
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
