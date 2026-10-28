<?php get_header(); ?>
<div class="b-wrap b-content">
	<?php if ( have_posts() ) : ?>
		<?php if ( ! is_singular() ) : ?>
			<h1 class="b-entry__title"><?php echo esc_html( is_home() ? 'Knowledge' : wp_strip_all_tags( get_the_archive_title() ) ); ?></h1>
			<div class="b-cards">
		<?php endif; ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if ( is_singular() ) : ?>
				<article <?php post_class( 'b-entry' ); ?>>
					<h1 class="b-entry__title"><?php the_title(); ?></h1>
					<div class="b-entry__body b-prose"><?php the_content(); ?></div>
				</article>
			<?php else : ?>
				<a class="b-card" href="<?php the_permalink(); ?>" data-reveal>
					<span class="b-card__meta"><?php echo esc_html( get_the_date( 'j M Y' ) ); ?></span>
					<span class="b-card__title"><?php the_title(); ?></span>
					<span class="b-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></span>
				</a>
			<?php endif; ?>
		<?php endwhile; ?>
		<?php if ( ! is_singular() ) : ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php endif; ?>
	<?php else : ?>
		<h1 class="b-entry__title">Nothing here yet</h1>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
