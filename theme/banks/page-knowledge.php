<?php
/*
 * Knowledge (/knowledge/), the hub for every article, built as scenes: a fan of the latest
 * covers in the hero, the newest and most-read pieces, the full library with topic chips and
 * a search (both added by JS; without it every article simply shows), a run of glossary terms,
 * closing call. Articles keep the old site's fields (bs_lead, bs_read_time), with Rank Math's
 * description as the summary. Motion lives in knowledge.js.
 */
get_header();

$b_posts = get_posts(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 200,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

// One shape per article, so every block below reads the same fields.
$b_items = array();
foreach ( $b_posts as $b_p ) {
	$b_cats    = get_the_category( $b_p->ID );
	$b_cat     = $b_cats ? $b_cats[0] : null;
	$b_sum     = (string) get_post_meta( $b_p->ID, 'rank_math_description', true );
	$b_sum     = $b_sum ? $b_sum : wp_trim_words( wp_strip_all_tags( (string) get_post_meta( $b_p->ID, 'bs_lead', true ) ), 26 );
	$b_read    = (string) get_post_meta( $b_p->ID, 'bs_read_time', true );
	$b_items[] = array(
		'id'    => $b_p->ID,
		'title' => get_the_title( $b_p ),
		'url'   => get_permalink( $b_p ),
		'date'  => get_the_date( 'j M Y', $b_p ),
		'iso'   => get_the_date( 'Y-m-d', $b_p ),
		'cat'   => $b_cat ? $b_cat->slug : '',
		'catn'  => $b_cat ? html_entity_decode( $b_cat->name, ENT_QUOTES ) : '',
		'sum'   => $b_sum,
		'read'  => $b_read ? $b_read : '',
		'views' => (int) get_post_meta( $b_p->ID, 'wcf_post_views_count', true ),
		'thumb' => (int) get_post_thumbnail_id( $b_p ),
	);
}

$b_topics = get_categories(
	array(
		'hide_empty' => true,
		'exclude'    => array( (int) get_option( 'default_category' ) ),
		'orderby'    => 'count',
		'order'      => 'DESC',
	)
);

$b_terms = get_posts(
	array(
		'post_type'      => 'glossary',
		'post_status'    => 'publish',
		'posts_per_page' => 100,
		'orderby'        => 'title',
		'order'          => 'ASC',
	)
);

$b_latest = array_slice( $b_items, 0, 1 );
$b_rest   = $b_items;
usort(
	$b_rest,
	function ( $a, $b ) {
		return $b['views'] - $a['views'];
	}
);
$b_popular = array_slice(
	array_values(
		array_filter(
			$b_rest,
			function ( $i ) use ( $b_latest ) {
				return ! $b_latest || $i['id'] !== $b_latest[0]['id'];
			}
		)
	),
	0,
	3
);
$b_fan = array_slice(
	array_values(
		array_filter(
			$b_items,
			function ( $i ) {
				return $i['thumb'];
			}
		)
	),
	0,
	3
);
$b_brief = banks_route( '/start/', '/contact/' );

/** One article card. */
$b_card = function ( $i, $size = 'medium_large', $eager = false ) {
	?>
	<a class="kn-card" href="<?php echo esc_url( $i['url'] ); ?>">
		<span class="kn-card__img">
			<?php
			if ( $i['thumb'] ) {
				echo wp_get_attachment_image(
					$i['thumb'],
					$size,
					false,
					array(
						'alt'     => '',
						'loading' => $eager ? 'eager' : 'lazy',
						'sizes'   => '(max-width: 700px) 92vw, 33vw',
					)
				);
			}
			?>
		</span>
		<span class="kn-card__meta"><?php echo esc_html( $i['catn'] ); ?><?php echo $i['read'] ? ' · ' . esc_html( $i['read'] ) : ''; ?></span>
		<span class="kn-card__title"><?php echo esc_html( $i['title'] ); ?></span>
		<span class="kn-card__sum"><?php echo esc_html( $i['sum'] ); ?></span>
	</a>
	<?php
};
?>
<section class="kn-hero" data-dark data-hero>
	<div class="kn-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap kn-inner">
			<div class="kn-copy">
				<p class="b-eyebrow kn-eyebrow">Knowledge · Free guides for Nigerian businesses</p>
				<h1 class="kn-title">We’d rather you understood it<span class="s-dot">.</span></h1>
				<p class="kn-lede">Plain guides on websites, AI, automation, money, law and growth for Nigerian business owners. A lot of what gets sold in this industry depends on the buyer not understanding it, so we explain it instead.</p>
				<dl class="kn-stats">
					<div><dt>Articles</dt><dd><?php echo esc_html( count( $b_items ) ); ?></dd></div>
					<div><dt>Glossary terms</dt><dd><?php echo esc_html( count( $b_terms ) ); ?></dd></div>
					<div><dt>Topics</dt><dd><?php echo esc_html( count( $b_topics ) ); ?></dd></div>
					<div><dt>Email needed</dt><dd>None</dd></div>
				</dl>
			</div>
			<?php if ( $b_fan ) : ?>
				<div class="kn-fan" aria-hidden="true">
					<?php foreach ( $b_fan as $b_i => $b_f ) : ?>
						<span class="kn-fan__card kn-fan__card--<?php echo esc_attr( $b_i ); ?>">
							<?php echo wp_get_attachment_image( $b_f['thumb'], 'medium_large', false, array( 'alt' => '', 'loading' => 'eager' ) ); ?>
							<span class="kn-fan__cap"><?php echo esc_html( $b_f['catn'] ); ?></span>
						</span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php if ( $b_latest ) : ?>
	<section class="kn-top">
		<div class="b-wrap kn-top__grid">
			<div class="kn-feature" data-reveal>
				<p class="b-eyebrow">Newest</p>
				<?php $b_card( $b_latest[0], 'large', true ); ?>
			</div>
			<?php if ( $b_popular ) : ?>
				<div class="kn-popular">
					<p class="b-eyebrow">Most read</p>
					<ol class="kn-popular__list">
						<?php foreach ( $b_popular as $b_n => $b_i ) : ?>
							<li data-reveal>
								<a href="<?php echo esc_url( $b_i['url'] ); ?>">
									<span class="kn-popular__n"><?php echo esc_html( $b_n + 1 ); ?></span>
									<span class="kn-popular__t"><?php echo esc_html( $b_i['title'] ); ?></span>
									<span class="kn-popular__m"><?php echo esc_html( $b_i['catn'] ); ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ol>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>

<section class="kn-lib" id="library">
	<div class="b-wrap">
		<div class="kn-lib__head">
			<div class="kn-head">
				<p class="b-eyebrow">The library</p>
				<h2 data-split>Every guide, by topic.</h2>
			</div>
			<div class="kn-tools" hidden>
				<label class="kn-search">
					<span class="b-sr">Search the guides</span>
					<input type="search" placeholder="Search the guides" autocomplete="off">
				</label>
			</div>
		</div>
		<div class="kn-chips" role="group" aria-label="Filter by topic" hidden>
			<button type="button" class="kn-chip is-on" data-topic="" aria-pressed="true">All <span><?php echo esc_html( count( $b_items ) ); ?></span></button>
			<?php foreach ( $b_topics as $b_t ) : ?>
				<button type="button" class="kn-chip" data-topic="<?php echo esc_attr( $b_t->slug ); ?>" aria-pressed="false"><?php echo esc_html( html_entity_decode( $b_t->name, ENT_QUOTES ) ); ?> <span><?php echo esc_html( $b_t->count ); ?></span></button>
			<?php endforeach; ?>
		</div>
		<ul class="kn-grid">
			<?php foreach ( $b_items as $b_i ) : ?>
				<li class="kn-grid__item" data-topic="<?php echo esc_attr( $b_i['cat'] ); ?>" data-text="<?php echo esc_attr( strtolower( $b_i['title'] . ' ' . $b_i['sum'] . ' ' . $b_i['catn'] ) ); ?>"><?php $b_card( $b_i ); ?></li>
			<?php endforeach; ?>
		</ul>
		<p class="kn-more" hidden><button type="button" class="b-btn b-btn--lagoon">Show all <?php echo esc_html( count( $b_items ) ); ?> guides</button></p>
		<p class="kn-empty" hidden>No guide matches that yet. <a href="<?php echo esc_url( $b_brief ); ?>">Ask us instead</a>, and it might become the next one.</p>
	</div>
</section>

<?php if ( $b_terms ) : ?>
	<section class="kn-gloss" data-dark>
		<div class="b-wrap kn-gloss__head">
			<div class="kn-head kn-head--dark">
				<p class="b-eyebrow">The glossary</p>
				<h2 data-split>The jargon, translated.</h2>
				<p><?php echo esc_html( count( $b_terms ) ); ?> terms you’ll hear from developers, agencies and software sellers, each explained in a few lines.</p>
			</div>
			<?php if ( banks_route( '/glossary/' ) ) : ?>
				<a class="b-btn b-btn--line" href="<?php echo esc_url( banks_route( '/glossary/' ) ); ?>">Open the glossary</a>
			<?php endif; ?>
		</div>
		<ul class="kn-terms">
			<?php foreach ( $b_terms as $b_t ) : ?>
				<li><a href="<?php echo esc_url( get_permalink( $b_t ) ); ?>"><?php echo esc_html( get_the_title( $b_t ) ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</section>
<?php endif; ?>

<section class="s-cta" data-dark>
	<div class="s-glow" aria-hidden="true"></div>
	<div class="b-wrap s-cta__inner">
		<h2 class="s-cta__title" data-split>Want it explained for your business<span class="s-dot">?</span></h2>
		<p>Tell us what you’re trying to fix. We’ll come back within two working days with a straight answer, even if the answer is that you don’t need us.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_brief ); ?>" data-magnetic>Start a brief</a>
	</div>
</section>

<script type="application/ld+json">
<?php
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'       => 'CollectionPage',
				'name'        => 'Knowledge: guides for Nigerian businesses',
				'url'         => banks_main_url( '/knowledge/' ),
				'description' => 'Free guides from Banks Solutions on websites, AI, automation, finance, law and growth for Nigerian business owners.',
				'publisher'   => array(
					'@type' => 'Organization',
					'@id'   => banks_main_url( '/' ) . '#organization',
					'name'  => 'Banks Solutions',
					'url'   => banks_main_url( '/' ),
				),
				'mainEntity'  => array(
					'@type'           => 'ItemList',
					'numberOfItems'   => count( $b_items ),
					'itemListElement' => array_map(
						function ( $i, $n ) {
							return array(
								'@type'    => 'ListItem',
								'position' => $n + 1,
								'url'      => $i['url'],
								'name'     => $i['title'],
							);
						},
						$b_items,
						array_keys( $b_items )
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
