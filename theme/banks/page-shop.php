<?php
/*
 * Shop (/shop/), built as scenes: a licence key that activates in the hero, the shelf (the
 * catalogue from Banks Core), what every licence includes, how buying works, questions,
 * closing call. Motion lives in shop.js; every state is in the HTML.
 */
get_header();

$b_products = banks_products();
$b_phone    = banks_detail( 'whatsapp' );
$b_wa       = $b_phone ? 'https://wa.me/' . preg_replace( '/\D/', '', $b_phone ) : '';
$b_custom   = banks_route( '/solutions/web-apps/', '/start/' );
$b_key      = array( 'BBE', '7Q4M', 'K2XD', '9F8A' );

$b_includes = array(
	array( 'A licence key', 'One key per website. It switches the software on and ties it to your domain.' ),
	array( 'Updates in your dashboard', 'New versions arrive as we release them, so your tools keep getting better.' ),
	array( 'Set up for you', 'We install it, shape it to your business, connect your accounts and test it before it goes live.' ),
	array( 'A person to ask', 'Support from the team that built it, on WhatsApp or email, not a ticket queue abroad.' ),
);

$b_steps = array(
	array( 'Pick a tool', 'Read what it does, then tell us about your business in a short brief.' ),
	array( 'Get your quote', 'We price it on what it needs to do on your site and come back within two working days.' ),
	array( 'Pay and go live', 'Pay the Paystack invoice, we set it up, and your licence key is active.' ),
);

$b_faqs = array(
	array( 'What can I buy in the Banks Solutions shop?', 'Ready-made software for business websites, built by Banks Solutions. Right now that is Banks Business Engine, an AI assistant and lead CRM that answers enquiries, qualifies visitors and books them in. A booking platform is next.' ),
	array( 'Will it work with my website?', 'Yes. We set each tool up on your website, whatever it was built with. If you don’t have a website yet, we can build one with the tool included.' ),
	array( 'What does a licence cover?', 'One website. The licence switches the software on, keeps the updates coming and gives you support from our team for as long as it is active.' ),
	array( 'Who sets it up?', 'We do. Every product comes with setup on your website: installed, shaped to your business, connected to your accounts and tested before it goes live.' ),
	array( 'How much does it cost?', 'Each tool is priced on scope, meaning what it needs to do on your website, and runs on a monthly licence per site. Send a brief and the quote comes back within two working days.' ),
	array( 'How do I pay?', 'We send a Paystack invoice, and you can pay by card, bank transfer or USSD.' ),
	array( 'What happens if I stop renewing?', 'Updates and support stop, and the software’s public features pause. Your data stays on your own website and nothing is deleted.' ),
	array( 'Can you build something that isn’t in the shop?', 'Yes. Most of what we build is custom: web apps and custom solutions shaped around how your business works, priced from a spec.' ),
);
?>
<section class="sh-hero" data-dark data-hero>
	<div class="sh-stage">
		<div class="s-glow" aria-hidden="true"></div>
		<div class="b-wrap sh-inner">
			<div class="sh-copy">
				<p class="b-eyebrow sh-eyebrow">Shop · Software for business websites</p>
				<h1 class="sh-title">Ready-made tools for your website<span class="s-dot">.</span></h1>
				<p class="sh-lede">The Banks Solutions shop sells software we built for our own clients, ready to add to your website. Every tool comes with a licence key, updates and a person who sets it up for you.</p>
				<div class="sh-actions">
					<a class="b-btn b-btn--signal b-btn--lg" href="#shelf" data-magnetic>See what’s on the shelf</a>
					<?php if ( $b_wa ) : ?>
						<a class="b-btn b-btn--line b-btn--lg" href="<?php echo esc_url( $b_wa . '?text=' . rawurlencode( 'Hi Banks Solutions, I have a question about the shop.' ) ); ?>">Ask on WhatsApp</a>
					<?php endif; ?>
				</div>
			</div>

			<figure class="sh-rig" aria-label="An example licence key, active on one website">
				<div class="sh-card" data-tilt>
					<div class="sh-card__sheen" aria-hidden="true"></div>
					<div class="sh-card__top">
						<span class="sh-card__brand">Banks Solutions<span class="s-dot">.</span></span>
						<span class="sh-card__type">Licence</span>
					</div>
					<span class="sh-card__chip" aria-hidden="true"><i></i><i></i><i></i></span>
					<p class="sh-card__name">Banks Business Engine</p>
					<p class="sh-card__key" aria-label="Licence key <?php echo esc_attr( implode( '-', $b_key ) ); ?>">
						<?php foreach ( $b_key as $b_i => $b_seg ) : ?>
							<?php echo $b_i ? '<i aria-hidden="true">-</i>' : ''; ?><span class="sh-seg" aria-hidden="true"><?php echo esc_html( $b_seg ); ?></span>
						<?php endforeach; ?>
					</p>
					<dl class="sh-card__rows">
						<div><dt>Website</dt><dd>yourbusiness.ng</dd></div>
						<div><dt>Updates</dt><dd>Included</dd></div>
						<div><dt>Status</dt><dd class="sh-status"><span class="s-live"></span><span class="sh-status__t">Active</span></dd></div>
					</dl>
				</div>
				<p class="sh-notice"><span class="sh-notice__dot" aria-hidden="true"></span>A new version is ready · <strong>Update now</strong></p>
			</figure>
		</div>
	</div>
