<?php
/*
 * Knowledge article, built as scenes: a dark masthead with the cover sliding over the fold,
 * the text beside a numbered contents list that follows you down, the questions people ask
 * as an accordion, guides from the same topic, closing call. The text lives in the custom
 * fields the old site used (bs_lead, bs_body_html, bs_toc_html, bs_faqs_html, bs_related_html,
 * bs_read_time); post content is the fallback for articles written in the editor later.
 * Everything reads without JS; read.js adds the progress bar, contents highlight and motion.
 */
get_header();
while ( have_posts() ) :
	the_post();
	$b_id      = get_the_ID();
	$b_lead    = (string) get_post_meta( $b_id, 'bs_lead', true );
	$b_body    = (string) get_post_meta( $b_id, 'bs_body_html', true );
	$b_toc     = (string) get_post_meta( $b_id, 'bs_toc_html', true );
	$b_faqs    = (string) get_post_meta( $b_id, 'bs_faqs_html', true );
	$b_related = (string) get_post_meta( $b_id, 'bs_related_html', true );
	$b_read    = (string) get_post_meta( $b_id, 'bs_read_time', true );
	$b_desc    = (string) get_post_meta( $b_id, 'rank_math_description', true );
	if ( '' === $b_read ) {
		$b_words = str_word_count( wp_strip_all_tags( $b_body ? $b_body : get_the_content() ) );
		$b_read  = max( 1, (int) round( $b_words / 220 ) ) . ' min read';
	}
	$b_cats  = get_the_category();
	$b_cat   = $b_cats ? $b_cats[0] : null;
	$b_catn  = $b_cat ? html_entity_decode( $b_cat->name, ENT_QUOTES ) : '';
	$b_url   = get_permalink();
	$b_title = get_the_title();
	$b_brief = banks_route( '/start/', '/contact/' );
	$b_hub   = banks_main_url( '/knowledge/' );

	// Contents: the old site's list, or the headings in the text when there isn't one.
	$b_steps = array();
	if ( preg_match_all( '/<a[^>]+href="#([^"]+)"[^>]*>(.*?)<\/a>/s', $b_toc, $b_m, PREG_SET_ORDER ) ) {
		foreach ( $b_m as $b_x ) {
			$b_steps[] = array( $b_x[1], wp_strip_all_tags( $b_x[2] ) );
		}
	} elseif ( preg_match_all( '/<h2[^>]+id="([^"]+)"[^>]*>(.*?)<\/h2>/s', $b_body, $b_m, PREG_SET_ORDER ) ) {
		foreach ( $b_m as $b_x ) {
			$b_steps[] = array( $b_x[1], wp_strip_all_tags( $b_x[2] ) );
		}
	}

	// Questions: pairs of bs-faq-q and bs-faq-a.
	$b_qs = array();
	if ( preg_match_all( '/class="bs-faq-q"[^>]*>(.*?)<\/p>\s*<p[^>]*class="bs-faq-a"[^>]*>(.*?)<\/p>/s', $b_faqs, $b_m, PREG_SET_ORDER ) ) {
		foreach ( $b_m as $b_x ) {
			$b_qs[] = array( wp_strip_all_tags( $b_x[1] ), $b_x[2] );
		}
	}

	// Read next: the old related chips, minus the contact one (the closing call covers it).
	$b_next = array();
	if ( preg_match_all( '/<a[^>]+href="([^"]+)"[^>]*>(.*?)<\/a>/s', $b_related, $b_m, PREG_SET_ORDER ) ) {
		foreach ( $b_m as $b_x ) {
			if ( false === strpos( $b_x[1], '/contact' ) && false === strpos( $b_x[1], '/start' ) ) {
				$b_next[] = array( $b_x[1], html_entity_decode( wp_strip_all_tags( $b_x[2] ), ENT_QUOTES ) );
			}
		}
	}

	// More from the same topic, topped up with the newest guides.
	$b_more = $b_cat ? get_posts(
		array(
			'post_type'      => 'post',
			'posts_per_page' => 3,
			'category_name'  => $b_cat->slug,
			'post__not_in'   => array( $b_id ),
		)
	) : array();
	if ( count( $b_more ) < 3 ) {
		$b_more = array_merge(
			$b_more,
			get_posts(
				array(
					'post_type'      => 'post',
					'posts_per_page' => 3 - count( $b_more ),
					'post__not_in'   => array_merge( array( $b_id ), wp_list_pluck( $b_more, 'ID' ) ),
				)
			)
		);
	}
	?>
	<div class="rd-progress" aria-hidden="true" hidden><span></span></div>
	<article <?php post_class( 'rd' ); ?>>
		<header class="rd-hero" data-dark data-hero>
			<div class="s-glow" aria-hidden="true"></div>
			<div class="b-wrap rd-head">
				<nav class="rd-crumbs" aria-label="Breadcrumb">
					<a href="<?php echo esc_url( $b_hub ); ?>">Knowledge</a>
					<?php if ( $b_cat ) : ?>
						<span aria-hidden="true">/</span>
						<a href="<?php echo esc_url( add_query_arg( 'topic', $b_cat->slug, $b_hub ) . '#library' ); ?>"><?php echo esc_html( $b_catn ); ?></a>
					<?php endif; ?>
				</nav>
				<h1 class="rd-title"><?php echo esc_html( $b_title ); ?></h1>
				<?php if ( $b_lead ) : ?>
					<p class="rd-lead"><?php echo wp_kses_post( $b_lead ); ?></p>
				<?php endif; ?>
				<ul class="rd-meta">
					<li><span class="rd-meta__mark" aria-hidden="true">B</span>Banks Solutions</li>
					<li><time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></time></li>
					<li><?php echo esc_html( $b_read ); ?></li>
				</ul>
			</div>
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="b-wrap rd-cover">
					<span class="rd-cover__frame"><?php the_post_thumbnail( 'large', array( 'alt' => banks_image_alt( get_post_thumbnail_id(), get_the_title() ), 'loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '(max-width: 1240px) 94vw, 1180px' ) ); ?></span>
				</figure>
			<?php endif; ?>
		</header>

		<div class="b-wrap rd-grid">
			<aside class="rd-side">
				<?php if ( $b_steps ) : ?>
					<details class="rd-toc" open>
						<summary>In this article <span><?php echo esc_html( count( $b_steps ) ); ?> parts</span></summary>
						<ol>
							<?php foreach ( $b_steps as $b_n => $b_s ) : ?>
								<li><a href="#<?php echo esc_attr( $b_s[0] ); ?>"><span class="rd-toc__n"><?php echo esc_html( sprintf( '%02d', $b_n + 1 ) ); ?></span><?php echo esc_html( $b_s[1] ); ?></a></li>
							<?php endforeach; ?>
						</ol>
					</details>
				<?php endif; ?>
				<div class="rd-share">
					<p class="rd-label">Share this guide</p>
					<ul>
						<li><a href="<?php echo esc_url( 'https://wa.me/?text=' . rawurlencode( $b_title . ' ' . $b_url ) ); ?>" rel="noopener" target="_blank">WhatsApp</a></li>
						<li><a href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $b_url ) ); ?>" rel="noopener" target="_blank">LinkedIn</a></li>
						<li><a href="<?php echo esc_url( 'https://x.com/intent/post?url=' . rawurlencode( $b_url ) . '&text=' . rawurlencode( $b_title ) ); ?>" rel="noopener" target="_blank">X</a></li>
						<li hidden><button type="button" class="rd-copy" data-url="<?php echo esc_url( $b_url ); ?>">Copy link</button></li>
					</ul>
				</div>
			</aside>

			<div class="rd-main">
				<div class="b-prose rd-prose">
					<?php
					if ( $b_body ) {
						echo wp_kses_post( $b_body );
					} else {
						the_content();
					}
					?>
				</div>

				<?php if ( $b_qs ) : ?>
					<section class="rd-faqs" aria-labelledby="rd-faqs-title">
						<p class="b-eyebrow">Short answers</p>
						<h2 id="rd-faqs-title">Questions people ask</h2>
						<?php foreach ( $b_qs as $b_q ) : ?>
							<details class="rd-qa">
								<summary><?php echo esc_html( $b_q[0] ); ?><span class="rd-qa__icon" aria-hidden="true"></span></summary>
								<div class="rd-qa__a"><p><?php echo wp_kses_post( $b_q[1] ); ?></p></div>
							</details>
						<?php endforeach; ?>
					</section>
				<?php elseif ( $b_faqs ) : ?>
					<section class="rd-faqs" aria-labelledby="rd-faqs-title">
						<h2 id="rd-faqs-title">Questions people ask</h2>
						<?php echo wp_kses_post( $b_faqs ); ?>
					</section>
				<?php endif; ?>

				<aside class="rd-note" data-dark>
					<span class="rd-note__mark" aria-hidden="true">B<span class="s-dot">.</span></span>
					<div>
						<p class="rd-note__by">Written by Banks Solutions</p>
						<p>We build websites, web apps and custom solutions for businesses in Nigeria and abroad. If this raised a question about your own setup, ask us. You’ll get a straight answer.</p>
						<a class="b-btn b-btn--signal" href="<?php echo esc_url( $b_brief ); ?>" data-magnetic>Ask about your business</a>
					</div>
				</aside>

				<?php if ( $b_next ) : ?>
					<nav class="rd-next" aria-label="Read next">
						<p class="rd-label">Read next</p>
						<ul>
							<?php foreach ( $b_next as $b_x ) : ?>
								<li><a href="<?php echo esc_url( $b_x[0] ); ?>"><?php echo esc_html( $b_x[1] ); ?><span aria-hidden="true">→</span></a></li>
							<?php endforeach; ?>
						</ul>
					</nav>
				<?php endif; ?>
			</div>
		</div>
	</article>

	<?php if ( $b_more ) : ?>
		<section class="rd-more">
			<div class="b-wrap">
				<div class="rd-more__head">
					<div>
						<p class="b-eyebrow"><?php echo $b_cat ? esc_html( 'More on ' . $b_catn ) : 'More guides'; ?></p>
						<h2 data-split>Keep reading.</h2>
					</div>
					<a class="b-btn b-btn--line" href="<?php echo esc_url( $b_hub . '#library' ); ?>">Every guide</a>
				</div>
				<ul class="rd-cards">
					<?php foreach ( $b_more as $b_p ) : ?>
						<?php
						$b_pc  = get_the_category( $b_p->ID );
						$b_pr  = (string) get_post_meta( $b_p->ID, 'bs_read_time', true );
						$b_ps  = (string) get_post_meta( $b_p->ID, 'rank_math_description', true );
						?>
						<li>
							<a class="rd-card" href="<?php echo esc_url( get_permalink( $b_p ) ); ?>">
								<span class="rd-card__img"><?php echo get_the_post_thumbnail( $b_p, 'medium_large', array( 'alt' => '', 'loading' => 'lazy', 'sizes' => '(max-width: 700px) 92vw, 33vw' ) ); ?></span>
								<span class="rd-card__meta"><?php echo $b_pc ? esc_html( html_entity_decode( $b_pc[0]->name, ENT_QUOTES ) ) : ''; ?><?php echo $b_pr ? ' · ' . esc_html( $b_pr ) : ''; ?></span>
								<span class="rd-card__title"><?php echo esc_html( get_the_title( $b_p ) ); ?></span>
								<?php if ( $b_ps ) : ?><span class="rd-card__sum"><?php echo esc_html( $b_ps ); ?></span><?php endif; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<section class="s-cta" data-dark>
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap s-cta__inner">
			<h2 class="s-cta__title" data-split>Rather have it done for you<span class="s-dot">?</span></h2>
			<p>Tell us what you’re trying to fix. We’ll come back within two working days with a plan and a price, or an honest answer that you don’t need us.</p>
			<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_brief ); ?>" data-magnetic>Start a brief</a>
		</div>
	</section>

	<script type="application/ld+json">
	<?php
	$b_graph = array(
		array(
			'@type'           => 'BreadcrumbList',
			'itemListElement' => array_values(
				array_filter(
					array(
						array(
							'@type'    => 'ListItem',
							'position' => 1,
							'name'     => 'Knowledge',
							'item'     => $b_hub,
						),
						$b_cat ? array(
							'@type'    => 'ListItem',
							'position' => 2,
							'name'     => $b_catn,
							'item'     => add_query_arg( 'topic', $b_cat->slug, $b_hub ),
						) : null,
						array(
							'@type'    => 'ListItem',
							'position' => $b_cat ? 3 : 2,
							'name'     => $b_title,
							'item'     => $b_url,
						),
					)
				)
			),
		),
	);
	// Rank Math already describes the article itself; without it, the theme does.
	if ( ! defined( 'RANK_MATH_VERSION' ) ) {
		$b_graph[] = array_filter(
			array(
			'@type'            => 'BlogPosting',
			'headline'         => $b_title,
			'description'      => $b_desc ? $b_desc : wp_strip_all_tags( $b_lead ),
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'mainEntityOfPage' => $b_url,
			'image'            => has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'large' ) : null,
			'articleSection'   => $b_catn,
			'author'           => array(
				'@type' => 'Organization',
				'@id'   => banks_main_url( '/' ) . '#organization',
				'name'  => 'Banks Solutions',
			),
			'publisher'        => array( '@id' => banks_main_url( '/' ) . '#organization' ),
			)
		);
	}
	if ( $b_qs ) {
		$b_graph[] = array(
			'@type'      => 'FAQPage',
			'mainEntity' => array_map(
				function ( $q ) {
					return array(
						'@type'          => 'Question',
						'name'           => $q[0],
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => wp_strip_all_tags( $q[1] ),
						),
					);
				},
				$b_qs
			),
		);
	}
	echo wp_json_encode(
		array(
			'@context' => 'https://schema.org',
			'@graph'   => $b_graph,
		),
		JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
	);
	?>
	</script>
	<?php
endwhile;
get_footer();
