<?php
/*
 * WordPress development for agencies and developers (/wordpress-development/), built as scenes:
 * a plugin file writing itself and passing review in the hero, what we build, how we work with
 * a team (pinned and sideways on wide screens), the standards every file meets, proof,
 * questions, closing call. Linked from the footer and the custom solutions page only, so this
 * is the one page that talks plugins and code. Motion lives in dev.js; every state is in the HTML.
 */
get_header();

$b_brief = add_query_arg( 'need', 'web-app', banks_route( '/start/', '/contact/' ) );
$b_phone = banks_detail( 'whatsapp' );
$b_wa    = $b_phone ? 'https://wa.me/' . preg_replace( '/\D/', '', $b_phone ) : '';

// The file in the hero editor, as [ token class, text ] pairs per line. '' is plain text.
$b_code = array(
	array( array( 'c', '/**' ) ),
	array( array( 'c', ' * Plugin Name: Client Bookings' ) ),
	array( array( 'c', ' * Author:      Banks Solutions' ) ),
	array( array( 'c', ' */' ) ),
	array( array( 'f', 'add_action' ), array( '', '( ' ), array( 's', "'rest_api_init'" ), array( '', ', ' ), array( 'k', 'function' ), array( '', ' () {' ) ),
	array( array( '', '	' ), array( 'f', 'register_rest_route' ), array( '', '( ' ), array( 's', "'bookings/v1'" ), array( '', ', ' ), array( 's', "'/slots'" ), array( '', ', ' ), array( 'k', 'array' ), array( '', '(' ) ),
	array( array( '', '		' ), array( 's', "'methods'" ), array( '', '             => ' ), array( 's', "'GET'" ), array( '', ',' ) ),
	array( array( '', '		' ), array( 's', "'callback'" ), array( '', '            => ' ), array( 's', "'cb_get_slots'" ), array( '', ',' ) ),
	array( array( '', '		' ), array( 's', "'permission_callback'" ), array( '', ' => ' ), array( 's', "'cb_can_book'" ), array( '', ',' ) ),
	array( array( '', '	) );' ) ),
	array( array( '', '} );' ) ),
);

$b_checks = array( 'WordPress Coding Standards', 'Escaped output, sanitised input', 'Nonces and capability checks', 'Ready to translate' );

$b_builds = array(
	array( 'Custom plugins', 'Features WordPress doesn’t have out of the box: booking engines, portals, calculators, CRMs, licence servers, admin tools.' ),
	array( 'Custom themes', 'Hand-coded themes with no page builder weight, built from your designs and fast on real phones.' ),
	array( 'Integrations', 'Paystack, WhatsApp Cloud API, Twilio, Google Calendar, Slack, OpenAI and the REST APIs your client already pays for.' ),
	array( 'Extending what’s there', 'New features on an existing plugin or theme, once we’ve read the code and agreed it’s safe to build on.' ),
);

$b_flow = array(
	array( 'Spec', 'You send the brief or the spec. We ask the awkward questions now, not in week three.' ),
	array( 'Quote', 'A fixed price and a timeline from the spec, with ownership and licensing agreed before work starts.' ),
	array( 'Build', 'In your repository or ours, on a staging site, with commits you can follow as we go.' ),
	array( 'Review', 'You test it on staging. We fix what you find and walk your team through the code.' ),
	array( 'Handover', 'Documented, versioned and ready for your client, with support after launch if you want it.' ),
);

$b_standards = array(
	array( 'Coding standards', 'Every file follows the WordPress Coding Standards and is checked before it ships.' ),
	array( 'Security', 'Output escaped, input sanitised, nonces and capability checks on every action, secrets encrypted.' ),
	array( 'No collisions', 'Every function, hook, option and table is prefixed, so it never fights another plugin.' ),
	array( 'Speed', 'Scripts load only where they’re used, and pages stay usable in under 2.5 seconds on 4G.' ),
	array( 'Clean exit', 'Settings and data are removed on uninstall when the client asks for it, and kept when they don’t.' ),
	array( 'Readable history', 'Small commits with clear messages, so the next developer can see why, not just what.' ),
);

