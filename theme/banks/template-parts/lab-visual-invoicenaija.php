<?php
/**
 * InvoiceNaija hero: a naira invoice on paper, the PAID stamp landing and the receipt toast.
 * Example data. product.js plays the lines, the stamp and the toast.
 *
 * @package Banks
 */

$b_lines = array(
	array( 'Upholstered lobby armchair', '8', '₦1,480,000.00' ),
	array( 'Mahogany side table', '8', '₦496,000.00' ),
	array( 'Delivery and installation', '1', '₦85,000.00' ),
);
?>
<figure class="lv lv--in" aria-label="An example: a naira invoice with VAT and bank details, marked paid, and its receipt">
	<div class="lv-paper" data-tilt>
		<header class="lv-paper__top">
			<div><p class="lv-paper__biz">Adunni Interiors Ltd</p><p class="lv-paper__addr">Lekki Phase 1, Lagos · RC 1748293</p></div>
			<div class="lv-paper__no"><span>Invoice</span><b>INV-2026-0009</b></div>
		</header>
		<table class="lv-lines">
			<thead><tr><th scope="col">Description</th><th scope="col">Qty</th><th scope="col">Amount</th></tr></thead>
			<tbody>
				<?php foreach ( $b_lines as $b_l ) : ?>
					<tr class="lv-line"><td><?php echo esc_html( $b_l[0] ); ?></td><td><?php echo esc_html( $b_l[1] ); ?></td><td><?php echo esc_html( $b_l[2] ); ?></td></tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<dl class="lv-totals">
			<div><dt>Subtotal</dt><dd>₦2,061,000.00</dd></div>
			<div><dt>Discount (5%)</dt><dd>−₦103,050.00</dd></div>
			<div><dt>VAT (7.5%)</dt><dd>₦146,846.25</dd></div>
			<div class="lv-totals__sum"><dt>Total</dt><dd>₦2,104,796.25</dd></div>
		</dl>
		<p class="lv-words">Two Million, One Hundred and Four Thousand, Seven Hundred and Ninety-Six Naira, Twenty-Five Kobo Only</p>
		<p class="lv-bank"><span>Pay by transfer</span>GTBank · 0234567890 · Narration: INV-2026-0009</p>
		<span class="lv-stamp" aria-hidden="true">Paid</span>
	</div>
	<p class="lv-toast lv-toast--receipt"><span class="lv-toast__app">Receipt RCP-2026-0003</span>Emailed to your customer, with a copy to you.</p>
</figure>