</section>

<section class="sh-shelf" id="shelf">
	<div class="b-wrap">
		<div class="sh-head">
			<p class="b-eyebrow">On the shelf</p>
			<h2 data-split>Built for our clients first. Now ready for yours.</h2>
			<p>Each tool started as something a client needed. When it worked, we made it ready for any business.</p>
		</div>
		<div class="sh-grid">
			<?php foreach ( $b_products as $b_p ) : ?>
				<?php
				$b_live = 'available' === $b_p['status'];
				$b_page = $b_p['url'] ? banks_route( $b_p['url'] ) : '';
				?>
				<article class="sh-product sh-product--<?php echo esc_attr( $b_live ? 'live' : 'soon' ); ?>"<?php echo $b_live ? ' data-dark' : ''; ?> data-reveal>
					<?php if ( 'banks-business-engine' === $b_p['slug'] ) : ?>
						<div class="sh-art" aria-hidden="true">
							<p class="sh-art__msg sh-art__msg--in">Do you deliver to Abuja?</p>
							<p class="sh-art__msg sh-art__msg--out">Yes, in two to three days for ₦6,500. Shall I start your order?</p>
							<div class="sh-art__lead"><span class="sh-art__tag">New lead</span><strong>Tunde A.</strong><span>Order · Abuja · This week</span><b>86</b></div>
							<p class="sh-art__toast"><span>WhatsApp</span>New lead: Tunde A., order to Abuja</p>
						</div>
					<?php endif; ?>
					<div class="sh-product__body">
					<div class="sh-product__top">
						<span class="sh-badge"><?php echo $b_live ? '<span class="s-live"></span>Available now' : 'In the works'; ?></span>
						<span class="sh-product__kind"><?php echo esc_html( $b_p['kind'] ); ?></span>
					</div>
					<h3 class="sh-product__name"><?php echo esc_html( $b_p['name'] ); ?></h3>
					<p class="sh-product__sum"><?php echo esc_html( $b_p['summary'] ); ?></p>
					<ul class="sh-product__feats">
						<?php foreach ( $b_p['features'] as $b_f ) : ?>
							<li><?php echo esc_html( $b_f ); ?></li>
						<?php endforeach; ?>
					</ul>
					<div class="sh-product__foot">
						<p class="sh-product__price"><?php echo esc_html( $b_p['price'] ); ?></p>
						<div class="sh-product__go">
							<?php if ( $b_live ) : ?>
								<?php if ( $b_page ) : ?>
									<a class="b-btn b-btn--line" href="<?php echo esc_url( $b_page ); ?>">See how it works</a>
								<?php endif; ?>
								<a class="b-btn b-btn--signal" href="<?php echo esc_url( add_query_arg( 'need', $b_p['need'], banks_route( '/start/', '/contact/' ) ) ); ?>" data-magnetic>Book a setup</a>
							<?php elseif ( $b_wa ) : ?>
								<a class="b-btn b-btn--line" href="<?php echo esc_url( $b_wa . '?text=' . rawurlencode( 'Hi Banks Solutions, please tell me when the ' . strtolower( $b_p['name'] ) . ' is ready.' ) ); ?>">Tell me when it’s ready</a>
							<?php endif; ?>
						</div>
					</div>
					</div>
				</article>
			<?php endforeach; ?>
			<a class="sh-custom" href="<?php echo esc_url( $b_custom ); ?>" data-reveal>
				<span class="sh-custom__label">Not on the shelf?</span>
				<span class="sh-custom__title">We build web apps and custom solutions around how your business works.</span>
				<span class="sh-custom__go">Priced from a spec <span aria-hidden="true">→</span></span>
			</a>
		</div>
	</div>
