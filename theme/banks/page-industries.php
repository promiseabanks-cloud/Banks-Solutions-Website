<?php
/*
 * Industries hub (/industries/), built as scenes: hero with the fields rolling through the
 * headline, an index of every field (hovering one floats a preview of what we'd run for it),
 * the standards that stay the same in every field, questions, closing call. Copy for each field
 * is in inc/industries.php. Motion lives in industries.js; everything reads without JS.
 */
get_header();

$b_all   = banks_industries();
$b_start = banks_route( '/start/', '/contact/' );

// How many published projects each field has, from Banks Core.
$b_slugs = wp_list_pluck( banks_work_items(), 'slug' );
$b_count = array();
foreach ( $b_all as $b_k => $b_i ) {
	$b_count[ $b_k ] = count( array_intersect( $b_i['work'], $b_slugs ) );
}

$b_roll = array( 'finance', 'law firms', 'hotels', 'schools', 'clinics', 'foundations', 'fashion' );

$b_faqs = array(
	array( 'Which industries does Banks Solutions work with?', 'Any field. We have pages for finance, legal, hospitality, education, health, non-profits and fashion because that is where most of our clients are, and we also work with retail, coaching, entertainment, beauty and professional services.' ),
	array( 'Do you have experience in my industry?', 'Each industry page shows the projects we have published in that field. Where we have none yet, the page says so, and we will walk you through how we would approach your business before you commit to anything.' ),
	array( 'Is the price different by industry?', 'No. Business websites start at ₦499,000 and online stores at ₦750,000 in every field. Web apps and custom solutions are priced from a written spec, because the cost depends on what they need to do, not on your industry.' ),
	array( 'Do you work with businesses outside Nigeria?', 'Yes. We work with clients in Nigeria, the United States, the United Kingdom, Canada, Kenya and Australia.' ),
);
?>
<section class="ix-hero" data-dark data-hero>
	<div class="ix-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap ix-inner">
			<p class="b-eyebrow ix-eyebrow">Industries · <?php echo esc_html( count( $b_all ) ); ?> fields, one standard</p>
			<h1 class="ix-title">
				<span class="ix-title__line">Technology built for</span>
				<span class="ix-roll" aria-hidden="true">
					<?php foreach ( $b_roll as $b_n => $b_w ) : ?>
						<span class="ix-roll__word<?php echo 0 === $b_n ? ' is-on' : ''; ?>"><?php echo esc_html( $b_w ); ?><span class="s-dot">.</span></span>
					<?php endforeach; ?>
				</span>
				<span class="b-sr">finance, law firms, hotels, schools, clinics, foundations and fashion.</span>
			</h1>
			<p class="ix-lede">Every field runs on its own paperwork, its own customers and its own rules. Banks Solutions builds websites, web apps and custom solutions around how yours actually works, in Nigeria and abroad.</p>
			<a class="b-btn b-btn--signal b-btn--lg" href="#fields" data-magnetic>Find your field</a>
		</div>
	</div>
</section>

<section class="ix-index" id="fields">
	<div class="b-wrap">
		<div class="ix-index__head">
			<p class="b-eyebrow">Choose your field</p>
			<h2 data-split>Where we work.</h2>
		</div>
		<ol class="ix-list">
			<?php $b_n = 0; ?>
			<?php foreach ( $b_all as $b_k => $b_i ) : ?>
				<li>
					<a class="ix-row" href="<?php echo esc_url( banks_route( '/industries/' . $b_k . '/', '/industries/' ) ); ?>" data-peek="<?php echo esc_attr( $b_n ); ?>">
						<span class="ix-row__n"><?php echo esc_html( sprintf( '%02d', ++$b_n ) ); ?></span>
						<span class="ix-row__name"><?php echo esc_html( $b_i['name'] ); ?></span>
						<span class="ix-row__short"><?php echo esc_html( $b_i['short'] ); ?></span>
						<span class="ix-row__count"><?php echo $b_count[ $b_k ] ? esc_html( sprintf( _n( '%d project', '%d projects', $b_count[ $b_k ], 'banks' ), $b_count[ $b_k ] ) ) : ''; ?></span>
						<span class="ix-row__arrow" aria-hidden="true">→</span>
					</a>
				</li>
			<?php endforeach; ?>
			<li>
				<a class="ix-row ix-row--other" href="<?php echo esc_url( $b_start ); ?>">
					<span class="ix-row__n">+</span>
					<span class="ix-row__name">Something else</span>
					<span class="ix-row__short">Retail, coaching, logistics, entertainment, professional services. Tell us how yours runs.</span>
					<span class="ix-row__count"></span>
					<span class="ix-row__arrow" aria-hidden="true">→</span>
				</a>
			</li>
		</ol>
		<div class="ix-peek" aria-hidden="true">
			<?php foreach ( $b_all as $b_k => $b_i ) : ?>
				<div class="ix-peek__card">
					<p class="ix-peek__head"><span class="s-live"></span><?php echo esc_html( $b_i['label'] ); ?></p>
					<?php foreach ( $b_i['feed'] as $b_f ) : ?>
						<p class="ix-peek__note"><strong><?php echo esc_html( $b_f[0] ); ?></strong><?php echo esc_html( $b_f[1] ); ?></p>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="ix-same" data-dark>
	<div class="b-wrap">
		<div class="ix-same__head">
			<p class="b-eyebrow">The same in every field</p>
			<h2 data-split>Different problems. Same standard.</h2>
		</div>
		<ol class="ix-same__list">
			<li><span class="ix-same__n">01</span><h3>A written spec and a fixed price</h3><p>Before any work starts you know what we’ll build, how long it takes and what it costs. Websites from ₦499,000, stores from ₦750,000.</p></li>
			<li><span class="ix-same__n">02</span><h3>Built for phones on mobile data</h3><p>Your customers are on a phone, often on a slow connection. Every build is made and tested for that first.</p></li>
			<li><span class="ix-same__n">03</span><h3>Yours to own</h3><p>The website, the code and the data belong to you, documented so any developer could take over.</p></li>
		</ol>
	</div>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>About industries.</h2>
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
		<h2 class="s-cta__title" data-split>Tell us how your business runs<span class="s-dot">.</span></h2>
		<p>Within two working days you’ll have what we’d build, how long it takes and a fixed price.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>" data-magnetic>Start a brief</a>
	</div>
</section>

<script type="application/ld+json">
<?php
$b_n = 0;
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'       => 'CollectionPage',
				'name'        => 'Industries Banks Solutions works with',
				'url'         => banks_main_url( '/industries/' ),
				'description' => 'Websites, web apps and custom solutions for finance, legal, hospitality, education, health, non-profit and fashion businesses in Nigeria and abroad.',
				'mainEntity'  => array(
					'@type'           => 'ItemList',
					'itemListElement' => array_map(
						function ( $k, $i ) use ( &$b_n ) {
							return array(
								'@type'    => 'ListItem',
								'position' => ++$b_n,
								'name'     => $i['label'],
								'url'      => banks_main_url( '/industries/' . $k . '/' ),
							);
						},
						array_keys( $b_all ),
						$b_all
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
