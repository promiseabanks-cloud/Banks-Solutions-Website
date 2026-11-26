<?php
/*
 * Year-end website offer (/offer/). One goal: a qualified lead (name, WhatsApp, email, what the
 * business does). Built to the landing page framework in docs: headline, sub-headline, hero
 * visual, one button, a short form, three objections answered, plans and proof underneath, and
 * the fine print last. Leads are saved and followed up by Banks Core (includes/offers.php).
 * With JavaScript off the page reads in full and the form posts normally.
 */
get_header();

$b_active = function_exists( 'banks_core_offer_active' ) ? banks_core_offer_active() : true;
$b_ends   = function_exists( 'banks_core_offer_ends' ) ? banks_core_offer_ends() : strtotime( '2026-12-31 23:59:00' );
$b_end_tx = wp_date( 'j F Y', $b_ends );
$b_state  = isset( $_GET['offer_state'] ) ? sanitize_key( wp_unslash( $_GET['offer_state'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- display only.
$b_ready  = function_exists( 'banks_core_submit_offer' );
$b_start  = banks_route( '/start/', '/contact/' );

$b_plans = array(
	array( 'starter', 'Starter', '₦200,000', '₦380,000', '47% off', 'Ready in 5 to 7 days', 'The one most businesses need: a fast, clear website that answers customers and gets you found.' ),
	array( 'growth', 'Growth', 'from ₦320,000', 'about ₦550,000', '42% off', 'Ready in about 14 days', 'More pages and features, scoped with you.' ),
	array( 'max', 'Max', 'from ₦550,000', 'from ₦950,000', '42% off', 'Ready in 2 to 3 weeks', 'The full build: larger sites, stores and custom features.' ),
);
$b_incl = array(
	'A fast, mobile-first business website, designed and written for you',
	'A .com.ng domain and hosting for your first year',
	'Your Google Business Profile set up, so people find you on Google and Maps',
	'Entry-level AI search optimisation, so ChatGPT and Gemini can find and cite you',
	'Full access to the Banks Business Engine for 30 days after launch, then its core features stay with your site',
	'30 days of care after launch: updates, backups and fixes',
);
$b_objs = array(
	array( 'Will it work for my business?', 'We have built for 7+ brands in 6 countries, from hotels and law firms to salons, a bank and a foundation, and our Google reviews are from real clients. Tell us what you do on the form, and we will say honestly if a website is not what you need.' ),
	array( 'This sounds too good to be true.', 'The price is lower because this is a year-end offer with limited builds, not because the work is cut down. You see exactly what is included above. You pay a ₦50,000 deposit to start and the rest only when you are happy with the website.' ),
	array( 'How long will it take?', 'The Starter website is ready in 5 to 7 days from when we have your business details, logo and photos. Growth takes about 14 days and Max 2 to 3 weeks. We confirm the date in writing before you pay anything.' ),
);
?>
<section class="of-hero" data-dark data-hero id="start">
	<div class="of-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap of-inner">
			<div class="of-copy">
				<p class="b-eyebrow of-eyebrow"><span class="s-live" aria-hidden="true"></span><?php echo $b_active ? esc_html( 'Year-end offer · ends ' . $b_end_tx ) : 'Year-end offer · ended'; ?></p>
				<h1 class="of-title">A website that answers your customers for you<span class="s-dot">.</span></h1>
				<p class="of-lede">Live in 5 to 7 days, with your domain, hosting and Google listing included. Pay a ₦50,000 deposit to start, and the rest only when you love it.</p>
				<div class="of-price" aria-label="Starter website price">
					<?php if ( $b_active ) : ?>
						<span class="of-price__now">₦200,000</span>
						<span class="of-price__was"><s>₦380,000</s> normal price</span>
					<?php else : ?>
						<span class="of-price__now">From ₦380,000</span>
					<?php endif; ?>
				</div>
				<?php if ( $b_active ) : ?>
					<p class="of-count" data-ends="<?php echo esc_attr( gmdate( 'c', $b_ends ) ); ?>" aria-live="off">Offer ends <?php echo esc_html( $b_end_tx ); ?></p>
				<?php endif; ?>
				<div class="of-visual" aria-hidden="true">
					<div class="of-phone">
						<div class="of-phone__bar"><i></i><i></i><i></i></div>
						<div class="of-chat">
							<p class="of-msg of-msg--in">Hi, how much for 20 braids and can I book Saturday?</p>
							<p class="of-msg of-msg--out">Hi Ada! 20 braids is ₦25,000. Saturday 2pm is free. Shall I hold it for you?</p>
							<p class="of-msg of-msg--in">Yes please</p>
							<p class="of-msg of-msg--out">Done. You will get a payment link now.</p>
						</div>
						<p class="of-phone__foot"><span class="s-live"></span>Example: replied in 4 seconds, at 11:42 pm</p>
					</div>
				</div>
			</div>
			<div class="of-card">
				<?php if ( 'confirmed' === $b_state ) : ?>
					<div class="of-done">
						<h2>You are in<span class="s-dot">.</span></h2>
						<p>We have reserved your place and emailed your deposit details. Check your inbox, and spam folder if you do not see it within a few minutes.</p>
					</div>
				<?php elseif ( 'stopped' === $b_state ) : ?>
					<div class="of-done">
						<h2>Done, we will not email you again.</h2>
						<p>If you change your mind, the form is still here.</p>
					</div>
				<?php elseif ( 'sent' === $b_state ) : ?>
					<div class="of-done">
						<h2>Got it<span class="s-dot">.</span></h2>
						<p>We have emailed you a link. Click it to confirm that you are ready to start, and we will send your deposit details.</p>
					</div>
				<?php elseif ( ! $b_active ) : ?>
					<div class="of-done">
						<h2>This offer has ended<span class="s-dot">.</span></h2>
						<p>Business websites now start from ₦380,000. Send us a short brief and we will reply within two working days.</p>
						<a class="b-btn b-btn--signal" href="<?php echo esc_url( $b_start ); ?>">Start a project</a>
					</div>
				<?php elseif ( $b_ready ) : ?>
					<h2 class="of-card__title">Start my website</h2>
					<p class="of-card__sub">Four quick details. You pay nothing on this form.</p>
					<p class="of-alert" role="alert" hidden></p>
					<?php if ( 0 === strpos( $b_state, 'error-' ) ) : ?>
						<p class="of-alert" role="alert">Something went wrong. Please check your details and try again, or email <?php echo esc_html( banks_detail( 'email' ) ); ?>.</p>
					<?php endif; ?>
					<form class="of-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-rest="<?php echo esc_url( rest_url( 'banks/v1/offer' ) ); ?>"<?php echo is_user_logged_in() ? ' data-nonce="' . esc_attr( wp_create_nonce( 'wp_rest' ) ) . '"' : ''; ?> novalidate>
						<input type="hidden" name="action" value="banks_offer">
						<input type="hidden" name="banks_t" value="">
						<input type="hidden" name="plan" value="starter">
						<div class="of-hp" aria-hidden="true"><label>Leave this empty <input type="text" name="banks_hp" tabindex="-1" autocomplete="off"></label></div>
						<label class="of-field"><span>Your name</span><input type="text" name="name" autocomplete="name" required></label>
						<label class="of-field"><span>WhatsApp number</span><input type="tel" name="phone" autocomplete="tel" inputmode="tel" placeholder="+234 ..." required></label>
						<label class="of-field"><span>Email</span><input type="email" name="email" autocomplete="email" required></label>
						<label class="of-field"><span>What does your business do?</span><input type="text" name="business" placeholder="e.g. Hair salon in Lekki" required></label>
						<label class="of-check"><input type="checkbox" name="consent" value="1" required><span>I agree that Banks Solutions may contact me about this offer by email and WhatsApp.</span></label>
						<button class="b-btn b-btn--signal b-btn--lg of-send" type="submit" data-magnetic>Start my website</button>
						<p class="of-note">Next you will get an email to confirm. Then a ₦50,000 deposit starts your build.</p>
					</form>
				<?php else : ?>
					<h2 class="of-card__title">Start my website</h2>
					<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>">Send us a brief</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<section class="of-objs">
	<div class="b-wrap">
		<p class="b-eyebrow">The three questions we hear most</p>
		<ul class="of-objs__list">
			<?php foreach ( $b_objs as $b_o ) : ?>
				<li class="of-obj">
					<h2><?php echo esc_html( $b_o[0] ); ?></h2>
					<p><?php echo esc_html( $b_o[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="of-incl">
	<div class="b-wrap of-incl__grid">
		<div>
			<p class="b-eyebrow">What the Starter includes</p>
			<h2 data-split>Everything to get found and get replies<span class="s-dot">.</span></h2>
			<p class="of-incl__lede">Normally ₦380,000. For the offer, ₦200,000.</p>
		</div>
		<ul class="of-incl__list">
			<?php foreach ( $b_incl as $b_i ) : ?>
				<li><span class="of-tick" aria-hidden="true"></span><?php echo esc_html( $b_i ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="of-plans">
	<div class="b-wrap">
		<p class="b-eyebrow">Need more than a starter site?</p>
		<h2 class="of-plans__title">Bigger builds are on offer too.</h2>
		<ul class="of-plans__grid">
			<?php foreach ( $b_plans as $b_p ) : ?>
				<li class="of-plan<?php echo 'starter' === $b_p[0] ? ' of-plan--main' : ''; ?>">
					<h3><?php echo esc_html( $b_p[1] ); ?></h3>
					<?php if ( $b_active ) : ?>
						<p class="of-plan__price"><?php echo esc_html( $b_p[2] ); ?></p>
						<p class="of-plan__was"><s><?php echo esc_html( $b_p[3] ); ?></s> · <?php echo esc_html( $b_p[4] ); ?></p>
					<?php else : ?>
						<p class="of-plan__price"><?php echo esc_html( $b_p[3] ); ?></p>
					<?php endif; ?>
					<p><?php echo esc_html( $b_p[6] ); ?></p>
					<p class="of-plan__when"><?php echo esc_html( $b_p[5] ); ?></p>
					<?php if ( $b_active ) : ?>
						<a class="b-btn <?php echo 'starter' === $b_p[0] ? 'b-btn--signal' : 'b-btn--line'; ?>" href="#start" data-plan="<?php echo esc_attr( $b_p[0] ); ?>">Choose <?php echo esc_html( $b_p[1] ); ?></a>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php get_template_part( 'template-parts/testimonials' ); ?>

<section class="of-fine">
	<div class="b-wrap">
		<h2>The small print</h2>
		<ul>
			<li>A ₦50,000 deposit starts your build. You pay the balance when you are happy with the website, before it goes live.</li>
			<li>The domain and hosting are included for your first year. We tell you the renewal cost before you pay the deposit.</li>
			<li>Build time runs from the day we have your business details, logo and photos.</li>
			<li>Business Engine full access runs for 30 days from launch. After that, its core features stay with your website and the rest is optional.</li>
			<li>Offer prices apply to builds confirmed by <?php echo esc_html( $b_end_tx ); ?>. Growth and Max are priced from the figures shown and confirmed in writing after a short call.</li>
		</ul>
	</div>
</section>
<?php
get_footer();
