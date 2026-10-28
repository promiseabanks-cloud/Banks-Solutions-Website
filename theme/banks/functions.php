<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BANKS_VERSION', '0.2.1' );
define( 'BANKS_GSAP', '3.13.0' );
define( 'BANKS_LENIS', '1.3.4' );

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/article.css' );
		register_nav_menus(
			array(
				'primary' => 'Header menu',
				'footer'  => 'Footer menu',
			)
		);
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		$uri = get_template_directory_uri() . '/assets/';
		wp_enqueue_style( 'banks-fonts', 'https://fonts.googleapis.com/css2?family=Familjen+Grotesk:wght@500;600;700&family=IBM+Plex+Mono:wght@400;500&family=Public+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap', array(), null );
		wp_enqueue_style( 'banks', $uri . 'main.css', array(), BANKS_VERSION );
		wp_enqueue_script( 'banks-nav', $uri . 'nav.js', array(), BANKS_VERSION, true );
		if ( is_singular( array( 'post', 'glossary' ) ) || ( is_page() && ! banks_is_elementor_page() ) ) {
			wp_enqueue_style( 'banks-article', $uri . 'article.css', array( 'banks' ), BANKS_VERSION );
		}
		banks_legacy_styles();
		if ( 'main' !== banks_site() ) {
			return;
		}
		// Motion layer for the public site only; the portal stays light and fast.
		wp_enqueue_style( 'banks-motion', $uri . 'motion.css', array( 'banks' ), BANKS_VERSION );
		wp_enqueue_script( 'gsap', $uri . 'vendor/gsap.min.js', array(), BANKS_GSAP, true );
		wp_enqueue_script( 'gsap-scrolltrigger', $uri . 'vendor/ScrollTrigger.min.js', array( 'gsap' ), BANKS_GSAP, true );
		wp_enqueue_script( 'gsap-splittext', $uri . 'vendor/SplitText.min.js', array( 'gsap' ), BANKS_GSAP, true );
		wp_enqueue_script( 'lenis', $uri . 'vendor/lenis.min.js', array(), BANKS_LENIS, true );
		wp_enqueue_script( 'banks-motion', $uri . 'motion.js', array( 'gsap', 'gsap-scrolltrigger', 'gsap-splittext', 'lenis', 'banks-nav' ), BANKS_VERSION, true );
		if ( is_front_page() ) {
			wp_enqueue_style( 'banks-home', $uri . 'home.css', array( 'banks-motion' ), BANKS_VERSION );
			wp_enqueue_script( 'banks-home', $uri . 'home.js', array( 'banks-motion' ), BANKS_VERSION, true );
		}
	}
);

/** GSAP and Lenis load in the footer and never block the first paint. */
add_filter(
	'script_loader_tag',
	function ( $tag, $handle ) {
		if ( in_array( $handle, array( 'gsap', 'gsap-scrolltrigger', 'gsap-splittext', 'lenis', 'banks-motion', 'banks-home', 'banks-nav' ), true ) ) {
			return str_replace( ' src=', ' defer src=', $tag );
		}
		return $tag;
	},
	10,
	2
);

/** Apply the saved or system theme before first paint, so dark-mode visitors never see a light flash. */
add_action(
	'wp_head',
	function () {
		echo "<script>(function(d){var t;try{t=localStorage.getItem('banks-theme')}catch(e){}if(t!=='dark'&&t!=='light')t=window.matchMedia&&matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';d.setAttribute('data-theme',t)})(document.documentElement);</script>\n";
	},
	0
);

/** Mark the page as animated before paint; fall back to static if the scripts never arrive. */
add_action(
	'wp_head',
	function () {
		if ( 'main' !== banks_site() ) {
			return;
		}
		echo "<script>(function(d){if(window.matchMedia('(prefers-reduced-motion: reduce)').matches)return;d.classList.add('js-motion');setTimeout(function(){if(!window.__banksReady)d.classList.remove('js-motion')},4000)})(document.documentElement);</script>\n";
	},
	1
);

