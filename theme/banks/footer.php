</main>
<footer class="b-footer">
	<div class="b-wrap b-footer__grid">
		<div class="b-footer__brand">
			<?php banks_brand( 'reverse' ); ?>
			<p><?php echo esc_html( banks_detail( 'tagline' ) ); ?></p>
		</div>
		<div>
			<h2 class="b-footer__title">Build</h2>
			<ul class="b-footer__list">
				<?php banks_nav_item( '/solutions/', 'Solutions', '/services/' ); ?>
				<?php banks_nav_item( '/work/', 'Work' ); ?>
				<?php banks_nav_item( '/industries/', 'Industries' ); ?>
				<?php banks_nav_item( '/banks-business-engine/', 'Banks Business Engine' ); ?>
				<?php banks_nav_item( '/shop/', 'Shop' ); ?>
			</ul>
		</div>
		<div>
			<h2 class="b-footer__title">Learn</h2>
			<ul class="b-footer__list">
				<?php banks_nav_item( '/knowledge/', 'Knowledge' ); ?>
				<?php banks_nav_item( '/glossary/', 'Glossary' ); ?>
				<?php banks_nav_item( '/labs/', 'Labs' ); ?>
				<?php banks_nav_item( '/wordpress-development/', 'For agencies' ); ?>
			</ul>
		</div>
		<div>
			<h2 class="b-footer__title">Talk</h2>
			<ul class="b-footer__list">
				<li><a href="mailto:<?php echo esc_attr( banks_detail( 'email' ) ); ?>"><?php echo esc_html( banks_detail( 'email' ) ); ?></a></li>
				<?php if ( banks_detail( 'whatsapp' ) ) : ?><li><a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D/', '', banks_detail( 'whatsapp' ) ) ); ?>">WhatsApp us</a></li><?php endif; ?>
				<?php if ( banks_detail( 'instagram' ) ) : ?><li><a href="<?php echo esc_url( banks_detail( 'instagram' ) ); ?>" rel="noopener" target="_blank">Instagram</a></li><?php endif; ?>
				<?php if ( banks_detail( 'linkedin' ) ) : ?><li><a href="<?php echo esc_url( banks_detail( 'linkedin' ) ); ?>" rel="noopener" target="_blank">LinkedIn</a></li><?php endif; ?>
				<?php if ( banks_has_portal() ) : ?><li><a href="<?php echo esc_url( banks_portal_url( '/' ) ); ?>">Client portal</a></li><?php endif; ?>
			</ul>
		</div>
	</div>
	<div class="b-wrap">
		<div class="b-footer__base">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( banks_detail( 'legal' ) ); ?> &middot; RC <?php echo esc_html( banks_detail( 'rc' ) ); ?> &middot; <?php echo esc_html( banks_detail( 'locations' ) ); ?></span>
			<span class="b-footer__legal">
				<?php foreach ( array( '/privacy-policy/' => 'Privacy', '/terms/' => 'Terms' ) as $b_path => $b_label ) : ?>
					<?php $b_url = banks_route( $b_path ); ?>
					<?php if ( $b_url ) : ?><a href="<?php echo esc_url( $b_url ); ?>"><?php echo esc_html( $b_label ); ?></a><?php endif; ?>
				<?php endforeach; ?>
			</span>
			<span class="b-footer__receipt" data-receipt hidden></span>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
