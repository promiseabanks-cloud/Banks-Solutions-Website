<?php
/**
 * 1904 Car Wash hero: the customer app on a phone, with the wallet, a booked wash and a car on
 * file, and the receipt arriving. Prices are from the 1904 Solutions price list; the customer
 * and car are examples. product.js plays the booking tick and the toast.
 *
 * @package Banks
 */
?>
<figure class="lv lv--cw" aria-label="An example: a customer's 1904 Car Wash app with wallet, booking and car on file">
	<div class="lv-phone" data-tilt>
		<div class="lv-phone__notch" aria-hidden="true"></div>
		<div class="lv-phone__screen">
			<p class="lv-app__brand">1904 <span>Car Wash</span></p>
			<div class="lv-card lv-card--wallet">
				<span class="lv-tag">1904 Wallet</span>
				<p class="lv-wallet">₦12,500</p>
				<p class="lv-card__meta"><span>Pay at the counter</span><span>Top up</span></p>
			</div>
			<p class="lv-app__label">Book a wash</p>
			<ul class="lv-menu">
				<li class="is-on"><span>Normal wash · Sedan</span><b>₦1,500</b></li>
				<li><span>Normal wash · SUV</span><b>₦2,000</b></li>
				<li><span>Engine wash · Sedan</span><b>₦2,000</b></li>
			</ul>
			<div class="lv-card lv-card--booked">
				<span class="lv-check" aria-hidden="true"></span>
				<div><p>Booked · Saturday, 10:00</p><small>Toyota Corolla · Silver · LND 482 KJ</small></div>
			</div>
			<nav class="lv-tabs" aria-hidden="true"><span class="is-on">Home</span><span>Book</span><span>Cars</span><span>Wallet</span></nav>
		</div>
	</div>
	<div class="lv-float lv-float--car">
		<p class="lv-float__label">Cars on file</p>
		<ul class="lv-cars">
			<li><span class="lv-swatch" style="--c:#C9CDD0"></span><b>Toyota Corolla</b><small>LND 482 KJ</small></li>
			<li><span class="lv-swatch" style="--c:#1B1F24"></span><b>Lexus RX 350</b><small>KJA 117 BD</small></li>
		</ul>
	</div>
	<p class="lv-toast"><span class="lv-toast__app">1904 Car Wash</span>Receipt for your wash is in your email.</p>
</figure>
