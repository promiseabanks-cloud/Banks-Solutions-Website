<?php
/*
 * One city page (/web-design-lagos/, /web-developer-ilorin/). Same layout and motion as an
 * industry page (industry.{css,js}) without the project list; copy is in inc/cities.php.
 */
get_header();

$b_slug = get_post_field( 'post_name', get_queried_object_id() );
$b_all  = banks_cities();
$b      = $b_all[ $b_slug ];
$b_sols = banks_industry_solutions();
$b_hub  = banks_main_url( '/industries/' );
$b_url  = banks_main_url( '/' . $b_slug . '/' );
$b_go   = banks_route( '/start/', '/contact/' );
?>
<section class="in-hero" data-dark data-hero>
	<div class="in-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap in-inner">
			<div class="in-copy">
				<nav class="in-crumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url( banks_main_url( '/' ) ); ?>">Home</a><span aria-hidden="true">/</span><span aria-current="page"><?php echo esc_html( $b['name'] ); ?></span></nav>
				<h1 class="in-title"><?php echo esc_html( $b['h1'] ); ?><span class="s-dot">.</span></h1>
				<p class="in-lede"><?php echo esc_html( $b['answer'] ); ?></p>
				<div class="in-actions">
					<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_go ); ?>" data-magnetic>Start a project</a>
					<a class="b-btn b-btn--line b-btn--lg" href="#in-builds">What we build</a>
				</div>
			</div>
			<div class="in-feed" aria-label="<?php echo esc_attr( 'Examples of what a system for a ' . $b['name'] . ' business handles' ); ?>">
				<p class="in-feed__head"><span class="s-live" aria-hidden="true"></span>Today, handled for you</p>
				<ol class="in-feed__list">
					<?php foreach ( $b['feed'] as $b_n => $b_f ) : ?>
						<li class="in-note">
							<span class="in-note__mark" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $b_n + 1 ) ); ?></span>
							<span class="in-note__body"><strong><?php echo esc_html( $b_f[0] ); ?></strong><?php echo esc_html( $b_f[1] ); ?></span>
							<span class="in-note__tick" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg></span>
						</li>
					<?php endforeach; ?>
				</ol>
				<p class="in-feed__foot">No one had to type, chase or forward any of it.</p>
			</div>
		</div>
	</div>
</section>

