<?php
/*
 * Glossary (/glossary/), every term on one page, built as scenes: a definition card that
 * cycles through terms in the hero, an A to Z bar that follows you down, the terms grouped
 * by letter with a search (added by JS; without it everything shows), closing call. Terms
 * keep the old site's fields (bs_definition, bs_short_label). Motion lives in glossary.js.
 */
get_header();

$b_terms = get_posts(
	array(
		'post_type'      => 'glossary',
		'post_status'    => 'publish',
		'posts_per_page' => 300,
		'orderby'        => 'title',
		'order'          => 'ASC',
	)
);

// Grouped by first letter; digits and symbols go under #.
$b_groups = array();
foreach ( $b_terms as $b_t ) {
	$b_title = get_the_title( $b_t );
	$b_first = strtoupper( substr( preg_replace( '/[^a-z0-9]/i', '', $b_title ), 0, 1 ) );
	$b_key   = ctype_alpha( $b_first ) ? $b_first : '#';
	$b_def   = (string) get_post_meta( $b_t->ID, 'bs_definition', true );
	$b_groups[ $b_key ][] = array(
		'title' => $b_title,
		'short' => (string) get_post_meta( $b_t->ID, 'bs_short_label', true ),
		'def'   => $b_def,
		'url'   => get_permalink( $b_t ),
	);
}
ksort( $b_groups );

// The hero card cycles through a handful of terms that have a definition.
$b_cycle = array();
foreach ( $b_groups as $b_list ) {
	foreach ( $b_list as $b_i ) {
		if ( $b_i['def'] && count( $b_cycle ) < 8 && strlen( $b_i['def'] ) < 200 ) {
			$b_cycle[] = $b_i;
		}
	}
}
$b_first = $b_cycle ? $b_cycle[0] : null;
$b_brief = banks_route( '/start/', '/contact/' );
?>
<section class="gl-hero" data-dark data-hero>
	<div class="gl-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap gl-inner">
			<div class="gl-copy">
				<p class="b-eyebrow gl-eyebrow">Glossary · <?php echo esc_html( count( $b_terms ) ); ?> terms</p>
				<h1 class="gl-title">The jargon, translated<span class="s-dot">.</span></h1>
				<p class="gl-lede">The words developers, agencies and software sellers use, each explained in plain English for Nigerian business owners, with why it matters to you.</p>
				<a class="b-btn b-btn--signal b-btn--lg" href="#terms" data-magnetic>Browse A to Z</a>
			</div>
			<?php if ( $b_first ) : ?>
				<figure class="gl-card" aria-label="An example definition">
					<p class="gl-card__label"><span>Definition</span><span class="gl-card__count"><span class="gl-card__i">01</span> / <?php echo esc_html( sprintf( '%02d', count( $b_cycle ) ) ); ?></span></p>
					<p class="gl-card__term"><?php echo esc_html( $b_first['title'] ); ?></p>
					<p class="gl-card__def"><?php echo esc_html( $b_first['def'] ); ?></p>
					<a class="gl-card__go" href="<?php echo esc_url( $b_first['url'] ); ?>">Why it matters <span aria-hidden="true">→</span></a>
					<script type="application/json" class="gl-card__data"><?php echo wp_json_encode( $b_cycle, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG ); ?></script>
				</figure>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="gl-body" id="terms">
	<nav class="gl-az" aria-label="Jump to a letter">
		<div class="b-wrap gl-az__in">
			<ol class="gl-az__list">
				<?php foreach ( $b_groups as $b_k => $b_list ) : ?>
					<li><a href="#letter-<?php echo esc_attr( '#' === $b_k ? 'num' : strtolower( $b_k ) ); ?>"><?php echo esc_html( $b_k ); ?></a></li>
				<?php endforeach; ?>
			</ol>
			<label class="gl-search" hidden>
				<span class="b-sr">Search the glossary</span>
				<input type="search" placeholder="Search terms" autocomplete="off">
			</label>
		</div>
	</nav>

	<div class="b-wrap">
		<?php foreach ( $b_groups as $b_k => $b_list ) : ?>
			<section class="gl-group" id="letter-<?php echo esc_attr( '#' === $b_k ? 'num' : strtolower( $b_k ) ); ?>" aria-labelledby="letter-<?php echo esc_attr( '#' === $b_k ? 'num' : strtolower( $b_k ) ); ?>-h">
				<h2 class="gl-letter" id="letter-<?php echo esc_attr( '#' === $b_k ? 'num' : strtolower( $b_k ) ); ?>-h"><?php echo esc_html( $b_k ); ?></h2>
				<ul class="gl-list">
					<?php foreach ( $b_list as $b_i ) : ?>
						<li class="gl-item" data-text="<?php echo esc_attr( strtolower( $b_i['title'] . ' ' . $b_i['short'] . ' ' . $b_i['def'] ) ); ?>">
							<a class="gl-term" href="<?php echo esc_url( $b_i['url'] ); ?>">
								<span class="gl-term__name"><?php echo esc_html( $b_i['title'] ); ?></span>
								<?php if ( $b_i['def'] ) : ?>
									<span class="gl-term__def"><?php echo esc_html( $b_i['def'] ); ?></span>
								<?php endif; ?>
								<span class="gl-term__go" aria-hidden="true">→</span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endforeach; ?>
		<p class="gl-empty" hidden>No term matches that. <a href="<?php echo esc_url( $b_brief ); ?>">Ask us what it means</a>, and we’ll add it.</p>
	</div>
</section>

<section class="s-cta" data-dark>
	<div class="s-glow" aria-hidden="true"></div>
	<div class="b-wrap s-cta__inner">
		<h2 class="s-cta__title" data-split>Heard a word you didn’t know<span class="s-dot">?</span></h2>
		<p>Ask us. We’ll explain it, and tell you honestly whether it matters for your business.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_brief ); ?>" data-magnetic>Start a brief</a>
	</div>
</section>

<script type="application/ld+json">
<?php
$b_defined = array();
foreach ( $b_groups as $b_list ) {
	foreach ( $b_list as $b_i ) {
		$b_defined[] = array(
			'@type'       => 'DefinedTerm',
			'name'        => $b_i['title'],
			'description' => $b_i['def'],
			'url'         => $b_i['url'],
		);
	}
}
echo wp_json_encode(
	array(
		'@context'     => 'https://schema.org',
		'@type'        => 'DefinedTermSet',
		'name'         => 'Banks Solutions glossary',
		'url'          => banks_main_url( '/glossary/' ),
		'description'  => 'Technology and digital business terms explained in plain English for Nigerian business owners.',
		'hasDefinedTerm' => $b_defined,
		'publisher'    => array(
			'@type' => 'Organization',
			'@id'   => banks_main_url( '/' ) . '#organization',
			'name'  => 'Banks Solutions',
			'url'   => banks_main_url( '/' ),
		),
	),
	JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
);
?>
</script>
<?php
get_footer();
