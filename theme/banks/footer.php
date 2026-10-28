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
				<li><a href="<?php echo esc_url( banks_main_url( '/solutions/' ) ); ?>">Solutions</a></li>
				<li><a href="<?php echo esc_url( banks_main_url( '/work/' ) ); ?>">Work</a></li>
				<li><a href="<?php echo esc_url( banks_main_url( '/banks-business-engine/' ) ); ?>">Banks Business Engine</a></li>
				<li><a href="<?php echo esc_url( banks_main_url( '/shop/' ) ); ?>">Shop</a></li>
			</ul>
		</div>
		<div>
			<h2 class="b-footer__title">Learn</h2>
			<ul class="b-footer__list">
				<li><a href="<?php echo esc_url( banks_main_url( '/knowledge/' ) ); ?>">Knowledge</a></li>
				<li><a href="<?php echo esc_url( banks_main_url( '/glossary/' ) ); ?>">Glossary</a></li>
				<li><a href="<?php echo esc_url( banks_main_url( '/labs/' ) ); ?>">Labs</a></li>
			</ul>
		</div>
		<div>
			<h2 class="b-footer__title">Talk</h2>
			<ul class="b-footer__list">
				<li><a href="mailto:<?php echo esc_attr( banks_detail( 'email' ) ); ?>"><?php echo esc_html( banks_detail( 'email' ) ); ?></a></li>
				<?php if ( banks_detail( 'whatsapp' ) ) : ?><li><a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D/', '', banks_detail( 'whatsapp' ) ) ); ?>">WhatsApp us</a></li><?php endif; ?>
				<?php if ( banks_detail( 'instagram' ) ) : ?><li><a href="<?php echo esc_url( banks_detail( 'instagram' ) ); ?>" rel="noopener" target="_blank">Instagram</a></li><?php endif; ?>
				<?php if ( banks_detail( 'linkedin' ) ) : ?><li><a href="<?php echo esc_url( banks_detail( 'linkedin' ) ); ?>" rel="noopener" target="_blank">LinkedIn</a></li><?php endif; ?>
				<li><a href="<?php echo esc_url( banks_portal_url( '/' ) ); ?>">Client portal</a></li>
			</ul>
		</div>
	</div>
	<div class="b-wrap">
		<div class="b-footer__base">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Banks Solutions</span>
			<span class="b-footer__receipt" data-receipt hidden></span>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