<section class="in-pains">
	<div class="b-wrap in-pains__grid">
		<div class="in-pains__head">
			<p class="b-eyebrow">Sound familiar?</p>
			<h2 data-split>What gets in the way for <?php echo esc_html( $b['name'] ); ?> businesses.</h2>
			<p>We hear these from <?php echo esc_html( $b['name'] ); ?> business owners more than anything else. Each one has a fix that doesn’t mean changing how you work.</p>
		</div>
		<ol class="in-pains__list">
			<?php foreach ( $b['pains'] as $b_n => $b_p ) : ?>
				<li class="in-pain">
					<span class="in-pain__n"><?php echo esc_html( sprintf( '%02d', $b_n + 1 ) ); ?></span>
					<h3><?php echo esc_html( $b_p[0] ); ?></h3>
					<p><?php echo esc_html( $b_p[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="in-builds" id="in-builds" data-dark>
	<div class="b-wrap">
		<div class="in-builds__head">
			<p class="b-eyebrow">What we build</p>
			<h2 data-split>What we build in <?php echo esc_html( $b['name'] ); ?>.</h2>
		</div>
		<ul class="in-builds__grid">
			<?php foreach ( $b['builds'] as $b_n => $b_x ) : ?>
				<?php $b_link = banks_route( '/solutions/' . $b_x[0] . '/', '/solutions/' ); ?>
				<li>
					<a class="in-build" href="<?php echo esc_url( $b_link ); ?>" data-tilt>
						<span class="in-build__tag"><?php echo esc_html( $b_sols[ $b_x[0] ] ); ?></span>
						<span class="in-build__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $b_n + 1 ) ); ?></span>
						<span class="in-build__title"><?php echo esc_html( $b_x[1] ); ?></span>
						<span class="in-build__text"><?php echo esc_html( $b_x[2] ); ?></span>
						<span class="in-build__go">How it works <span aria-hidden="true">→</span></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="in-care">
	<div class="b-wrap">
		<div class="in-care__head">
			<p class="b-eyebrow">Handled carefully</p>
			<h2 data-split>How we work with <?php echo esc_html( $b['name'] ); ?> businesses.</h2>
		</div>
		<ul class="in-care__list">
			<?php foreach ( $b['care'] as $b_c ) : ?>
				<li class="in-care__item">
					<h3><?php echo esc_html( $b_c[0] ); ?></h3>
					<p><?php echo esc_html( $b_c[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>What <?php echo esc_html( $b['name'] ); ?> businesses ask us.</h2>
		</div>
		<div class="s-faq__list">
			<?php foreach ( $b['faqs'] as $b_f ) : ?>
				<details class="s-qa">
					<summary><?php echo esc_html( $b_f[0] ); ?><span class="s-qa__icon" aria-hidden="true"></span></summary>
					<div class="s-qa__a"><p><?php echo esc_html( $b_f[1] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<nav class="in-others" aria-label="Related pages">
	<div class="b-wrap">
		<p class="b-eyebrow">Also see</p>
		<ul>
			<?php foreach ( $b_all as $b_k => $b_o ) : ?>
				<?php
				if ( $b_k === $b_slug ) {
					continue;
				}
				?>
				<li><a href="<?php echo esc_url( banks_main_url( '/' . $b_k . '/' ) ); ?>"><?php echo esc_html( 'Web work in ' . $b_o['name'] ); ?></a></li>
			<?php endforeach; ?>
			<li><a href="<?php echo esc_url( banks_route( '/solutions/', '/' ) ); ?>">Solutions</a></li>
			<li><a href="<?php echo esc_url( $b_hub ); ?>">Industries</a></li>
			<li><a href="<?php echo esc_url( banks_route( '/work/', '/' ) ); ?>">Our work</a></li>
		</ul>
	</div>
</nav>

<section class="s-cta" data-dark>
	<div class="s-glow" aria-hidden="true"></div>
	<div class="b-wrap s-cta__inner">
		<h2 class="s-cta__title" data-split>Tell us how your business runs<span class="s-dot">.</span></h2>
		<p>Within two working days you’ll have what we’d build, how long it takes and a fixed price, or an honest answer that you don’t need us.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_go ); ?>" data-magnetic>Start a brief</a>
	</div>
</section>

<script type="application/ld+json">
<?php
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'       => 'Service',
				'name'        => 'Website design and web apps in ' . $b['name'],
				'description' => $b['answer'],
				'url'         => $b_url,
				'serviceType' => 'Web design, web app development and automation',
				'areaServed'  => array(
					'@type' => 'City',
					'name'  => $b['name'],
				),
				'provider'    => array(
					'@type' => 'Organization',
					'@id'   => banks_main_url( '/' ) . '#organization',
					'name'  => 'Banks Solutions',
					'url'   => banks_main_url( '/' ),
				),
				'hasOfferCatalog' => array(
					'@type'           => 'OfferCatalog',
					'name'            => 'What we build in ' . $b['name'],
					'itemListElement' => array_map(
						function ( $x ) {
							return array(
								'@type'       => 'Offer',
								'itemOffered' => array(
									'@type'       => 'Service',
									'name'        => $x[1],
									'description' => $x[2],
								),
							);
						},
						$b['builds']
					),
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
					$b['faqs']
				),
			),
			array(
				'@type'           => 'BreadcrumbList',
				'itemListElement' => array(
					array(
						'@type'    => 'ListItem',
						'position' => 1,
						'name'     => 'Home',
						'item'     => banks_main_url( '/' ),
					),
					array(
						'@type'    => 'ListItem',
						'position' => 2,
						'name'     => $b['name'],
						'item'     => $b_url,
					),
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
