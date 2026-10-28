<?php
/*
 * Banks Business Engine (/banks-business-engine/), the product page, built as scenes: a console
 * where an enquiry becomes a qualified lead and a booking, the 9pm problem, the three things it
 * does (pinned on wide screens), everything inside, data protection, how to get it, questions,
 * closing call. Copy: "Banks Solutions website: sitemap and copy" doc, the old homepage copy and
 * the plugin's own changelog. Motion lives in engine.js; every state is in the HTML.
 */
get_header();

$b_setup = add_query_arg( 'need', 'ai', banks_route( '/start/', '/contact/' ) );

// The conversation in the console, and the lead it turns into.
$b_chat = array(
	array( 'in', 'Hi, do you have a room for two this Friday? And can I pay online?' ),
	array( 'out', 'Yes, a deluxe double is free on Friday at ₦85,000 a night. I can hold it and send a Paystack link. What name should I book it under?' ),
	array( 'in', 'Adaeze Okafor. Two nights please.' ),
);
$b_lead = array(
	'Name'     => 'Adaeze Okafor',
	'Service'  => 'Deluxe double, 2 nights',
	'Budget'   => '₦170,000',
	'Timeline' => 'This Friday',
);

$b_does = array(
	array(
		'key'   => 'answer',
		'title' => 'Answers in real time',
		'text'  => 'No “we’ll get back to you.” Every question gets answered the moment it’s asked, from what you’ve told it about your services, prices and hours, in your voice.',
	),
	array(
		'key'   => 'qualify',
		'title' => 'Qualifies while it talks',
		'text'  => 'It picks up what the visitor wants, their budget and their timeline as the conversation goes, books a slot from your real hours, and hands you a lead that’s ready.',
	),
	array(
		'key'   => 'pattern',
		'title' => 'Shows you the pattern',
		'text'  => 'A dashboard of every enquiry, your most-asked questions, every lead’s status, win rates, which sources bring paying customers and what has been collected.',
	),
);

$b_inside = array(
	array( 'Bookings', 'Slots from your own working hours, booked inside the conversation, synced to Google Calendar.' ),
	array( 'Lead and customer CRM', 'Every lead, customer, booking and note in one place, with a status you can move along.' ),
	array( 'WhatsApp alerts', 'You get each new lead on WhatsApp with the service, budget and timeline. The customer gets their confirmation.' ),
	array( 'Paystack links', 'Send a payment link from any lead. Money goes straight to your own Paystack account.' ),
	array( 'Automations', 'Six ready recipes, follow-ups, reminders and notifications, plus a builder for your own.' ),
	array( 'Insights', 'Win rates, source performance, revenue collected and a 30-day trend, in one tab.' ),
	array( 'Your choice of AI', 'Runs on OpenAI or Groq with your own key, so you see and pay the real model cost.' ),
	array( 'Five-minute setup', 'A guided wizard for your business, services, knowledge, hours and AI, then you’re live.' ),
	array( 'Slack and SMS', 'Lead alerts to a Slack channel, or by SMS and WhatsApp through Twilio.' ),
	array( 'Updates built in', 'New versions arrive on their own. We keep your assistant current without you lifting a finger.' ),
);

