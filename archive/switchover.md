# Switchover runbook

How the live bankssolution.ng moves to the new Banks theme and the Banks Core plugin. Live is
changed in place: nothing is wiped, and every step can be undone by switching the theme back to
Baseplate. Run it at a quiet hour, with Promise's go-ahead on the day.

## 0. Before the day

- [ ] Promise has reviewed every staging page and signed off.
- [ ] Legal pages (privacy, terms) have been reviewed by a lawyer.
- [x] WPForms Lite, Animation Addons and Novamira Pro were removed from live and staging on
      2026-10-28 at Promise's request. They were moved, not deleted, to
      `/home/bankssol/banks-backups/live-removed-20261028/`.
- [ ] Company facts that are still placeholders: founder photo and bio, LinkedIn URL
      (option `banks_linkedin`), case-study results.

## 1. Back up (about 15 minutes)

- [ ] Fresh database dump and a zip of `wp-content/`, saved to `/home/bankssol/banks-backups/<date>/`
      and copied off the server. Check that both archives open.
- [ ] Write down the current theme, the active_plugins value, `page_on_front` and `show_on_front`.

## 2. Code (about 5 minutes)

- [ ] Copy the staging `themes/banks/` and `plugins/banks-core/` folders to live on the server (both
      sites are on the same host). First check that staging matches the commit approved for launch.
- [ ] Activate Banks Core. Don't switch the theme yet.

## 3. Content (about 20 minutes)

Copy the page records from the staging database to live in one server-side script. Copy only the
rows; nothing is rebuilt, because all the design and copy live in the theme. The script keeps the
slugs, parents, page template `default`, Rank Math title, description and focus keyword, and maps
parent IDs (staging IDs in brackets):

- [ ] solutions (608) and its children websites, web-apps, automation-crm, ai, care-plans, seo-aeo (609-614)
- [ ] start (615), pricing (617), work (618), about (629), banks-business-engine (630), shop (631),
      labs (632), wordpress-development (633)
- [ ] privacy-policy (634) and terms (635), then set `wp_page_for_privacy_policy`
- [ ] industries (636) and its children finance, legal, hospitality, education, health, non-profit, fashion (637-643)
- [ ] Rank Math meta on knowledge (179) and glossary (193); these pages keep their IDs
- [ ] The ten projects (banks_work, staging 619-628) with their `_banks_work` meta, plus the
      recordings and posters in `wp-content/uploads/work/`
- [ ] Banks options (`banks_email` and any `banks_*` details set on staging)

## 4. Switch (about 2 minutes)

- [ ] Activate the Banks theme.
- [ ] Delete Rank Math redirection id 1 (/audit/ to /contact/, 302). The theme now sends /audit/ to /start/.
- [ ] Flush permalinks: Settings > Permalinks > Save.
- [ ] Purge any page cache.

## 5. Check every old address

Run `archive/url-check.php` through the connector. It requests every address in
`archive/redirects.md` and expects one of two results:

- a 200, or
- a single 301 to a page that returns 200.

Any other result means rolling back (step 8) or fixing it on the spot.

- [ ] All 41 articles and 30 glossary terms return 200.
- [ ] Every redirect lands in one hop.
- [ ] The brief at /start/ sends both emails. These can only be tested on live, because staging blocks mail.
- [ ] The BBE chat widget still answers on the new pages.

## 6. Tell search engines

- [ ] Resubmit `sitemap_index.xml` in Google Search Console and Bing Webmaster Tools.
- [ ] Check that Rank Math's own schema is off on the scene pages, since the theme writes schema itself.

## 7. Tidy the content links

Rewrite the 140 links to old addresses inside the article and term fields (bs_body_html,
bs_related_html, bs_faqs_html, bs_why_html, bs_lead) using the map in `archive/redirects.md`, so
nothing goes through a redirect. Run it on a copy of the rows first and compare the counts.

## 8. Roll back

Switch the theme back to Baseplate, deactivate Banks Core, and re-add Rank Math redirection id 1.
The old Elementor pages are untouched throughout, so the old site comes back as it was.

## Later, not on switchover day

- Converting to multisite for portal.bankssolution.ng. This is done in place, after the portal is
  built and tested on staging, and needs a DNS record for the subdomain.
- Deleting the old Elementor pages (services and its children, banks-solution, home-v2,
  homepage-v3-jasper-clone). Wait a month after the switch, once the redirects have been seen working.
