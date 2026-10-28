<?php
/*
 * Start a project (/start/): the guided brief every "Start a project" button points to.
 * The theme only draws the form; Banks Core (plugins/banks-core) supplies the questions,
 * validates the answers, saves the brief and sends the emails. With JavaScript the brief runs
 * one step at a time (start.js); without it, every step shows at once and posts normally.
 * Copy: "Banks Solutions website: sitemap and copy" doc.
 */
get_header();

$b_ready = function_exists( 'banks_core_brief_options' );
$b_opts  = $b_ready ? banks_core_brief_options() : array();
// An industry page links here with ?industry=<slug>, so the field is already chosen.
$b_field = isset( $_GET['industry'] ) ? sanitize_key( wp_unslash( $_GET['industry'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
// After a no-JavaScript submit, Banks Core sends the visitor back with ?brief=<ref> or ?brief_error=<code>.
$b_ref   = isset( $_GET['brief'] ) ? sanitize_text_field( wp_unslash( $_GET['brief'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- display only.
$b_ref   = preg_match( '/^BS-\d{6}-\d{4,}$/', $b_ref ) ? $b_ref : '';
$b_error = isset( $_GET['brief_error'] ) ? sanitize_key( wp_unslash( $_GET['brief_error'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- display only.
// Links from product and solution pages can tick a need in advance: /start/?need=ai.
$b_need  = isset( $_GET['need'] ) ? array_map( 'sanitize_key', explode( ',', sanitize_text_field( wp_unslash( $_GET['need'] ) ) ) ) : array(); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- display only.
$b_wa    = 'https://wa.me/' . preg_replace( '/\D/', '', banks_detail( 'whatsapp' ) );
$b_mail  = banks_detail( 'email' );

$b_next = array(
	array( 'About 10 minutes', 'You answer six short questions', 'What you need, your business, what is not working, budget, timeline and how to reach you.' ),
	array( 'Within two working days', 'We reply with a proposal', 'What we would build, how long it takes and what it costs. If a smaller fix would do, we say so.' ),
	array( 'When you accept', 'It becomes your project', 'Your brief opens as a project in your client portal, with files, progress and payments in one place.' ),
);

$b_faqs = array(
	array( 'What happens after I send the brief?', 'You get an email with your reference straight away. Within two working days a person at Banks Solutions replies with what we would build, how long it would take and a fixed price, or tells you plainly if a smaller fix would do.' ),
	array( 'Do I need to know exactly what I want?', 'No. Pick "Not sure yet" and describe what is not working. Working out the right fix is our job, and the answer is sometimes smaller than people expect.' ),
	array( 'Why do you ask about budget?', 'So we can suggest something that fits. A budget range lets us tell you what is realistic, and what to leave for later, instead of sending a quote you have to reject.' ),
	array( 'What do you do with my details?', 'We use them only to reply to your brief and prepare a proposal. We do not sell or share them, and you can ask us to delete them at any time by emailing ' . $b_mail . '.' ),
);

$b_step = function ( $n, $title, $hint ) {
	echo '<legend class="st-step__head"><span class="st-step__n">' . esc_html( sprintf( '%02d', $n ) ) . '<span> / 06</span></span><span class="st-step__title">' . esc_html( $title ) . '</span>';
	if ( $hint ) {
		echo '<span class="st-step__hint">' . esc_html( $hint ) . '</span>';
	}
	echo '</legend>';
};
?>
<section class="st-hero" data-dark data-hero id="brief">
	<div class="st-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap st-inner">
			<div class="st-copy">
				<p class="b-eyebrow st-eyebrow">Start a project</p>
				<h1 class="st-title">Tell us what you’re building<span class="s-dot">.</span></h1>
				<p class="st-lede">Answer a few questions about your business and what’s not working. It takes about 10 minutes. We reply within two working days with what we’d build, how long it takes and what it costs.</p>
				<ol class="st-next">
					<?php foreach ( $b_next as $b_i => $b_n ) : ?>
						<li class="st-next__item">
							<span class="st-next__dot" aria-hidden="true"><?php echo esc_html( $b_i + 1 ); ?></span>
							<span class="st-next__when"><?php echo esc_html( $b_n[0] ); ?></span>
							<strong><?php echo esc_html( $b_n[1] ); ?></strong>
							<span class="st-next__text"><?php echo esc_html( $b_n[2] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ol>
				<p class="st-direct">Rather talk first? <a href="<?php echo esc_url( $b_wa ); ?>">WhatsApp us</a> or email <a href="<?php echo esc_url( 'mailto:' . $b_mail ); ?>"><?php echo esc_html( $b_mail ); ?></a>.</p>
			</div>

			<div class="st-card">
				<?php if ( $b_ref ) : ?>
					<div class="st-done" role="status">
						<span class="st-done__tick" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7"/></svg></span>
						<h2 class="st-done__title">Brief received.</h2>
						<p>Your reference is <strong class="st-done__ref"><?php echo esc_html( $b_ref ); ?></strong>. We have emailed you a copy.</p>
						<p>Within two working days we’ll reply with what we’d build, how long it takes and what it costs.</p>
						<a class="b-btn b-btn--line" href="<?php echo esc_url( $b_wa ); ?>">Message us on WhatsApp</a>
					</div>
				<?php elseif ( ! $b_ready ) : ?>
					<div class="st-done">
						<h2 class="st-done__title">The brief is offline for a moment.</h2>
						<p>Tell us what you’re building on <a href="<?php echo esc_url( $b_wa ); ?>">WhatsApp</a> or at <a href="<?php echo esc_url( 'mailto:' . $b_mail ); ?>"><?php echo esc_html( $b_mail ); ?></a>, and we’ll reply within two working days.</p>
					</div>
				<?php else : ?>
					<form class="st-form" method="post" action="<?php echo esc_url( banks_core_brief_action_url() ); ?>" data-rest="<?php echo esc_url( banks_core_brief_rest_url() ); ?>"<?php echo is_user_logged_in() ? ' data-nonce="' . esc_attr( wp_create_nonce( 'wp_rest' ) ) . '"' : ''; ?>>
						<input type="hidden" name="action" value="banks_brief">
						<input type="hidden" name="banks_return" value="<?php echo esc_url( get_permalink() ); ?>">
						<input type="hidden" name="banks_t" value="">
						<div class="st-hp" aria-hidden="true"><label>Leave this empty <input type="text" name="banks_hp" tabindex="-1" autocomplete="off"></label></div>

						<div class="st-bar" aria-hidden="true"><span></span></div>
						<p class="st-alert" role="alert"<?php echo $b_error ? '' : ' hidden'; ?>><?php echo esc_html( $b_error ? 'Something was missing or went wrong. Please check your answers and send again, or email ' . $b_mail . '.' : '' ); ?></p>

						<div class="st-steps">
							<fieldset class="st-step" data-step="1">
								<?php $b_step( 1, 'What do you need?', 'Pick as many as you like.' ); ?>
								<div class="st-tiles st-tiles--two" data-need="needs">
									<?php foreach ( $b_opts['needs'] as $b_k => $b_l ) : ?>
										<label class="st-tile"><input type="checkbox" name="needs[]" value="<?php echo esc_attr( $b_k ); ?>"<?php checked( in_array( $b_k, $b_need, true ) ); ?>><span><?php echo esc_html( $b_l ); ?></span></label>
									<?php endforeach; ?>
								</div>
							</fieldset>

							<fieldset class="st-step" data-step="2">
								<?php $b_step( 2, 'Your business', '' ); ?>
								<label class="st-field"><span>Business name</span><input type="text" name="business" required maxlength="120" autocomplete="organization"></label>
								<label class="st-field st-field--select"><span>Industry</span>
									<select name="industry" required>
										<option value="">Choose one</option>
										<?php foreach ( $b_opts['industry'] as $b_k => $b_l ) : ?>
											<option value="<?php echo esc_attr( $b_k ); ?>"<?php selected( $b_k, $b_field ); ?>><?php echo esc_html( $b_l ); ?></option>
										<?php endforeach; ?>
									</select>
								</label>
								<label class="st-field"><span>Current website <em>if you have one</em></span><input type="url" name="website" maxlength="200" placeholder="https://" inputmode="url"></label>
							</fieldset>

							<fieldset class="st-step" data-step="3">
								<?php $b_step( 3, 'What’s not working?', 'In your own words. What is slow, broken or missing today?' ); ?>
								<label class="st-field"><span>The problem</span><textarea name="problem" rows="5" required maxlength="4000" placeholder="For example: enquiries come in on WhatsApp and we lose track of who has been quoted."></textarea></label>
								<label class="st-field"><span>What would success look like? <em>optional</em></span><textarea name="success" rows="3" maxlength="2000"></textarea></label>
							</fieldset>

							<fieldset class="st-step" data-step="4">
								<?php $b_step( 4, 'Budget', 'A rough range helps us suggest something that fits.' ); ?>
								<div class="st-tiles st-tiles--two">
									<?php foreach ( $b_opts['budget'] as $b_k => $b_l ) : ?>
										<label class="st-tile"><input type="radio" name="budget" value="<?php echo esc_attr( $b_k ); ?>" required><span><?php echo esc_html( $b_l ); ?></span></label>
									<?php endforeach; ?>
								</div>
							</fieldset>

							<fieldset class="st-step" data-step="5">
								<?php $b_step( 5, 'Timeline', 'When would you like to start?' ); ?>
								<div class="st-tiles">
									<?php foreach ( $b_opts['timeline'] as $b_k => $b_l ) : ?>
										<label class="st-tile"><input type="radio" name="timeline" value="<?php echo esc_attr( $b_k ); ?>" required><span><?php echo esc_html( $b_l ); ?></span></label>
									<?php endforeach; ?>
								</div>
							</fieldset>

							<fieldset class="st-step" data-step="6">
								<?php $b_step( 6, 'How do we reach you?', '' ); ?>
								<label class="st-field"><span>Your name</span><input type="text" name="name" required maxlength="100" autocomplete="name"></label>
								<label class="st-field"><span>Email</span><input type="email" name="email" required maxlength="200" autocomplete="email"></label>
								<label class="st-field"><span>Phone or WhatsApp <em>optional</em></span><input type="tel" name="phone" maxlength="30" autocomplete="tel"></label>
								<label class="st-check"><input type="checkbox" name="consent" value="1" required><span>Banks Solutions may use these details to reply to this brief. We never sell them.<?php $b_pp = banks_route( '/privacy-policy/' ); ?><?php if ( $b_pp ) : ?> See our <a href="<?php echo esc_url( $b_pp ); ?>" target="_blank" rel="noopener">privacy policy</a>.<?php endif; ?></span></label>
								<button class="b-btn b-btn--signal b-btn--lg st-send" type="submit" data-magnetic>Send the brief</button>
							</fieldset>
						</div>

						<div class="st-nav" hidden>
							<button class="st-back" type="button">Back</button>
							<button class="b-btn b-btn--signal st-go" type="button">Next</button>
						</div>
					</form>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>Before you send it.</h2>
		</div>
		<div class="s-faq__list">
			<?php foreach ( $b_faqs as $b_f ) : ?>
				<details class="s-qa">
					<summary><?php echo esc_html( $b_f[0] ); ?><span class="s-qa__icon" aria-hidden="true"></span></summary>
					<div class="s-qa__a"><p><?php echo esc_html( $b_f[1] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<script type="application/ld+json">
<?php
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'       => 'ContactPage',
				'name'        => 'Start a project',
				'url'         => banks_main_url( '/start/' ),
				'description' => 'Answer a few questions about your business and what is not working. Banks Solutions replies within two working days with what it would build, how long it takes and what it costs.',
			),
			array(
				'@type'      => 'FAQPage',
				'mainEntity' => array_map(
					function ( $f ) {
						return array(
							'@type'          => 'Question',
							'name'           => $f[0],
							'acceptedAnswer' => array(
								'@type' => 'Answer',
								'text'  => $f[1],
							),
						);
					},
					$b_faqs
				),
			),
		),
	),
	JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
);
?>
</script>
<?php
get_footer();
