<?php
/*
 * About (/about/), built as scenes: who we are with a map of where our clients are, the numbers,
 * the story told word by word, how we work as a stack of cards, the founder, the company facts,
 * questions, closing call. Copy: "Banks Solutions website: sitemap and copy" doc. Motion lives in
 * about.js; the map is drawn in full and every word is lit, so the page reads with JavaScript off.
 */
get_header();

$b_start = banks_route( '/start/', '/contact/' );
$b_wa    = 'https://wa.me/' . preg_replace( '/\D/', '', banks_detail( 'whatsapp' ) );
$b_mail  = banks_detail( 'email' );
$b_li    = banks_detail( 'linkedin' );

// Where clients are, by longitude and latitude, on a flat map, with where each label sits. Lagos is home.
$b_xy     = function ( $lon, $lat ) {
	return array( round( ( $lon + 180 ) / 360 * 1000, 1 ), round( ( 90 - $lat ) / 180 * 500, 1 ) );
};
$b_home   = $b_xy( 3.4, 6.5 );
$b_places = array(
	array( 'United States', -98, 39, 'start', 10, 22 ),
	array( 'Canada', -106, 56, 'start', 10, -10 ),
	array( 'United Kingdom', -2, 54, 'start', 11, -6 ),
	array( 'Kenya', 38, 0, 'start', 11, 5 ),
	array( 'Australia', 134, -25, 'end', -4, 24 ),
);

$b_numbers = array(
	array( '9.0', 1, 'Client rating' ),
	array( '7', 0, 'Brands built', '+' ),
	array( '6', 0, 'Countries with clients' ),
	array( '2', 0, 'Offices, Lagos and Ilorin' ),
);

$b_ways = array(
	array( 'Diagnose first', 'Before we suggest anything, we find out what is actually slowing the business down. Sometimes the answer is a new website. Sometimes it is a form, a follow-up or a fix to what you already have.' ),
	array( 'Honest about scope', 'You get a fixed price and a written scope before work starts. If a smaller fix would do, we say so, and if something is not worth building, we say that too.' ),
	array( 'Build in the open', 'You see the work as it happens: a clickable version early, progress you can follow, and releases in stages, so there is never a big reveal that misses the point.' ),
	array( 'AI in our own work', 'We use AI to research, draft, test and check, then people review every piece. It is how a focused team delivers at the pace of a much larger one.' ),
);

$b_facts = array(
	'Registered name' => banks_detail( 'legal' ),
	'RC number'       => banks_detail( 'rc' ),
	'Offices'         => banks_detail( 'locations' ),
	'Clients in'      => 'Nigeria, the United States, the United Kingdom, Canada, Kenya and Australia',
	'Founder'         => 'Promise Banks',
);