$b_faqs = array(
	array( 'What is Banks Business Engine?', 'Banks Business Engine is an AI assistant and lead CRM from Banks Solutions. It adds an assistant to your website that answers visitors in real time, qualifies them, books appointments and sends ready leads to a dashboard with a CRM, automations, WhatsApp alerts, Paystack payment links and insights.' ),
	array( 'Does it work on WhatsApp?', 'Yes, for notifications. You get each new lead on WhatsApp with the service, budget and timeline, and customers get their confirmation on WhatsApp too, through Meta’s WhatsApp Cloud API or Twilio. The conversation itself happens on your website.' ),
	array( 'Which AI does it use?', 'It runs on OpenAI or Groq, using your own API key, which is encrypted before it is stored. The assistant answers from what you tell it about your business, and it only offers appointment times from your real booking hours.' ),
	array( 'What does it cost a month?', 'It’s priced on scope: what the assistant needs to do on your website, from answering questions to taking bookings, payments and WhatsApp follow-ups. It runs on a monthly licence per website, and we quote both with the setup. AI model usage is billed by the provider on your own key, never marked up. Start the brief and the quote comes back within two working days.' ),
	array( 'Does it work with my website?', 'Yes. We set it up on your website, whatever it was built with, and connect it to WhatsApp, Paystack and your calendar. If you don’t have a website yet, we can build one with it included.' ),
	array( 'Where is my data kept?', 'With your own website and business, not on a shared platform you don’t control. API keys and credentials are encrypted with AES-256-GCM, and the setup follows Nigeria’s Data Protection Act 2023.' ),
	array( 'What happens if I stop paying?', 'The public assistant pauses, but you keep full access to your dashboard, leads, customers and bookings. Nothing is deleted.' ),
);
?>
<section class="en-hero" data-dark data-hero>
	<div class="en-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap en-inner">
			<div class="en-copy">
				<p class="b-eyebrow en-eyebrow">Banks Business Engine · AI assistant and lead CRM</p>
				<h1 class="en-title">Every enquiry answered, qualified and followed up<span class="s-dot">.</span></h1>
				<p class="en-lede">Banks Business Engine is an AI assistant from Banks Solutions that answers your website visitors in real time, qualifies them and sends ready leads to a built-in dashboard with bookings and automations. It works on your website, in your voice.</p>
				<div class="en-actions">
					<button type="button" class="b-btn b-btn--signal b-btn--lg en-try" data-magnetic hidden>Try it live</button>
					<a class="b-btn b-btn--signal b-btn--lg en-setup" href="<?php echo esc_url( $b_setup ); ?>" data-magnetic>Book a setup</a>
				</div>
			</div>

			<figure class="en-console" aria-label="An example: a website enquiry becomes a lead and a booking">
				<div class="en-console__chat">
					<p class="en-console__label"><span class="s-live"></span>On your website</p>
					<ol class="en-chat">
						<?php foreach ( $b_chat as $b_m ) : ?>
							<li class="en-msg en-msg--<?php echo esc_attr( $b_m[0] ); ?>"><span class="b-sr"><?php echo 'in' === $b_m[0] ? 'Visitor:' : 'Assistant:'; ?> </span><?php echo esc_html( $b_m[1] ); ?></li>
						<?php endforeach; ?>
					</ol>
				</div>
				<div class="en-console__lead">
					<p class="en-console__label">In your dashboard</p>
					<div class="en-lead">
						<div class="en-lead__top">
							<span class="en-lead__tag">New lead</span>
							<span class="en-score" style="--p:.86"><svg viewBox="0 0 36 36" aria-hidden="true"><circle cx="18" cy="18" r="15.5"></circle><circle class="en-score__bar" cx="18" cy="18" r="15.5" pathLength="100"></circle></svg><span class="en-score__n" data-score="86">86</span><span class="b-sr"> intent score out of 100</span></span>
						</div>
						<dl class="en-lead__fields">
							<?php foreach ( $b_lead as $b_k => $b_v ) : ?>
								<div class="en-field"><dt><?php echo esc_html( $b_k ); ?></dt><dd><?php echo esc_html( $b_v ); ?></dd></div>
							<?php endforeach; ?>
						</dl>
						<p class="en-booked"><span class="en-booked__tick" aria-hidden="true"></span>Booked for Friday · Paystack link sent</p>
					</div>
					<p class="en-toast"><span class="en-toast__app">WhatsApp</span>New lead: Adaeze Okafor, deluxe double, ₦170,000, this Friday</p>
				</div>
			</figure>
		</div>
	</div>
</section>

<section class="en-problem">
	<div class="b-wrap en-problem__grid">
		<p class="b-eyebrow">The 9pm problem</p>
		<div>
			<p class="en-problem__big" data-scrub>A customer messages at 9pm. They ask three questions before they’ll trust you enough to call. By the time someone on your team sees it, they’ve already messaged your competitor.</p>
			<p class="en-problem__note">It isn’t a traffic problem. It’s a response problem, and no amount of extra marketing spend fixes it. Banks Business Engine replies at 9pm, and at 3am, in your voice.</p>
		</div>
	</div>
</section>

