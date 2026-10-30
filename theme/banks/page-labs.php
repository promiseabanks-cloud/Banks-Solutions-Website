<?php
/*
 * Banks Labs (/labs/), the home our software links back to, built as scenes: a release log
 * typing out in the hero, the catalogue (from Banks Core), docs and support, how we build,
 * building for you, questions, closing call. Motion lives in labs.js; every state is in the HTML.
 */
get_header();

$b_products = banks_products();
$b_phone    = banks_detail( 'whatsapp' );
$b_wa       = $b_phone ? 'https://wa.me/' . preg_replace( '/\D/', '', $b_phone ) : '';
$b_email    = banks_detail( 'email' );
$b_brief    = add_query_arg( 'need', 'web-app', banks_route( '/start/', '/contact/' ) );
$b_agency   = banks_route( '/wordpress-development/' );
$b_webapps  = banks_route( '/solutions/web-apps/', '/solutions/' );
$b_1904     = banks_route( '/work/1904-solutions/', '/work/' );

// The release log in the hero: what every release goes through before it reaches a site.
$b_log = array(
	array( 'cmd', 'release banks-business-engine' ),
	array( 'ok', 'Coding standards', 'pass' ),
	array( 'ok', 'Inputs checked, output escaped', 'pass' ),
	array( 'ok', 'Secrets encrypted (AES-256-GCM)', 'pass' ),
	array( 'ok', 'Speed on a mid-range phone, 4G', 'pass' ),
	array( 'go', 'Shipped to every licensed site', 'live' ),
);

$b_principles = array(
	array( 'Your data stays yours', 'Leads, customers and settings live with your own website, not on a shared platform. If you ever leave, everything comes with you.' ),
	array( 'Secure by default', 'Every input is checked, every output is escaped and every key or password is encrypted before it is stored.' ),
	array( 'Fast on real phones', 'Each release is held to a budget: usable in under 2.5 seconds on a mid-range Android on 4G.' ),
	array( 'Built to be extended', 'Clean code with hooks and filters, so a developer can build on our tools instead of around them.' ),
);

$b_faqs = array(
	array( 'What is Banks Labs?', 'Banks Labs is the software side of Banks Solutions. It is where our products, such as Banks Business Engine, are built, documented and supported, and where developers and agencies can see how we work.' ),
	array( 'Where do I find the documentation?', 'Every product ships with a setup guide written for your business, handed over at setup. Public documentation for each product is being written and will be published here.' ),
	array( 'How do I get support?', 'Message us on WhatsApp or email us, and the team that built the product answers. Support is included for as long as your licence is active.' ),
	array( 'How are updates delivered?', 'New versions reach your website as they are released, as part of your licence. We test each release before it ships.' ),
	array( 'Can you build software for my business?', 'Yes. Most of what we build is custom: web apps and custom solutions shaped around how a business works, priced from a spec. Start a brief and we come back within two working days.' ),
	array( 'Do you work with agencies and developers?', 'Yes. We take on development work for agencies and developers, from a single feature to a full product.' ),
);
?>
<section class="lb-hero" data-dark data-hero>
	<div class="lb-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap lb-inner">
			<div class="lb-copy">
				<p class="b-eyebrow lb-eyebrow">Banks Labs · Software by Banks Solutions</p>
				<h1 class="lb-title">Where we build the tools<span class="s-dot">.</span></h1>
				<p class="lb-lede">Banks Labs is the software side of Banks Solutions. It’s where our products are made, documented and supported, and where developers and agencies can see how we work.</p>
				<div class="lb-actions">
					<a class="b-btn b-btn--signal b-btn--lg" href="#catalogue" data-magnetic>See the software</a>
					<a class="b-btn b-btn--line b-btn--lg" href="#support">Get support</a>
				</div>
			</div>

			<figure class="lb-term" aria-label="What every release goes through before it reaches a website">
				<div class="lb-term__bar"><i></i><i></i><i></i><span>banks-labs · release</span></div>
				<ol class="lb-log">
					<?php foreach ( $b_log as $b_l ) : ?>
						<?php if ( 'cmd' === $b_l[0] ) : ?>
							<li class="lb-line lb-line--cmd"><span class="lb-prompt" aria-hidden="true">$</span> <span class="lb-type"><?php echo esc_html( $b_l[1] ); ?></span><span class="lb-cursor" aria-hidden="true"></span></li>
						<?php else : ?>
							<li class="lb-line lb-line--<?php echo esc_attr( $b_l[0] ); ?>"><span class="lb-mark" aria-hidden="true"><?php echo 'go' === $b_l[0] ? '→' : '✓'; ?></span><span class="lb-line__t"><?php echo esc_html( $b_l[1] ); ?></span><span class="lb-line__s"><?php echo esc_html( $b_l[2] ); ?></span></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ol>
			</figure>
		</div>
	</div>
