<?php
/**
 * Every capability of a product, by area: an index that follows you down the page (a sticky
 * side list on wide screens, a chip row on phones) and the areas with their cards. Used by the
 * Labs product pages and the Banks Business Engine page. Styles in product.css, the index and
 * the motion in product.js.
 *
 * @package Banks
 */

$b_name   = isset( $args['name'] ) ? $args['name'] : '';
$b_groups = isset( $args['groups'] ) ? $args['groups'] : array();
if ( empty( $b_groups['items'] ) ) {
	return;
}
$b_total = 0;
foreach ( $b_groups['items'] as $b_g ) {
	$b_total += count( $b_g['feats'] );
}
?>
<section class="lp-caps" id="capabilities">
	<div class="b-wrap">
		<div class="lp-head">
			<p class="b-eyebrow"><?php echo esc_html( $b_groups['eyebrow'] ); ?> · <?php echo esc_html( $b_total ); ?> capabilities</p>
			<h2 data-split><?php echo esc_html( $b_groups['title'] ); ?></h2>
			<p><?php echo esc_html( $b_groups['lede'] ); ?></p>
		</div>
		<div class="lp-caps__grid">
			<nav class="lp-index" aria-label="<?php echo esc_attr( $b_name . ' capabilities' ); ?>">
				<ol>
					<?php foreach ( $b_groups['items'] as $b_i => $b_g ) : ?>
						<li><a href="#cap-<?php echo esc_attr( $b_g['key'] ); ?>"<?php echo 0 === $b_i ? ' aria-current="true"' : ''; ?>><span class="lp-index__n"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span><span class="lp-index__t"><?php echo esc_html( $b_g['title'] ); ?></span><span class="lp-index__c"><?php echo esc_html( count( $b_g['feats'] ) ); ?></span></a></li>
					<?php endforeach; ?>
				</ol>
			</nav>
			<div class="lp-groups">
				<?php foreach ( $b_groups['items'] as $b_i => $b_g ) : ?>
					<section class="lp-group" id="cap-<?php echo esc_attr( $b_g['key'] ); ?>" aria-labelledby="cap-<?php echo esc_attr( $b_g['key'] ); ?>-t">
						<header class="lp-group__head">
							<span class="lp-group__n"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span>
							<h3 id="cap-<?php echo esc_attr( $b_g['key'] ); ?>-t"><?php echo esc_html( $b_g['title'] ); ?></h3>
							<p><?php echo esc_html( $b_g['blurb'] ); ?></p>
						</header>
						<ul class="lp-feats">
							<?php foreach ( $b_g['feats'] as $b_f ) : ?>
								<li class="lp-feat">
									<span class="lp-feat__tick" aria-hidden="true"></span>
									<h4><?php echo esc_html( $b_f[0] ); ?></h4>
									<p><?php echo esc_html( $b_f[1] ); ?></p>
								</li>
							<?php endforeach; ?>
						</ul>
					</section>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
