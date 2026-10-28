<?php
/*
 * Solutions hub (/solutions/), built as scenes: hero with the six solutions in orbit, "start where
 * it hurts" (symptom to solution), the six in depth as stacking cards, prices at a glance, the
 * fields we work in, questions, closing call. Copy: "Banks Solutions website: sitemap and copy" doc.
 * Motion lives in solutions.js; everything here reads in full with JavaScript off.
 */
get_header();

$b_start = banks_route( '/start/', '/contact/' );

$b_solutions = array(
	array(
		'title'  => 'Websites & e-commerce',
		'short'  => 'Websites',
		'pain'   => 'Visitors arrive and leave without a word.',
		'line'   => 'A website that does a job, not one that just exists.',
		'answer' => 'Business websites start at ₦499,000 and take about 5 weeks. Online stores with Paystack start at ₦750,000 and take about 8 weeks. Both are built around how your customers decide.',
		'items'  => array( 'Business websites', 'Online stores with Paystack', 'Landing pages', 'Copy guidance', 'Fast on mobile data', 'Launch support' ),
		'price'  => 'From ₦499,000 · about 5 weeks',
		'url'    => banks_route( '/solutions/websites/', '/services/digital-foundation/' ),
	),
	array(
		'title'  => 'Web apps & custom solutions',
		'short'  => 'Web apps',
		'pain'   => 'Nothing off the shelf does what you need.',
		'line'   => 'Software that fits the way you already work.',
		'answer' => 'Client portals, booking systems, dashboards, membership sites and internal tools, scoped from a short brief and paid in stages. You own the code, and it is documented so another developer could take over.',
		'items'  => array( 'Client and member portals', 'Booking and scheduling', 'Order and inventory tools', 'Dashboards and reports', 'Paystack and Flutterwave payments', 'WhatsApp, Zoho and HubSpot links' ),
		'price'  => 'Priced from a written spec',
		'url'    => banks_route( '/solutions/web-apps/', '/services/' ),
	),
	array(
		'title'  => 'Automation & CRM',
		'short'  => 'Automation',
		'pain'   => 'Leads go cold in WhatsApp before anyone replies.',
		'line'   => 'Systems, not spreadsheets.',
		'answer' => 'Every enquiry captured, followed up and tracked to payment, with WhatsApp first because that is where Nigerian customers talk. We set up Zoho, HubSpot or a custom system.',
		'items'  => array( 'CRM setup', 'WhatsApp automation', 'Lead capture', 'Follow-up sequences', 'Invoices and reminders', 'Team dashboards' ),
		'price'  => 'From ₦800,000 + ₦250,000 a month',
		'url'    => banks_route( '/solutions/automation-crm/', '/services/automation-crm/' ),
	),
	array(
		'title'  => 'AI solutions',
		'short'  => 'AI',
		'pain'   => 'The same questions eat your team’s whole day.',
		'line'   => 'AI, aimed at a specific job you can name.',
		'answer' => 'Assistants that answer routine customer questions, tools that sort enquiries, and systems that draft documents or find answers in your own files. We will also tell you when a simpler fix will do more for less.',
		'items'  => array( 'Customer assistants', 'Enquiry sorting', 'Document drafting', 'Search across your files', 'Banks Business Engine' ),
		'price'  => 'Scoped to one job at a time',
		'url'    => banks_route( '/solutions/ai/', '/services/ai-custom-solutions/' ),
	),
	array(
		'title'  => 'Care plans',
		'short'  => 'Care',
		'pain'   => 'Something breaks and nobody knows who to call.',
		'line'   => 'Someone who already knows your setup.',
		'answer' => 'Updates, verified backups, security, monitoring and a monthly allowance for changes, handled by a named person. Plans start at ₦150,000 a month.',
		'items'  => array( 'Updates', 'Verified backups', 'Security monitoring', 'Uptime checks', 'Monthly changes', 'A named contact' ),
		'price'  => 'From ₦150,000 a month',
		'url'    => banks_route( '/solutions/care-plans/', '/services/managed-technology/' ),
	),
	array(
		'title'  => 'SEO & AI search',
		'short'  => 'SEO & AEO',
		'pain'   => 'Customers ask Google and ChatGPT, and find your competitor.',
		'line'   => 'Be the answer, on Google and in AI.',
		'answer' => 'Search engine optimisation (SEO) and answer engine optimisation (AEO), done together: clear answers, structured data, consistent business facts and fast pages, so Google ranks you and ChatGPT, Gemini and Perplexity quote you.',
		'items'  => array( 'Technical SEO', 'Structured data', 'Answer-first content', 'Business facts across the web', 'Page speed', 'AI visibility checks' ),
		'price'  => 'SEO and AEO, built together',
		'url'    => banks_route( '/solutions/seo-aeo/', '/aeo/' ),
	),
);