</section>

<section class="lb-cat" id="catalogue">
	<div class="b-wrap">
		<div class="lb-head">
			<p class="b-eyebrow">The catalogue</p>
			<h2 data-split>Everything we ship, and where it stands.</h2>
		</div>
		<ol class="lb-rows">
			<li class="lb-row lb-row--head" aria-hidden="true"><span>Product</span><span>What it is</span><span>Release</span><span>Status</span><span></span></li>
			<?php foreach ( $b_products as $b_p ) : ?>
				<?php
				$b_live = 'available' === $b_p['status'];
				$b_page = $b_p['url'] ? banks_route( $b_p['url'] ) : '';
				?>
				<li class="lb-row" data-reveal>
					<span class="lb-row__name"><?php echo esc_html( $b_p['name'] ); ?></span>
					<span class="lb-row__kind"><?php echo esc_html( $b_p['kind'] ); ?></span>
					<span class="lb-row__ver"><span class="b-sr">Release </span><?php echo esc_html( ! empty( $b_p['version'] ) ? 'v' . $b_p['version'] : 'Not yet' ); ?></span>
					<span class="lb-row__status lb-row__status--<?php echo esc_attr( $b_live ? 'live' : 'soon' ); ?>"><?php echo $b_live ? '<span class="s-live"></span>Available' : 'In development'; ?></span>
					<span class="lb-row__go">
						<?php if ( $b_page ) : ?>
							<a href="<?php echo esc_url( $b_page ); ?>">Product page <span aria-hidden="true">→</span></a>
						<?php endif; ?>
					</span>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="lb-support" id="support">
	<div class="b-wrap">
		<div class="lb-head">
			<p class="b-eyebrow">Docs and support</p>
			<h2 data-split>Help from the people who wrote the code.</h2>
		</div>
		<div class="lb-cards">
			<article class="lb-card" data-reveal>
				<span class="lb-card__n">01</span>
				<h3>Setup guide</h3>
				<p>Every product comes with a guide written for your business, handed over when we set it up. Public documentation is being written and will live here.</p>
			</article>
			<article class="lb-card" data-reveal>
				<span class="lb-card__n">02</span>
				<h3>Updates and release notes</h3>
				<p>New versions reach your website as they’re released, with notes on what changed. Each one is tested before it ships.</p>
			</article>
			<article class="lb-card lb-card--talk" data-dark data-reveal>
				<span class="lb-card__n">03</span>
				<h3>Talk to us</h3>
				<p>Questions, bugs or ideas go straight to the team that built it. Included for as long as your licence is active.</p>
				<div class="lb-card__go">
					<?php if ( $b_wa ) : ?>
						<a class="b-btn b-btn--signal" href="<?php echo esc_url( $b_wa . '?text=' . rawurlencode( 'Hi Banks Solutions, I need help with one of your products.' ) ); ?>" data-magnetic>WhatsApp support</a>
					<?php endif; ?>
					<?php if ( $b_email ) : ?>
						<a class="b-btn b-btn--line" href="mailto:<?php echo esc_attr( $b_email ); ?>?subject=<?php echo rawurlencode( 'Support request' ); ?>">Email us</a>
					<?php endif; ?>
				</div>
			</article>
		</div>
	</div>
</section>

