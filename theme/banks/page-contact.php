<?php
/*
 * Contact (/contact/), built as scenes: a WhatsApp-style chat that types itself under a live
 * Lagos clock, the three ways to reach us, where we are, questions, closing call. Copy:
 * "Banks Solutions website: sitemap and copy" doc. Motion lives in contact.js; every message is
 * in the HTML, so the page reads in full with JavaScript off.
 */
get_header();

$b_start = banks_route( '/start/', '/contact/' );
$b_phone = banks_detail( 'whatsapp' );
$b_wa    = 'https://wa.me/' . preg_replace( '/\D/', '', $b_phone );
$b_mail  = banks_detail( 'email' );
$b_nice  = preg_replace( '/^\+234(\d{3})(\d{3})(\d{4})$/', '+234 $1 $2 $3', $b_phone );

$b_chat = array(
	array( 'in', 'Hi, we run a hotel in Ilorin. Can you help us take bookings on our website?' ),
	array( 'out', 'Hello! Yes, we build booking websites with Paystack payments. What happens with bookings now?' ),
	array( 'in', 'Mostly phone calls and WhatsApp, and we miss a lot of them.' ),
	array( 'out', 'That’s fixable. Fill in the brief and within two working days you’ll have what we’d build, the timeline and a fixed price.' ),
);

$b_ways = array(
	array(
		'key'   => 'whatsapp',
		'label' => 'WhatsApp',
		'value' => $b_nice,
		'note'  => 'Quickest for a short question.',
		'url'   => $b_wa,
		'go'    => 'Message us',
	),
	array(
		'key'   => 'email',
		'label' => 'Email',
		'value' => $b_mail,
		'note'  => 'Best for details, files and anything long.',
		'url'   => 'mailto:' . $b_mail,
		'go'    => 'Write to us',
	),
	array(
		'key'   => 'brief',
		'label' => 'Start a project',
		'value' => 'The 10-minute brief',
		'note'  => 'The fastest way to a proposal and a fixed price.',
		'url'   => $b_start,
		'go'    => 'Start the brief',
	),
);

$b_faqs = array(
	array( 'How quickly does Banks Solutions reply?', 'Within one working day, Monday to Friday, by email or WhatsApp. Briefs sent through the form at /start/ get a full reply within two working days, with what we would build, how long it takes and what it costs.' ),
	array( 'What is the fastest way to get a quote?', 'Fill in the brief at /start/. It takes about 10 minutes and asks the questions we would ask on a call, so the reply can include a fixed price rather than a range.' ),
	array( 'Where is Banks Solutions based?', 'In Nigeria, with offices in Lagos and Ilorin. We work with businesses across Nigeria and in the United States, the United Kingdom, Canada, Kenya and Australia.' ),
	array( 'What is Banks Solutions’ WhatsApp number?', 'You can message us on WhatsApp at ' . $b_nice . '.' ),
);
?>
<section class="ct-hero" data-dark data-hero>
	<div class="ct-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap ct-inner">
			<div class="ct-copy">
				<p class="b-eyebrow ct-eyebrow">Contact</p>
				<h1 class="ct-title">Talk to a person<span class="s-dot">.</span></h1>
				<p class="ct-lede">Email <a href="mailto:<?php echo esc_attr( $b_mail ); ?>"><?php echo esc_html( $b_mail ); ?></a> or message us on WhatsApp. We reply within one working day, Monday to Friday. Starting a project? The brief at <a href="<?php echo esc_url( $b_start ); ?>">/start/</a> gets you a proposal faster.</p>
				<div class="ct-actions">
					<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_wa ); ?>" data-magnetic>Message us on WhatsApp</a>
					<a class="b-btn b-btn--line b-btn--lg" href="mailto:<?php echo esc_attr( $b_mail ); ?>">Send an email</a>
				</div>
			</div>
			<figure class="ct-chat" aria-label="An example conversation with Banks Solutions">
				<div class="ct-chat__top">
					<span class="ct-chat__avatar" aria-hidden="true">B<span class="s-dot">.</span></span>
					<span class="ct-chat__who"><strong>Banks Solutions</strong><span class="ct-chat__status"><span class="s-live"></span>Replies within one working day</span></span>
					<span class="ct-clock" aria-hidden="true"><span class="ct-clock__label">Lagos</span><span class="ct-clock__time" data-clock><?php echo esc_html( wp_date( 'H:i', null, new DateTimeZone( 'Africa/Lagos' ) ) ); ?></span></span>
				</div>
				<ol class="ct-chat__log">
					<?php foreach ( $b_chat as $b_m ) : ?>
						<li class="ct-msg ct-msg--<?php echo esc_attr( $b_m[0] ); ?>"><span class="b-sr"><?php echo 'in' === $b_m[0] ? 'Client:' : 'Banks Solutions:'; ?> </span><?php echo esc_html( $b_m[1] ); ?></li>
					<?php endforeach; ?>
				</ol>
				<div class="ct-chat__bar" aria-hidden="true"><span>Type a message</span><span class="ct-chat__send"></span></div>
			</figure>
		</div>
	</div>
