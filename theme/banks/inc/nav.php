<?php
/**
 * Header menu: top items, and panels for the items that have children.
 *
 * The tree comes from the menu assigned to the "primary" location when there is one,
 * otherwise from banks_nav_default_tree(). A child that has children of its own becomes a
 * column in a wide panel (Solutions > Build / Grow). A menu item's Description field is the
 * small line under its title. Desktop shows panels on hover or click; the mobile menu shows
 * the same markup as tap-to-open groups.
 *
 * @package Banks
 */

/**
 * Default menu, as [ title, path, description or children, overview label ].
 * Paths go through banks_route(), so a page that isn't published yet drops out.
 */
function banks_nav_default_tree() {
	return array(
		array(
			'Solutions',
			'/solutions/',
			array(
				array(
					'Build',
					'',
					array(
						array( 'Websites & e-commerce', '/solutions/websites/', 'Fast sites and online stores' ),
						array( 'Web apps & custom solutions', '/solutions/web-apps/', 'Portals, dashboards and tools, built to spec' ),
						array( 'WordPress development', '/wordpress-development/', 'Plugins and themes for agencies' ),
					),
				),
				array(
					'Grow',
					'',
					array(
						array( 'Automation & CRM', '/solutions/automation-crm/', 'Leads, follow-ups and invoices that run themselves' ),
						array( 'AI solutions', '/solutions/ai/', 'AI assistants that work inside your business' ),
						array( 'SEO & AI search', '/solutions/seo-aeo/', 'Get found on Google and in AI answers' ),
						array( 'Care plans', '/solutions/care-plans/', 'Hosting, updates and support every month' ),
					),
				),
			),
			'All solutions',
		),
		array(
			'Work',
			'/work/',
			array(
				array(
					'Our work',
					'',
					array(
						array( 'Portfolio', '/work/', 'Websites and systems we have built' ),
						array( 'All industries', '/industries/', 'How we help businesses in your field' ),
					),
				),
				array(
					'Industries',
					'',
					array(
						array( 'Finance', '/industries/finance/' ),
						array( 'Legal', '/industries/legal/' ),
						array( 'Hospitality', '/industries/hospitality/' ),
						array( 'Education', '/industries/education/' ),
						array( 'Health', '/industries/health/' ),
						array( 'Non-profit', '/industries/non-profit/' ),
						array( 'Fashion', '/industries/fashion/' ),
					),
				),
			),
		),
		array(
			'Products',
			'',
			array(
				array( 'Banks Business Engine', '/banks-business-engine/', 'Answers, qualifies and follows up every enquiry' ),
				array( 'Shop', '/shop/', 'Ready-made tools for your website' ),
				array( 'Banks Labs', '/labs/', 'Where we build and document our software' ),
			),
		),
		array( 'Pricing', '/pricing/' ),
		array(
			'Resources',
			'',
			array(
				array( 'Knowledge', '/knowledge/', 'Plain guides for Nigerian business owners' ),
				array( 'Glossary', '/glossary/', 'Tech jargon, translated' ),
			),
		),
		array(
			'Company',
			'',
			array(
				array( 'About', '/about/', 'Who we are and how we work' ),
				array( 'Contact', '/contact/', 'Talk to us about your project' ),
			),
		),
	);
}

/**
 * Normalised tree: each node has title, url, desc, overview, current, children.
 *
 * @return array[]
 */
function banks_nav_tree() {
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations['primary'] ) ) {
		$items = wp_get_nav_menu_items( $locations['primary'] );
		if ( $items ) {
			$by_parent = array();
			foreach ( $items as $item ) {
				$by_parent[ (int) $item->menu_item_parent ][] = $item;
			}
			$build = function ( $parent ) use ( &$build, $by_parent ) {
				$out = array();
				foreach ( isset( $by_parent[ $parent ] ) ? $by_parent[ $parent ] : array() as $item ) {
					$url   = '#' === $item->url ? '' : $item->url;
					$out[] = array(
						'title'    => $item->title,
						'url'      => $url,
						'desc'     => $item->description,
						'overview' => '',
						'current'  => banks_nav_is_current( $url ),
						'children' => $build( (int) $item->ID ),
					);
				}
				return $out;
			};
			return $build( 0 );
		}
	}
	return banks_nav_normalise( banks_nav_default_tree() );
}

/**
 * Turn the compact default tree into nodes, dropping links to pages that aren't live.
 *
 * @param array $rows Compact rows.
 * @return array[]
 */