<section class="lb-how" data-dark>
	<div class="b-wrap">
		<div class="lb-head lb-head--dark">
			<p class="b-eyebrow">How we build</p>
			<h2 data-split>Four rules every release has to pass.</h2>
		</div>
		<ol class="lb-rules">
			<?php foreach ( $b_principles as $b_i => $b_r ) : ?>
				<li class="lb-rule" data-reveal>
					<span class="lb-rule__n"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $b_r[0] ); ?></h3>
					<p><?php echo esc_html( $b_r[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="lb-build">
	<div class="b-wrap lb-build__grid">
		<div class="lb-head">
			<p class="b-eyebrow">Build with us</p>
			<h2 data-split>Need something that doesn’t exist yet?</h2>
			<p>Most of what we build is made for one business. Some of it becomes a product. Either way it starts with a short brief.</p>
			<div class="lb-build__go">
				<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_brief ); ?>" data-magnetic>Start a brief</a>
				<?php if ( $b_agency ) : ?>
					<a class="lb-link" href="<?php echo esc_url( $b_agency ); ?>">For agencies and developers <span aria-hidden="true">→</span></a>
				<?php endif; ?>
			</div>
		</div>
		<ul class="lb-cases">
			<li data-reveal>
				<a class="lb-case" href="<?php echo esc_url( $b_1904 ); ?>">
					<span class="lb-case__tag">Built for one client</span>
					<span class="lb-case__title">1904 Solutions</span>
					<span class="lb-case__text">A custom system and web app built around how a car wash and hospitality business actually runs.</span>
					<span class="lb-case__go">See the project <span aria-hidden="true">→</span></span>
				</a>
			</li>
			<li data-reveal>
				<a class="lb-case" href="<?php echo esc_url( banks_route( '/banks-business-engine/', '/shop/' ) ); ?>">
					<span class="lb-case__tag">Built as a product</span>
					<span class="lb-case__title">Banks Business Engine</span>
					<span class="lb-case__text">Our own product. It answers, qualifies and books every enquiry on a business’s website, at any hour.</span>
					<span class="lb-case__go">See the product <span aria-hidden="true">→</span></span>
				</a>
			</li>
			<li data-reveal>
				<a class="lb-case lb-case--plain" href="<?php echo esc_url( $b_webapps ); ?>">
					<span class="lb-case__tag">Your idea</span>
					<span class="lb-case__title">Web apps and custom solutions</span>
					<span class="lb-case__text">Portals, booking systems, dashboards and tools, priced from a spec.</span>
					<span class="lb-case__go">How we build them <span aria-hidden="true">→</span></span>
				</a>
			</li>
		</ul>
	</div>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>About Banks Labs.</h2>
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
		<h2 class="s-cta__title" data-split>Tell us what you need built<span class="s-dot">.</span></h2>
		<p>Send a short brief and we’ll come back within two working days with how we’d build it, the timeline and the price.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_brief ); ?>" data-magnetic>Start a brief</a>
	</div>
</section>

<script type="application/ld+json">
<?php
$b_list = array();
foreach ( $b_products as $b_i => $b_p ) {
	$b_item = array(
		'@type'               => 'SoftwareApplication',
		'name'                => $b_p['name'],
		'applicationCategory' => 'BusinessApplication',
		'description'         => $b_p['summary'],
	);
	if ( ! empty( $b_p['version'] ) ) {
		$b_item['softwareVersion'] = $b_p['version'];
	}
	if ( $b_p['url'] ) {
		$b_item['url'] = banks_main_url( $b_p['url'] );
	}
	$b_list[] = array(
		'@type'    => 'ListItem',
		'position' => $b_i + 1,
		'item'     => $b_item,
	);
}
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'       => 'CollectionPage',
				'name'        => 'Banks Labs',
				'url'         => banks_main_url( '/labs/' ),
				'description' => 'Banks Labs is the software side of Banks Solutions: the products we build, their documentation and support, and how we build them.',
				'publisher'   => array(
					'@type' => 'Organization',
					'@id'   => banks_main_url( '/' ) . '#organization',
					'name'  => 'Banks Solutions',
					'url'   => banks_main_url( '/' ),
				),
				'mainEntity'  => array(
					'@type'           => 'ItemList',
					'numberOfItems'   => count( $b_list ),
					'itemListElement' => $b_list,
				),
			),
			array(
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
		),
	),
	JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
);
?>
</script>
<?php
get_footer();
