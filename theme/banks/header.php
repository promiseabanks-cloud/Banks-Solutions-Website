<?php
$b_site = banks_site();
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="b-skip" href="#main">Skip to content</a>
<?php if ( 'main' === $b_site ) : ?><div class="b-curtain" aria-hidden="true"><img src="<?php echo esc_url( banks_img( 'banks-solutions-mark-reverse.svg' ) ); ?>" width="78" height="72" alt=""></div><?php endif; ?>
<header class="b-header">
	<div class="b-wrap b-header__inner">
		<?php banks_brand( is_front_page() ? 'reverse' : 'lagoon' ); ?>
		<button class="b-burger" aria-expanded="false" aria-controls="b-nav" type="button"><span></span><span class="b-sr">Menu</span></button>
		<nav class="b-nav" id="b-nav" aria-label="Main">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'b-nav__list', 'depth' => 2 ) );
			} else {
				banks_default_nav();
			}
			?>
			<a class="b-nav__portal" href="<?php echo esc_url( banks_portal_url( '/' ) ); ?>">Client portal</a>
			<a class="b-btn b-btn--signal" href="<?php echo esc_url( banks_main_url( '/start/' ) ); ?>" data-magnetic>Start a project</a>
		</nav>
	</div>
</header>
<main id="main" class="b-main">