$b_faqs = array(
	array( 'Do you build WordPress plugins for agencies?', 'Yes. Banks Solutions builds custom WordPress plugins and themes for agencies, freelancers and in-house teams, from a single feature to a full product, to the WordPress Coding Standards.' ),
	array( 'How do you price plugin development?', 'From a spec. Send what the plugin needs to do and we come back within two working days with a fixed price and a timeline.' ),
	array( 'Who owns the code?', 'Ownership and licensing are agreed in writing before work starts, as part of the quote, so there are no surprises at handover.' ),
	array( 'Can you work in our repository and process?', 'Yes. We can work in your Git repository, on your staging site and through your review process, or run the project end to end in ours.' ),
	array( 'Can you fix or extend an existing plugin?', 'Often, yes. We read the code first and tell you honestly whether it is safe to build on or better to rebuild.' ),
	array( 'What have you built?', 'Our own product, Banks Business Engine, is a WordPress plugin with an AI assistant, CRM, bookings, a REST API, licensing and encrypted credentials. Client work includes custom systems and web apps such as the one we built for 1904 Solutions.' ),
);
?>
<section class="dv-hero" data-dark data-hero>
	<div class="dv-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap dv-inner">
			<div class="dv-copy">
				<p class="b-eyebrow dv-eyebrow">For agencies and developers</p>
				<h1 class="dv-title">WordPress plugins, built properly<span class="s-dot">.</span></h1>
				<p class="dv-lede">Banks Solutions builds custom WordPress plugins and themes for agencies, developers and the businesses they serve. Clean, documented code to WordPress Coding Standards, delivered on your timeline.</p>
				<div class="dv-actions">
					<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_brief ); ?>" data-magnetic>Send a spec</a>
					<?php if ( $b_wa ) : ?>
						<a class="b-btn b-btn--line b-btn--lg" href="<?php echo esc_url( $b_wa . '?text=' . rawurlencode( 'Hi Banks Solutions, I have a WordPress development project.' ) ); ?>">Talk on WhatsApp</a>
					<?php endif; ?>
				</div>
			</div>

			<figure class="dv-editor" aria-label="An example plugin file that has passed review">
				<div class="dv-editor__bar"><i></i><i></i><i></i><span>client-bookings.php</span></div>
				<pre class="dv-code"><code><?php
				foreach ( $b_code as $b_n => $b_line ) {
					echo '<span class="dv-ln"><span class="dv-ln__n" aria-hidden="true">' . esc_html( $b_n + 1 ) . '</span>';
					foreach ( $b_line as $b_tok ) {
						echo $b_tok[0] ? '<span class="t-' . esc_attr( $b_tok[0] ) . '">' . esc_html( $b_tok[1] ) . '</span>' : esc_html( $b_tok[1] );
					}
					echo '</span>';
				}
				?></code></pre>
				<div class="dv-review">
					<p class="dv-review__head"><span class="s-live"></span>Review passed</p>
					<ul class="dv-review__list">
						<?php foreach ( $b_checks as $b_c ) : ?>
							<li><span aria-hidden="true">✓</span><?php echo esc_html( $b_c ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</figure>
		</div>
	</div>
</section>

<section class="dv-builds">
	<div class="b-wrap">
		<div class="dv-head">
			<p class="b-eyebrow">What we build</p>
			<h2 data-split>The part of the project your team would rather hand off.</h2>
		</div>
		<ol class="dv-grid">
			<?php foreach ( $b_builds as $b_i => $b_b ) : ?>
				<li class="dv-card" data-reveal>
					<span class="dv-card__n"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $b_b[0] ); ?></h3>
					<p><?php echo esc_html( $b_b[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="dv-flow" data-dark>
	<div class="dv-flow__pin">
		<div class="b-wrap dv-flow__head">
			<div class="dv-head dv-head--dark">
				<p class="b-eyebrow">How we work with your team</p>
				<h2 data-split>Five steps, no surprises at handover.</h2>
			</div>
			<div class="dv-flow__bar" aria-hidden="true"><span></span></div>
		</div>
		<ol class="dv-track">
			<?php foreach ( $b_flow as $b_i => $b_f ) : ?>
				<li class="dv-stepcard">
					<span class="dv-stepcard__n"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $b_f[0] ); ?></h3>
					<p><?php echo esc_html( $b_f[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="dv-std">
	<div class="b-wrap dv-std__grid">
		<div class="dv-head">
			<p class="b-eyebrow">The standards</p>
			<h2 data-split>What every file we hand over has in common.</h2>
			<p>Written so the next developer, yours or ours, can open it and carry on.</p>
		</div>
		<dl class="dv-std__list">
			<?php foreach ( $b_standards as $b_s ) : ?>
				<div class="dv-std__item" data-reveal>
					<dt><?php echo esc_html( $b_s[0] ); ?></dt>
					<dd><?php echo esc_html( $b_s[1] ); ?></dd>
				</div>
			<?php endforeach; ?>
		</dl>
	</div>
</section>

<section class="dv-proof">
	<div class="b-wrap">
		<div class="dv-head">
			<p class="b-eyebrow">Built by us</p>
			<h2 data-split>Our own plugin runs real businesses.</h2>
		</div>
		<div class="dv-proof__grid">
			<a class="dv-proof__card dv-proof__card--main" href="<?php echo esc_url( banks_route( '/banks-business-engine/', '/shop/' ) ); ?>" data-dark data-reveal>
				<span class="dv-proof__tag">Our product</span>
				<span class="dv-proof__title">Banks Business Engine</span>
				<span class="dv-proof__text">A WordPress plugin with an AI assistant, CRM, bookings, automations, a REST API, licensing with updates, and credentials encrypted with AES-256-GCM.</span>
				<span class="dv-proof__go">See the product <span aria-hidden="true">→</span></span>
			</a>
			<a class="dv-proof__card" href="<?php echo esc_url( banks_route( '/work/1904-solutions/', '/work/' ) ); ?>" data-reveal>
				<span class="dv-proof__tag">Client work</span>
				<span class="dv-proof__title">1904 Solutions</span>
				<span class="dv-proof__text">A custom system and web app built around how a car wash and hospitality business runs.</span>
				<span class="dv-proof__go">See the project <span aria-hidden="true">→</span></span>
			</a>
			<a class="dv-proof__card" href="<?php echo esc_url( banks_route( '/labs/', '/shop/' ) ); ?>" data-reveal>
				<span class="dv-proof__tag">Banks Labs</span>
				<span class="dv-proof__title">How we build</span>
				<span class="dv-proof__text">The software we ship, where it stands and the rules every release has to pass.</span>
				<span class="dv-proof__go">Visit Labs <span aria-hidden="true">→</span></span>
			</a>
		</div>
	</div>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>About working with us.</h2>
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
		<h2 class="s-cta__title" data-split>Send us the spec<span class="s-dot">.</span></h2>
		<p>Tell us what the plugin or theme needs to do. We’ll come back within two working days with a fixed price and a timeline.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_brief ); ?>" data-magnetic>Send a spec</a>
	</div>
</section>

<script type="application/ld+json">
<?php
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'       => 'Service',
				'name'        => 'WordPress plugin and theme development',
				'serviceType' => 'WordPress development',
				'url'         => banks_main_url( '/wordpress-development/' ),
				'description' => 'Custom WordPress plugins, themes and integrations for agencies, developers and businesses, built to WordPress Coding Standards and priced from a spec.',
				'audience'    => array(
					'@type'        => 'BusinessAudience',
					'audienceType' => 'Agencies and developers',
				),
				'provider'    => array(
					'@type' => 'Organization',
					'@id'   => banks_main_url( '/' ) . '#organization',
					'name'  => 'Banks Solutions',
					'url'   => banks_main_url( '/' ),
				),
				'areaServed'  => 'Worldwide',
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
