# Banks Solutions Website

Rebuild of bankssolution.ng, following the same pattern as the 1904 Solutions build: a hand-coded classic WordPress theme plus a separate plugin for business logic. The full plan is in `docs/plan.html`.

## Structure

- `theme/banks/` is presentation only. One template per page (`front-page.php`, `page-<slug>.php`), per-page CSS/JS pairs in `assets/` enqueued only on that page, shared motion in `assets/motion.{css,js}`.
- `plugins/banks-core/` (to come) owns all business data: clients, projects, uploads, invoices, retainers, licences. The theme must never store business data.
- Banks Business Engine is a separate plugin in its own repo (`business-engine`). Embed it, don't fork it here.

## Brand

Brand guide v1.0 is final. Use the tokens in `theme/banks/assets/main.css`, never raw hex in page CSS.
- Name is always "Banks Solutions" (plural). Domain stays bankssolution.ng.
- Signal yellow (`--b-signal`) is for actions only, plus the dot in the logo.
- Fonts: Familjen Grotesk (display), Public Sans (body), IBM Plex Mono (labels, data). They carry the ₦ glyph; don't swap them.
- Stats in copy: 9.0 rating, 7+ brands built.

## Motion

- GSAP 3.13 (with ScrollTrigger and SplitText) and Lenis are vendored in `theme/banks/assets/vendor/`. Load nothing from a CDN.
- Pages opt in with attributes: `data-reveal`, `data-split`, `data-magnetic`, `data-tilt`, `data-count` (+ `data-decimals`). Prefer these over one-off code.
- Every page must read correctly with JavaScript off and with reduced motion on. Start states are set by JS, never by CSS.
- Respect `Banks.lite` (weak phones, data saver): no smooth scroll, fewer simultaneous effects.
- Speed budget: usable in under 2.5s on a mid-range Android on 4G.

## Rules

- Never commit backups, database dumps, `.env` files or credentials. `.gitignore` blocks the common ones.
- Keep every old URL working or 301 it; the map will live in `archive/`.
- WordPress coding standards for PHP (tabs, `esc_*` on all output, `banks_`-prefixed functions).