<section class="en-does" data-dark>
	<div class="en-does__pin">
		<div class="b-wrap en-does__grid">
			<div class="en-does__copy">
				<div class="en-head en-head--dark">
					<p class="b-eyebrow">What it does</p>
					<h2 data-split>Three jobs, done the moment a visitor asks.</h2>
				</div>
				<ol class="en-steps">
					<?php foreach ( $b_does as $b_i => $b_d ) : ?>
						<li class="en-step" data-step="<?php echo esc_attr( $b_d['key'] ); ?>">
							<span class="en-step__n"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span>
							<h3><?php echo esc_html( $b_d['title'] ); ?></h3>
							<p><?php echo esc_html( $b_d['text'] ); ?></p>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
			<div class="en-screens" aria-hidden="true">
				<div class="en-screen en-screen--answer">
					<p class="en-screen__label">Conversation</p>
					<div class="en-q">Do you deliver to Abuja?</div>
					<div class="en-a">Yes. Delivery to Abuja takes two to three working days and costs ₦6,500. Would you like me to start an order?</div>
					<p class="en-screen__meta">Answered on the spot</p>
				</div>
				<div class="en-screen en-screen--qualify">
					<p class="en-screen__label">Lead</p>
					<ul class="en-checks">
						<li><span>Service</span><strong>Website for a clinic</strong></li>
						<li><span>Budget</span><strong>₦500k to ₦1m</strong></li>
						<li><span>Timeline</span><strong>Within a month</strong></li>
						<li><span>Booked</span><strong>Tue 10:00, call</strong></li>
					</ul>
					<p class="en-screen__meta">Ready for you</p>
				</div>
				<div class="en-screen en-screen--pattern">
					<p class="en-screen__label">Insights · 30 days</p>
					<div class="en-bars">
						<?php foreach ( array( 38, 52, 46, 64, 58, 72, 80, 69, 86, 92 ) as $b_h ) : ?>
							<span style="--h:<?php echo esc_attr( $b_h ); ?>%"></span>
						<?php endforeach; ?>
					</div>
					<ul class="en-asked">
						<li><span>Most asked</span><strong>Prices and delivery</strong></li>
						<li><span>Top source</span><strong>Google search</strong></li>
					</ul>
					<p class="en-screen__meta">Example data</p>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="en-inside">
	<div class="b-wrap">
		<div class="en-head">
			<p class="b-eyebrow">What’s inside</p>
			<h2 data-split>Everything after the first hello.</h2>
			<p>One tool on your website, doing the work that usually needs a receptionist, a CRM and a few apps stitched together.</p>
		</div>
		<ul class="en-grid">
			<?php foreach ( $b_inside as $b_i => $b_f ) : ?>
				<li class="en-feat">
					<span class="en-feat__n"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $b_f[0] ); ?></h3>
					<p><?php echo esc_html( $b_f[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="en-safe" data-dark>
	<div class="b-wrap en-safe__grid">
		<div class="en-vault" aria-hidden="true">
			<span class="en-vault__ring"></span><span class="en-vault__ring"></span><span class="en-vault__ring"></span>
			<span class="en-vault__core">AES<br>256</span>
		</div>
		<div class="en-head en-head--dark">
			<p class="b-eyebrow">Data protection</p>
			<h2 data-split>Your data stays on your site.</h2>
			<p>Banks Business Engine keeps your leads and customers with your own business, not on a shared platform you don’t control. Every API key and credential is encrypted with AES-256-GCM before it touches the database, and every setup follows Nigeria’s Data Protection Act 2023.</p>
		</div>
	</div>
</section>

<section class="en-get">
	<div class="b-wrap">
		<div class="en-head">
			<p class="b-eyebrow">How to get it</p>
			<h2 data-split>Set up for you, then yours to run.</h2>
		</div>
		<ol class="en-get__steps">
			<li class="en-get__step" data-reveal><span>01</span><h3>Tell us about your business</h3><p>Your services, prices, hours and the questions customers ask most. The brief takes about 10 minutes.</p></li>
			<li class="en-get__step" data-reveal><span>02</span><h3>We set it up</h3><p>Installed on your site, trained on your business, connected to WhatsApp, Paystack and your calendar, and tested with real questions.</p></li>
			<li class="en-get__step" data-reveal><span>03</span><h3>It goes to work</h3><p>A monthly licence keeps the assistant live and the updates coming. Your leads, customers and data are always yours.</p></li>
		</ol>
		<div class="en-get__cta">
			<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_setup ); ?>" data-magnetic>Book a setup</a>
			<p>Coming to the Banks Solutions shop soon, with a licence key, updates and documentation.</p>
		</div>
	</div>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>About Banks Business Engine.</h2>
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
		<h2 class="s-cta__title" data-split>Stop losing the 9pm enquiry<span class="s-dot">.</span></h2>
		<p>Tell us about your business and we’ll come back within two working days with the setup, the timeline and the price.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_setup ); ?>" data-magnetic>Book a setup</a>
	</div>
</section>

<script type="application/ld+json">
<?php
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'               => 'SoftwareApplication',
				'name'                => 'Banks Business Engine',
				'url'                 => banks_main_url( '/banks-business-engine/' ),
				'applicationCategory' => 'BusinessApplication',
				'applicationSubCategory' => 'AI assistant and lead CRM',
				'operatingSystem'     => 'Web',
				'description'         => 'An AI assistant and lead CRM that answers website visitors in real time, qualifies them, books appointments and sends ready leads to a dashboard with a CRM, automations, WhatsApp alerts, Paystack payment links and insights.',
				'featureList'         => array_map(
					function ( $f ) {
						return $f[0];
					},
					$b_inside
				),
				'publisher'           => array(
					'@type' => 'Organization',
					'@id'   => banks_main_url( '/' ) . '#organization',
					'name'  => 'Banks Solutions',
					'url'   => banks_main_url( '/' ),
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
