# Banks Solutions Website

Source for the rebuilt [bankssolution.ng](https://bankssolution.ng): a custom WordPress theme with a GSAP motion layer, and the Banks Core plugin that runs the client portal, onboarding, payments, retainer desk and shop.

## Layout

| Path | What it is |
| --- | --- |
| `theme/banks/` | The Banks theme. Everything visitors see. Holds no business data. |
| `plugins/banks-core/` | Banks Core plugin: portal, onboarding, file vault, progress, invoices, retainer desk, licences. |
| `archive/` | Readable copy of the old site's content (articles, glossary, pages) and the URL redirect map. |
| `docs/` | Plan and decisions. |

Banks Business Engine lives in its own repository and stays a separate plugin.

## Deploying

Copy `theme/banks` into `wp-content/themes/` and `plugins/banks-core` into `wp-content/plugins/` on the staging site first. Nothing goes to the live site until the switchover in phase 1.