$b_prices = array(
	array( 'Business website', 499000, '', 'About 5 weeks' ),
	array( 'Online store with Paystack', 750000, '', 'About 8 weeks' ),
	array( 'Automation & CRM', 800000, ' + ₦250,000 a month', 'Scoped from the brief' ),
	array( 'Care plan', 150000, ' a month', 'Ongoing, cancel any time' ),
	array( 'Web apps, custom solutions and AI', 0, 'Priced from a written spec', 'Timeline before you commit' ),
);

$b_fields  = array( 'Finance', 'Legal', 'Hospitality', 'Education', 'Health', 'Non-profit', 'Fashion' );
$b_places  = array( 'Nigeria', 'United States', 'United Kingdom', 'Canada', 'Kenya', 'Australia' );

$b_faqs = array(
	array( 'What does Banks Solutions build?', 'Banks Solutions, a technology company based in Lagos and Ilorin, Nigeria, builds six kinds of system: websites and online stores, web apps and custom solutions, automation and CRM, AI solutions, care plans, and SEO for Google and AI search. Most clients start with one and add others as the business grows.' ),
	array( 'How do I know which solution I need?', 'Start with the brief. It takes about 10 minutes and asks what is slowing the business down. Within two working days we come back with what we would build, how long it takes and what it costs. We will also tell you which solutions you do not need.' ),
	array( 'Can you combine solutions in one project?', 'Yes. A common pairing is a website with automation, so every enquiry from the site lands in a CRM and gets a WhatsApp reply. That takes about 8 weeks. You get one plan, one timeline and one client portal for the whole project.' ),
	array( 'How much do your solutions cost?', 'Websites start at ₦499,000 and online stores at ₦750,000. Automation and CRM starts at ₦800,000 plus ₦250,000 a month, and care plans at ₦150,000 a month. Web apps, custom solutions and AI are priced from a written spec, so you see the full cost before you commit.' ),
	array( 'Do you only work with certain industries?', 'No. We work with businesses in any field. Clients include a microfinance bank, law firms, a hotel, a school, a medical practice and a foundation, in Nigeria, the United States, the United Kingdom, Canada, Kenya and Australia. Fashion brands are welcome too.' ),
);
?>
<section class="sl-hero" data-dark data-hero>
	<div class="sl-hero__stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap sl-hero__inner">
			<div class="sl-hero__copy">
				<p class="b-eyebrow sl-hero__eyebrow"><span class="s-live" aria-hidden="true"></span>Solutions · Six systems, one partner</p>
				<h1 class="sl-hero__title" data-split-hero>Whatever the business runs on, we can build it<span class="s-dot">.</span></h1>
				<p class="sl-hero__lede">Banks Solutions builds six kinds of system: websites, web apps and custom solutions, automation and CRM, AI, care plans, and SEO for Google and AI search. Most clients start with one. The brief tells us which, and often which ones you don’t need.</p>
				<div class="sl-hero__actions">
					<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>" data-magnetic>Start a project</a>
					<a class="b-btn b-btn--line b-btn--lg" href="#sl-pain">Find your starting point</a>
				</div>
			</div>
			<div class="sl-orbit" aria-hidden="true">
				<span class="sl-orbit__ring"></span>
				<span class="sl-orbit__ring sl-orbit__ring--2"></span>
				<span class="sl-orbit__core">Your<br>business</span>
				<?php foreach ( $b_solutions as $b_i => $b_s ) : ?>
					<span class="sl-node" style="--a:<?php echo esc_attr( $b_i * 60 - 90 ); ?>deg">
						<span class="sl-node__spoke"></span>
						<span class="sl-node__pos"><span class="sl-node__chip"><i><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></i><?php echo esc_html( $b_s['short'] ); ?></span></span>
					</span>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<section class="sl-pain" id="sl-pain">
	<div class="b-wrap">
		<div class="sl-pain__head">
			<p class="b-eyebrow">Start where it hurts</p>
			<h2 data-split>Which of these sounds like your business?</h2>
		</div>
		<ol class="sl-pain__list">
			<?php foreach ( $b_solutions as $b_i => $b_s ) : ?>
				<li>
					<a class="sl-row" href="#sl-<?php echo esc_attr( $b_i + 1 ); ?>">
						<span class="sl-row__num"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span>
						<span class="sl-row__pain"><?php echo esc_html( $b_s['pain'] ); ?></span>
						<span class="sl-row__arrow" aria-hidden="true"><span></span></span>
						<span class="sl-row__fix"><?php echo esc_html( $b_s['title'] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="sl-deep" aria-label="The six solutions">
	<div class="b-wrap sl-deep__head">
		<p class="b-eyebrow">What we build</p>
		<h2 data-split>Six systems, each built to do one job well.</h2>
	</div>
	<div class="b-wrap sl-stack">
		<?php foreach ( $b_solutions as $b_i => $b_s ) : ?>
			<article class="sl-card" id="sl-<?php echo esc_attr( $b_i + 1 ); ?>"<?php echo $b_i % 2 ? ' data-dark' : ''; ?>>
				<div class="sl-card__inner" data-spot>
					<div class="sl-card__main">
						<p class="sl-card__num"><?php echo esc_html( sprintf( '%02d / 06', $b_i + 1 ) ); ?></p>
						<h3 class="sl-card__title"><?php echo esc_html( $b_s['title'] ); ?></h3>
						<p class="sl-card__line"><?php echo esc_html( $b_s['line'] ); ?></p>
						<p class="sl-card__answer"><?php echo esc_html( $b_s['answer'] ); ?></p>
						<p class="sl-card__price"><?php echo esc_html( $b_s['price'] ); ?></p>
						<a class="sl-card__go" href="<?php echo esc_url( $b_s['url'] ); ?>">Explore <?php echo esc_html( strtolower( $b_s['short'] ) === 'ai' ? 'AI' : $b_s['short'] ); ?> <span aria-hidden="true">→</span></a>
					</div>
					<div class="sl-card__side">
						<span class="sl-card__big" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span>
						<p class="sl-card__label">What’s included</p>
						<ul class="sl-card__items">
							<?php foreach ( $b_s['items'] as $b_item ) : ?>
								<li><?php echo esc_html( $b_item ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
					<span class="sl-card__shade" aria-hidden="true"></span>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<section class="sl-prices">
	<div class="b-wrap sl-prices__grid">
		<div class="sl-prices__head">
			<p class="b-eyebrow">Prices at a glance</p>
			<h2 data-split>How much does it cost?</h2>
			<p>Starting prices in naira, before anything is built. Every quote includes structure, copy guidance, mobile performance and launch support, and most projects are paid half at the start and half on delivery.</p>
		</div>
		<table class="sl-table">
			<caption class="b-sr">Banks Solutions starting prices and timelines</caption>
			<thead><tr><th scope="col">Solution</th><th scope="col">Starts at</th><th scope="col">Timeline</th></tr></thead>
			<tbody>
				<?php foreach ( $b_prices as $b_p ) : ?>
					<tr>
						<th scope="row"><?php echo esc_html( $b_p[0] ); ?></th>
						<td class="sl-table__price">
							<?php if ( $b_p[1] ) : ?>
								<strong>₦<span data-naira="<?php echo esc_attr( $b_p[1] ); ?>"><?php echo esc_html( number_format( $b_p[1] ) ); ?></span></strong><?php echo esc_html( $b_p[2] ); ?>
							<?php else : ?>
								<strong><?php echo esc_html( $b_p[2] ); ?></strong>
							<?php endif; ?>
						</td>
						<td><?php echo esc_html( $b_p[3] ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</section>

<section class="sl-fields" data-dark>
	<div class="b-wrap sl-fields__head">
		<p class="b-eyebrow">Any field, any distance</p>
		<h2 data-split>Built for businesses in any field.</h2>
		<p>Banks Solutions, a technology company based in Lagos and Ilorin, Nigeria, has built for businesses in 6 countries. Projects run through the client portal, so distance never slows the work.</p>
	</div>
	<div class="sl-fields__rows" aria-hidden="true">
		<p class="sl-fields__row"><?php echo esc_html( implode( ' / ', $b_fields ) ); ?> /</p>
		<p class="sl-fields__row sl-fields__row--2"><?php echo esc_html( implode( ' · ', $b_places ) ); ?> ·</p>
	</div>
	<p class="b-sr">Industries: <?php echo esc_html( implode( ', ', $b_fields ) ); ?>. Countries: <?php echo esc_html( implode( ', ', $b_places ) ); ?>.</p>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>What people ask before choosing.</h2>
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
		<h2 class="s-cta__title" data-split>Not sure where to start? Start with the brief<span class="s-dot">.</span></h2>
		<p>Ten minutes on the brief, and within two working days we’ll tell you what we’d build, how long it takes and what it costs.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>" data-magnetic="0.45">Start a project</a>
	</div>
</section>

<script type="application/ld+json">
<?php
$b_org = array(
	'@type' => 'Organization',
	'name'  => 'Banks Solutions',
	'url'   => banks_main_url( '/' ),
);
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'           => 'ItemList',
				'name'            => 'Banks Solutions: solutions',
				'itemListElement' => array_map(
					function ( $s, $i ) use ( $b_org ) {
						return array(
							'@type'    => 'ListItem',
							'position' => $i + 1,
							'item'     => array(
								'@type'       => 'Service',
								'name'        => $s['title'],
								'description' => $s['answer'],
								'url'         => $s['url'],
								'provider'    => $b_org,
								'areaServed'  => 'Worldwide',
							),
						);
					},
					$b_solutions,
					array_keys( $b_solutions )
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
	JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG
);
?>
</script>
<?php
get_footer();
