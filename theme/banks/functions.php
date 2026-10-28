<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BANKS_VERSION', '0.1.0' );
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
		echo '<meta name="theme-color" content="#0B3B40">' . "\n";
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

function banks_portal_url( $path = '/' ) {
	return defined( 'BANKS_PORTAL_DOMAIN' ) ? 'https://' . BANKS_PORTAL_DOMAIN . $path : banks_main_url( '/portal' . $path );
}

function banks_img( $file ) {
	return get_template_directory_uri() . '/assets/img/' . $file;
}

/** Contact details shared by header and footer, editable in Appearance > Customize > Banks details. */
function banks_detail( $key ) {
	$defaults = array(
		'email'     => 'hello@bankssolution.ng',
		'whatsapp'  => '',
		'instagram' => 'https://instagram.com/bankssolutions',
		'linkedin'  => '',
		'tagline'   => 'Websites, web apps, plugins, automation and AI for businesses in any field.',
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
	$file = 'reverse' === $variant ? 'banks-solutions-lockup-reverse.svg' : 'banks-solutions-lockup-lagoon.svg';
	echo '<a class="b-brand" href="' . esc_url( banks_main_url( '/' ) ) . '"><img class="b-brand__img" src="' . esc_url( banks_img( $file ) ) . '" width="239" height="36" alt="Banks Solutions"></a>';
}

/** Fallback header links until a menu is assigned. */
function banks_default_nav() {
	$links = array(
		'/solutions/' => 'Solutions',
		'/work/'      => 'Work',
		'/knowledge/' => 'Knowledge',
		'/labs/'      => 'Labs',
		'/about/'     => 'About',
	);
	echo '<ul class="b-nav__list">';
	foreach ( $links as $p => $l ) {
		echo '<li><a href="' . esc_url( banks_main_url( $p ) ) . '">' . esc_html( $l ) . '</a></li>';
	}
	echo '</ul>';
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
