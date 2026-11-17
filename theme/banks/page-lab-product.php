<?php
/*
 * A Banks Labs product page (/labs/<slug>/), built as scenes from inc/lab-products.php: a hero
 * with a live product mock, the facts, the problem, how it works (a line that draws as you
 * scroll), every capability by area (an index that follows you down the page), how it is
 * built, questions and the closing call. Motion lives in product.js; every state is in the HTML.
 */
get_header();

$b_slug = get_post_field( 'post_name', get_queried_object_id() );
$b_p    = banks_lab_product( $b_slug );
if ( ! $b_p ) {
	get_footer();
	return;
}
$b_labs = banks_route( '/labs/' );
?>
<section class="lp-hero" data-dark data-hero>
	<div class="lp-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap lp-inner">
			<div class="lp-copy">
				<?php if ( $b_labs ) : ?>
					<a class="lp-back" href="<?php echo esc_url( $b_labs ); ?>"><span aria-hidden="true">←</span> Banks Labs</a>
				<?php endif; ?>
				<p class="b-eyebrow lp-eyebrow"><?php echo esc_html( $b_p['eyebrow'] ); ?></p>
				<h1 class="lp-title"><?php echo esc_html( $b_p['title'] ); ?><span class="s-dot">.</span></h1>
				<p class="lp-lede"><?php echo esc_html( $b_p['lede'] ); ?></p>
				<div class="lp-actions">
					<?php foreach ( $b_p['actions'] as $b_i => $b_a ) : ?>
						<a class="b-btn b-btn--<?php echo esc_attr( $b_a[2] ); ?> b-btn--lg" href="<?php echo esc_url( $b_a[1] ); ?>"<?php echo 0 === $b_i ? ' data-magnetic' : ''; ?><?php echo 0 === strpos( $b_a[1], 'http' ) && false === strpos( $b_a[1], wp_parse_url( home_url(), PHP_URL_HOST ) ) ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $b_a[0] ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="lp-visual">
				<?php get_template_part( 'template-parts/lab-visual', $b_p['visual'] ); ?>
			</div>
		</div>
	</div>
</section>

<section class="lp-facts" aria-label="<?php echo esc_attr( $b_p['name'] . ' at a glance' ); ?>">
	<div class="b-wrap">
		<dl class="lp-facts__row">
			<?php foreach ( $b_p['facts'] as $b_f ) : ?>
				<div class="lp-fact" data-reveal><dt><?php echo esc_html( $b_f[0] ); ?></dt><dd><?php echo esc_html( $b_f[1] ); ?></dd></div>
			<?php endforeach; ?>
		</dl>
	</div>
</section>

<section class="lp-problem">
	<div class="b-wrap lp-problem__grid">
		<p class="b-eyebrow"><?php echo esc_html( $b_p['problem']['eyebrow'] ); ?></p>
		<div>
			<p class="lp-problem__big" data-scrub><?php echo esc_html( $b_p['problem']['big'] ); ?></p>
			<p class="lp-problem__note"><?php echo esc_html( $b_p['problem']['note'] ); ?></p>
		</div>
	</div>
</section>

