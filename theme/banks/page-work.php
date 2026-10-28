<?php
/*
 * Work (/work/), built as scenes: a showreel hero with a laptop and a phone cycling through live
 * projects, the reel (a pinned 3D carousel on desktop, a list on phones), every project by field
 * with a preview that follows the cursor, questions, closing call. Projects come from Banks Core
 * (Dashboard > Work). Motion lives in work.js; with JavaScript off the reel is a plain list.
 */
get_header();

$b_start = banks_route( '/start/', '/contact/' );
$b_items = banks_work_items();
$b_count = count( $b_items );
$b_tags  = array();
foreach ( $b_items as $b_i ) {
	$b_tags += banks_work_tags( $b_i['industry'] );
}

$b_faqs = array(
	array( 'What has Banks Solutions built?', $b_count ? 'Websites and platforms for businesses in ' . ( count( $b_tags ) > 1 ? count( $b_tags ) . ' fields' : 'many fields' ) . ', including ' . implode( ', ', array_slice( wp_list_pluck( $b_items, 'title' ), 0, 6 ) ) . '. Every project on this page is live, and each one has its own case study.' : 'Websites, web apps and custom solutions for businesses in many fields. Projects are listed here as each case study is ready.' ),
	array( 'Do you only build for one industry?', 'No. Banks Solutions builds for any business in any field: hotels, banks, law firms, salons, fashion labels, coaches, entertainment brands and foundations so far. What matters is the business problem, and the brief is where we learn it.' ),
	array( 'Can I visit these websites?', 'Yes. Every project links to the live site, so you can try it on your own phone and see how fast it is for yourself.' ),
	array( 'How much would a site like these cost?', 'Business websites start at ₦499,000 and online stores at ₦750,000. Web apps and custom solutions are priced from a written spec. Every quote is fixed before work starts.' ),
);
?>
<section class="wk-hero" data-dark data-hero>
	<div class="wk-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap wk-inner">
			<div class="wk-copy">
				<p class="b-eyebrow wk-eyebrow">Selected work</p>
				<h1 class="wk-title">Built for real businesses<span class="s-dot">.</span></h1>
				<p class="wk-lede">
					<?php if ( $b_count ) : ?>
						<?php echo esc_html( sprintf( '%d websites and platforms Banks Solutions has built for businesses in %d fields, from hotels and a bank to salons, a law firm and a foundation. Every one is live. Scroll through them, then open any project for the full story.', $b_count, count( $b_tags ) ) ); ?>
					<?php else : ?>
						Websites, web apps and custom solutions Banks Solutions has built for businesses in many fields. Case studies are on their way.
					<?php endif; ?>
				</p>
				<div class="wk-actions">
					<?php if ( $b_count ) : ?>
						<a class="b-btn b-btn--signal b-btn--lg" href="#wk-reel" data-magnetic>Watch the reel</a>
					<?php endif; ?>
					<a class="b-btn b-btn--line b-btn--lg" href="<?php echo esc_url( $b_start ); ?>">Start a project</a>
				</div>
				<?php if ( $b_count ) : ?>
					<dl class="wk-stats">
						<div><dt>Live builds</dt><dd data-count="<?php echo esc_attr( $b_count ); ?>"><?php echo esc_html( $b_count ); ?></dd></div>
						<div><dt>Fields</dt><dd data-count="<?php echo esc_attr( count( $b_tags ) ); ?>"><?php echo esc_html( count( $b_tags ) ); ?></dd></div>
						<div><dt>Client rating</dt><dd data-count="9.0" data-decimals="1">9.0</dd></div>
					</dl>
				<?php endif; ?>
			</div>
			<?php if ( $b_count ) : ?>
				<?php $b_show = array_slice( $b_items, 0, 5 ); ?>
				<div class="wk-show" aria-hidden="true">
					<div class="wk-show__rig">
						<?php get_template_part( 'template-parts/work-device', null, array( 'items' => $b_show, 'form' => 'laptop', 'eager' => true ) ); ?>
						<?php get_template_part( 'template-parts/work-device', null, array( 'items' => $b_show, 'form' => 'phone', 'tone' => 1 ) ); ?>
					</div>
					<p class="wk-show__now"><span class="s-live"></span>Now showing <strong><?php echo esc_html( $b_show[0]['title'] ); ?></strong></p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php if ( $b_count ) : ?>
	<section class="wk-reel" id="wk-reel" data-dark>
		<div class="wk-reel__pin">
			<div class="b-wrap wk-reel__head">
				<div>
					<p class="b-eyebrow">The reel</p>
					<h2 data-split>Scroll through every build.</h2>
				</div>
				<p class="wk-reel__count" aria-hidden="true"><span class="wk-reel__now">01</span> / <?php echo esc_html( sprintf( '%02d', $b_count ) ); ?></p>
			</div>
			<ol class="wk-reel__track">
				<?php foreach ( $b_items as $b_n => $b_i ) : ?>
					<li class="wk-slide">
						<div class="wk-slide__rig">
							<?php get_template_part( 'template-parts/work-device', null, array( 'item' => $b_i, 'form' => 'laptop', 'tone' => $b_n % 4 + 1 ) ); ?>
							<?php get_template_part( 'template-parts/work-device', null, array( 'item' => $b_i, 'form' => 'phone', 'tone' => ( $b_n + 1 ) % 4 + 1 ) ); ?>
						</div>
						<div class="wk-slide__copy">
							<p class="wk-slide__meta"><span><?php echo esc_html( sprintf( '%02d', $b_n + 1 ) ); ?></span><?php echo esc_html( $b_i['industry'] ); ?></p>
							<h3 class="wk-slide__name"><a href="<?php echo esc_url( $b_i['link'] ); ?>"><?php echo esc_html( $b_i['title'] ); ?></a></h3>
							<?php if ( $b_i['excerpt'] ) : ?>
								<p class="wk-slide__line"><?php echo esc_html( $b_i['excerpt'] ); ?></p>
							<?php endif; ?>
							<p class="wk-slide__links">
								<a class="wk-slide__case" href="<?php echo esc_url( $b_i['link'] ); ?>">Case study<span aria-hidden="true"> →</span></a>
								<?php if ( $b_i['url'] ) : ?>
									<a class="wk-slide__live" href="<?php echo esc_url( $b_i['url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $b_i['domain'] ); ?><span aria-hidden="true"> ↗</span><span class="b-sr"> (opens in a new tab)</span></a>
								<?php endif; ?>
							</p>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
			<div class="wk-reel__bar" aria-hidden="true"><span></span></div>
		</div>
	</section>

	<section class="wk-index">
		<div class="b-wrap">
			<div class="wk-head">
				<p class="b-eyebrow">Every project</p>
				<h2 data-split>Find your field.</h2>
				<p>Pick a field to see what we built for it. Each project opens its case study.</p>
			</div>
			<?php if ( count( $b_tags ) > 1 ) : ?>
				<div class="wk-chips" role="group" aria-label="Filter by field" hidden>
					<button type="button" class="wk-chip is-on" data-tag="" aria-pressed="true">All <sup><?php echo esc_html( $b_count ); ?></sup></button>
					<?php foreach ( $b_tags as $b_slug => $b_label ) : ?>
						<?php $b_has = count( array_filter( $b_items, function ( $i ) use ( $b_slug ) { return isset( banks_work_tags( $i['industry'] )[ $b_slug ] ); } ) ); ?>
						<button type="button" class="wk-chip" data-tag="<?php echo esc_attr( $b_slug ); ?>" aria-pressed="false"><?php echo esc_html( $b_label ); ?> <sup><?php echo esc_html( $b_has ); ?></sup></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<ol class="wk-list">
				<?php foreach ( $b_items as $b_n => $b_i ) : ?>
					<li class="wk-row" data-tags="<?php echo esc_attr( implode( ' ', array_keys( banks_work_tags( $b_i['industry'] ) ) ) ); ?>" data-peek="<?php echo esc_attr( $b_n ); ?>">
						<a class="wk-row__link" href="<?php echo esc_url( $b_i['link'] ); ?>">
							<span class="wk-row__n"><?php echo esc_html( sprintf( '%02d', $b_n + 1 ) ); ?></span>
							<span class="wk-row__name"><?php echo esc_html( $b_i['title'] ); ?></span>
							<span class="wk-row__field"><?php echo esc_html( $b_i['industry'] ); ?></span>
							<span class="wk-row__domain"><?php echo esc_html( $b_i['domain'] ); ?></span>
							<span class="wk-row__arrow" aria-hidden="true">→</span>
						</a>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
		<div class="wk-peek" aria-hidden="true">
			<?php foreach ( $b_items as $b_n => $b_i ) : ?>
				<div class="wk-peek__item"><?php get_template_part( 'template-parts/work-device', null, array( 'item' => $b_i, 'form' => 'laptop', 'tone' => $b_n % 4 + 1 ) ); ?></div>
			<?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>About the work.</h2>
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
		<h2 class="s-cta__title" data-split>Your business could be next<span class="s-dot">.</span></h2>
		<p>Tell us what you’re building. Within two working days you’ll have what we’d make, how long it takes and a fixed price.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>" data-magnetic>Start the brief</a>
	</div>
</section>

<script type="application/ld+json">
<?php
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'      => 'CollectionPage',
				'name'       => 'Work by Banks Solutions',
				'url'        => banks_main_url( '/work/' ),
				'mainEntity' => array(
					'@type'           => 'ItemList',
					'numberOfItems'   => $b_count,
					'itemListElement' => array_map(
						function ( $i, $n ) {
							return array(
								'@type'    => 'ListItem',
								'position' => $n + 1,
								'url'      => $i['link'],
								'item'     => array_filter(
									array(
										'@type'    => 'CreativeWork',
										'name'     => $i['title'],
										'url'      => $i['link'],
										'genre'    => $i['industry'],
										'sameAs'   => $i['url'],
										'abstract' => $i['excerpt'],
										'creator'  => array(
											'@type' => 'Organization',
											'name'  => 'Banks Solutions',
										),
									)
								),
							);
						},
						$b_items,
						array_keys( $b_items )
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
