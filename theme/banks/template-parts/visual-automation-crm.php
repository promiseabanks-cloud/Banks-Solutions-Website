<?php
/*
 * Automation & CRM hero visual: enquiries flow from WhatsApp through reply and quote to payment,
 * each stage counting as they pass. Decorative, plain HTML and SVG; solution.js runs it.
 */
$b_stages = array(
	array( 'Enquiry', 128 ),
	array( 'Replied', 128 ),
	array( 'Quoted', 61 ),
	array( 'Paid', 34 ),
);
?>
<div class="so-vis vf" data-visual="automation-crm" aria-hidden="true">
	<div class="vf-panel">
		<div class="vf-chrome"><i></i><i></i><i></i><span>crm.yourbusiness.ng / pipeline</span><em><span class="s-live"></span>This month</em></div>
		<div class="vf-river">
			<svg viewBox="0 0 520 300" preserveAspectRatio="none">
				<path class="vf-bank" d="M40 150 C 89 60, 137 60, 186.7 150 S 284 240, 333.3 150 S 431 60, 480 150"/>
				<path class="vf-line" d="M40 150 C 89 60, 137 60, 186.7 150 S 284 240, 333.3 150 S 431 60, 480 150"/>
			</svg>
			<?php foreach ( $b_stages as $b_i => $b_s ) : ?>
				<div class="vf-stage vf-stage--<?php echo esc_attr( $b_i ); ?>" style="--x:<?php echo esc_attr( array( '7.7', '35.9', '64.1', '92.3' )[ $b_i ] ); ?>%">
					<span class="vf-stage__node"></span>
					<p class="vf-stage__label"><?php echo esc_html( $b_s[0] ); ?><b data-vf-count><?php echo esc_html( $b_s[1] ); ?></b></p>
				</div>
			<?php endforeach; ?>
			<div class="vf-dots"></div>
		</div>
		<div class="vf-foot"><span>Replied in <b>4s</b> on average</span><span>Follow-ups sent <b data-vf-follow>212</b></span></div>
	</div>
	<div class="vf-msg"><em>WhatsApp · new enquiry</em><p data-vf-msg>Hi, can I get a quote for 200 units?</p></div>
	<div class="vf-paid"><span class="vf-paid__icon">✓</span><span><em>Invoice paid · Paystack</em><b data-vf-paid>₦320,000 · Invoice #0187</b></span></div>
</div>
