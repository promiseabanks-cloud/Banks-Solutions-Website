<?php
/*
 * One industry page (/industries/<slug>/), built as scenes: hero with a live feed of the work
 * that field runs on, "sound familiar?", what we build for it, projects from that field, what
 * we handle carefully, questions, the other fields, closing call. The copy for every field is in
 * inc/industries.php; projects come from Banks Core by slug. Motion lives in industry.js.
 */
get_header();

$b_slug = get_post_field( 'post_name', get_queried_object_id() );
$b_all  = banks_industries();
$b      = $b_all[ $b_slug ];
$b_sols = banks_industry_solutions();
$b_hub  = banks_main_url( '/industries/' );
$b_url  = banks_main_url( '/industries/' . $b_slug . '/' );
$b_go   = add_query_arg( 'industry', $b_slug, banks_route( '/start/', '/contact/' ) );

// Projects from this field, in the order the work list keeps them.
$b_work = array();
foreach ( banks_work_items() as $b_i ) {
	if ( in_array( $b_i['slug'], $b['work'], true ) ) {
		$b_work[] = $b_i;
	}
}
?>
<section class="in-hero" data-dark data-hero>
	<div class="in-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap in-inner">
			<div class="in-copy">
				<nav class="in-crumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url( $b_hub ); ?>">Industries</a><span aria-hidden="true">/</span><span aria-current="page"><?php echo esc_html( $b['name'] ); ?></span></nav>
				<h1 class="in-title"><?php echo esc_html( $b['h1'] ); ?><span class="s-dot">.</span></h1>
				<p class="in-lede"><?php echo esc_html( $b['answer'] ); ?></p>
				<div class="in-actions">
					<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_go ); ?>" data-magnetic>Start a project</a>
					<a class="b-btn b-btn--line b-btn--lg" href="#in-builds">What we build</a>
				</div>
			</div>
			<div class="in-feed" aria-label="<?php echo esc_attr( 'Examples of what a system for ' . strtolower( $b['label'] ) . ' handles' ); ?>">
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
			<h2 data-split>What gets in the way in <?php echo esc_html( strtolower( $b['name'] ) ); ?>.</h2>
			<p>We hear these from <?php echo esc_html( strtolower( $b['label'] ) ); ?> more than anything else. Each one has a fix that doesn’t mean changing how you work.</p>
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
			<h2 data-split>For <?php echo esc_html( strtolower( $b['label'] ) ); ?>.</h2>
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

<section class="in-work">
	<div class="b-wrap">
		<div class="in-work__head">
			<div>
				<p class="b-eyebrow">The work</p>
				<h2 data-split><?php echo $b_work ? esc_html( 'Built for ' . strtolower( $b['label'] ) . '.' ) : esc_html( 'Yours could be the first project here.' ); ?></h2>
			</div>
			<?php if ( banks_route( '/work/' ) ) : ?>
				<a class="b-btn b-btn--line" href="<?php echo esc_url( banks_route( '/work/' ) ); ?>">All our work</a>
			<?php endif; ?>
		</div>
		<?php if ( $b_work ) : ?>
			<ul class="in-work__list">
				<?php foreach ( $b_work as $b_n => $b_i ) : ?>
					<li class="in-proj">
						<a class="in-proj__rig" href="<?php echo esc_url( $b_i['link'] ); ?>" aria-label="<?php echo esc_attr( $b_i['title'] . ' case study' ); ?>">
							<span class="in-proj__laptop"><?php get_template_part( 'template-parts/work-device', null, array( 'item' => $b_i, 'form' => 'laptop', 'tone' => $b_n % 4 + 1 ) ); ?></span>
							<span class="in-proj__phone"><?php get_template_part( 'template-parts/work-device', null, array( 'item' => $b_i, 'form' => 'phone', 'tone' => ( $b_n + 1 ) % 4 + 1 ) ); ?></span>
						</a>
						<div class="in-proj__info">
							<p class="in-proj__field"><?php echo esc_html( $b_i['industry'] ); ?><?php echo $b_i['place'] ? ' · ' . esc_html( $b_i['place'] ) : ''; ?></p>
							<h3><a href="<?php echo esc_url( $b_i['link'] ); ?>"><?php echo esc_html( $b_i['title'] ); ?></a></h3>
							<?php if ( $b_i['result'] ) : ?>
								<p><?php echo esc_html( $b_i['result'] ); ?></p>
							<?php elseif ( $b_i['built'] ) : ?>
								<p><?php echo esc_html( $b_i['built'] ); ?></p>
							<?php endif; ?>
							<?php if ( $b_i['domain'] ) : ?>
								<p class="in-proj__domain"><?php echo esc_html( $b_i['domain'] ); ?></p>
							<?php endif; ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<div class="in-first">
				<p>We haven’t published a project in <?php echo esc_html( strtolower( $b['name'] ) ); ?> yet, so we won’t pretend otherwise. What we bring is the same: a written spec, a fixed price and a build that works on a phone on mobile data. Tell us what you need and we’ll show you how we’d approach it.</p>
				<a class="b-btn b-btn--signal" href="<?php echo esc_url( $b_go ); ?>" data-magnetic>Tell us what you need</a>
			</div>
		<?php endif; ?>
	</div>
</section>

<section class="in-care">
	<div class="b-wrap">
		<div class="in-care__head">
			<p class="b-eyebrow">Handled carefully</p>
			<h2 data-split>The parts that matter more in <?php echo esc_html( strtolower( $b['name'] ) ); ?>.</h2>
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
			<h2 data-split>What <?php echo esc_html( strtolower( $b['label'] ) ); ?> ask us.</h2>
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

<nav class="in-others" aria-label="Other industries">
	<div class="b-wrap">
		<p class="b-eyebrow">Other fields we work in</p>
		<ul>
			<?php foreach ( $b_all as $b_k => $b_o ) : ?>
				<?php
				if ( $b_k === $b_slug ) {
					continue;
				}
				?>
				<li><a href="<?php echo esc_url( banks_route( '/industries/' . $b_k . '/', '/industries/' ) ); ?>"><?php echo esc_html( $b_o['name'] ); ?></a></li>
			<?php endforeach; ?>
			<li><a href="<?php echo esc_url( $b_hub ); ?>">All industries</a></li>
		</ul>
	</div>
</nav>

<section class="s-cta" data-dark>
	<div class="s-glow" aria-hidden="true"></div>
	<div class="b-wrap s-cta__inner">
		<h2 class="s-cta__title" data-split>Tell us how your <?php echo esc_html( 'non-profit' === $b_slug ? 'organisation' : 'business' ); ?> runs<span class="s-dot">.</span></h2>
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
				'name'        => 'Websites, web apps and custom solutions for ' . strtolower( $b['label'] ),
				'description' => $b['answer'],
				'url'         => $b_url,
				'serviceType' => 'Web design, web app development and automation',
				'audience'    => array(
					'@type'        => 'BusinessAudience',
					'audienceType' => $b['label'],
				),
				'areaServed'  => array( 'Nigeria', 'United States', 'United Kingdom', 'Canada', 'Kenya', 'Australia' ),
				'provider'    => array(
					'@type' => 'Organization',
					'@id'   => banks_main_url( '/' ) . '#organization',
					'name'  => 'Banks Solutions',
					'url'   => banks_main_url( '/' ),
				),
				'hasOfferCatalog' => array(
					'@type'           => 'OfferCatalog',
					'name'            => 'What we build for ' . strtolower( $b['label'] ),
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
						'name'     => 'Industries',
						'item'     => $b_hub,
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
