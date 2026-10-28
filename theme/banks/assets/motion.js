/*
 * Banks motion layer: smooth scroll, island header, page curtain, Signal cursor,
 * magnetic buttons, 3D tilt, split headings, scroll reveals, counters, reading progress
 * and the speed receipt. Pages opt in with data attributes:
 *   data-reveal  data-split  data-magnetic="0.3"  data-tilt  data-count="9.0" data-decimals="1"
 */
(function () {
  var doc = document.documentElement;
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  // Light mode for weak phones: fewer simultaneous effects, no smooth scroll.
  var lite = !!((navigator.deviceMemory && navigator.deviceMemory <= 2) || (navigator.hardwareConcurrency || 8) <= 2 || (navigator.connection && navigator.connection.saveData));
  var gsap = window.gsap;
  var header = document.querySelector('.b-header');
  var B = (window.Banks = window.Banks || {});
  B.reduce = reduce;
  B.lite = lite;

  function done() {
    window.__banksReady = true;
  }
  /* Theme switch: remembers the choice; the new theme spreads out from the button */
  var toggles = document.querySelectorAll('[data-theme-toggle]');
  function label() {
    var dark = doc.getAttribute('data-theme') === 'dark';
    toggles.forEach(function (b) { b.setAttribute('aria-label', dark ? 'Switch to light mode' : 'Switch to dark mode'); b.setAttribute('aria-pressed', String(dark)); });
  }
  B.setTheme = function (t, from) {
    function apply() {
      doc.setAttribute('data-theme', t);
      try { localStorage.setItem('banks-theme', t); } catch (err) {}
      label();
      document.dispatchEvent(new CustomEvent('banks:theme', { detail: t }));
    }
    if (from && document.startViewTransition && !reduce) {
      var r = from.getBoundingClientRect();
      doc.style.setProperty('--b-vt-x', (r.left + r.width / 2) + 'px');
      doc.style.setProperty('--b-vt-y', (r.top + r.height / 2) + 'px');
      document.startViewTransition(apply);
    } else apply();
  };
  toggles.forEach(function (b) {
    b.addEventListener('click', function () { B.setTheme(doc.getAttribute('data-theme') === 'dark' ? 'light' : 'dark', b); });
  });
  label();

  if (!gsap) {
    doc.classList.remove('js-motion');
    done();
    return;
  }
  if (window.ScrollTrigger) gsap.registerPlugin(window.ScrollTrigger);
  if (window.SplitText) gsap.registerPlugin(window.SplitText);
  var ST = window.ScrollTrigger;
  gsap.defaults({ ease: 'power3.out', duration: 0.9 });

  /* Smooth scroll */
  var lenis = null;
  if (!reduce && !lite && window.Lenis) {
    lenis = new window.Lenis({ lerp: 0.1, smoothWheel: true });
    B.lenis = lenis;
    if (ST) lenis.on('scroll', ST.update);
    gsap.ticker.add(function (t) { lenis.raf(t * 1000); });
    gsap.ticker.lagSmoothing(0);
  }
  B.scrollTo = function (target) {
    if (lenis) lenis.scrollTo(target, { offset: 0, duration: 1.4 });
    else (typeof target === 'string' ? document.querySelector(target) : target).scrollIntoView({ behavior: reduce ? 'auto' : 'smooth' });
  };
  document.addEventListener('click', function (e) {
    var a = e.target.closest('a[href^="#"]');
    if (!a || a.getAttribute('href').length < 2) return;
    var el = document.querySelector(a.getAttribute('href'));
    if (!el) return;
    e.preventDefault();
    B.scrollTo(el);
  });

  /* Header: gathers into a floating island after 24px, with a small spring as it lands */
  var inner = header && header.querySelector('.b-header__inner');
  var island = false;
  function onScroll() {
    var on = (window.scrollY || 0) > 24;
    if (!header || on === island) return;
    island = on;
    header.classList.toggle('is-scrolled', on);
    if (on && inner && !reduce) {
      inner.classList.remove('b-island-pulse');
      void inner.offsetWidth;
      inner.classList.add('b-island-pulse');
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* Mobile menu: stagger the big links in */
  var burger = document.querySelector('.b-burger');
  if (burger) {
    burger.addEventListener('click', function () {
      if (!document.body.classList.contains('b-nav-open') || reduce) {
        if (lenis) lenis.start();
        return;
      }
      if (lenis) lenis.stop();
      gsap.fromTo('.b-nav .b-nav__list li, .b-nav > a', { y: 40, opacity: 0 }, { y: 0, opacity: 1, duration: 0.6, stagger: 0.06, delay: 0.05 });
    });
  }

  /* Page curtain: lift on load, drop on internal navigation */
  var curtain = document.querySelector('.b-curtain');
  if (curtain) {
    var seen = null;
    try { seen = sessionStorage.getItem('banks-curtain'); sessionStorage.removeItem('banks-curtain'); } catch (err) {}
    if (reduce || seen !== '1') {
      curtain.style.display = 'none';
    } else {
      gsap.set(curtain, { yPercent: 0 });
      gsap.to(curtain, { yPercent: -100, duration: 0.8, ease: 'expo.inOut', delay: 0.05, onComplete: function () { curtain.style.display = 'none'; } });
    }
    document.addEventListener('click', function (e) {
      var a = e.target.closest('a[href]');
      if (!a || reduce || e.defaultPrevented || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;
      if ((a.target && a.target !== '_self') || a.hasAttribute('download')) return;
      var url;
      try { url = new URL(a.href, location.href); } catch (err) { return; }
      if (url.origin !== location.origin || url.pathname.indexOf('/wp-') === 0) return;
      if (url.pathname === location.pathname && url.hash) return;
      e.preventDefault();
      try { sessionStorage.setItem('banks-curtain', '1'); } catch (err) {}
      curtain.style.display = 'grid';
      gsap.fromTo(curtain, { yPercent: 100 }, { yPercent: 0, duration: 0.55, ease: 'expo.in', onComplete: function () { location.href = url.href; } });
    });
    window.addEventListener('pageshow', function (e) { if (e.persisted) curtain.style.display = 'none'; });
  }

  /* Split a heading into masked words; SplitText keeps the original text for screen readers */
  B.split = function (el, type) {
    if (!window.SplitText) return [el];
    var s = window.SplitText.create(el, { type: type || 'words', mask: type || 'words', wordsClass: 'b-split-word', linesClass: 'b-split-line', aria: 'auto' });
    return type === 'lines' ? s.lines : s.words;
  };

  /* Magnetic buttons */
  B.magnet = function (el) {
    if (!fine || reduce || el.dataset.magnetDone) return;
    el.dataset.magnetDone = '1';
    var k = parseFloat(el.getAttribute('data-magnetic')) || 0.3;
    var xTo = gsap.quickTo(el, 'x', { duration: 0.5 });
    var yTo = gsap.quickTo(el, 'y', { duration: 0.5 });
    el.addEventListener('mousemove', function (e) {
      var r = el.getBoundingClientRect();
      xTo((e.clientX - r.left - r.width / 2) * k);
      yTo((e.clientY - r.top - r.height / 2) * k);
    });
    el.addEventListener('mouseleave', function () {
      gsap.to(el, { x: 0, y: 0, duration: 0.9, ease: 'elastic.out(1, 0.35)' });
    });
  };
  document.querySelectorAll('[data-magnetic], .elementor-button').forEach(B.magnet);

  /* 3D tilt */
  B.tilt = function (el) {
    if (!fine || reduce) return;
    gsap.set(el, { transformPerspective: 900 });
    var rx = gsap.quickTo(el, 'rotationX', { duration: 0.6 });
    var ry = gsap.quickTo(el, 'rotationY', { duration: 0.6 });
    el.addEventListener('mousemove', function (e) {
      var r = el.getBoundingClientRect();
      ry(((e.clientX - r.left) / r.width - 0.5) * 12);
      rx(-((e.clientY - r.top) / r.height - 0.5) * 12);
    });
    el.addEventListener('mouseleave', function () { rx(0); ry(0); });
  };
  document.querySelectorAll('[data-tilt]').forEach(B.tilt);

  /* Cursor: ring follows with lag, the Signal dot tracks exactly */
  if (fine && !reduce) {
    var ring = document.createElement('div');
    var dot = document.createElement('div');
    ring.className = 'b-cursor';
    dot.className = 'b-cursor-dot';
    document.body.appendChild(ring);
    document.body.appendChild(dot);
    var cx = gsap.quickTo(ring, 'x', { duration: 0.45 });
    var cy = gsap.quickTo(ring, 'y', { duration: 0.45 });
    var started = false;
    window.addEventListener('mousemove', function (e) {
      if (!started) { started = true; doc.classList.add('has-cursor'); gsap.set([ring, dot], { x: e.clientX, y: e.clientY }); }
      cx(e.clientX);
      cy(e.clientY);
      gsap.set(dot, { x: e.clientX, y: e.clientY });
      var t = e.target;
      ring.classList.toggle('is-link', !!(t.closest && t.closest('a, button, [data-tilt]')));
      ring.classList.toggle('is-dark', !!(t.closest && t.closest('[data-dark], .b-footer, .b-nav-open .b-nav')));
    }, { passive: true });
    document.addEventListener('mouseleave', function () { doc.classList.remove('has-cursor'); started = false; });
  }

  if (ST && !reduce) {
    /* Scroll reveals on theme blocks. Old Elementor pages keep their own animations. */
    var items = Array.prototype.filter.call(document.querySelectorAll('[data-reveal]'), function (el) { return !el.closest('.h-hero'); });
    gsap.set(items, { y: 40, opacity: 0 });
    ST.batch(items, {
      start: 'top 90%',
      once: true,
      onEnter: function (batch) { gsap.to(batch, { y: 0, opacity: 1, duration: 1, stagger: lite ? 0 : 0.08, overwrite: true }); }
    });

    /* Split headings rise word by word */
    document.querySelectorAll('[data-split]').forEach(function (h) {
      if (h.closest('.h-hero')) return;
      var words = B.split(h);
      gsap.from(words, { yPercent: 110, duration: 1.1, ease: 'expo.out', stagger: 0.05, scrollTrigger: { trigger: h, start: 'top 90%', once: true } });
    });

    /* Counters keep their final value in the HTML, so the page reads right without JS */
    document.querySelectorAll('[data-count]').forEach(function (el) {
      var end = parseFloat(el.getAttribute('data-count'));
      var dec = parseInt(el.getAttribute('data-decimals') || '0', 10);
      var o = { v: 0 };
      el.textContent = (0).toFixed(dec);
      gsap.to(o, { v: end, duration: 1.6, ease: 'power2.out', scrollTrigger: { trigger: el, start: 'top 92%', once: true }, onUpdate: function () { el.textContent = o.v.toFixed(dec); } });
    });

    /* Reading progress on articles */
    var bar = document.querySelector('.b-progress span');
    if (bar) {
      gsap.to(bar, { scaleX: 1, ease: 'none', scrollTrigger: { trigger: '.b-article', start: 'top top', end: 'bottom bottom', scrub: 0.3 } });
    }

    window.addEventListener('load', function () { ST.refresh(); });
  }

  /* Speed receipt: what this page actually cost the visitor to load */
  var receipt = document.querySelector('[data-receipt]');
  if (receipt && window.performance && performance.getEntriesByType) {
    window.addEventListener('load', function () {
      setTimeout(function () {
        var nav = performance.getEntriesByType('navigation')[0];
        if (!nav) return;
        var bytes = (nav.transferSize || 0) + performance.getEntriesByType('resource').reduce(function (s, r) { return s + (r.transferSize || 0); }, 0);
        var secs = nav.loadEventStart / 1000;
        if (!bytes || !secs) return;
        receipt.textContent = 'This page loaded in ' + secs.toFixed(1) + 's and weighed ' + Math.round(bytes / 1024) + ' KB';
        receipt.hidden = false;
      }, 0);
    });
  }

  done();
})();
