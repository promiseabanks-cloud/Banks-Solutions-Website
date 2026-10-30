<?php
get_header();
while ( have_posts() ) :
	the_post();
	if ( banks_is_elementor_page() ) :
		// Elementor owns the layout: full width, no theme title.
		the_content();
	else :
		?>
		<div class="b-wrap b-content">
			<h1 class="b-entry__title" data-split><?php the_title(); ?></h1>
			<div class="b-entry__body b-prose"><?php the_content(); ?></div>
		</div>
		<?php
	endif;
endwhile;
get_footer();
