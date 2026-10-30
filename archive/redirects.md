# Redirect map

Every address the live bankssolution.ng served on 2026-10-28, and what it does after the switch.
The rules live in `banks_redirects()` and `banks_redirect_target()` in `theme/banks/functions.php`.
A redirect fires only once its new page exists, so an old page keeps working until its replacement
is published. All redirects are 301.

## Kept at the same address (no redirect)

| Address | Now |
| --- | --- |
| / | New homepage (theme front page) |
| /knowledge/ | New Knowledge hub (page 179, same ID) |
| /glossary/ | New Glossary hub (page 193, same ID) |
| /contact/ | Same page (267), Elementor content kept |
| 41 articles at /&lt;post-slug&gt;/ | Same slugs, new article template |
| 30 terms at /glossary/&lt;slug&gt;/ | Same slugs, new term template |
| /feed/, /sitemap_index.xml | WordPress and Rank Math, unchanged |

## Pages that moved

| Old | New |
| --- | --- |
| /services/ | /solutions/ |
| /services/digital-foundation/ | /solutions/websites/ |
| /services/automation-crm/ | /solutions/automation-crm/ |
| /services/ai-custom-solutions/ | /solutions/ai/ |
| /services/managed-technology/ | /solutions/care-plans/ |
| /services/aeo/ and /aeo/ | /solutions/seo-aeo/ |
| /audit/ | /start/ (live's temporary Rank Math redirect to /contact/, id 1, is deleted at the switch) |
| /banks-solution/ | / |
| /home-v2/ (draft homepage) | / |
| /homepage-v3-jasper-clone/ (old front page's own address) | / |
| /author/creator/ | /about/ |

## Archives folded into the hubs

| Old | New |
| --- | --- |
| /category/&lt;slug&gt;/ (9 topics, and their /page/N/) | /knowledge/?topic=&lt;slug&gt;#library (opens the library filtered) |
| /category/uncategorized/ | /knowledge/ |
| /knowledge-topic/ai-for-business/ | /knowledge/?topic=ai-custom-solutions#library |
| /knowledge-topic/crm-and-automation/ | /knowledge/?topic=automation-crm#library |
| /knowledge-topic/search-and-being-found/ | /knowledge/?topic=aeo#library |
| /knowledge-topic/trust-and-compliance/ | /knowledge/?topic=legal-compliance#library |
| /knowledge-topic/websites-and-digital-presence/ | /knowledge/?topic=digital-foundation#library |
| /knowledge-topic/cost-and-practical-basics/ | /knowledge/#library |
| /glossary-letter/&lt;a-z&gt;/ | /glossary/#letter-&lt;a-z&gt; |

The /knowledge-topic/ links were already broken on live (the taxonomy has no template), so these
redirects fix them.

## Links inside the content

The articles and glossary terms link to old addresses 140 times: /services/ 90, /services/automation-crm/ 13,
/services/managed-technology/ 11, /services/digital-foundation/ 8, /services/ai-custom-solutions/ 8,
/services/aeo/ 2, and /contact/ 46 (still valid). The redirects cover all of them. Step 7 of
`archive/switchover.md` also rewrites them to the new addresses, so visitors and search engines
don't go through a redirect.

One article links to /validate-business-idea-demand-nigeria/, which is scheduled (post 567) rather
than published. It starts working when that post goes live.