add_action(
	'wp_head',
	function () {
		$img = get_template_directory_uri() . '/assets/img/';
		echo '<link rel="icon" href="' . esc_url( $img . 'favicon.ico' ) . '" sizes="any">' . "\n";
		echo '<link rel="apple-touch-icon" href="' . esc_url( $img . 'banks-solutions-icon-180.png' ) . '">' . "\n";
		echo '<meta name="theme-color" content="#0B3B40" media="(prefers-color-scheme: light)">' . "\n";
		echo '<meta name="theme-color" content="#071719" media="(prefers-color-scheme: dark)">' . "\n";
	},
	2
);

add_filter(
	'wp_resource_hints',
	function ( $urls, $type ) {
		if ( 'preconnect' === $type ) {
			$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		}
		return $urls;
	},
	10,
	2
);

/** Body classes: pages that open on a Lagoon hero get the transparent light-on-dark header. */
add_filter(
	'body_class',
	function ( $classes ) {
		$classes[] = 'b-site-' . banks_site();
		if ( is_front_page() ) {
			$classes[] = 'b-hero-dark';
		}
		return $classes;
	}
);

/** Which front door we are on: the public site or the client portal. */
function banks_site() {
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	return ( $host && 0 === strpos( $host, 'portal.' ) ) ? 'portal' : 'main';
}

function banks_main_url( $path = '/' ) {
	return is_multisite() ? get_home_url( get_main_site_id(), $path ) : home_url( $path );
}

/**
 * Link to a main-site page that may not be built yet. Until the page exists the link
 * goes to $fallback, or is dropped when there is none, so the menus never lead to a 404.
 */
function banks_route( $path, $fallback = '' ) {
	$slug = trim( $path, '/' );
	if ( '' === $slug || 'main' !== banks_site() || get_page_by_path( $slug ) ) {
		return banks_main_url( $path );
	}
	return $fallback ? banks_main_url( $fallback ) : '';
}

/** One menu item through banks_route(); prints nothing when the page has no stand-in yet. */
function banks_nav_item( $path, $label, $fallback = '' ) {
	$url = banks_route( $path, $fallback );
	if ( $url ) {
		echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}
}

/** The portal links stay hidden until the portal site (or a /portal/ page) exists. */
function banks_has_portal() {
	return defined( 'BANKS_PORTAL_DOMAIN' ) || 'main' !== banks_site() || get_page_by_path( 'portal' );
}

function banks_portal_url( $path = '/' ) {
	return defined( 'BANKS_PORTAL_DOMAIN' ) ? 'https://' . BANKS_PORTAL_DOMAIN . $path : banks_main_url( '/portal' . $path );
}

function banks_img( $file ) {
	return get_template_directory_uri() . '/assets/img/' . $file;
}

/** Contact details shared by header and footer, editable in Appearance > Customize > Banks details. */
function banks_detail( $key ) {
	$defaults = array(
		'legal'     => 'Banks Solution Limited',
		'rc'        => '8259372',
		'email'     => 'hello@bankssolution.ng',
		'whatsapp'  => '+2349132826032',
		'locations' => 'Lagos and Ilorin, Nigeria',
		'instagram' => 'https://instagram.com/bankssolutions',
		'linkedin'  => '',
		'tagline'   => 'Websites, web apps and custom solutions, automation and AI for businesses in any field.',
	);
	$v = get_option( 'banks_' . $key, null );
	return null === $v || '' === $v ? ( $defaults[ $key ] ?? '' ) : $v;
}

add_action(
	'customize_register',
	function ( WP_Customize_Manager $c ) {
		$c->add_section( 'banks', array( 'title' => 'Banks details', 'priority' => 30 ) );
		$fields = array(
			'tagline'   => 'Footer tagline',
			'legal'     => 'Registered company name',
			'rc'        => 'CAC registration number',
			'locations' => 'Locations',
			'email'     => 'Email',
			'whatsapp'  => 'WhatsApp number (international, e.g. 2348030000000)',
			'instagram' => 'Instagram URL',
			'linkedin'  => 'LinkedIn URL',
		);
		foreach ( $fields as $k => $label ) {
			$c->add_setting( 'banks_' . $k, array( 'type' => 'option', 'sanitize_callback' => 'sanitize_text_field' ) );
			$c->add_control( 'banks_' . $k, array( 'label' => $label, 'section' => 'banks', 'type' => 'tagline' === $k ? 'textarea' : 'text' ) );
		}
	}
);

