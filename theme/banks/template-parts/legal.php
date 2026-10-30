<?php
/**
 * A legal page: a short hero, the plain-words summary, a contents list that follows the
 * reader on wide screens, then the numbered sections. Used by page-privacy-policy.php and
 * page-terms.php; motion and the contents highlight live in legal.js.
 *
 * Args: eyebrow, h1, lede, updated (Y-m-d), summary (strings), sections (arrays of id, title,
 * body). A body item is a paragraph string, or array( 'list', array( strings ) ). Strings may
 * carry <a href> and <strong>, nothing else.
 *
 * @package Banks
 */

$b       = $args;
$b_allow = array(
	'a'      => array( 'href' => true ),
	'strong' => array(),
);
?>
<section class="lg-hero" data-dark data-hero>
	<div class="lg-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap lg-inner">
			<p class="b-eyebrow lg-eyebrow"><?php echo esc_html( $b['eyebrow'] ); ?></p>
			<h1 class="lg-title"><?php echo esc_html( $b['h1'] ); ?><span class="s-dot">.</span></h1>
			<p class="lg-lede"><?php echo wp_kses( $b['lede'], $b_allow ); ?></p>
			<p class="lg-meta">Last updated <time datetime="<?php echo esc_attr( $b['updated'] ); ?>"><?php echo esc_html( date_i18n( 'j F Y', strtotime( $b['updated'] ) ) ); ?></time> · <?php echo esc_html( banks_detail( 'legal' ) ); ?>, RC <?php echo esc_html( banks_detail( 'rc' ) ); ?></p>
		</div>
	</div>
</section>

<div class="lg-progress" aria-hidden="true"><span></span></div>

<section class="lg-body">
	<div class="b-wrap lg-grid">
		<nav class="lg-toc" aria-label="On this page">
			<p class="lg-toc__label">On this page</p>
			<ol>
				<?php foreach ( $b['sections'] as $b_i => $b_s ) : ?>
					<li><a href="#<?php echo esc_attr( $b_s['id'] ); ?>"><span><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span><?php echo esc_html( $b_s['title'] ); ?></a></li>
				<?php endforeach; ?>
			</ol>
		</nav>

		<div class="lg-doc">
			<aside class="lg-summary" data-reveal>
				<p class="lg-summary__label">In plain words</p>
				<ul>
					<?php foreach ( $b['summary'] as $b_line ) : ?>
						<li><?php echo wp_kses( $b_line, $b_allow ); ?></li>
					<?php endforeach; ?>
				</ul>
			</aside>

			<?php foreach ( $b['sections'] as $b_i => $b_s ) : ?>
				<section class="lg-sec" id="<?php echo esc_attr( $b_s['id'] ); ?>" aria-labelledby="<?php echo esc_attr( $b_s['id'] ); ?>-h">
					<h2 id="<?php echo esc_attr( $b_s['id'] ); ?>-h"><span class="lg-sec__n"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span><?php echo esc_html( $b_s['title'] ); ?></h2>
					<?php foreach ( $b_s['body'] as $b_item ) : ?>
						<?php if ( is_array( $b_item ) && 'list' === $b_item[0] ) : ?>
							<ul>
								<?php foreach ( $b_item[1] as $b_li ) : ?>
									<li><?php echo wp_kses( $b_li, $b_allow ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php else : ?>
							<p><?php echo wp_kses( $b_item, $b_allow ); ?></p>
						<?php endif; ?>
					<?php endforeach; ?>
				</section>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<script type="application/ld+json">
<?php
echo wp_json_encode(
	array(
		'@context'     => 'https://schema.org',
		'@type'        => 'WebPage',
		'name'         => $b['h1'],
		'url'          => banks_main_url( $b['path'] ),
		'dateModified' => $b['updated'],
		'description'  => wp_strip_all_tags( $b['lede'] ),
		'publisher'    => array(
			'@type' => 'Organization',
			'@id'   => banks_main_url( '/' ) . '#organization',
			'name'  => 'Banks Solutions',
			'url'   => banks_main_url( '/' ),
		),
	),
	JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
);
?>
</script>
