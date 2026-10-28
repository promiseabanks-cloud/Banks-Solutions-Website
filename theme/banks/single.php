<?php
get_header();
while ( have_posts() ) :
	the_post();
	$b_words = str_word_count( wp_strip_all_tags( get_the_content() ) );
	?>
	<div class="b-progress" aria-hidden="true"><span></span></div>
	<article <?php post_class( 'b-article' ); ?>>
		<header class="b-wrap b-article__head">
			<a class="b-article__back" href="<?php echo esc_url( banks_main_url( '/knowledge/' ) ); ?>">Knowledge</a>
			<h1 class="b-article__title" data-split><?php the_title(); ?></h1>
			<p class="b-article__meta"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?> · <?php echo esc_html( max( 1, (int) round( $b_words / 220 ) ) ); ?> min read</p>
		</header>
		<div class="b-wrap">
			<div class="b-prose"><?php the_content(); ?></div>
		</div>
	</article>
	<?php
endwhile;
get_footer();
