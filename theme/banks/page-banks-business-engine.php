<?php
/*
 * Banks Business Engine (/banks-business-engine/), the product page, built as scenes: a console
 * where an enquiry becomes a qualified lead and a booking, the 9pm problem, the three things it
 * does (pinned on wide screens), everything inside, data protection, how to get it, questions,
 * closing call. Every capability uses the shared map (template-parts/lab-capabilities.php). Copy: "Banks Solutions website: sitemap and copy" doc, the old homepage copy and
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

// Every capability, by area, from the plugin itself (v0.12). Shown with the shared capability map.
$b_caps = array(
	'eyebrow' => 'Every capability',
	'title'   => 'Everything after the first hello.',
	'lede'    => 'One tool on your website, doing the work that usually needs a receptionist, a CRM, a booking app, a payment link and a few automations stitched together.',
	'items'   => array(
		array(
			'key'   => 'assistant',
			'title' => 'The AI assistant',
			'blurb' => 'A chat on your website that answers in your voice, from what you have told it.',
			'feats' => array(
				array( 'Answers in real time', 'Every question answered the moment it is asked, at 9pm and at 3am.' ),
				array( 'Only from approved knowledge', 'It answers from the business information you approve, never invented, and offers only real, available times.' ),
				array( 'Its own name and playbook', 'Name the assistant and tell it in plain words who to send where, what to ask and what the next step is.' ),
				array( 'Your choice of AI', 'Runs on OpenAI or Groq with your own key, so you see and pay the real model cost. Demo mode works with no setup.' ),
				array( 'Knowledge that keeps itself current', 'Your blog posts and glossary sync into its knowledge on their own, with a link back to the full article.' ),
				array( 'Voice typing', 'Visitors can speak their message instead of typing it, tuned for Nigerian English. They still check it before sending.' ),
				array( 'Welcome and suggested questions', 'A welcome message and up to four suggested questions, so visitors know what to ask.' ),
				array( 'Enquiry form inside the chat', 'One tap and the chat asks for name, service, contact and message, one question at a time, and files a proper enquiry.' ),
				array( 'Your look and sound', 'Brand colours, launcher position and three message tones. Visitors can mute them.' ),
				array( 'Test before you go live', 'Try real customer conversations, qualification and booking in the dashboard before switching the public assistant on.' ),
			),
		),
		array(
			'key'   => 'inbox',
			'title' => 'Inbox',
			'blurb' => 'Every conversation and enquiry, in one place you can step into.',
			'feats' => array(
				array( 'Every chat, live', 'Read along with every conversation your assistant has had.' ),
				array( 'Reply or take over', 'Answer a visitor yourself, or take the conversation over from the assistant.' ),
				array( 'Form enquiries', 'Enquiries from the chat form arrive as their own entries, with unread ones marked.' ),
			),
		),
		array(
			'key'   => 'crm',
			'title' => 'Leads and CRM',
			'blurb' => 'Every visitor who asks becomes a lead you can act on.',
			'feats' => array(
				array( 'Qualifies while it talks', 'Picks up the service, budget and timeline as the conversation goes, and hands you a lead that is ready.' ),
				array( 'Intent score', 'Each lead is scored out of 100 and labelled high, medium or low, with the next step suggested.' ),
				array( 'Pipeline, as a list or a board', 'Move leads through your stages and see each lead’s full journey and next action.' ),
				array( 'Customers', 'Customer history, connected leads and recent activity in one place.' ),
				array( 'Your services', 'The services you sell power the qualification and what the assistant recommends.' ),
			),
		),
		array(
			'key'   => 'bookings',
			'title' => 'Bookings',
			'blurb' => 'Appointments booked inside the conversation, from your real hours.',
			'feats' => array(
				array( 'Booked in the chat', 'The assistant offers slots from your own working hours and books the visitor in.' ),
				array( 'Google Calendar sync', 'Confirmed bookings appear in your calendar, and cancelled ones are removed again.' ),
				array( 'Reminder emails', 'Customers get a reminder before their booking, with a private link to reschedule or cancel. You are told when they do.' ),
				array( 'Reschedule from the dashboard', 'Move a booking yourself, or send the customer their manage-my-booking link.' ),
				array( 'Availability controls', 'Set your hours and check any slot before you promise it.' ),
			),
		),
		array(
			'key'   => 'payments',
			'title' => 'Payments',
			'blurb' => 'Get paid from the same place the lead came in.',
			'feats' => array(
				array( 'Paystack links', 'Send a payment link from any lead. Money goes straight to your own Paystack account.' ),
				array( 'Payments that trigger the next step', 'A payment received can start an automation, such as a thank-you or a task for the team.' ),
			),
		),
		array(
			'key'   => 'automations',
			'title' => 'Automations',
			'blurb' => 'Turn business events into notifications and follow-ups, without another manual step.',
			'feats' => array(
				array( 'Eight ready recipes', 'New lead alert, qualified lead follow-up, booking confirmation, post-booking and completed consultation follow-ups, inactive lead reminder and two WhatsApp confirmations.' ),
				array( 'A builder for your own', 'Start from a lead created, qualified, gone quiet, a booking made or completed, or a payment received. Add conditions, then actions.' ),
				array( 'Actions', 'Email you or the customer, WhatsApp the customer, post to Slack, move the lead’s status, call a webhook or create a task.' ),
				array( 'Tasks', 'Follow-ups land as tasks for the team, so nothing depends on memory.' ),
				array( 'A record of every run', 'Email activity and every automation run are logged, so you can see what went out and when.' ),
			),
		),
		array(
			'key'   => 'alerts',
			'title' => 'WhatsApp, SMS and Slack',
			'blurb' => 'You hear about every lead where you already are.',
			'feats' => array(
				array( 'WhatsApp through Meta', 'Notifications through Meta’s own WhatsApp Cloud API, free for up to five verified numbers.' ),
				array( 'SMS and WhatsApp through Twilio', 'A second route for alerts and customer confirmations.' ),
				array( 'Slack', 'New leads posted to a Slack channel for the team.' ),
				array( 'Test every channel', 'Send a test message from the dashboard before you rely on it.' ),
			),
		),
		array(
			'key'   => 'insights',
			'title' => 'Command center and insights',
			'blurb' => 'What is happening today, and what is working over time.',
			'feats' => array(
				array( 'Today at a glance', 'What needs attention, the lead journey and the latest movement, the moment you open the dashboard.' ),
				array( 'Conversion funnel', 'How many leads reached each stage and how long they stayed, over 30 days, 90 days or 12 months.' ),
				array( 'Sources that pay', 'Which sources bring leads, and which bring paying customers.' ),
				array( 'Pipeline and bookings trends', 'Where your pipeline stands, and leads and bookings over the last 30 days.' ),
				array( 'Automation reliability', 'How each automation is performing, so a broken follow-up never goes unnoticed.' ),
				array( 'Website analytics', 'Visitors, page views and Google searches from Google Analytics and Search Console, in the same dashboard.' ),
			),
		),
		array(
			'key'   => 'setup',
			'title' => 'Setup, updates and safety',
			'blurb' => 'Quick to start, kept current, and your data stays yours.',
			'feats' => array(
				array( 'Five-minute setup', 'A guided wizard: your business, one service, what the assistant should know, your booking hours and going live.' ),
				array( 'Updates built in', 'New versions arrive on your website’s own Plugins page, ready to install like any other update.' ),
				array( 'Encrypted keys', 'Every API key and credential is encrypted with AES-256-GCM before it is stored.' ),
				array( 'Your data stays on your site', 'Leads and customers live with your own website. Setups follow Nigeria’s Data Protection Act 2023.' ),
				array( 'Nothing is lost if you stop', 'If the licence lapses, the public assistant pauses but your dashboard, leads and bookings stay.' ),
			),
		),
	),
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
				<?php if ( banks_route( '/labs/' ) ) : ?><a class="lp-back" href="<?php echo esc_url( banks_route( '/labs/' ) ); ?>"><span aria-hidden="true">←</span> Banks Labs</a><?php endif; ?>
				<p class="b-eyebrow en-eyebrow">Banks Business Engine · AI assistant and lead CRM</p>
				<h1 class="en-title">Every enquiry answered, qualified and followed up<span class="s-dot">.</span></h1>
				<p class="en-lede">Banks Business Engine is an AI assistant from Banks Solutions that answers your website visitors in real time, qualifies them and sends ready leads to a built-in dashboard with bookings and automations. It works on your website, in your voice.</p>
				<div class="en-actions">
					<button type="button" class="b-btn b-btn--signal b-btn--lg en-try" data-magnetic hidden>Try it live</button>
					<a class="b-btn b-btn--signal b-btn--lg en-setup" href="<?php echo esc_url( $b_setup ); ?>" data-magnetic>Book a setup</a>
					<a class="b-btn b-btn--line b-btn--lg" href="#capabilities">See every capability</a>
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

<?php get_template_part( 'template-parts/lab-capabilities', null, array( 'name' => 'Banks Business Engine', 'groups' => $b_caps ) ); ?>

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
$b_feature_list = array();
foreach ( $b_caps['items'] as $b_g ) {
	foreach ( $b_g['feats'] as $b_f ) {
		$b_feature_list[] = $b_f[0];
	}
}
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
				'featureList'         => $b_feature_list,
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
