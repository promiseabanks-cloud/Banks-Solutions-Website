<?php
/**
 * Phone type scale: every font size on the public site, 4px smaller on phones.
 *
 * Rather than hand-editing hundreds of sizes across the page stylesheets, each theme
 * stylesheet gets a generated companion that repeats only its font sizes, minus 4px,
 * loaded with media="(max-width:767px)". Companions rebuild themselves whenever their
 * source file changes, so new page CSS is covered with no extra work.
 *
 * @package Banks
 */

defined( 'ABSPATH' ) || exit;

/** Phones only. */
const BANKS_MOBILE_TYPE_MEDIA = '(max-width:767px)';
/** How much smaller every size gets on phones, in px. */
const BANKS_MOBILE_TYPE_STEP = 4;
/** Nothing shrinks below this, so the smallest mono labels stay legible. */
const BANKS_MOBILE_TYPE_FLOOR = 10;
/** Bump to rebuild every companion. */
const BANKS_MOBILE_TYPE_REV = '1';

add_action(
	'wp_enqueue_scripts',
	function () {
		$styles = wp_styles();
		$base   = trailingslashit( get_template_directory_uri() ) . 'assets/';
		foreach ( $styles->queue as $handle ) {
			$src = isset( $styles->registered[ $handle ] ) ? (string) $styles->registered[ $handle ]->src : '';
			if ( 0 !== strpos( $src, $base ) || '.css' !== substr( $src, -4 ) ) {
				continue;
			}
			$url = banks_mobile_type_file( basename( $src ) );
			if ( $url ) {
				wp_enqueue_style( $handle . '-phone', $url, array( $handle ), null, BANKS_MOBILE_TYPE_MEDIA );
			}
		}
	},
	50
);

/**
 * URL of the phone companion for one theme stylesheet, rebuilt when the source is newer.
 *
 * @param string $name File name in the theme's assets folder.
 * @return string Empty when the companion can't be written.
 */
function banks_mobile_type_file( $name ) {
	$source = get_template_directory() . '/assets/' . $name;
	if ( ! is_readable( $source ) ) {
		return '';
	}
	$uploads = wp_upload_dir( null, false );
	$dir     = trailingslashit( $uploads['basedir'] ) . 'banks-phone-type/';
	$mtime   = (int) filemtime( $source );
	$file    = basename( $name, '.css' ) . '-' . substr( md5( $mtime . BANKS_MOBILE_TYPE_REV . BANKS_MOBILE_TYPE_STEP . BANKS_MOBILE_TYPE_FLOOR ), 0, 8 ) . '.css';
	if ( ! file_exists( $dir . $file ) ) {
		if ( ! wp_mkdir_p( $dir ) ) {
			return '';
		}
		foreach ( (array) glob( $dir . basename( $name, '.css' ) . '-????????.css' ) as $old ) {
			wp_delete_file( $old );
		}
		$css = banks_mobile_type_css( (string) file_get_contents( $source ) );
		if ( false === file_put_contents( $dir . $file, $css ) ) {
			return '';
		}
	}
	return set_url_scheme( trailingslashit( $uploads['baseurl'] ) . 'banks-phone-type/' . $file );
}

/**
 * Repeat every font size in a stylesheet, 4px smaller, keeping selectors, order and
 * any @media/@supports wrappers so the cascade resolves exactly as it does on desktop.
 *
 * @param string $css Source stylesheet.
 * @return string
 */
function banks_mobile_type_css( $css ) {
	$css = preg_replace( '#/\*.*?\*/#s', '', $css );
	return "/* Generated from the theme stylesheet by inc/mobile-type.php. Do not edit. */\n" . banks_mobile_type_block( $css );
}

/**
 * Walk one level of rules, recursing into conditional at-rules.
 *
 * @param string $css Rules without the surrounding braces.
 * @return string
 */
