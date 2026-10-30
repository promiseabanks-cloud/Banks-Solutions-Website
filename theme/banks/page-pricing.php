<?php
/*
 * Pricing (/pricing/), built as scenes: a split-flap board of starting prices, the six solutions
 * priced in full, how payment works, what changes a price, questions, closing call.
 * Copy: "Banks Solutions website: sitemap and copy" doc. Motion lives in pricing.js; the board is
 * plain text first, so everything reads with JavaScript off.
 */
get_header();

$b_start = banks_route( '/start/', '/contact/' );

// The board: solution, from, time. Kept short so each row fits the flaps.
$b_board = array(
	array( 'Business website', '₦499,000', '~5 weeks' ),
	array( 'Online store', '₦750,000', '~8 weeks' ),
	array( 'Web app', 'From a spec', 'In the spec' ),
	array( 'Automation & CRM', '₦800k+₦250k/mo', '6–12 weeks' ),
	array( 'AI build', 'From a spec', '1 job first' ),
	array( 'Care plan', '₦150k a month', 'Monthly' ),
	array( 'SEO & AI search', 'From the audit', 'Monthly' ),
);
$b_cols  = array( 16, 14, 11 );

$b_cards = array(
	array(
		'name'  => 'Websites & e-commerce',
		'naira' => 499000,
		'unit'  => 'a business website, one-off',
		'extra' => 'Online stores from ₦750,000',
		'when'  => 'About 5 weeks, 8 for a store',
		'items' => array( 'Copy written for you', 'Fast and mobile-first', 'Paystack checkout for stores', 'Search and AI foundations' ),
		'pay'   => 'Pay in full, or half at the start and half on delivery.',
		'url'   => banks_route( '/solutions/websites/' ),
	),
	array(
		'name'  => 'Web apps & custom solutions',
		'label' => 'From a spec',
		'unit'  => 'a fixed price before you commit',
		'when'  => 'Timeline in the spec',
		'items' => array( 'Written spec and fixed price', 'Clickable prototype first', 'Built and released in stages', 'You own the code' ),
		'pay'   => 'Paid in stages, as each part ships.',
		'url'   => banks_route( '/solutions/web-apps/' ),
	),
	array(
		'name'     => 'Automation & CRM',
		'naira'    => 800000,
		'from'     => true,
		'unit'     => 'setup, then from ₦250,000 a month',
		'when'     => 'Usually 6 to 12 weeks',
		'items'    => array( 'Process mapping', 'CRM and WhatsApp set up', 'Follow-ups, quotes and invoices', 'Training, then running it' ),
		'pay'      => 'Setup in stages, then monthly. Licences go to the vendor, never marked up.',
		'url'      => banks_route( '/solutions/automation-crm/' ),
		'featured' => true,
	),
	array(
		'name'  => 'AI solutions',
		'label' => 'From a spec',
		'unit'  => 'one named job at a time',
		'when'  => 'Proved on one job first',
		'items' => array( 'Audit and brief', 'One job built and tested', 'Run alongside your team', 'Banks Business Engine, monthly' ),
		'pay'   => 'Fixed in the spec. Model fees shown separately, never marked up.',
		'url'   => banks_route( '/solutions/ai/' ),
	),
	array(
		'name'  => 'Care plans',
		'naira' => 150000,
		'from'  => true,
		'unit'  => 'a month',
		'when'  => 'Monthly, no long lock-in',
		'items' => array( 'Tested updates', 'Verified backups', 'Security and uptime monitoring', 'Monthly changes, a named person' ),
		'pay'   => 'Billed monthly, after a takeover audit.',
		'url'   => banks_route( '/solutions/care-plans/' ),
	),
	array(
		'name'  => 'SEO & AI search',
		'label' => 'From the audit',
		'unit'  => 'quoted once we know where you stand',
		'when'  => 'Then checked monthly',
		'items' => array( 'Google and AI visibility audit', 'Structured data and schema', 'Answer-first content', 'Before-and-after tests' ),
		'pay'   => 'A project, then monitoring if you want it.',
		'url'   => banks_route( '/solutions/seo-aeo/' ),
	),
);

$b_pay = array(
	array( '01', 'A fixed price, first', 'Every quote is fixed in writing before work starts. No hourly rate that drifts, and no surprise at invoice time.' ),
	array( '02', 'Paid through Paystack', 'Card, bank transfer or USSD, with a receipt for every payment. Invoices and payments live in your client portal.' ),
	array( '03', 'In full, in halves or in stages', 'Websites: in full, or half at the start and half on delivery. Web apps: in stages as each part ships. Plans: monthly.' ),
);

