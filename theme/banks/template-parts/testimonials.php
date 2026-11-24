<?php
/**
 * Client reviews, quoted from the public Google reviews for Banks Solution Ltd. Shown on the
 * homepage and About. Plain markup, no motion, so it reads the same with JavaScript off.
 *
 * @package Banks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$b_reviews = array(
	array( 'We have had the pleasure of working with Banks Solution on multiple occasions and have consistently been impressed by their level of excellence. They consistently deliver beyond our expectations and have helped us build not one, but three successful websites, and are currently building the fourth.', 'Dr. Bimbo Mesele' ),
	array( 'Banks Solution really helped my business to succeed online. The website they did for me boosted my sales and I got a lot of orders and phone calls as a result of their work.', 'Helen Osumah' ),
	array( 'From the very beginning, they demonstrated a strong understanding of my vision and translated it into a clean, modern, and highly functional website.', 'Legacy Legal' ),
	array( 'I experienced professionalism at its best dealing with Banks Solution Ltd. I love my new website and would easily and gladly recommend its service to anyone wishing to build a website.', 'Aituaje Aizenobie' ),
);
$b_gbp = banks_detail( 'gbp' );
?>
<section class="b-reviews" aria-labelledby="b-reviews-title">
	<div class="b-wrap">
		<p class="b-eyebrow">What clients say</p>
		<h2 id="b-reviews-title">In their words.</h2>
		<div class="b-reviews__grid">
			<?php foreach ( $b_reviews as $b_r ) : ?>
				<figure class="b-review">
					<blockquote><p><?php echo esc_html( $b_r[0] ); ?></p></blockquote>
					<figcaption><strong><?php echo esc_html( $b_r[1] ); ?></strong><span>5 stars on Google</span></figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
		<?php if ( $b_gbp ) : ?>
			<p class="b-reviews__more"><a href="<?php echo esc_url( $b_gbp ); ?>" rel="noopener">Read all our Google reviews</a></p>
		<?php endif; ?>
	</div>
</section>
