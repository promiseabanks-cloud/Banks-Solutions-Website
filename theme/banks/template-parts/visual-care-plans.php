<?php
/*
 * Care plans hero visual: a site-health monitor. The pulse keeps beating, tonight's routine runs
 * check by check, and a support request from the portal goes from received to done.
 * Decorative, plain HTML and SVG; solution.js runs it.
 */
$b_checks = array(
	array( 'Updates', '14 plugins', 'Tested on a copy' ),
	array( 'Backup', 'Off-site, nightly', 'Restore verified' ),
	array( 'Security scan', 'Malware and logins', 'Clean' ),
	array( 'Speed check', 'Phone on 4G', '1.2s' ),
);
// One heartbeat every 150 units, drawn twice so the line can loop without a seam.
$b_beat = '';
for ( $b_i = 0; $b_i < 8; $b_i++ ) {
	$b_x     = $b_i * 150;
	$b_beat .= sprintf( ' L%1$d 50 L%2$d 50 L%3$d 22 L%4$d 72 L%5$d 50 L%6$d 50', $b_x + 50, $b_x + 62, $b_x + 70, $b_x + 80, $b_x + 88, $b_x + 150 );
}
?>
<div class="so-vis vc" data-visual="care-plans" aria-hidden="true">
	<div class="vc-panel">
		<div class="vc-chrome"><i></i><i></i><i></i><span>care / yourbusiness.ng</span><em><span class="s-live"></span>All systems normal</em></div>
		<div class="vc-kpis">
			<div class="vc-kpi"><em>Uptime, 90 days</em><b><span data-vc-up>99.98</span>%</b></div>
			<div class="vc-kpi"><em>Load on a phone</em><b>1.2s</b></div>
			<div class="vc-kpi"><em>Last backup</em><b data-vc-backup>2h ago</b></div>
		</div>
		<div class="vc-pulse">
			<svg viewBox="0 0 600 90" preserveAspectRatio="none"><g class="vc-beat"><path d="M0 50<?php echo esc_attr( $b_beat ); ?>"/></g></svg>
			<span class="vc-pulse__dot"></span>
		</div>
		<div class="vc-run">
			<p class="vc-run__head">Tonight’s routine <span data-vc-time>02:00</span></p>
			<?php foreach ( $b_checks as $b_c ) : ?>
				<div class="vc-check is-done">
					<span class="vc-check__icon"><svg viewBox="0 0 16 16"><path d="M3.5 8.5l3 3 6-7"/></svg></span>
					<span class="vc-check__text"><b><?php echo esc_html( $b_c[0] ); ?></b><span><?php echo esc_html( $b_c[1] ); ?></span></span>
					<span class="vc-check__state"><?php echo esc_html( $b_c[2] ); ?></span>
					<span class="vc-check__bar"></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="vc-ticket">
		<em>Portal · Support · <span data-vc-id>#214</span></em>
		<p data-vc-ask>Please update our opening hours for the holiday</p>
		<div class="vc-ticket__foot"><span class="vc-status" data-vc-status>Done · 1h 40m</span><span>Handled by your care lead</span></div>
	</div>
</div>
