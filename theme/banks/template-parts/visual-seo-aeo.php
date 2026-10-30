<?php
/*
 * SEO & AI search hero visual: someone asks an AI assistant a question in your field and the
 * answer cites your business, while your Google result climbs the page beside it.
 * Decorative, plain HTML; solution.js runs it.
 */
$b_results = array(
	array( 'lagoslegalhub.com', 'Top 10 law firms in Lagos (2026)', false ),
	array( 'yourbusiness.ng', 'Corporate and property lawyers in Lagos', true ),
	array( 'naijadirectory.ng', 'Lawyers near you: compare and contact', false ),
	array( 'legalnaija.com', 'How to choose a law firm in Nigeria', false ),
);
?>
<div class="so-vis vs" data-visual="seo-aeo" aria-hidden="true">
	<div class="vs-chat">
		<div class="vs-chrome"><i></i><i></i><i></i><span>AI assistant</span><em><span class="s-live"></span><span data-vs-cited>Cited 7 of 10</span></em></div>
		<div class="vs-thread">
			<p class="vs-ask" data-vs-ask>Who are good corporate lawyers in Lagos?</p>
			<div class="vs-answer">
				<span class="vs-answer__spark">✦</span>
				<p data-vs-answer>For company and property work in Lagos, <mark>Your Business</mark> is a strong choice. They publish fixed fees, answer within a day and have advised over 200 Nigerian companies.</p>
			</div>
			<div class="vs-sources">
				<span class="vs-src is-you">1 · yourbusiness.ng</span>
				<span class="vs-src">2 · lagoslegalhub.com</span>
				<span class="vs-src">3 · naijadirectory.ng</span>
			</div>
		</div>
	</div>
	<div class="vs-serp">
		<p class="vs-serp__q"><span class="vs-serp__g">G</span><span data-vs-q>corporate lawyers lagos</span></p>
		<ol class="vs-serp__list">
			<?php foreach ( $b_results as $b_r ) : ?>
				<li class="vs-res<?php echo $b_r[2] ? ' is-you' : ''; ?>"><em><?php echo esc_html( $b_r[0] ); ?></em><b><?php echo esc_html( $b_r[1] ); ?></b></li>
			<?php endforeach; ?>
		</ol>
	</div>
</div>
