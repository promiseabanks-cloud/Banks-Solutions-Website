<?php
/**
 * Project Desk hero: the client's portal on a phone, the owner's money card beside it and a
 * push notification arriving. Example data. product.js plays the phase bar and the toast.
 *
 * @package Banks
 */

$b_phases = array(
	array( 'Kick-off', 'done' ),
	array( 'Agreement and deposit', 'done' ),
	array( 'Design', 'done' ),
	array( 'Build', 'now' ),
	array( 'Launch sign-off', 'next' ),
);
?>
<figure class="lv lv--pd" aria-label="An example: a client's project in the Project Desk portal, with the owner's money card">
	<div class="lv-phone" data-tilt>
		<div class="lv-phone__notch" aria-hidden="true"></div>
		<div class="lv-phone__screen">
			<p class="lv-app__hi">Good morning, Adaeze</p>
			<div class="lv-card lv-card--hero">
				<span class="lv-tag">Website · In progress</span>
				<p class="lv-card__title">Oak &amp; Ember website</p>
				<div class="lv-progress" style="--p:.72"><span></span></div>
				<p class="lv-card__meta"><span>Phase 4 of 5</span><span>72%</span></p>
			</div>
			<ol class="lv-phases">
				<?php foreach ( $b_phases as $b_ph ) : ?>
					<li class="lv-phase lv-phase--<?php echo esc_attr( $b_ph[1] ); ?>"><span class="lv-phase__dot" aria-hidden="true"></span><?php echo esc_html( $b_ph[0] ); ?><?php echo 'now' === $b_ph[1] ? '<em>Now</em>' : ''; ?></li>
				<?php endforeach; ?>
			</ol>
			<div class="lv-card lv-card--wait">
				<span class="lv-tag lv-tag--signal">Waiting on you</span>
				<p>Approve the homepage design</p>
				<span class="lv-btn">Review</span>
			</div>
			<nav class="lv-tabs" aria-hidden="true"><span class="is-on">Home</span><span>Projects</span><span>Files</span><span>Pay</span></nav>
		</div>
	</div>
	<div class="lv-float lv-float--money">
		<p class="lv-float__label">Money · this month</p>
		<p class="lv-float__big">₦2,450,000</p>
		<p class="lv-float__sub">collected · 81% of invoiced</p>
		<div class="lv-mini" aria-hidden="true">
			<?php foreach ( array( 42, 55, 48, 66, 74, 92 ) as $b_h ) : ?>
				<span style="--h:<?php echo esc_attr( $b_h ); ?>%"></span>
			<?php endforeach; ?>
		</div>
		<p class="lv-float__row"><span>Awaiting your confirmation</span><b>₦350,000</b></p>
	</div>
	<p class="lv-toast"><span class="lv-toast__app">Project Desk</span>Design phase complete. Build has started.</p>
</figure>
