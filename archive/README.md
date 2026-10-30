# Old site archive

A readable copy of everything published on bankssolution.ng, exported on 28 October 2026 before the rebuild. Nothing here is served by the new site; it is the source we migrate from and the record of what existed.

| Path | What it holds |
| --- | --- |
| `articles/` | 41 Knowledge articles as Markdown, with SEO fields, category, read time and featured image in the front matter |
| `glossary/` | 30 glossary terms |
| `pages/` | 12 pages. Elementor pages are flattened to their readable copy in page order |
| `data/site-content.json` | Raw export of the published items, including every custom field and the Elementor layout data, for re-import |
| `url-map.csv` | Every live URL with its SEO title, description and keywords, and what happens to it in the new site |
| `missing-urls.csv` | URLs visitors are hitting that 404 today, with a proposed home for each |
| `media.csv` | The 63 media library files |

## How the old site stores articles

Article and glossary text is **not** in the normal WordPress content field. It lives in custom fields (`bs_lead`, `bs_body_html`, `bs_faqs_html`, `bs_toc_html`, `bs_related_html`, `bs_read_time`, `bs_linkedin` for articles; `bs_definition`, `bs_why_html`, `bs_short_label`, `bs_entry_num` for glossary terms), shown through Elementor templates. The new theme must read these fields, or they must be moved into post content, before the switchover, or every article will render empty.

## Not in this folder

Full backups (database, files) are never committed. They are kept on the server outside the public folder (`/home/bankssol/banks-backups/`) and in the project files under `backups/2026-10-28/`. The one scheduled post and one draft page are only in those backups.
