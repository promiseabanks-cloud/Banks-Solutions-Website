<?php get_header(); ?>
<div class="b-wrap b-content b-404">
	<p class="b-eyebrow">404</p>
	<h1 data-split>This page went off course.</h1>
	<p>The link may be old, or the page moved when we rebuilt the site.</p>
	<a class="b-btn b-btn--lagoon" href="<?php echo esc_url( banks_main_url( '/' ) ); ?>" data-magnetic>Back to the homepage</a>
</div>
<?php get_footer(); ?>