function banks_mobile_type_block( $css ) {
	$out = '';
	$len = strlen( $css );
	$i   = 0;
	while ( $i < $len ) {
		$open = strpos( $css, '{', $i );
		if ( false === $open ) {
			break;
		}
		$prelude = trim( substr( $css, $i, $open - $i ) );
		// Statements such as @import end in a semicolon before the next block starts.
		if ( false !== strrpos( $prelude, ';' ) ) {
			$prelude = trim( substr( $prelude, strrpos( $prelude, ';' ) + 1 ) );
		}
		$depth = 1;
		$j     = $open + 1;
		while ( $j < $len && $depth ) {
			if ( '{' === $css[ $j ] ) {
				++$depth;
			} elseif ( '}' === $css[ $j ] ) {
				--$depth;
			}
			++$j;
		}
		$body = substr( $css, $open + 1, $j - $open - 2 );
		$i    = $j;
		if ( '@' === substr( $prelude, 0, 1 ) ) {
			if ( preg_match( '/^@(media|supports|container|layer)\b/i', $prelude ) ) {
				$inner = banks_mobile_type_block( $body );
				if ( '' !== $inner ) {
					$out .= $prelude . "{\n" . $inner . "}\n";
				}
			}
			continue; // @keyframes, @font-face and friends carry no element sizes.
		}
		$size = banks_mobile_type_size( $body );
		if ( null !== $size ) {
			$out .= $prelude . '{font-size:' . $size . "}\n";
		}
	}
	return $out;
}

/**
 * The phone font-size for one declaration block, or null when it sets none.
 *
 * Sizes relative to the parent (em, %, inherit) or to a container are repeated unchanged:
 * they already follow the smaller parent, and repeating them keeps the cascade intact.
 *
 * @param string $decls Declarations.
 * @return string|null
 */
function banks_mobile_type_size( $decls ) {
	$value = null;
	foreach ( explode( ';', $decls ) as $decl ) {
		if ( ! preg_match( '/^\s*(font-size|font)\s*:\s*(.+?)\s*$/is', $decl, $m ) ) {
			continue;
		}
		$v         = $m[2];
		$important = (bool) preg_match( '/!\s*important$/i', $v );
		$v         = trim( preg_replace( '/!\s*important$/i', '', $v ) );
		if ( 'font' === strtolower( $m[1] ) ) {
			if ( ! preg_match( '/(?:^|\s)((?:clamp|min|max|calc|var)\((?:[^()]|\([^()]*\))*\)|-?[\d.]+(?:px|rem|em|%|vw|cqw|cqi))(?=\/|\s)/i', $v, $s ) ) {
				if ( in_array( strtolower( $v ), array( 'inherit', 'initial', 'unset' ), true ) ) {
					$value = array( $v, $important );
				}
				continue;
			}
			$v = $s[1];
		}
		$value = array( banks_mobile_type_shrink( $v ), $important );
	}
	if ( null === $value ) {
		return null;
	}
	return $value[0] . ( $value[1] ? '!important' : '' );
}

/**
 * One size, 4px smaller, never below the floor (sizes already under it stay as they are).
 *
 * @param string $v CSS length.
 * @return string
 */
function banks_mobile_type_shrink( $v ) {
	if ( preg_match( '/(?<![a-z])em\b|%|cq[a-z]|inherit|initial|unset|smaller|larger/i', $v ) ) {
		return $v;
	}
	if ( preg_match( '/^([\d.]+)(px|rem)$/i', $v, $n ) ) {
		$px = 'rem' === strtolower( $n[2] ) ? (float) $n[1] * 16 : (float) $n[1];
		return round( max( min( BANKS_MOBILE_TYPE_FLOOR, $px ), $px - BANKS_MOBILE_TYPE_STEP ), 2 ) . 'px';
	}
	return 'max(min(' . BANKS_MOBILE_TYPE_FLOOR . 'px,' . $v . '),calc(' . $v . ' - ' . BANKS_MOBILE_TYPE_STEP . 'px))';
}
