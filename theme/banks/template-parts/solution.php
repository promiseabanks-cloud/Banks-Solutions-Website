<?php
/*
 * One solution page, built as scenes: hero with the solution's own visual, "sound familiar?"
 * checklist, the statement, what's included, how a build runs, who it's for, prices, questions,
 * closing call. Each page-<slug>.php passes its copy in $args; the hero visual comes from
 * template-parts/visual-<slug>.php. Motion lives in solution.js; everything reads without JS.
 */
$b      = $args;
$b_slug = $b['slug'];
?>
<section class="so-hero" data-dark data-hero>
	<div class="so-hero__stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap so-hero__inner">
			<div class="so-hero__copy">
				<nav class="so-crumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url( banks_main_url( '/solutions/' ) ); ?>">Solutions</a><span aria-hidden="true">/</span><span aria-current="page"><?php echo esc_html( $b['name'] ); ?></span></nav>
				<h1 class="so-hero__title" data-split-hero><?php echo esc_html( $b['h1'] ); ?><span class="s-dot">.</span></h1>
				<p class="so-hero__lede"><?php echo esc_html( $b['answer'] ); ?></p>
				<div class="so-hero__actions">
					<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b['start'] ); ?>" data-magnetic>Start a project</a>
					<a class="b-btn b-btn--line b-btn--lg" href="#so-plans">See prices</a>
				</div>
				<ul class="so-hero__facts">
					<?php foreach ( $b['facts'] as $b_f ) : ?>
						<li><strong><?php echo esc_html( $b_f[0] ); ?></strong><?php echo esc_html( $b_f[1] ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php get_template_part( 'template-parts/visual', $b_slug ); ?>
		</div>
	</div>
</section>

<section class="so-check">
	<div class="b-wrap so-check__grid">
		<div class="so-check__head">
			<p class="b-eyebrow">Sound familiar?</p>
			<h2 data-split><?php echo esc_html( $b['check_title'] ); ?></h2>
			<p><?php echo esc_html( $b['check_text'] ); ?></p>
			<p class="so-check__score" aria-hidden="true"><span data-so-score>0</span> of <?php echo esc_html( count( $b['symptoms'] ) ); ?> sound familiar</p>
		</div>
		<ul class="so-check__list">
			<?php foreach ( $b['symptoms'] as $b_s ) : ?>
				<li class="so-sym">
					<span class="so-sym__box" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg></span>
					<span><strong><?php echo esc_html( $b_s[0] ); ?></strong> <?php echo esc_html( $b_s[1] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="so-say" data-dark>
	<div class="b-wrap">
		<p class="b-eyebrow"><?php echo esc_html( $b['say_label'] ); ?></p>
		<p class="so-say__big" data-scrub-words><?php echo esc_html( $b['say'] ); ?></p>
		<div class="so-say__text">
			<?php foreach ( $b['say_text'] as $b_p ) : ?>
				<p><?php echo esc_html( $b_p ); ?></p>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="so-inc">
	<div class="b-wrap">
		<div class="so-inc__head">
			<p class="b-eyebrow">What’s included</p>
			<h2 data-split><?php echo esc_html( $b['inc_title'] ); ?></h2>
			<p><?php echo esc_html( $b['inc_text'] ); ?></p>
		</div>
		<div class="so-inc__groups">
			<?php foreach ( $b['included'] as $b_i => $b_g ) : ?>
				<div class="so-group">
					<p class="so-group__head"><span><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span><?php echo esc_html( $b_g['title'] ); ?></p>
					<?php foreach ( $b_g['items'] as $b_item ) : ?>
						<div class="so-item" data-spot>
							<h3><?php echo esc_html( $b_item[0] ); ?></h3>
							<p><?php echo esc_html( $b_item[1] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="so-run">
	<div class="b-wrap">
		<div class="so-run__head">
			<p class="b-eyebrow">How it runs</p>
			<h2 data-split><?php echo esc_html( $b['run_title'] ); ?></h2>
			<p><?php echo esc_html( $b['run_text'] ); ?></p>
		</div>
		<div class="so-run__track">
			<span class="so-run__line" aria-hidden="true"><span></span></span>
			<ol class="so-run__list">
				<?php foreach ( $b['steps'] as $b_i => $b_s ) : ?>
					<li class="so-stage">
						<span class="so-stage__dot" aria-hidden="true"><?php echo esc_html( $b_i + 1 ); ?></span>
						<p class="so-stage__when"><?php echo esc_html( $b_s[0] ); ?></p>
						<h3><?php echo esc_html( $b_s[1] ); ?></h3>
						<p><?php echo esc_html( $b_s[2] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</section>

<section class="so-fit">
	<div class="b-wrap">
		<div class="so-fit__head">
			<p class="b-eyebrow">Fit</p>
			<h2 data-split>Who this is for, and who it isn’t.</h2>
			<p>We would rather turn work down than take on a job that was never going to succeed.</p>
		</div>
		<div class="so-fit__grid">
			<div class="so-fit__col so-fit__col--yes">
				<h3>This is for you if</h3>
				<ul><?php foreach ( $b['fit_yes'] as $b_l ) : ?><li><?php echo esc_html( $b_l ); ?></li><?php endforeach; ?></ul>
			</div>
			<div class="so-fit__col so-fit__col--no">
				<h3>This is not for you if</h3>
				<ul><?php foreach ( $b['fit_no'] as $b_l ) : ?><li><?php echo esc_html( $b_l ); ?></li><?php endforeach; ?></ul>
			</div>
		</div>
	</div>
</section>

<section class="so-plans" id="so-plans">
	<div class="b-wrap">
		<div class="so-plans__head">
			<p class="b-eyebrow">Prices</p>
			<h2 data-split><?php echo esc_html( $b['plans_title'] ); ?></h2>
			<p><?php echo esc_html( $b['plans_text'] ); ?></p>
		</div>
		<div class="so-plans__grid">
			<?php foreach ( $b['plans'] as $b_p ) : ?>
				<div class="so-plan<?php echo ! empty( $b_p['featured'] ) ? ' so-plan--featured' : ''; ?>"<?php echo ! empty( $b_p['featured'] ) ? ' data-dark' : ''; ?> data-spot>
					<h3><?php echo esc_html( $b_p['name'] ); ?></h3>
					<p class="so-plan__price">
						<?php if ( ! empty( $b_p['from'] ) ) : ?><small>From</small><?php endif; ?>
						<?php if ( ! empty( $b_p['naira'] ) ) : ?>
							<strong>₦<span data-naira="<?php echo esc_attr( $b_p['naira'] ); ?>"><?php echo esc_html( number_format( $b_p['naira'] ) ); ?></span></strong>
						<?php else : ?>
							<strong><?php echo esc_html( $b_p['label'] ); ?></strong>
						<?php endif; ?>
					</p>
					<p class="so-plan__when"><?php echo esc_html( $b_p['when'] ); ?></p>
					<p><?php echo esc_html( $b_p['text'] ); ?></p>
					<a class="b-btn <?php echo ! empty( $b_p['featured'] ) ? 'b-btn--signal' : 'b-btn--lagoon'; ?>" href="<?php echo esc_url( $b['start'] ); ?>" data-magnetic><?php echo esc_html( $b_p['cta'] ); ?></a>
				</div>
			<?php endforeach; ?>
		</div>
		<p class="so-plans__note"><?php echo esc_html( $b['plans_note'] ); ?></p>
	</div>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>Straight answers.</h2>
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

<section class="s-cta" data-dark>
	<div class="s-glow" aria-hidden="true"></div>
	<div class="b-wrap s-cta__inner">
		<h2 class="s-cta__title" data-split><?php echo esc_html( $b['cta_title'] ); ?><span class="s-dot">.</span></h2>
		<p><?php echo esc_html( $b['cta_text'] ); ?></p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b['start'] ); ?>" data-magnetic="0.45">Start a project</a>
	</div>
</section>

<script type="application/ld+json">
<?php
$b_url    = banks_main_url( '/solutions/' . $b_slug . '/' );
$b_offers = array();
foreach ( $b['plans'] as $b_p ) {
	if ( ! empty( $b_p['naira'] ) ) {
		$b_offers[] = array(
			'@type'              => 'Offer',
			'name'               => $b_p['name'],
			'priceCurrency'      => 'NGN',
			'priceSpecification' => array(
				'@type'         => 'PriceSpecification',
				'priceCurrency' => 'NGN',
				( empty( $b_p['from'] ) ? 'price' : 'minPrice' ) => $b_p['naira'],
			),
		);
	}
}
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'       => 'Service',
				'name'        => $b['name'],
				'serviceType' => $b['service_type'],
				'description' => $b['answer'],
				'url'         => $b_url,
				'areaServed'  => 'Worldwide',
				'provider'    => array(
					'@type' => 'Organization',
					'name'  => 'Banks Solutions',
					'url'   => banks_main_url( '/' ),
				),
				'offers'      => $b_offers,
			),
			array(
				'@type'           => 'BreadcrumbList',
				'itemListElement' => array(
					array( '@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => banks_main_url( '/' ) ),
					array( '@type' => 'ListItem', 'position' => 2, 'name' => 'Solutions', 'item' => banks_main_url( '/solutions/' ) ),
					array( '@type' => 'ListItem', 'position' => 3, 'name' => $b['name'], 'item' => $b_url ),
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
		),
	),
	JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG
);
?>
</script>
