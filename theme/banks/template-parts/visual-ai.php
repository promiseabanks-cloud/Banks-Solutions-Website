<?php
/*
 * AI hero visual: a busy inbox sorting itself. Each message is read, tagged with how sure the
 * AI is, and the routine ones get a drafted reply that waits for a person to approve it.
 * Decorative, plain HTML; solution.js runs it.
 */
$b_msgs = array(
	array( 'C', 'Chioma E.', 'Can I get a price for 50 branded shirts?', 'quote', 'Quote', 98 ),
	array( 'B', 'Bayo T.', 'Is Saturday 11am still available?', 'booking', 'Booking', 96 ),
	array( 'F', 'Funmi A.', 'I paid yesterday but have no receipt', 'payment', 'Payment', 94 ),
	array( 'D', 'Daniel O.', 'How do I reset my portal password?', 'support', 'Support', 99 ),
	array( 'K', 'Kunle M.', 'Do you deliver outside Lagos?', 'support', 'Support', 97 ),
);
$b_cats = array(
	'quote'   => array( 'Quotes', 12 ),
	'booking' => array( 'Bookings', 9 ),
	'payment' => array( 'Payments', 5 ),
	'support' => array( 'Support', 17 ),
);
?>
<div class="so-vis vi" data-visual="ai" aria-hidden="true">
	<div class="vi-panel">
		<div class="vi-chrome"><i></i><i></i><i></i><span>inbox.yourbusiness.ng / sorted</span><em><span class="s-live"></span>Sorting</em></div>
		<div class="vi-cats">
			<?php foreach ( $b_cats as $b_key => $b_cat ) : ?>
				<p class="vi-cat" data-tag="<?php echo esc_attr( $b_key ); ?>"><?php echo esc_html( $b_cat[0] ); ?><b data-vi-cat="<?php echo esc_attr( $b_key ); ?>"><?php echo esc_html( $b_cat[1] ); ?></b></p>
			<?php endforeach; ?>
		</div>
		<div class="vi-list">
			<?php foreach ( $b_msgs as $b_m ) : ?>
				<div class="vi-row" data-tag="<?php echo esc_attr( $b_m[3] ); ?>">
					<span class="vi-row__av"><?php echo esc_html( $b_m[0] ); ?></span>
					<span class="vi-row__text"><b><?php echo esc_html( $b_m[1] ); ?></b><span><?php echo esc_html( $b_m[2] ); ?></span></span>
					<span class="vi-tag"><?php echo esc_html( $b_m[4] ); ?> <em><?php echo esc_html( $b_m[5] ); ?>%</em></span>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="vi-foot"><span>Sorted today <b data-vi-sorted>143</b></span><span>Every reply checked by a person</span></div>
	</div>
	<div class="vi-draft">
		<em><span class="vi-draft__spark">✦</span><span data-vi-state>Draft ready · waiting for you</span></em>
		<p data-vi-draft>Hi Chioma, 50 branded shirts come to ₦212,500 with delivery in 6 days. Shall I send the invoice?</p>
		<div class="vi-draft__actions"><span>Edit</span><span class="vi-approve" data-vi-approve>Approve &amp; send</span></div>
	</div>
</div>