function banks_brand( $variant = 'lagoon' ) {
	$a = '<a class="b-brand" href="' . esc_url( banks_main_url( '/' ) ) . '">';
	$i = '<img class="b-brand__img%s" src="%s" width="239" height="36" alt="%s">';
	if ( 'auto' === $variant ) {
		// Both lockups; main.css shows the one that reads on the current background and theme.
		$a .= sprintf( $i, ' b-brand__img--std', esc_url( banks_img( 'banks-solutions-lockup-lagoon.svg' ) ), 'Banks Solutions' );
		$a .= sprintf( $i, ' b-brand__img--rev', esc_url( banks_img( 'banks-solutions-lockup-reverse.svg' ) ), '' );
	} else {
		$file = 'reverse' === $variant ? 'banks-solutions-lockup-reverse.svg' : 'banks-solutions-lockup-lagoon.svg';
		$a   .= sprintf( $i, '', esc_url( banks_img( $file ) ), 'Banks Solutions' );
	}
	echo $a . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from escaped parts above.
}

/** Light/dark switch for the header. */
function banks_theme_toggle() {
	echo '<button class="b-theme" type="button" data-theme-toggle aria-label="Switch to dark mode"><svg class="b-theme__moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 14.5A8 8 0 0 1 9.5 4a8 8 0 1 0 10.5 10.5Z"/></svg><svg class="b-theme__sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg></button>';
}

/** Fallback header links until a menu is assigned. */
function banks_default_nav() {
	echo '<ul class="b-nav__list">';
	banks_nav_item( '/solutions/', 'Solutions', '/services/' );
	banks_nav_item( '/work/', 'Work' );
	banks_nav_item( '/knowledge/', 'Knowledge' );
	banks_nav_item( '/labs/', 'Labs' );
	banks_nav_item( '/about/', 'About' );
	echo '</ul>';
}

/**
 * Transition only: the old Elementor pages were styled by Baseplate (its base.css plus
 * the "baseplate" Customizer CSS), not by Elementor alone. Load that on those pages until
 * each one is rebuilt as a theme template, then delete this function.
 */
function banks_legacy_styles() {
	if ( is_front_page() || ! is_page() || ! banks_is_elementor_page() ) {
		return;
	}
	$dir = get_theme_root() . '/baseplate/assets/css/';
	$uri = get_theme_root_uri() . '/baseplate/assets/css/';
	if ( file_exists( $dir . 'base.css' ) ) {
		wp_enqueue_style( 'baseplate-fonts', $uri . 'fonts.css', array(), (string) filemtime( $dir . 'fonts.css' ) );
		wp_enqueue_style( 'baseplate', $uri . 'base.css', array( 'baseplate-fonts', 'banks' ), (string) filemtime( $dir . 'base.css' ) );
	}
	$css = wp_get_custom_css( 'baseplate' );
	if ( $css ) {
		wp_register_style( 'baseplate-custom', false, array( 'banks' ), BANKS_VERSION );
		wp_enqueue_style( 'baseplate-custom' );
		wp_add_inline_style( 'baseplate-custom', wp_strip_all_tags( $css ) );
	}
}

/** True when Elementor owns this page's layout (Canvas template or an Elementor-built page). */
function banks_is_elementor_page( $id = null ) {
	$id = $id ? $id : get_the_ID();
	if ( ! $id || ! class_exists( '\Elementor\Plugin' ) ) {
		return false;
	}
	$doc = \Elementor\Plugin::$instance->documents->get( $id );
	return $doc && $doc->is_built_with_elementor();
}

/**
 * The old site's Elementor Pro theme-builder templates (header, footer, article single,
 * glossary single) would otherwise replace this theme's templates. Elementor stays for
 * page content and Canvas campaign pages only.
 */
add_filter(
	'elementor/theme/get_location_templates/template_id',
	function ( $template_id, $location ) {
		return in_array( $location, array( 'header', 'footer', 'single', 'archive' ), true ) ? 0 : $template_id;
	},
	10,
	2
);