$b_changes = array(
	array( 'How much there is', 'The number of pages, products, user types or processes to build or automate.' ),
	array( 'What it connects to', 'Payments, WhatsApp, a CRM, accounting or an existing system each add work.' ),
	array( 'Whether the content is ready', 'We write the copy either way; photos, product data and old records take longer if they need finding.' ),
	array( 'Custom features', 'Calculators, portals, bookings or anything that has to be built rather than set up.' ),
	array( 'Moving existing data', 'Customer lists, products or old posts that need cleaning and moving across.' ),
	array( 'How soon you need it', 'A tight deadline can mean more people on it at once. The quote says so if it does.' ),
);

$b_faqs = array(
	array( 'How much does a website cost in Nigeria?', 'At Banks Solutions a business website costs ₦499,000 and takes about 5 weeks. Online stores with Paystack start at ₦750,000 and take about 8 weeks. Larger builds are priced from a written spec. Every quote is fixed before work starts and includes copy, mobile performance, search foundations and launch support.' ),
	array( 'Can I pay in instalments?', 'Yes. Websites and stores can be paid half at the start and half on delivery. Web apps and larger projects are paid in stages, each one ending with something working you can try. Care plans and running costs are billed monthly.' ),
	array( 'Do you work with clients outside Nigeria?', 'Yes. We work with businesses in Nigeria, the United States, the United Kingdom, Canada, Kenya and Australia. Prices are set in naira, and we agree how you will pay before any work starts.' ),
	array( 'What changes the price?', 'Mainly how much there is to build, what it has to connect to, custom features, moving existing data and how soon you need it. The brief tells us all of that, which is why you get a fixed number rather than a range.' ),
	array( 'Are there any other costs?', 'Sometimes: your domain, hosting and any software licences, such as Zoho, HubSpot or AI model usage. You pay those to the provider directly or at cost, we never mark them up, and they are listed in the quote before you commit.' ),
	array( 'Why do you charge fixed prices instead of hourly?', 'Because a fixed price puts the risk of things taking longer on us, not you. It also means we do the thinking upfront, in the brief and the spec, which is where most projects are won or lost.' ),
);
?>
<section class="pr-hero" data-dark data-hero>
	<div class="pr-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap pr-inner">
			<div class="pr-copy">
				<p class="b-eyebrow pr-eyebrow">Pricing</p>
				<h1 class="pr-title">What it costs, in naira<span class="s-dot">.</span></h1>
				<p class="pr-lede">Business websites from Banks Solutions start at ₦499,000, online stores at ₦750,000, automation and CRM at ₦800,000 plus ₦250,000 a month, and care plans at ₦150,000 a month. Web apps and custom solutions are priced from a written spec.</p>
				<div class="pr-actions">
					<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>" data-magnetic>Get a fixed price</a>
					<a class="b-btn b-btn--line b-btn--lg" href="#pr-cards">See every price</a>
				</div>
			</div>
			<div class="pr-board" aria-label="Starting prices">
				<table class="pr-board__table">
					<caption class="b-sr">Banks Solutions starting prices and timelines</caption>
					<thead class="pr-board__top"><tr><th scope="col">Solution</th><th scope="col">From</th><th scope="col">Time</th></tr></thead>
					<tbody>
						<?php foreach ( $b_board as $b_row ) : ?>
							<tr class="pr-row">
								<?php foreach ( $b_row as $b_c => $b_cell ) : ?>
									<td>
										<span class="b-sr"><?php echo esc_html( $b_cell ); ?></span>
										<span class="pr-flaps" aria-hidden="true" data-text="<?php echo esc_attr( $b_cell ); ?>">
											<?php
											$b_chars = preg_split( '//u', $b_cell, -1, PREG_SPLIT_NO_EMPTY );
											$b_chars = array_pad( $b_chars, $b_cols[ $b_c ], ' ' );
											foreach ( $b_chars as $b_ch ) {
												echo '<span class="pr-ch">' . esc_html( $b_ch ) . '</span>';
											}
											?>
										</span>
									</td>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<p class="pr-board__foot" aria-hidden="true"><span class="s-live"></span>Prices fixed in writing before work starts</p>
			</div>
		</div>
	</div>
</section>