</section>

<section class="sh-incl" data-dark>
	<div class="b-wrap sh-incl__grid">
		<div class="sh-head sh-head--dark">
			<p class="b-eyebrow">Every licence includes</p>
			<h2 data-split>Not just a download.</h2>
			<p>Software is only useful once it’s working on your site. So every licence comes with the people who make that happen.</p>
		</div>
		<ol class="sh-incl__list">
			<?php foreach ( $b_includes as $b_i => $b_in ) : ?>
				<li class="sh-incl__item" data-reveal>
					<span class="sh-incl__n"><?php echo esc_html( sprintf( '%02d', $b_i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $b_in[0] ); ?></h3>
					<p><?php echo esc_html( $b_in[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="sh-buy">
	<div class="b-wrap">
		<div class="sh-head">
			<p class="b-eyebrow">How buying works</p>
			<h2 data-split>Three steps, and we do the hard one.</h2>
		</div>
		<ol class="sh-steps">
			<?php foreach ( $b_steps as $b_i => $b_s ) : ?>
				<li class="sh-step">
					<span class="sh-step__n"><?php echo esc_html( $b_i + 1 ); ?></span>
					<h3><?php echo esc_html( $b_s[0] ); ?></h3>
					<p><?php echo esc_html( $b_s[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="s-faq">
	<div class="b-wrap s-faq__grid">
		<div>
			<p class="b-eyebrow">Questions</p>
			<h2 data-split>About the shop.</h2>
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
		<h2 class="s-cta__title" data-split>Add a tool that works while you sleep<span class="s-dot">.</span></h2>
		<p>Start with Banks Business Engine. Tell us about your business and we’ll come back within two working days with the setup and the price.</p>
		<a class="b-btn b-btn--signal b-btn--lg" href="<?php echo esc_url( add_query_arg( 'need', 'ai', banks_route( '/start/', '/contact/' ) ) ); ?>" data-magnetic>Book a setup</a>
	</div>
</section>

<script type="application/ld+json">
<?php
$b_list = array();
foreach ( $b_products as $b_i => $b_p ) {
	$b_item = array(
		'@type'               => 'SoftwareApplication',
		'name'                => $b_p['name'],
		'applicationCategory' => 'BusinessApplication',
		'operatingSystem'     => 'Web',
		'description'         => $b_p['summary'],
	);
	if ( $b_p['url'] ) {
		$b_item['url'] = banks_main_url( $b_p['url'] );
	}
	$b_list[] = array(
		'@type'    => 'ListItem',
		'position' => $b_i + 1,
		'item'     => $b_item,
	);
}
echo wp_json_encode(
	array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'       => 'CollectionPage',
				'name'        => 'Banks Solutions shop',
				'url'         => banks_main_url( '/shop/' ),
				'description' => 'Ready-made software for business websites from Banks Solutions, with a licence key, updates and setup included.',
				'publisher'   => array(
					'@type' => 'Organization',
					'@id'   => banks_main_url( '/' ) . '#organization',
					'name'  => 'Banks Solutions',
					'url'   => banks_main_url( '/' ),
				),
				'mainEntity'  => array(
					'@type'           => 'ItemList',
					'numberOfItems'   => count( $b_list ),
					'itemListElement' => $b_list,
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
