<?php
/*
 * Web apps hero visual: a booking board that runs itself. A cursor drags bookings across the
 * columns, the numbers update and payments arrive. Decorative, plain HTML; solution.js runs it.
 */
$b_cards = array(
	array( 'new', 'Tolu A.', 'Consultation · Tue 10:00' ),
	array( 'new', 'Grace O.', 'Fitting · Wed 14:30' ),
	array( 'new', 'Kemi B.', 'Site visit · Thu 09:00' ),
	array( 'confirmed', 'Ifeanyi N.', 'Follow-up · Mon 11:00' ),
	array( 'confirmed', 'Sade L.', 'Consultation · Mon 15:00' ),
	array( 'done', 'Musa K.', 'Fitting · Fri 12:00' ),
	array( 'done', 'Ada E.', 'Site visit · Fri 16:00' ),
);
$b_cols  = array(
	'new'       => 'New',
	'confirmed' => 'Confirmed',
	'done'      => 'Done',
);
?>
<div class="so-vis va" data-visual="web-apps" aria-hidden="true">
	<div class="va-app">
		<div class="va-chrome"><i></i><i></i><i></i><span>app.yourbusiness.ng / bookings</span></div>
		<div class="va-body">
			<div class="va-side"><span class="va-side__logo"></span><span class="is-on"></span><span></span><span></span><span></span></div>
			<div class="va-main">
				<div class="va-kpis">
					<div class="va-kpi"><em>Bookings</em><b data-va-kpi="bookings">42</b></div>
					<div class="va-kpi"><em>Deposits</em><b>₦<span data-va-kpi="paid">630</span>k</b></div>
					<div class="va-kpi"><em>No-shows</em><b>0</b></div>
				</div>
				<div class="va-board">
					<?php foreach ( $b_cols as $b_key => $b_label ) : ?>
						<div class="va-col" data-col="<?php echo esc_attr( $b_key ); ?>">
							<p class="va-col__head"><?php echo esc_html( $b_label ); ?> <span></span></p>
							<div class="va-col__list">
								<?php foreach ( $b_cards as $b_c ) : ?>
									<?php if ( $b_c[0] === $b_key ) : ?>
										<div class="va-card"><b><?php echo esc_html( $b_c[1] ); ?></b><span><?php echo esc_html( $b_c[2] ); ?></span></div>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<svg class="va-cursor" viewBox="0 0 24 24"><path d="M4 2.5l15 8.2-6.6 1.7 3.6 7.1-2.9 1.4-3.6-7.1L4.6 18z"/></svg>
	<div class="va-toast"><span class="va-toast__icon">₦</span><span><em>Paystack · deposit received</em><b data-va-toast>₦45,000 from Tolu A.</b></span></div>
</div>
