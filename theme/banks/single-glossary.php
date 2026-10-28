<?php
/*
 * Glossary term. Text lives in the old site's custom fields
 * (bs_definition, bs_why_html, bs_related_html, bs_short_label, bs_entry_num, bs_read_time).
 */
get_header();
while ( have_posts() ) :
	the_post();
	$b_id      = get_the_ID();
	$b_label   = (string) get_post_meta( $b_id, 'bs_short_label', true );
	$b_def     = (string) get_post_meta( $b_id, 'bs_definition', true );
	$b_why     = (string) get_post_meta( $b_id, 'bs_why_html', true );
	$b_related = (string) get_post_meta( $b_id, 'bs_related_html', true );
	$b_num     = (string) get_post_meta( $b_id, 'bs_entry_num', true );
	?>
	<article <?php post_class( 'b-article b-term' ); ?>>
		<header class="b-wrap b-article__head">
			<a class="b-article__back" href="<?php echo esc_url( banks_main_url( '/glossary/' ) ); ?>">Glossary<?php echo $b_num ? ' · No. ' . esc_html( str_pad( $b_num, 2, '0', STR_PAD_LEFT ) ) : ''; ?></a>
			<h1 class="b-article__title" data-split><?php the_title(); ?></h1>
			<?php if ( $b_label ) : ?><p class="b-article__meta"><?php echo esc_html( $b_label ); ?></p><?php endif; ?>
		</header>
		<div class="b-wrap">
			<div class="b-prose">
				<?php if ( $b_def ) : ?>
					<p class="b-term__def"><?php echo esc_html( $b_def ); ?></p>
				<?php endif; ?>
				<?php if ( $b_why ) : ?>
					<h2>Why it matters</h2>
					<?php echo wp_kses_post( $b_why ); ?>
				<?php endif; ?>
				<?php
				if ( ! $b_def && ! $b_why ) {
					the_content();
				}
				?>
				<?php if ( $b_related ) : ?>
					<div class="b-chips"><?php echo wp_kses_post( $b_related ); ?></div>
				<?php endif; ?>
			</div>
		</div>
	</article>
	<?php
endwhile;
get_footer();