<section class="pr-cards" id="pr-cards">
	<div class="b-wrap">
		<div class="pr-head">
			<p class="b-eyebrow">Every price, upfront</p>
			<h2 data-split>Six solutions, priced in full.</h2>
			<p>Starting prices for each solution, what they include and how they are paid. The brief turns a starting price into a fixed number for your business.</p>
		</div>
		<div class="pr-grid">
			<?php foreach ( $b_cards as $b_p ) : ?>
				<article class="pr-card<?php echo empty( $b_p['featured'] ) ? '' : ' is-featured'; ?>"<?php echo empty( $b_p['featured'] ) ? '' : ' data-dark'; ?> data-tilt>
					<h3 class="pr-card__name"><?php echo esc_html( $b_p['name'] ); ?></h3>
					<p class="pr-card__price">
						<?php if ( ! empty( $b_p['naira'] ) ) : ?>
							<?php if ( ! empty( $b_p['from'] ) ) : ?>
								<span class="pr-card__from">From</span>
							<?php endif; ?>
							<strong>₦<span data-naira="<?php echo esc_attr( $b_p['naira'] ); ?>"><?php echo esc_html( number_format( $b_p['naira'] ) ); ?></span></strong>
						<?php else : ?>
							<strong><?php echo esc_html( $b_p['label'] ); ?></strong>
						<?php endif; ?>
						<span class="pr-card__unit"><?php echo esc_html( $b_p['unit'] ); ?></span>
					</p>
					<?php if ( ! empty( $b_p['extra'] ) ) : ?>
						<p class="pr-card__extra"><?php echo esc_html( $b_p['extra'] ); ?></p>
					<?php endif; ?>
					<p class="pr-card__when"><?php echo esc_html( $b_p['when'] ); ?></p>
					<ul class="pr-card__list">
						<?php foreach ( $b_p['items'] as $b_i ) : ?>
							<li><?php echo esc_html( $b_i ); ?></li>
						<?php endforeach; ?>
					</ul>
					<p class="pr-card__pay"><?php echo esc_html( $b_p['pay'] ); ?></p>
					<?php if ( $b_p['url'] ) : ?>
						<a class="pr-card__link" href="<?php echo esc_url( $b_p['url'] ); ?>">What’s included<span aria-hidden="true"> →</span></a>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="pr-pay" data-dark>
	<div class="b-wrap">
		<div class="pr-head pr-head--dark">
			<p class="b-eyebrow">How payment works</p>
			<h2 data-split>A number you can plan around.</h2>
		</div>
		<ol class="pr-pay__steps">
			<?php foreach ( $b_pay as $b_s ) : ?>
				<li class="pr-pay__step">
					<span class="pr-pay__n"><?php echo esc_html( $b_s[0] ); ?></span>
					<h3><?php echo esc_html( $b_s[1] ); ?></h3>
					<p><?php echo esc_html( $b_s[2] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="pr-changes">
	<div class="b-wrap pr-changes__grid">
		<div class="pr-head">
			<p class="b-eyebrow">What changes a price</p>
			<h2 data-split>Six things move the number.</h2>
			<p>Nothing else does. Each one is in the brief, so the price you get is the price you pay.</p>
		</div>
		<ol class="pr-changes__list">
			<?php foreach ( $b_changes as $b_i => $b_c ) : ?>
				<li class="pr-change"><span class="pr-change__n"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span><strong><?php echo esc_html( $b_c[0] ); ?></strong><span><?php echo esc_html( $b_c[1] ); ?></span></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>Straight answers on cost.</h2>
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
		<h2 class="s-cta__title" data-split>Turn a starting price into your price<span class="s-dot">.</span></h2>
		<p>Ten minutes on the brief, and within two working days you’ll have a fixed number for your business, and what it includes.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( $b_start ); ?>" data-magnetic>Start the brief</a>
	</div>
</section>

<script type="application/ld+json">
<?php
$b_services = array();
foreach ( $b_cards as $b_p ) {
	$b_svc = array(
		'@type'    => 'Service',
		'name'     => $b_p['name'],
		'provider' => array(
			'@type' => 'Organization',
			'name'  => 'Banks Solutions',
			'url'   => banks_main_url( '/' ),
		),
	);
	if ( $b_p['url'] ) {
		$b_svc['url'] = $b_p['url'];
	}
	if ( ! empty( $b_p['naira'] ) ) {
		$b_svc['offers'] = array(
			'@type'              => 'Offer',
			'priceCurrency'      => 'NGN',
			'priceSpecification' => array(
				'@type'         => 'PriceSpecification',
				'priceCurrency' => 'NGN',
				( empty( $b_p['from'] ) ? 'price' : 'minPrice' ) => $b_p['naira'],
			),
		);
	}
	$b_services[] = $b_svc;
}
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'           => 'OfferCatalog',
				'name'            => 'Banks Solutions pricing',
				'url'             => banks_main_url( '/pricing/' ),
				'itemListElement' => $b_services,
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