$b_faqs = array(
	array( 'What does Banks Solutions do?', 'Banks Solutions designs and builds websites, web apps and custom solutions, automation and AI for businesses in any industry. We also look after sites once they are live, and help businesses get found on Google and in AI search.' ),
	array( 'Where is Banks Solutions based?', 'In Nigeria, with offices in Lagos and Ilorin. We work with clients across Nigeria and in the United States, the United Kingdom, Canada, Kenya and Australia.' ),
	array( 'Who founded Banks Solutions?', 'Banks Solutions was founded by Promise Banks.' ),
	array( 'Is Banks Solutions a registered company?', 'Yes. Banks Solutions is the trading name of Banks Solution Limited, registered in Nigeria with RC number 8259372.' ),
	array( 'How is a small team able to take on big projects?', 'By diagnosing first, so the work is the right work, and by using AI in our own process for research, drafting, testing and checks, with people reviewing everything. That lets a focused team deliver at the pace of a much larger one.' ),
);
?>
<section class="ab-hero" data-dark data-hero>
	<div class="ab-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap ab-inner">
			<div class="ab-copy">
				<p class="b-eyebrow ab-eyebrow">About Banks Solutions</p>
				<h1 class="ab-title">A small team that builds like a big one<span class="s-dot">.</span></h1>
				<p class="ab-lede">Banks Solutions is a Nigerian technology company based in Lagos and Ilorin, founded by Promise Banks. We design and build websites, web apps and custom solutions, automation and AI for businesses in any industry, and we use AI in our own work so a focused team can deliver at the pace of a much larger one.</p>
				<div class="ab-actions">
					<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>" data-magnetic>Start a project</a>
					<a class="b-btn b-btn--line b-btn--lg" href="<?php echo esc_url( banks_route( '/work/', '/' ) ); ?>">See the work</a>
				</div>
			</div>
			<figure class="ab-map">
				<svg class="ab-map__svg" viewBox="185 70 720 280" role="img" aria-labelledby="ab-map-t">
					<title id="ab-map-t">Banks Solutions works from Lagos and Ilorin with clients in the United States, Canada, the United Kingdom, Kenya and Australia.</title>
					<defs>
						<pattern id="ab-dots" width="10" height="10" patternUnits="userSpaceOnUse"><circle cx="5" cy="5" r="1.1"></circle></pattern>
						<radialGradient id="ab-fade" cx="50%" cy="50%" r="60%"><stop offset="0" stop-color="#fff"></stop><stop offset="1" stop-color="#fff" stop-opacity="0"></stop></radialGradient>
						<mask id="ab-mask"><rect x="110" y="70" width="840" height="280" fill="url(#ab-fade)"></rect></mask>
					</defs>
					<g class="ab-map__grid" mask="url(#ab-mask)">
						<rect x="110" y="70" width="840" height="280" fill="url(#ab-dots)"></rect>
						<?php for ( $b_l = -150; $b_l <= 180; $b_l += 30 ) : ?>
							<line x1="<?php echo esc_attr( ( $b_l + 180 ) / 360 * 1000 ); ?>" y1="70" x2="<?php echo esc_attr( ( $b_l + 180 ) / 360 * 1000 ); ?>" y2="350"></line>
						<?php endfor; ?>
						<?php for ( $b_l = -30; $b_l <= 60; $b_l += 30 ) : ?>
							<line x1="110" y1="<?php echo esc_attr( ( 90 - $b_l ) / 180 * 500 ); ?>" x2="950" y2="<?php echo esc_attr( ( 90 - $b_l ) / 180 * 500 ); ?>"></line>
						<?php endfor; ?>
					</g>
					<?php foreach ( $b_places as $b_p ) : ?>
						<?php
						list( $b_x, $b_y ) = $b_xy( $b_p[1], $b_p[2] );
						// Bow each route upward from the line between home and the client.
						$b_mx = ( $b_home[0] + $b_x ) / 2;
						$b_my = ( $b_home[1] + $b_y ) / 2 - abs( $b_x - $b_home[0] ) * 0.28 - 18;
						?>
						<g class="ab-route">
							<path class="ab-route__arc" d="<?php echo esc_attr( "M{$b_home[0]} {$b_home[1]} Q{$b_mx} {$b_my} {$b_x} {$b_y}" ); ?>"></path>
							<circle class="ab-route__pin" cx="<?php echo esc_attr( $b_x ); ?>" cy="<?php echo esc_attr( $b_y ); ?>" r="4.2"></circle>
							<text class="ab-route__label" x="<?php echo esc_attr( $b_x + $b_p[4] ); ?>" y="<?php echo esc_attr( $b_y + $b_p[5] ); ?>" text-anchor="<?php echo esc_attr( $b_p[3] ); ?>"><?php echo esc_html( $b_p[0] ); ?></text>
						</g>
					<?php endforeach; ?>
					<g class="ab-home">
						<circle class="ab-home__ring" cx="<?php echo esc_attr( $b_home[0] ); ?>" cy="<?php echo esc_attr( $b_home[1] ); ?>" r="12"></circle>
						<circle class="ab-home__dot" cx="<?php echo esc_attr( $b_home[0] ); ?>" cy="<?php echo esc_attr( $b_home[1] ); ?>" r="5"></circle>
						<text class="ab-home__label" x="<?php echo esc_attr( $b_home[0] ); ?>" y="<?php echo esc_attr( $b_home[1] + 26 ); ?>" text-anchor="middle">Lagos · Ilorin</text>
					</g>
				</svg>
				<figcaption class="ab-map__cap"><span class="s-live"></span>Clients in 6 countries, from 2 offices in Nigeria</figcaption>
			</figure>
		</div>
	</div>
</section>

<section class="ab-numbers" aria-label="Banks Solutions in numbers">
	<dl class="b-wrap ab-numbers__grid">
		<?php foreach ( $b_numbers as $b_n ) : ?>
			<div class="ab-num" data-reveal>
				<dt><?php echo esc_html( $b_n[2] ); ?></dt>
				<dd><span data-count="<?php echo esc_attr( $b_n[0] ); ?>"<?php echo $b_n[1] ? ' data-decimals="' . esc_attr( $b_n[1] ) . '"' : ''; ?>><?php echo esc_html( $b_n[0] ); ?></span><?php echo esc_html( $b_n[3] ?? '' ); ?></dd>
			</div>
		<?php endforeach; ?>
	</dl>
</section>

<section class="ab-story">
	<div class="b-wrap ab-story__grid">
		<p class="b-eyebrow">Why we exist</p>
		<div class="ab-story__text">
			<p class="ab-story__big" data-scrub>Most businesses don’t need more software. They need the few things slowing them down fixed properly, by people who explain what they’re doing and stay around after launch.</p>
			<p>That is the job Banks Solutions was set up to do, for any business in any field. A hotel that needs bookings to arrive on their own. A bank that needs a site customers trust. A salon, a law firm, a fashion label or a foundation that needs to be found, and to turn visitors into customers.</p>
			<p>We are not built around one product. We build what the business needs, whether that is a website, a web app, an automation or an AI assistant, and we price it before we start.</p>
		</div>
	</div>
</section>

