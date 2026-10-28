<?php
/*
 * Homepage. First pass: hero, proof strip and the flow line that the rest of the
 * page sections will hang off. Copy from Banks_Solution_Homepage_Copy.docx.
 */
get_header();
?>
<section class="h-hero" data-dark>
	<svg class="h-flow" viewBox="0 0 1440 900" preserveAspectRatio="none" aria-hidden="true">
		<path class="h-flow__bank" d="M-20 140 C 320 120, 420 380, 720 420 S 1180 520, 1460 760"/>
		<path class="h-flow__line" d="M-20 140 C 320 120, 420 380, 720 420 S 1180 520, 1460 760"/>
	</svg>
	<div class="b-wrap h-hero__inner">
		<p class="b-eyebrow h-hero__eyebrow">Websites · Web apps · Plugins · Automation · AI</p>
		<h1 class="h-hero__title" data-split-hero>Your website should do more than look good<span class="h-dot">.</span></h1>
		<p class="h-hero__lede">We build the digital systems that bring in the right customers, turn more enquiries into sales and take repetitive work off your hands, for businesses in any field.</p>
		<div class="h-hero__actions">
			<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( banks_main_url( '/start/' ) ); ?>" data-magnetic>Start a project</a>
			<a class="b-btn b-btn--line b-btn--lg" href="#h-proof">See the work</a>
		</div>
	</div>
</section>

<section class="h-proof" id="h-proof">
	<div class="b-wrap h-proof__grid">
		<div class="h-stat" data-reveal><span class="h-stat__num" data-count="7">7</span><span class="h-stat__plus">+</span><span class="h-stat__label">brands built</span></div>
		<div class="h-stat" data-reveal><span class="h-stat__num" data-count="9.0" data-decimals="1">9.0</span><span class="h-stat__label">client rating out of 10</span></div>
		<div class="h-stat" data-reveal><span class="h-stat__num" data-count="6">6</span><span class="h-stat__label">countries served</span></div>
	</div>
</section>
<?php
get_footer();