function banks_nav_normalise( $rows ) {
	$out = array();
	foreach ( $rows as $row ) {
		$third    = isset( $row[2] ) ? $row[2] : '';
		$children = is_array( $third ) ? banks_nav_normalise( $third ) : array();
		$url      = $row[1] ? banks_route( $row[1] ) : '';
		if ( ( $row[1] && ! $url ) || ( is_array( $third ) && ! $children ) ) {
			continue;
		}
		$out[] = array(
			'title'    => $row[0],
			'url'      => $url,
			'desc'     => is_string( $third ) ? $third : '',
			'overview' => isset( $row[3] ) ? $row[3] : '',
			'current'  => banks_nav_is_current( $url ),
			'children' => $children,
		);
	}
	return $out;
}

/**
 * Whether a menu URL is the page being viewed.
 *
 * @param string $url Menu URL.
 * @return bool
 */
function banks_nav_is_current( $url ) {
	if ( ! $url || ! isset( $_SERVER['REQUEST_URI'] ) ) {
		return false;
	}
	$here = wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH );
	$path = wp_parse_url( $url, PHP_URL_PATH );
	return $path && trailingslashit( (string) $here ) === trailingslashit( $path );
}

/**
 * Whether a node or any of its descendants is the current page.
 *
 * @param array $node Node.
 * @return bool
 */
function banks_nav_in_trail( $node ) {
	if ( $node['current'] ) {
		return true;
	}
	foreach ( $node['children'] as $child ) {
		if ( banks_nav_in_trail( $child ) ) {
			return true;
		}
	}
	return false;
}

/**
 * One panel link.
 *
 * @param array $node Node.
 * @return string
 */
function banks_nav_panel_link( $node ) {
	$desc = $node['desc'] ? '<small>' . esc_html( $node['desc'] ) . '</small>' : '';
	return '<li><a class="b-panel__link" href="' . esc_url( $node['url'] ) . '"' . ( $node['current'] ? ' aria-current="page"' : '' ) . '><span>' . esc_html( $node['title'] ) . '</span>' . $desc . '</a></li>';
}

/** Print the header menu list. */
function banks_the_nav() {
	$chev = '<svg class="b-nav__chev" viewBox="0 0 12 12" aria-hidden="true"><path d="M2.5 4.5 6 8l3.5-3.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
	$html = '<ul class="b-nav__list">';
	foreach ( banks_nav_tree() as $i => $node ) {
		$trail = banks_nav_in_trail( $node ) ? ' is-current' : '';
		if ( ! $node['children'] ) {
			$html .= '<li class="b-nav__item' . $trail . '"><a class="b-nav__link" href="' . esc_url( $node['url'] ) . '"' . ( $node['current'] ? ' aria-current="page"' : '' ) . '>' . esc_html( $node['title'] ) . '</a></li>';
			continue;
		}
		$wide = false;
		foreach ( $node['children'] as $child ) {
			$wide = $wide || (bool) $child['children'];
		}
		$id    = 'b-panel-' . $i;
		$html .= '<li class="b-nav__item has-panel' . $trail . '"><button class="b-nav__link b-nav__top" type="button" aria-expanded="false" aria-controls="' . $id . '">' . esc_html( $node['title'] ) . $chev . '</button>';
		$html .= '<div class="b-panel' . ( $wide ? ' b-panel--wide' : '' ) . '" id="' . $id . '"><div class="b-panel__glass">';
		if ( $wide ) {
			foreach ( $node['children'] as $col ) {
				$html .= '<div class="b-panel__col"><p class="b-panel__title">' . esc_html( $col['title'] ) . '</p><ul class="b-panel__list' . ( count( $col['children'] ) > 4 ? ' b-panel__list--split' : '' ) . '">';
				foreach ( $col['children'] as $link ) {
					$html .= banks_nav_panel_link( $link );
				}
				$html .= '</ul></div>';
			}
		} else {
			$html .= '<ul class="b-panel__list">';
			foreach ( $node['children'] as $link ) {
				$html .= banks_nav_panel_link( $link );
			}
			$html .= '</ul>';
		}
		if ( $node['url'] && $node['overview'] ) {
			$html .= '<a class="b-panel__overview" href="' . esc_url( $node['url'] ) . '">' . esc_html( $node['overview'] ) . ' <span aria-hidden="true">&rarr;</span></a>';
		}
		$html .= '</div></div></li>';
	}
	echo $html . '</ul>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- every part escaped above.
}