</section>

<section class="ct-ways" aria-labelledby="ct-ways-h">
	<div class="b-wrap">
		<div class="ct-head">
			<p class="b-eyebrow">Three ways in</p>
			<h2 id="ct-ways-h" data-split>Pick whichever suits you.</h2>
		</div>
		<div class="ct-grid">
			<?php foreach ( $b_ways as $b_w ) : ?>
				<a class="ct-way ct-way--<?php echo esc_attr( $b_w['key'] ); ?>" href="<?php echo esc_url( $b_w['url'] ); ?>"<?php echo 'brief' === $b_w['key'] ? ' data-dark' : ''; ?> data-tilt>
					<span class="ct-way__label"><?php echo esc_html( $b_w['label'] ); ?></span>
					<span class="ct-way__value"><?php echo esc_html( $b_w['value'] ); ?></span>
					<span class="ct-way__note"><?php echo esc_html( $b_w['note'] ); ?></span>
					<span class="ct-way__go"><?php echo esc_html( $b_w['go'] ); ?><span aria-hidden="true"> →</span></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="ct-where">
	<div class="b-wrap ct-where__grid">
		<div class="ct-head">
			<p class="b-eyebrow">Where we are</p>
			<h2 data-split>Two offices, clients in six countries.</h2>
			<p>We work from Lagos and Ilorin, and with clients in Nigeria, the United States, the United Kingdom, Canada, Kenya and Australia.</p>
		</div>
		<ul class="ct-cities">
			<li class="ct-city" data-reveal><span class="ct-city__name">Lagos</span><span class="ct-city__meta">Lagos State, Nigeria</span></li>
			<li class="ct-city" data-reveal><span class="ct-city__name">Ilorin</span><span class="ct-city__meta">Kwara State, Nigeria</span></li>
		</ul>
	</div>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>Before you write.</h2>
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

<section class="s-cta" data-dark>
	<div class="s-glow" aria-hidden="true"></div>
	<div class="b-wrap s-cta__inner">
		<h2 class="s-cta__title" data-split>Rather skip the back and forth<span class="s-dot">?</span></h2>
		<p>The brief asks what we would ask on a call. Ten minutes, and within two working days you’ll have a fixed price.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>" data-magnetic>Start the brief</a>
	</div>
</section>

<script type="application/ld+json">
<?php
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'      => 'ContactPage',
				'name'       => 'Contact Banks Solutions',
				'url'        => banks_main_url( '/contact/' ),
				'mainEntity' => array(
					'@type'        => 'Organization',
					'@id'          => banks_main_url( '/' ) . '#organization',
					'name'         => 'Banks Solutions',
					'legalName'    => banks_detail( 'legal' ),
					'url'          => banks_main_url( '/' ),
					'email'        => $b_mail,
					'contactPoint' => array(
						'@type'             => 'ContactPoint',
						'contactType'       => 'customer service',
						'email'             => $b_mail,
						'telephone'         => $b_phone,
						'areaServed'        => array( 'NG', 'US', 'GB', 'CA', 'KE', 'AU' ),
						'availableLanguage' => 'English',
						'hoursAvailable'    => array(
							'@type'     => 'OpeningHoursSpecification',
							'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
						),
					),
					'address'      => array(
						array(
							'@type'           => 'PostalAddress',
							'addressLocality' => 'Lagos',
							'addressCountry'  => 'NG',
						),
						array(
							'@type'           => 'PostalAddress',
							'addressLocality' => 'Ilorin',
							'addressRegion'   => 'Kwara',
							'addressCountry'  => 'NG',
						),
					),
				),
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