<section class="ab-ways" data-dark>
	<div class="b-wrap">
		<div class="ab-head ab-head--dark">
			<p class="b-eyebrow">How we work</p>
			<h2 data-split>Four habits behind every project.</h2>
		</div>
		<ol class="ab-ways__stack">
			<?php foreach ( $b_ways as $b_i => $b_w ) : ?>
				<li class="ab-way" style="--i:<?php echo esc_attr( $b_i ); ?>">
					<div class="ab-way__in">
						<span class="ab-way__n"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span>
						<h3><?php echo esc_html( $b_w[0] ); ?></h3>
						<p><?php echo esc_html( $b_w[1] ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="ab-founder">
	<div class="b-wrap ab-founder__grid">
		<figure class="ab-portrait" data-tilt>
			<?php if ( file_exists( get_template_directory() . '/assets/img/founder.jpg' ) ) : ?>
				<img src="<?php echo esc_url( banks_img( 'founder.jpg' ) ); ?>" alt="Promise Banks, founder of Banks Solutions" loading="lazy" decoding="async" width="800" height="1000">
			<?php else : ?>
				<span class="ab-portrait__mark" aria-hidden="true"><span>PB<span class="s-dot">.</span></span></span>
			<?php endif; ?>
		</figure>
		<div class="ab-founder__copy">
			<p class="b-eyebrow">The founder</p>
			<h2 data-split>Promise Banks</h2>
			<p class="ab-founder__role">Founder, Banks Solutions</p>
			<p>Promise Banks founded Banks Solutions to give businesses in any field a technology partner that diagnoses first, prices honestly and builds in the open.</p>
			<p class="ab-founder__links">
				<?php if ( $b_li ) : ?>
					<a href="<?php echo esc_url( $b_li ); ?>" target="_blank" rel="noopener">LinkedIn<span aria-hidden="true"> ↗</span><span class="b-sr"> (opens in a new tab)</span></a>
				<?php endif; ?>
				<a href="mailto:<?php echo esc_attr( $b_mail ); ?>"><?php echo esc_html( $b_mail ); ?></a>
			</p>
		</div>
	</div>
</section>

<section class="ab-facts">
	<div class="b-wrap ab-facts__grid">
		<div class="ab-head">
			<p class="b-eyebrow">Company facts</p>
			<h2 data-split>The details, in one place.</h2>
		</div>
		<dl class="ab-facts__list">
			<?php foreach ( $b_facts as $b_k => $b_v ) : ?>
				<div class="ab-fact" data-reveal><dt><?php echo esc_html( $b_k ); ?></dt><dd><?php echo esc_html( $b_v ); ?></dd></div>
			<?php endforeach; ?>
			<div class="ab-fact" data-reveal><dt>Email</dt><dd><a href="mailto:<?php echo esc_attr( $b_mail ); ?>"><?php echo esc_html( $b_mail ); ?></a></dd></div>
			<div class="ab-fact" data-reveal><dt>WhatsApp</dt><dd><a href="<?php echo esc_url( $b_wa ); ?>"><?php echo esc_html( banks_detail( 'whatsapp' ) ); ?></a></dd></div>
		</dl>
	</div>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>About us, answered.</h2>
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
		<h2 class="s-cta__title" data-split>Let’s see what’s slowing you down<span class="s-dot">.</span></h2>
		<p>Tell us about your business. Within two working days you’ll have what we’d build, how long it takes and a fixed price.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>" data-magnetic>Start the brief</a>
	</div>
</section>

<script type="application/ld+json">
<?php
$b_countries = array( 'Nigeria', 'United States', 'United Kingdom', 'Canada', 'Kenya', 'Australia' );
$b_org       = array(
	'@type'         => 'Organization',
	'@id'           => banks_main_url( '/' ) . '#organization',
	'name'          => 'Banks Solutions',
	'legalName'     => banks_detail( 'legal' ),
	'url'           => banks_main_url( '/' ),
	'email'         => $b_mail,
	'telephone'     => banks_detail( 'whatsapp' ),
	'description'   => 'Nigerian technology company that designs and builds websites, web apps and custom solutions, automation and AI for businesses in any industry.',
	'identifier'    => array(
		'@type'      => 'PropertyValue',
		'propertyID' => 'RC number (Corporate Affairs Commission, Nigeria)',
		'value'      => banks_detail( 'rc' ),
	),
	'founder'       => array_filter(
		array(
			'@type'  => 'Person',
			'name'   => 'Promise Banks',
			'sameAs' => $b_li,
		)
	),
	'address'       => array(
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
	'areaServed'    => array_map(
		function ( $c ) {
			return array(
				'@type' => 'Country',
				'name'  => $c,
			);
		},
		$b_countries
	),
	'contactPoint'  => array(
		'@type'       => 'ContactPoint',
		'contactType' => 'sales',
		'email'       => $b_mail,
		'telephone'   => banks_detail( 'whatsapp' ),
	),
);
if ( banks_detail( 'instagram' ) ) {
	$b_org['sameAs'] = array_values( array_filter( array( banks_detail( 'instagram' ), $b_li ) ) );
}
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'      => 'AboutPage',
				'name'       => 'About Banks Solutions',
				'url'        => banks_main_url( '/about/' ),
				'mainEntity' => array( '@id' => $b_org['@id'] ),
			),
			$b_org,
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
