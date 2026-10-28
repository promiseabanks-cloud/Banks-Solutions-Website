<?php
/*
 * Glossary term, built as scenes: the word huge on a dark stage with its definition as a
 * statement card, then why it matters, where we use it, the terms either side of it and the
 * rest of the glossary, closing call. Text lives in the old site's custom fields
 * (bs_definition, bs_why_html, bs_related_html, bs_short_label, bs_entry_num, bs_read_time).
 */
get_header();
while ( have_posts() ) :
	the_post();
	$b_id      = get_the_ID();
	$b_title   = get_the_title();
	$b_label   = (string) get_post_meta( $b_id, 'bs_short_label', true );
	$b_def     = (string) get_post_meta( $b_id, 'bs_definition', true );
	$b_why     = (string) get_post_meta( $b_id, 'bs_why_html', true );
	$b_related = (string) get_post_meta( $b_id, 'bs_related_html', true );
	$b_read    = (string) get_post_meta( $b_id, 'bs_read_time', true );
	$b_hub     = banks_main_url( '/glossary/' );
	$b_brief   = banks_route( '/start/', '/contact/' );

	// Where we use it: the old related chips.
	$b_uses = array();
	if ( preg_match_all( '/<a[^>]+href="([^"]+)"[^>]*>(.*?)<\/a>/s', $b_related, $b_m, PREG_SET_ORDER ) ) {
		foreach ( $b_m as $b_x ) {
			$b_uses[] = array( $b_x[1], html_entity_decode( wp_strip_all_tags( $b_x[2] ), ENT_QUOTES ) );
		}
	}

	// The whole glossary, A to Z, for the neighbours and the closing list.
	$b_all = get_posts(
		array(
			'post_type'      => 'glossary',
			'post_status'    => 'publish',
			'posts_per_page' => 300,
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);
	$b_at = 0;
	foreach ( $b_all as $b_k => $b_t ) {
		if ( (int) $b_t->ID === (int) $b_id ) {
			$b_at = $b_k;
		}
	}
	$b_count = count( $b_all );
	$b_prev  = $b_count > 1 ? $b_all[ ( $b_at - 1 + $b_count ) % $b_count ] : null;
	$b_nxt   = $b_count > 1 ? $b_all[ ( $b_at + 1 ) % $b_count ] : null;
	?>
	<article <?php post_class( 'tm' ); ?>>
		<header class="tm-hero" data-dark data-hero>
			<div class="s-glow" aria-hidden="true"></div>
			<div class="b-wrap tm-inner">
				<nav class="rd-crumbs" aria-label="Breadcrumb">
					<a href="<?php echo esc_url( $b_hub ); ?>">Glossary</a>
					<span aria-hidden="true">/</span>
					<span><?php echo esc_html( sprintf( 'No. %02d of %d', $b_at + 1, max( 1, $b_count ) ) ); ?></span>
				</nav>
				<h1 class="tm-title"><?php echo esc_html( $b_title ); ?><span class="s-dot">.</span></h1>
				<?php if ( $b_label && false === stripos( $b_title, $b_label ) ) : ?>
					<p class="tm-label"><?php echo esc_html( $b_label ); ?></p>
				<?php endif; ?>
				<?php if ( $b_def ) : ?>
					<figure class="tm-def">
						<figcaption class="tm-def__label"><span>Definition</span><?php echo $b_read ? '<span>' . esc_html( $b_read ) . '</span>' : ''; ?></figcaption>
						<p class="tm-def__text"><?php echo esc_html( $b_def ); ?></p>
					</figure>
				<?php endif; ?>
			</div>
		</header>

		<div class="b-wrap tm-body">
			<div class="tm-why">
				<?php if ( $b_why ) : ?>
					<p class="b-eyebrow">Why it matters to you</p>
					<div class="b-prose tm-prose"><?php echo wp_kses_post( $b_why ); ?></div>
				<?php elseif ( ! $b_def ) : ?>
					<div class="b-prose tm-prose"><?php the_content(); ?></div>
				<?php endif; ?>
			</div>
			<aside class="tm-side">
				<?php if ( $b_uses ) : ?>
					<p class="rd-label">Where we use it</p>
					<ul class="tm-uses">
						<?php foreach ( $b_uses as $b_u ) : ?>
							<li><a href="<?php echo esc_url( $b_u[0] ); ?>"><?php echo esc_html( $b_u[1] ); ?><span aria-hidden="true">→</span></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<div class="tm-ask" data-dark>
					<p>Not sure whether <?php echo esc_html( $b_title ); ?> matters for your business? Ask us. We’ll tell you honestly.</p>
					<a class="b-btn b-btn--signal" href="<?php echo esc_url( $b_brief ); ?>" data-magnetic>Ask us</a>
				</div>
			</aside>
		</div>

		<?php if ( $b_prev && $b_nxt ) : ?>
			<nav class="b-wrap tm-pn" aria-label="Neighbouring terms">
				<a class="tm-pn__link" href="<?php echo esc_url( get_permalink( $b_prev ) ); ?>" rel="prev">
					<span class="rd-label">← Previous term</span>
					<span class="tm-pn__t"><?php echo esc_html( get_the_title( $b_prev ) ); ?></span>
				</a>
				<a class="tm-pn__link tm-pn__link--next" href="<?php echo esc_url( get_permalink( $b_nxt ) ); ?>" rel="next">
					<span class="rd-label">Next term →</span>
					<span class="tm-pn__t"><?php echo esc_html( get_the_title( $b_nxt ) ); ?></span>
				</a>
			</nav>
		<?php endif; ?>
	</article>

	<?php if ( $b_count > 1 ) : ?>
		<section class="tm-all">
			<div class="b-wrap">
				<div class="rd-more__head">
					<div>
						<p class="b-eyebrow">The glossary</p>
						<h2 data-split>Every term, A to Z.</h2>
					</div>
					<a class="b-btn b-btn--line" href="<?php echo esc_url( $b_hub ); ?>">Open the glossary</a>
				</div>
				<ul class="tm-terms">
					<?php foreach ( $b_all as $b_t ) : ?>
						<li><a href="<?php echo esc_url( get_permalink( $b_t ) ); ?>"<?php echo (int) $b_t->ID === (int) $b_id ? ' aria-current="page"' : ''; ?>><?php echo esc_html( get_the_title( $b_t ) ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

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
	echo wp_json_encode(
		array(
			'@context' => 'https://schema.org',
			'@graph'   => array(
				array_filter(
					array(
					'@type'            => 'DefinedTerm',
					'@id'              => get_permalink() . '#term',
					'name'             => $b_title,
					'alternateName'    => $b_label && false === stripos( $b_title, $b_label ) ? $b_label : null,
					'description'      => $b_def,
					'url'              => get_permalink(),
					'inDefinedTermSet' => array(
						'@type' => 'DefinedTermSet',
						'name'  => 'Banks Solutions glossary',
						'url'   => $b_hub,
					),
					)
				),
				array(
					'@type'           => 'BreadcrumbList',
					'itemListElement' => array(
						array(
							'@type'    => 'ListItem',
							'position' => 1,
							'name'     => 'Glossary',
							'item'     => $b_hub,
						),
						array(
							'@type'    => 'ListItem',
							'position' => 2,
							'name'     => $b_title,
							'item'     => get_permalink(),
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
endwhile;
get_footer();
