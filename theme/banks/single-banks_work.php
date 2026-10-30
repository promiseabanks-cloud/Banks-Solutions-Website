<?php
/*
 * One case study (/work/<project>/), built as scenes: the project in a laptop and a phone that
 * settle flat as you scroll, the facts, the story, and the next project. Projects come from
 * Banks Core; motion lives in case.js, and everything reads with JavaScript off.
 */
get_header();

the_post();
$b_item  = banks_core_work_item( get_post() );
$b_all   = banks_work_items();
$b_ids   = wp_list_pluck( $b_all, 'id' );
$b_at    = array_search( $b_item['id'], $b_ids, true );
$b_at    = false === $b_at ? 0 : $b_at;
$b_next  = count( $b_all ) > 1 ? $b_all[ ( $b_at + 1 ) % count( $b_all ) ] : null;
$b_start = banks_route( '/start/', '/contact/' );
$b_tone  = $b_at % 4 + 1;

$b_facts = array_filter(
	array(
		'Field'         => $b_item['industry'],
		'What we built' => $b_item['built'],
		'Platform'      => $b_item['platform'],
		'Year'          => $b_item['year'],
		'Based in'      => $b_item['place'],
	)
);

// A plain account from the facts, so the page says what it is even before the story is written.
$b_built   = $b_item['built'] ? lcfirst( $b_item['built'] ) : 'the website';
$b_summary = sprintf( 'Banks Solutions built %s for %s', $b_built, $b_item['title'] );
if ( $b_item['industry'] ) {
	$b_summary .= sprintf( ', in %s', strtolower( $b_item['industry'] ) );
}
$b_summary .= $b_item['place'] ? sprintf( ', based in %s.', $b_item['place'] ) : '.';
if ( $b_item['domain'] ) {
	$b_summary .= sprintf( ' It is live at %s.', $b_item['domain'] );
}
$b_story = trim( get_the_content() );
?>
<section class="cs-hero" data-dark data-hero>
	<div class="cs-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap cs-inner">
			<p class="b-eyebrow cs-eyebrow"><a href="<?php echo esc_url( banks_main_url( '/work/' ) ); ?>">Work</a><span aria-hidden="true"> / </span><?php echo esc_html( sprintf( 'Project %02d of %02d', $b_at + 1, max( 1, count( $b_all ) ) ) ); ?></p>
			<h1 class="cs-title"><?php echo esc_html( $b_item['title'] ); ?><span class="s-dot">.</span></h1>
			<p class="cs-lede"><?php echo esc_html( $b_item['excerpt'] ? $b_item['excerpt'] : $b_summary ); ?></p>
			<div class="cs-actions">
				<?php if ( $b_item['url'] ) : ?>
					<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_item['url'] ); ?>" target="_blank" rel="noopener" data-magnetic>Visit <?php echo esc_html( $b_item['domain'] ); ?><span aria-hidden="true"> ↗</span><span class="b-sr"> (opens in a new tab)</span></a>
				<?php endif; ?>
				<a class="b-btn b-btn--line b-btn--lg" href="<?php echo esc_url( $b_start ); ?>">Start a project like this</a>
			</div>
		</div>
		<div class="cs-rig" aria-hidden="true">
			<div class="cs-rig__laptop"><?php get_template_part( 'template-parts/work-device', null, array( 'item' => $b_item, 'form' => 'laptop', 'tone' => $b_tone, 'eager' => true ) ); ?></div>
			<div class="cs-rig__phone"><?php get_template_part( 'template-parts/work-device', null, array( 'item' => $b_item, 'form' => 'phone', 'tone' => $b_tone % 4 + 1 ) ); ?></div>
		</div>
	</div>
</section>

<section class="cs-body">
	<div class="b-wrap cs-body__grid">
		<?php if ( $b_facts ) : ?>
			<dl class="cs-facts">
				<?php foreach ( $b_facts as $b_k => $b_v ) : ?>
					<div class="cs-fact" data-reveal><dt><?php echo esc_html( $b_k ); ?></dt><dd><?php echo esc_html( $b_v ); ?></dd></div>
				<?php endforeach; ?>
				<?php if ( $b_item['url'] ) : ?>
					<div class="cs-fact" data-reveal><dt>Live at</dt><dd><a href="<?php echo esc_url( $b_item['url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $b_item['domain'] ); ?><span class="b-sr"> (opens in a new tab)</span></a></dd></div>
				<?php endif; ?>
			</dl>
		<?php endif; ?>
		<div class="cs-story">
			<p class="b-eyebrow">The project</p>
			<h2 data-split><?php echo esc_html( $b_item['result'] ? $b_item['result'] : sprintf( 'What we built for %s.', $b_item['title'] ) ); ?></h2>
			<div class="cs-prose">
				<?php if ( $b_story ) : ?>
					<?php the_content(); ?>
				<?php else : ?>
					<p><?php echo esc_html( $b_summary ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php if ( $b_next ) : ?>
	<section class="cs-next" data-dark>
		<a class="cs-next__link" href="<?php echo esc_url( $b_next['link'] ); ?>">
			<span class="b-wrap cs-next__inner">
				<span class="cs-next__copy">
					<span class="b-eyebrow">Next project</span>
					<span class="cs-next__name"><?php echo esc_html( $b_next['title'] ); ?></span>
					<span class="cs-next__field"><?php echo esc_html( $b_next['industry'] ); ?><span aria-hidden="true"> →</span></span>
				</span>
				<span class="cs-next__rig" aria-hidden="true"><?php get_template_part( 'template-parts/work-device', null, array( 'item' => $b_next, 'form' => 'laptop', 'tone' => ( $b_at + 1 ) % 4 + 1 ) ); ?></span>
			</span>
		</a>
	</section>
<?php endif; ?>

<section class="s-cta" data-dark>
	<div class="s-glow" aria-hidden="true"></div>
	<div class="b-wrap s-cta__inner">
		<h2 class="s-cta__title" data-split>Want one like this<span class="s-dot">?</span></h2>
		<p>Tell us about your business. Within two working days you’ll have what we’d build, how long it takes and a fixed price.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>" data-magnetic>Start the brief</a>
	</div>
</section>

<script type="application/ld+json">
<?php
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array_filter(
				array(
					'@type'    => 'CreativeWork',
					'name'     => $b_item['title'] . ' website',
					'url'      => $b_item['link'],
					'sameAs'   => $b_item['url'],
					'genre'    => $b_item['industry'],
					'abstract' => $b_item['excerpt'] ? $b_item['excerpt'] : $b_summary,
					'image'    => $b_item['poster'],
					'creator'  => array(
						'@type' => 'Organization',
						'name'  => 'Banks Solutions',
						'url'   => banks_main_url( '/' ),
					),
				)
			),
			array(
				'@type'           => 'BreadcrumbList',
				'itemListElement' => array(
					array(
						'@type'    => 'ListItem',
						'position' => 1,
						'name'     => 'Work',
						'item'     => banks_main_url( '/work/' ),
					),
					array(
						'@type'    => 'ListItem',
						'position' => 2,
						'name'     => $b_item['title'],
						'item'     => $b_item['link'],
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
