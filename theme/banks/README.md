# Banks theme

Coded theme for bankssolution.ng. Copy this folder to `wp-content/themes/banks` and activate it on staging.

| File | Purpose |
| --- | --- |
| `functions.php` | Setup, asset loading, helpers (`banks_site()`, `banks_portal_url()`, `banks_brand()`), Customizer details |
| `header.php` / `footer.php` | Island header, page curtain, footer with the speed receipt |
| `front-page.php` | Homepage (first pass: hero, flow line, proof strip) |
| `single.php` | Knowledge articles with reading progress |
| `page.php` | Plain pages; hands over to Elementor for Elementor-built pages |
| `assets/main.css` | Brand and motion tokens, base layout |
| `assets/motion.{css,js}` | Shared motion layer |
| `assets/article.css` | Long-form reading styles, also used in the block editor |
| `assets/home.{css,js}` | Homepage only |

Set `BANKS_PORTAL_DOMAIN` in `wp-config.php` (e.g. `portal.bankssolution.ng`) once the portal site exists; until then portal links fall back to `/portal/`.
