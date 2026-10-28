<?php
/*
 * Knowledge article. The text lives in the custom fields the old site used
 * (bs_lead, bs_body_html, bs_toc_html, bs_faqs_html, bs_related_html, bs_read_time);
 * post content is the fallback for articles written in the editor later.
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
	if ( '' === $b_read ) {
		$b_words = str_word_count( wp_strip_all_tags( $b_body ? $b_body : get_the_content() ) );
		$b_read  = max( 1, (int) round( $b_words / 220 ) ) . ' min read';
	}
	$b_cats = get_the_category();
	?>
	<div class="b-progress" aria-hidden="true"><span></span></div>
	<article <?php post_class( 'b-article' ); ?>>
		<header class="b-wrap b-article__head">
			<a class="b-article__back" href="<?php echo esc_url( banks_main_url( '/knowledge/' ) ); ?>">Knowledge<?php echo $b_cats ? ' · ' . esc_html( $b_cats[0]->name ) : ''; ?></a>
			<h1 class="b-article__title" data-split><?php the_title(); ?></h1>
			<p class="b-article__meta"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?> · <?php echo esc_html( $b_read ); ?></p>
			<?php if ( $b_lead ) : ?>
				<p class="b-article__lead"><?php echo wp_kses_post( $b_lead ); ?></p>
			<?php endif; ?>
		</header>
		<?php if ( has_post_thumbnail() && ! $b_body ) : ?>
			<div class="b-wrap"><?php the_post_thumbnail( 'large', array( 'class' => 'b-article__hero' ) ); ?></div>
		<?php endif; ?>
		<div class="b-wrap b-article__grid">
			<?php if ( $b_toc ) : ?>
				<nav class="b-toc" aria-label="In this article">
					<p class="b-toc__title">In this article</p>
					<?php echo wp_kses_post( $b_toc ); ?>
				</nav>
			<?php endif; ?>
			<div class="b-prose">
				<?php
				if ( $b_body ) {
					echo wp_kses_post( $b_body );
				} else {
					the_content();
				}
				?>
				<?php if ( $b_faqs ) : ?>
					<section class="b-faqs" aria-labelledby="b-faqs-title">
						<h2 id="b-faqs-title">Questions people ask</h2>
						<?php echo wp_kses_post( $b_faqs ); ?>
					</section>
				<?php endif; ?>
				<?php if ( $b_related ) : ?>
					<div class="b-chips"><?php echo wp_kses_post( $b_related ); ?></div>
				<?php endif; ?>
			</div>
		</div>
	</article>
	<?php
endwhile;
get_footer();