<section class="lp-flow" data-dark>
	<div class="b-wrap">
		<div class="lp-head lp-head--dark">
			<p class="b-eyebrow"><?php echo esc_html( $b_p['flow']['eyebrow'] ); ?></p>
			<h2 data-split><?php echo esc_html( $b_p['flow']['title'] ); ?></h2>
		</div>
		<div class="lp-steps__wrap" style="--n:<?php echo esc_attr( count( $b_p['flow']['steps'] ) ); ?>">
		<span class="lp-steps__line" aria-hidden="true"><i></i></span>
		<ol class="lp-steps">
			<?php foreach ( $b_p['flow']['steps'] as $b_i => $b_s ) : ?>
				<li class="lp-step">
					<span class="lp-step__dot" aria-hidden="true"><?php echo esc_html( $b_i + 1 ); ?></span>
					<h3><?php echo esc_html( $b_s[0] ); ?></h3>
					<p><?php echo esc_html( $b_s[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/lab-capabilities', null, array( 'name' => $b_p['name'], 'groups' => $b_p['groups'] ) ); ?>

<section class="lp-trust" data-dark>
	<div class="b-wrap lp-trust__grid">
		<div class="lp-orbit" aria-hidden="true">
			<span class="lp-orbit__ring"></span><span class="lp-orbit__ring"></span><span class="lp-orbit__ring"></span>
			<span class="lp-orbit__core"><?php echo esc_html( $b_p['name'] ); ?></span>
		</div>
		<div>
			<div class="lp-head lp-head--dark">
				<p class="b-eyebrow"><?php echo esc_html( $b_p['trust']['eyebrow'] ); ?></p>
				<h2 data-split><?php echo esc_html( $b_p['trust']['title'] ); ?></h2>
				<p><?php echo esc_html( $b_p['trust']['lede'] ); ?></p>
			</div>
			<ul class="lp-points">
				<?php foreach ( $b_p['trust']['points'] as $b_t ) : ?>
					<li class="lp-point" data-reveal><h3><?php echo esc_html( $b_t[0] ); ?></h3><p><?php echo esc_html( $b_t[1] ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>About <?php echo esc_html( $b_p['name'] ); ?>.</h2>
		</div>
		<div class="s-faq__list">
			<?php foreach ( $b_p['faqs'] as $b_f ) : ?>
				<details class="s-qa">
					<summary><?php echo esc_html( $b_f[0] ); ?><span class="s-qa__icon" aria-hidden="true"></span></summary>
					<div class="s-qa__a"><p><?php echo esc_html( $b_f[1] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
$b_others = array();
foreach ( banks_products() as $b_o ) {
	if ( ! empty( $b_o['url'] ) && trim( $b_o['url'], '/' ) !== 'labs/' . $b_slug && 'soon' !== $b_o['status'] ) {
		$b_url = banks_route( $b_o['url'] );
		if ( $b_url ) {
			$b_others[] = array( $b_o['name'], $b_o['kind'], $b_url );
		}
	}
}
if ( $b_others ) :
	?>
<section class="lp-more">
	<div class="b-wrap">
		<p class="b-eyebrow">More from Banks Labs</p>
		<ul class="lp-more__row">
			<?php foreach ( $b_others as $b_o ) : ?>
				<li data-reveal><a class="lp-more__card" href="<?php echo esc_url( $b_o[2] ); ?>"><span class="lp-more__kind"><?php echo esc_html( $b_o[1] ); ?></span><span class="lp-more__name"><?php echo esc_html( $b_o[0] ); ?></span><span class="lp-more__go" aria-hidden="true">→</span></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>

<section class="s-cta" data-dark>
	<div class="s-glow" aria-hidden="true"></div>
	<div class="b-wrap s-cta__inner">
		<h2 class="s-cta__title" data-split><?php echo esc_html( $b_p['cta'][0] ); ?><span class="s-dot">.</span></h2>
		<p><?php echo esc_html( $b_p['cta'][1] ); ?></p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_p['cta'][3] ); ?>" data-magnetic><?php echo esc_html( $b_p['cta'][2] ); ?></a>
	</div>
</section>

<script type="application/ld+json">
<?php
$b_features = array();
foreach ( $b_p['groups']['items'] as $b_g ) {
	foreach ( $b_g['feats'] as $b_f ) {
		$b_features[] = $b_f[0];
	}
}
$b_app = array(
	'@type'                  => 'SoftwareApplication',
	'name'                   => $b_p['name'],
	'url'                    => get_permalink(),
	'applicationCategory'    => $b_p['schema'][0],
	'applicationSubCategory' => $b_p['schema'][1],
	'operatingSystem'        => 'Web',
	'description'            => $b_p['lede'],
	'featureList'            => $b_features,
	'publisher'              => array(
		'@type' => 'Organization',
		'@id'   => banks_main_url( '/' ) . '#organization',
		'name'  => 'Banks Solutions',
		'url'   => banks_main_url( '/' ),
	),
);
if ( isset( $b_p['schema'][2] ) && 'free' === $b_p['schema'][2] ) {
	$b_app['offers'] = array(
		'@type'         => 'Offer',
		'price'         => '0',
		'priceCurrency' => 'NGN',
	);
}
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			$b_app,
			array(
				'@type'           => 'BreadcrumbList',
				'itemListElement' => array(
					array( '@type' => 'ListItem', 'position' => 1, 'name' => 'Banks Labs', 'item' => banks_main_url( '/labs/' ) ),
					array( '@type' => 'ListItem', 'position' => 2, 'name' => $b_p['name'], 'item' => get_permalink() ),
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
					$b_p['faqs']
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
