<?php
/**
 * Banks Labs product pages (/labs/<slug>/): the copy for each one, read by page-lab-product.php.
 *
 * Every page has the same scenes (hero with a live product mock, the problem, how it works,
 * every capability by area, how it is built, questions, closing call) so the family reads as
 * one. Facts come from each product's own code, readme and public pages; nothing here is a
 * promise the product does not already keep. The catalogue rows (name, status, version) live
 * in Banks Core, banks_core_products().
 *
 * @package Banks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * One product page's content, or null when the slug has no page.
 *
 * @param string $slug Page slug under /labs/.
 * @return array|null
 */
function banks_lab_product( $slug ) {
	$all = banks_lab_products();
	return isset( $all[ $slug ] ) ? $all[ $slug ] : null;
}

/**
 * All product pages, by slug.
 *
 * @return array[]
 */
function banks_lab_products() {
	$brief = function ( $need ) {
		return add_query_arg( 'need', $need, banks_route( '/start/', '/contact/' ) );
	};

	return array(
		'project-desk'  => array(
			'name'    => 'Project Desk',
			'visual'  => 'project-desk',
			'eyebrow' => 'Project Desk · Client portal and studio desk',
			'title'   => 'Every client project, in one place they can open',
			'lede'    => 'Project Desk is the app we run Banks Solutions on. Clients sign their agreement, follow every phase, send files, approve work and pay in one portal on their phone. The team gets the money, leads, tasks and insights behind it.',
			'actions' => array(
				array( 'Get Project Desk', $brief( 'web-app' ), 'signal' ),
				array( 'Client sign-in', 'https://clients.bankssolution.ng/', 'line' ),
			),
			'facts'   => array(
				array( 'Live', 'at clients.bankssolution.ng' ),
				array( 'v0.3', 'current release' ),
				array( '3', 'roles: owner, project manager, client' ),
				array( '2 GB', 'per file, uploaded in pieces' ),
			),
			'problem' => array(
				'eyebrow' => 'Why we built it',
				'big'     => 'The brief is in an email, the logo is in a WhatsApp chat, the agreement is unsigned and nobody is sure if the deposit landed. The client keeps asking how far along the project is.',
				'note'    => 'Every studio loses hours to that. Project Desk puts the whole project in one app both sides can open, so the client can see where things stand and nobody has to ask.',
			),
			'flow'    => array(
				'eyebrow' => 'How a project runs',
				'title'   => 'From first enquiry to final sign-off.',
				'steps'   => array(
					array( 'Enquiry', 'A prospect fills the public intake form. It lands under Leads, ready to turn into a client in one click.' ),
					array( 'Onboard', 'One step creates their account and invite, the first project with its phases and the agreement to sign.' ),
					array( 'Sign and pay', 'They sign on the screen and pay the deposit. Work cannot start until both are done.' ),
					array( 'Build', 'Phases move along, files go back and forth for review, and every change reaches the client at once.' ),
					array( 'Sign off', 'The client approves the last phase, pays the balance and leaves a review. The project closes itself.' ),
				),
			),
			'groups'  => array(
				'eyebrow' => 'Everything inside',
				'title'   => 'A client portal and a studio desk, in one app.',
				'lede'    => 'Two faces on one record, so what the team does is what the client sees.',
				'items'   => array(
					array(
						'key'   => 'portal',
						'title' => 'The client portal',
						'blurb' => 'An app clients add to their phone. No account to set up, no password to forget.',
						'feats' => array(
							array( 'Home that answers “how far along?”', 'Progress, what is waiting on them and the latest news, the moment they open it.' ),
							array( 'Projects, plans and approvals', 'Every phase of every project, with sign-off phases they approve in the portal.' ),
							array( 'Send files', 'One button to send a brief, logo, photos or video, straight into the right folder.' ),
							array( 'Documents to sign', 'Agreements, retainers and statements of work, read and signed on the phone.' ),
							array( 'Payments', 'What is due, what is paid and the balance, with proof of a transfer uploaded in a tap.' ),
							array( 'Push notifications', 'Phase changes, file decisions and invoices arrive as phone notifications. On iPhone, after adding it to the Home Screen.' ),
							array( 'Installable, light and dark', 'Opens full-screen like an app, follows the phone’s light or dark mode and shows an offline page with no signal.' ),
						),
					),
					array(
						'key'   => 'onboard',
						'title' => 'Onboarding and agreements',
						'blurb' => 'A new client is set up in one step, and nothing starts before the paperwork is done.',
						'feats' => array(
							array( 'One-step onboarding', 'Creates the client, their sign-in and invite email, the first project with its phases and the agreement.' ),
							array( 'Agreement templates', 'Your own wording, filled in with the business, company, service and date for each client.' ),
							array( 'Drawn signatures with evidence', 'Each signature records the name, time, IP address, browser and a SHA-256 fingerprint of the text.' ),
							array( 'Locked once signed', 'A signed document cannot be edited, so both sides keep the same record.' ),
							array( 'Work gate', 'The first work phase only opens once the agreement is signed and the deposit is paid.' ),
						),
					),
					array(
						'key'   => 'phases',
						'title' => 'Projects and phases',
						'blurb' => 'The plan the client sees is the plan the team works to.',
						'feats' => array(
							array( 'A pipeline per service', 'Three opening phases on every project, then the work phases for that service, set in settings.' ),
							array( 'One current phase', 'Starting a later phase closes the earlier ones, so there is never a doubt about where things stand.' ),
							array( 'Client sign-off', 'Sign-off phases wait for the client’s approval in the portal before the project moves on.' ),
							array( 'Monthly services', 'Retainers and care plans run month to month and never close on their own.' ),
							array( 'Messages per project', 'A thread on every project, with each message also emailed to the other side.' ),
						),
					),
					array(
						'key'   => 'files',
						'title' => 'Files and deliverables',
						'blurb' => 'Big files, kept private, with a clear outcome on every one.',
						'feats' => array(
							array( 'Uploads that survive bad network', 'Files go up in 8 MB pieces and pick up where they stopped, up to 2 GB per file.' ),
							array( 'Folders by kind', 'Brief, brand, copy, images, video, references and data, filed as they arrive.' ),
							array( 'Review with a reason', 'Each upload is accepted or sent back with a note, and the client is told either way.' ),
							array( 'Versions', 'A new copy of a file becomes v2, v3 and on, with the history kept.' ),
							array( 'Deliverables hub', 'Latest files grouped by category, with a count and a “to review” badge on each group.' ),
							array( 'Videos that play on phones', 'Files stream with seeking, so a client can watch a draft cut on mobile data.' ),
						),
					),
					array(
						'key'   => 'money',
						'title' => 'Payments and money',
						'blurb' => 'Naira invoices tied to the project, and a clear view of what has come in.',
						'feats' => array(
							array( 'Deposit, milestone and balance', 'Invoices in naira with due dates. A 50% deposit by default.' ),
							array( 'Partial payments', 'Record any amount. Every invoice keeps a running balance of what is still owed.' ),
							array( 'Proof of transfer', 'The client uploads their transfer receipt; the owner confirms it and the client is told.' ),
							array( 'Overdue detection and reminders', 'Late invoices are flagged and followed up, without anyone chasing by hand.' ),
							array( 'Money dashboard', 'Collected, outstanding, overdue and due this month, money awaiting confirmation, a 6-month trend and every client’s balance.' ),
							array( 'Works with InvoiceNaija', 'Project invoices sync with InvoiceNaija, so the invoice and the receipt match the project.' ),
						),
					),
					array(
						'key'   => 'grow',
						'title' => 'Leads, team and insights',
						'blurb' => 'The parts of a studio a client never sees, in the same desk.',
						'feats' => array(
							array( 'Public intake form', 'A form on your portal for new enquiries. Each one becomes a lead you can convert to a client.' ),
							array( 'Team tasks and workload', 'Internal to-dos assigned to people, with workload grouped by person. Clients never see them.' ),
							array( 'Studio insights', 'Pipeline and win rate, project health, delivery turnaround, client satisfaction and team load.' ),
							array( 'Milestone reviews', 'Clients rate a finished milestone from 1 to 5 and write a review the team sees per project.' ),
							array( 'Roles', 'Owners see everything. Project managers run projects, files and messages, without money, settings or staff.' ),
							array( 'Branded email for every event', 'Phase changes, invoices, receipts and messages go out in your brand, from your own domain.' ),
						),
					),
				),
			),
			'trust'   => array(
				'eyebrow' => 'How it is built',
				'title'   => 'Your business, your install, your data.',
				'lede'    => 'Project Desk runs on your own WordPress website, one install per business, with a setup wizard for the first run. Nothing sits on a shared platform.',
				'points'  => array(
					array( 'First-run setup wizard', 'Business basics, branding, billing, contact and emails in four short steps.' ),
					array( 'Invite-only sign-in', 'Email and password, a one-time email link or Google, only for people you invited.' ),
					array( 'Private files', 'Files sit in a private folder and are only served after an access check. Program files are refused.' ),
					array( 'Careful with every link', 'Sign-in is rate limited. Email links are hashed, single use and expire in 15 minutes.' ),
				),
			),
			'faqs'    => array(
				array( 'What is Project Desk?', 'Project Desk is a client portal and studio desk from Banks Solutions. Clients sign agreements, follow phases, send files, approve work and pay in one app on their phone, while the team runs projects, money, leads, tasks and insights from the same place.' ),
				array( 'Is it in use today?', 'Yes. Banks Solutions runs its own client projects on it at clients.bankssolution.ng.' ),
				array( 'Do my clients need to download anything?', 'No. They open the link from their invite and can add it to their home screen, where it opens full-screen like an app.' ),
				array( 'Can my business use it?', 'Yes. Each business gets its own install on its own WordPress website, with a setup wizard for its name, brand, billing and emails. Talk to us and we will set it up.' ),
				array( 'How do clients sign in?', 'With the email you invited them on, using a password, a one-time email link or Google. Nobody can sign themselves up.' ),
				array( 'Does it handle part payments?', 'Yes. Any amount can be recorded against an invoice, and the running balance shows what is still owed.' ),
			),
			'cta'     => array( 'Run your projects on Project Desk', 'Tell us about your business and how you work with clients. We’ll come back within two working days with the setup and the price.', 'Get Project Desk', $brief( 'web-app' ) ),
			'schema'  => array( 'BusinessApplication', 'Client portal and project management' ),
		),

		'invoicenaija'  => array(
			'name'    => 'InvoiceNaija',
			'visual'  => 'invoicenaija',
			'eyebrow' => 'InvoiceNaija · Invoices and receipts',
			'title'   => 'Invoices that get paid, receipts that send themselves',
			'lede'    => 'InvoiceNaija makes a professional naira invoice in under a minute, with VAT, your bank details and a private payment link. When the money lands, a numbered receipt goes to you and your customer at once.',
			'actions' => array(
				array( 'Start free', 'https://invoices.bankssolution.ng/', 'signal' ),
				array( 'Add it to my website', $brief( 'automation' ), 'line' ),
			),
			'facts'   => array(
				array( 'Free', 'no subscription, no card' ),
				array( '7.5%', 'VAT, handled correctly' ),
				array( '2', 'copies of every receipt' ),
				array( 'A4', 'print-perfect, save as PDF' ),
			),
			'problem' => array(
				'eyebrow' => 'Why we built it',
				'big'     => '“Please send your account details.” “I have paid, check your account.” “Can you send me a receipt?” Three messages for every sale, and the receipt is the one that gets forgotten.',
				'note'    => 'An invoice is a request. A receipt is proof. InvoiceNaija puts your bank details on the paper and makes the receipt automatic, so both sides hold the same record.',
			),
			'flow'    => array(
				'eyebrow' => 'How it works',
				'title'   => 'Invoice, payment, receipt. No back-and-forth.',
				'steps'   => array(
					array( 'Create and send', 'Pick a saved customer, add your lines, apply a discount and VAT. Print it, email it or send it on WhatsApp with the link.' ),
					array( 'Customer pays', 'By bank transfer to the details on the invoice, or online. They upload their transfer receipt from the invoice page.' ),
					array( 'Receipt goes out twice', 'One confirmed payment becomes one numbered receipt, emailed to your customer and copied to you.' ),
				),
			),
			'groups'  => array(
				'eyebrow' => 'Everything inside',
				'title'   => 'Built around how Nigerian businesses get paid.',
				'lede'    => 'Not a generic invoicing tool with the naira bolted on. Bank transfers, WhatsApp, VAT and withholding tax are the starting point.',
				'items'   => array(
					array(
						'key'   => 'naira',
						'title' => 'Naira and tax',
						'blurb' => 'The numbers the way accountants and auditors expect them.',
						'feats' => array(
							array( 'Naira, properly', 'Thousands separators, kobo and the amount written in words: “One Million Naira and Fifty Kobo Only”.' ),
							array( 'VAT at 7.5%', 'Worked out correctly on every invoice, and switchable per invoice.' ),
							array( 'Withholding tax', 'Shown as a deduction, so a customer deducting WHT sees exactly what to pay and what to remit.' ),
							array( 'Discounts and delivery', 'Percentage discounts and delivery charges, on the line where they belong.' ),
						),
					),
					array(
						'key'   => 'paid',
						'title' => 'Getting paid',
						'blurb' => 'Everything the customer needs to pay you is already on the invoice.',
						'feats' => array(
							array( 'Bank details on the paper', 'Account name, bank and number, with the invoice number as the narration to use.' ),
							array( 'Private customer link', 'Your customer opens the invoice on any phone to view, print, pay and upload proof of a transfer.' ),
							array( 'Paystack checkout', 'An optional Paystack link per invoice for card and USSD. A paid invoice is marked paid on its own.' ),
							array( 'No account for customers', 'They open the link, pay and receive their receipt. Nothing to sign up for.' ),
						),
					),
					array(
						'key'   => 'receipts',
						'title' => 'Receipts',
						'blurb' => 'The part that protects you, made automatic.',
						'feats' => array(
							array( 'Numbered on their own', 'RCP-2026-0001, RCP-2026-0002 and on, separate from invoices, so a gap is easy to spot.' ),
							array( 'Sent to both sides', 'Emailed to your customer and copied to you, in your business’s name.' ),
							array( 'Part payments', 'Record any amount. Each receipt states the payment and the balance still owed.' ),
							array( 'Voidable', 'If money does not clear, one click removes the payment and its receipt and restores the balance.' ),
						),
					),
					array(
						'key'   => 'run',
						'title' => 'Running your books',
						'blurb' => 'Small tools that save the most time.',
						'feats' => array(
							array( 'Saved customers', 'Add a customer once and reuse them on every invoice.' ),
							array( 'Your numbering', 'Invoice numbers that follow on, plus notes, terms and a signature block.' ),
							array( 'Print or PDF', 'A4 invoices and receipts that print the same on Windows, macOS and Android. Print, then save as PDF.' ),
							array( 'CSV export', 'Take your invoices and payments to your accountant or a spreadsheet.' ),
							array( 'On your phone', 'Add it to your home screen and it opens full-screen like an app, even offline.' ),
						),
					),
				),
			),
			'trust'   => array(
				'eyebrow' => 'Two ways to use it',
				'title'   => 'In your browser, or inside your own website.',
				'lede'    => 'Most people use the free web app. If you run a WordPress website, the InvoiceNaija plugin adds the same invoicing to your own admin, with receipts sent from your own domain.',
				'points'  => array(
					array( 'The web app', 'Open invoices.bankssolution.ng, sign in with Google or your email, add your business once and send your first invoice.' ),
					array( 'The WordPress plugin', 'Invoicing inside your own site, with Paystack checkout and receipts from your domain. We set it up for you.' ),
					array( 'Your Paystack key stays private', 'It never reaches the browser. Paystack’s payment notices are checked with an HMAC-SHA512 signature.' ),
					array( 'Records are kept', 'Invoices are business records, so they stay even if the plugin is removed, unless you choose otherwise.' ),
				),
			),
			'faqs'    => array(
				array( 'Is InvoiceNaija really free?', 'Yes. There is no account charge and no subscription. You only pay your payment provider’s normal fee, such as Paystack’s, when a customer pays online.' ),
				array( 'Do I need Paystack?', 'No. Bank transfer is the default and the invoice prints your account details. A Paystack link is optional, for card or USSD payments confirmed automatically.' ),
				array( 'Does it work on my phone?', 'Yes. It is built for the phone. Add it to your home screen and it opens full-screen like an app. Your customer’s invoice page works on any phone too.' ),
				array( 'Who sends the receipt email?', 'InvoiceNaija does, in your business’s name, the moment you confirm a payment. It goes to your customer and a copy comes to you.' ),
				array( 'Can it handle part payments?', 'Yes. Record any amount. The invoice shows the balance and each payment gets its own receipt stating what is still outstanding.' ),
				array( 'Can I use it on my WordPress website?', 'Yes. The InvoiceNaija plugin adds the same invoicing inside your own admin. It is an option, not a requirement. Get in touch and we will set it up.' ),
			),
			'cta'     => array( 'Send your first invoice today', 'No download and no setup. Sign in, add your business name, logo and bank details once, and every invoice and receipt is ready.', 'Start free', 'https://invoices.bankssolution.ng/' ),
			'schema'  => array( 'FinanceApplication', 'Invoices and receipts', 'free' ),
		),

		'1904-car-wash' => array(
			'name'    => '1904 Car Wash system',
			'visual'  => 'car-wash',
			'eyebrow' => '1904 Car Wash · Built for 1904 Solutions',
			'title'   => 'A car wash that fits in a customer’s pocket',
			'lede'    => 'We built the booking app, customer accounts and wallet behind 1904 Solutions, a premium car care business in Ogba, Lagos. Customers book a wash in under a minute, keep their cars on file and pay from a wallet at the counter.',
			'actions' => array(
				array( 'Build one for my business', $brief( 'web-app' ), 'signal' ),
				array( 'See the app', 'https://app.1904solutions.com/', 'line' ),
			),
			'facts'   => array(
				array( '< 1 min', 'to book a wash' ),
				array( '3', 'ways to pay: cash, POS, wallet' ),
				array( 'Every', 'wash recorded, with a receipt' ),
				array( 'Live', 'at app.1904solutions.com' ),
			),
			'problem' => array(
				'eyebrow' => 'The brief',
				'big'     => 'A busy car wash runs on a queue, a notebook and change for the POS. Regulars wait behind walk-ins, nobody knows which car came in when, and a receipt means writing one by hand.',
				'note'    => '1904 Solutions wanted the polish of the wash to carry into everything around it. So we built the system around how the business actually runs, from the booking to the counter.',
			),
			'flow'    => array(
				'eyebrow' => 'How a wash runs',
				'title'   => 'Booked on the phone, settled at the counter.',
				'steps'   => array(
					array( 'Book', 'The customer picks a wash and a time in the app, in under a minute. Walk-ins are still welcome.' ),
					array( 'Log the car', 'Each car is logged by plate, make and colour, and stays on file for next time.' ),
					array( 'Pay', 'By cash, POS or the 1904 Wallet, topped up ahead so paying at the counter is quick.' ),
					array( 'Receipt', 'Every wash is recorded and a receipt goes to the customer by email.' ),
				),
			),
			'groups'  => array(
				'eyebrow' => 'What we built',
				'title'   => 'One system, from the website to the counter.',
				'lede'    => 'A customer app, a wallet and the records behind them, on the same hand-built WordPress setup we use for our own site.',
				'items'   => array(
					array(
						'key'   => 'app',
						'title' => 'The customer app',
						'blurb' => '“Your car wash, in your pocket.”',
						'feats' => array(
							array( 'Book a wash', 'Choose the service and a time in under a minute, straight from the website or the app.' ),
							array( 'Customer accounts', 'Create an account, log in and reset a forgotten password, all on the phone.' ),
							array( 'Prices up front', 'The full price list is one tap away, before anyone signs in.' ),
							array( 'Installs like an app', 'Add it to the home screen and it opens full-screen, with its own icon.' ),
						),
					),
					array(
						'key'   => 'cars',
						'title' => 'Cars and records',
						'blurb' => 'Every car and every wash, on file.',
						'feats' => array(
							array( 'Cars on file', 'Each customer’s cars are saved by plate, make and colour, ready for the next booking.' ),
							array( 'Every wash recorded', 'Each visit is logged against the car and the customer, so nothing relies on memory.' ),
							array( 'Every vehicle size', 'Sedans, SUVs, buses and trucks, with prices by service and car type.' ),
						),
					),
					array(
						'key'   => 'pay',
						'title' => 'Payments and wallet',
						'blurb' => 'Paying takes seconds, however the customer likes to pay.',
						'feats' => array(
							array( '1904 Wallet', 'Customers keep a wallet balance and pay from it at the counter.' ),
							array( 'Cash and POS', 'Both still work, recorded the same way as wallet payments.' ),
							array( 'Emailed receipts', 'A receipt goes out by email after every wash.' ),
						),
					),
					array(
						'key'   => 'site',
						'title' => 'The website around it',
						'blurb' => 'The brand, the services and the booking, joined up.',
						'feats' => array(
							array( '1904solutions.com', 'The business website, with car wash, 1904 Kids and the coming 1904 Cafe.' ),
							array( 'Services and prices', 'Body wash, vacuuming, engine wash, interior cleaning, buffing and hand wax, with prices.' ),
							array( 'Book from any page', 'Every “Book a wash” button leads straight into the app.' ),
						),
					),
				),
			),
			'trust'   => array(
				'eyebrow' => 'How we built it',
				'title'   => 'Hand-built, so it fits the business.',
				'lede'    => 'Not a template with a booking plugin bolted on. A hand-coded WordPress theme for the brand and a custom plugin for the business logic, the same pattern our own website is built on.',
				'points'  => array(
					array( 'Custom theme', 'The 1904 Solutions website, coded for the brand and fast on a phone.' ),
					array( 'Custom plugin', 'Bookings, accounts, cars, wallet and receipts live in their own plugin, separate from the design.' ),
					array( 'Phone first', 'The app was designed for the phone in a customer’s hand at the counter.' ),
					array( 'Theirs to keep', 'Customer records live on the business’s own website, not on a shared platform.' ),
				),
			),
			'faqs'    => array(
				array( 'What is the 1904 Car Wash system?', 'It is the booking app, customer accounts and wallet that Banks Solutions built for 1904 Solutions, a car care business in Ogba, Lagos. Customers book a wash, keep their cars on file and pay by cash, POS or wallet, with every wash recorded and a receipt emailed.' ),
				array( 'Can I get one for my car wash?', 'Yes. We build systems like this around how each business runs, priced from a spec. Start a brief and we come back within two working days.' ),
				array( 'Does it only work for car washes?', 'No. The same idea fits any business that books, serves and takes payment at a counter: salons, laundries, clinics, workshops and more.' ),
				array( 'Can customers still walk in?', 'Yes. Walk-ins are welcome at 1904 Solutions, and booking ahead is there for those who want it.' ),
			),
			'cta'     => array( 'Want a system like this for your business', 'Tell us how your business runs today. We’ll come back within two working days with how we’d build it, the timeline and the price.', 'Start a brief', $brief( 'web-app' ) ),
			'schema'  => array( 'BusinessApplication', 'Car wash booking and wallet' ),
		),
	);
}
