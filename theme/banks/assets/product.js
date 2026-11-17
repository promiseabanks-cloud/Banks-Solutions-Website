/* Banks Labs product page choreography. Every start state is set here, so the page reads in
   full without JS: every step, capability and mock is in the HTML in its final state. The
   capability index works without motion too (it is plain anchor links). */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};

  /* The capability index marks the area you are reading, with or without motion */
  var links = Array.prototype.slice.call(document.querySelectorAll('.lp-index a'));
  if (links.length && 'IntersectionObserver' in window) {
    var mark = function (id) {
      links.forEach(function (a) {
        var on = a.getAttribute('href') === '#' + id;
        if (on) {
          a.setAttribute('aria-current', 'true');
          var row = a.closest('ol');
          if (row && row.scrollWidth > row.clientWidth) row.scrollTo({ left: a.parentNode.offsetLeft - 20, behavior: B.reduce ? 'auto' : 'smooth' });
        } else {
          a.removeAttribute('aria-current');
        }
      });
    };
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) { if (e.isIntersecting) mark(e.target.id); });
    }, { rootMargin: '-35% 0px -60% 0px' });
    document.querySelectorAll('.lp-group').forEach(function (g) { io.observe(g); });
  }

  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises, then the product mock lands and plays */
  var title = document.querySelector('.lp-title');
  var tl = gsap.timeline({ delay: 0.15, paused: !title });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.lp-back, .lp-eyebrow, .lp-lede, .lp-actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.07 }, '-=0.95')
    .from('.lv-phone, .lv-paper', { y: 80, rotationX: -16, opacity: 0, duration: 1.4, ease: 'expo.out', transformPerspective: 1400, transformOrigin: '50% 100%' }, 0.3)
    .from('.lv-float', { y: 40, x: 20, opacity: 0, scale: 0.94, duration: 1.1, ease: 'expo.out' }, 0.75);

  var lv = document.querySelector('.lv');
  if (lv && title) {
    var inner = gsap.timeline();
    // Project Desk: the phases tick through, the bar fills, the bars grow
    var bar = lv.querySelector('.lv-progress span');
    if (bar) inner.fromTo(bar, { scaleX: 0 }, { scaleX: getComputedStyle(bar.parentNode).getPropertyValue('--p') || 0.72, duration: 1.4, ease: 'power3.out' }, 0);
    var phases = lv.querySelectorAll('.lv-phase');
    if (phases.length) inner.from(phases, { x: -12, opacity: 0, duration: 0.5, stagger: 0.1, ease: 'power2.out' }, 0.1);
    var minis = lv.querySelectorAll('.lv-mini span');
    if (minis.length) inner.from(minis, { scaleY: 0, duration: 0.8, stagger: 0.06, ease: 'expo.out' }, 0.3);
    var wait = lv.querySelector('.lv-card--wait');
    if (wait) inner.from(wait, { y: 14, opacity: 0, duration: 0.6, ease: 'back.out(1.8)' }, 0.8);
    // InvoiceNaija: lines write in, totals settle, the stamp lands
    var lines = lv.querySelectorAll('.lv-line, .lv-totals div, .lv-words, .lv-bank');
    if (lines.length) inner.from(lines, { y: 8, opacity: 0, duration: 0.45, stagger: 0.08, ease: 'power2.out' }, 0.1);
    var stamp = lv.querySelector('.lv-stamp');
    if (stamp) inner.fromTo(stamp, { scale: 2.4, opacity: 0, rotate: -30 }, { scale: 1, opacity: 0.9, rotate: -12, duration: 0.55, ease: 'back.out(2.2)' }, '+=0.15');
    // Car wash: the wallet, the menu choice and the booking tick
    var menu = lv.querySelectorAll('.lv-menu li');
    if (menu.length) inner.from(menu, { y: 10, opacity: 0, duration: 0.45, stagger: 0.08 }, 0.1);
    var booked = lv.querySelector('.lv-card--booked');
    if (booked) inner.from(booked, { scale: 0.9, opacity: 0, duration: 0.6, ease: 'back.out(2)' }, '+=0.1').fromTo(booked.querySelector('.lv-check'), { scale: 0, rotate: -90 }, { scale: 1, rotate: 0, duration: 0.5, ease: 'back.out(3)' }, '-=0.3');
    var wallet = lv.querySelector('.lv-wallet');
    if (wallet) {
      var end = parseInt(wallet.textContent.replace(/\D/g, ''), 10) || 0;
      var o = { v: 0 };
      inner.to(o, { v: end, duration: 1.2, ease: 'power2.out', onUpdate: function () { wallet.textContent = '₦' + Math.round(o.v).toLocaleString('en-NG'); } }, 0);
    }
    // Every mock: the notification arrives, waits, leaves and comes back
    var toast = lv.querySelector('.lv-toast');
    if (toast) {
      inner.fromTo(toast, { y: 24, opacity: 0, scale: 0.92 }, { y: 0, opacity: 1, scale: 1, duration: 0.7, ease: 'back.out(1.8)' }, '+=0.3');
      if (!B.lite) {
        gsap.timeline({ repeat: -1, repeatDelay: 1.2, delay: 7 })
          .to(toast, { y: -10, opacity: 0, duration: 0.45, ease: 'power2.in' })
          .fromTo(toast, { y: 24, opacity: 0, scale: 0.92 }, { y: 0, opacity: 1, scale: 1, duration: 0.7, ease: 'back.out(1.8)', delay: 1.4 })
          .to({}, { duration: 4.5 });
      }
    }
    tl.add(inner, 0.9);
    // A slow float, so the mock feels alive
    if (!B.lite) gsap.to('.lv-float', { y: -10, duration: 3.2, ease: 'sine.inOut', yoyo: true, repeat: -1, stagger: 0.6 });
  }

  if (!ST) return;

  /* Hero exit: the frame pulls in and rounds off */
  if (!B.lite && title) {
    var scrub = { trigger: '.lp-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.lp-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.lp-copy', { yPercent: -14, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
    gsap.to('.lp-visual', { yPercent: 8, ease: 'none', scrollTrigger: scrub });
  }

  /* 3. The problem reads in word by word */
  var big = document.querySelector('.lp-problem [data-scrub]');
  if (big && B.split) {
    gsap.fromTo(B.split(big, 'words'), { opacity: 0.16 }, { opacity: 1, ease: 'none', stagger: 0.1, scrollTrigger: { trigger: big, start: 'top 78%', end: 'bottom 45%', scrub: 0.6 } });
  }

  /* 4. How it works: the line draws and each step lights as it passes */
  var wrap = document.querySelector('.lp-steps__wrap');
  if (wrap) {
    var line = wrap.querySelector('.lp-steps__line i');
    var steps = Array.prototype.slice.call(wrap.querySelectorAll('.lp-step'));
    line.style.setProperty('--draw', 0);
    gsap.set(steps, { opacity: 0.35 });
    ST.create({
      trigger: wrap,
      start: 'top 75%',
      end: 'bottom 55%',
      scrub: 0.5,
      onUpdate: function (self) {
        var p = self.progress;
        line.style.setProperty('--draw', p.toFixed(3));
        steps.forEach(function (s, i) {
          var on = p >= (steps.length > 1 ? i / (steps.length - 1) : 0) - 0.02;
          if (on !== s.classList.contains('is-on')) {
            s.classList.toggle('is-on', on);
            gsap.to(s, { opacity: on ? 1 : 0.35, duration: 0.4, overwrite: true });
          }
        });
      }
    });
  }

  /* 5. Capabilities: each area's cards rise in together */
  document.querySelectorAll('.lp-group').forEach(function (g) {
    gsap.from(g.querySelectorAll('.lp-group__head > *'), { y: 24, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.06, scrollTrigger: { trigger: g, start: 'top 85%', once: true } });
    gsap.from(g.querySelectorAll('.lp-feat'), { y: 34, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: { each: 0.06, grid: 'auto' }, scrollTrigger: { trigger: g.querySelector('.lp-feats'), start: 'top 88%', once: true } });
    gsap.fromTo(g.querySelectorAll('.lp-feat__tick'), { scale: 0 }, { scale: 1, duration: 0.6, ease: 'back.out(3)', stagger: 0.06, delay: 0.3, scrollTrigger: { trigger: g.querySelector('.lp-feats'), start: 'top 88%', once: true } });
  });

  /* 6. How it is built: the orbit turns */
  var orbit = document.querySelector('.lp-orbit');
  if (orbit && !B.lite) {
    var rings = orbit.querySelectorAll('.lp-orbit__ring');
    gsap.to(rings[0], { rotate: 360, duration: 40, ease: 'none', repeat: -1 });
    gsap.to(rings[1], { rotate: -360, duration: 28, ease: 'none', repeat: -1 });
    gsap.to(rings[2], { rotate: 360, duration: 18, ease: 'none', repeat: -1 });
    gsap.from(orbit.querySelector('.lp-orbit__core'), { scale: 0.6, opacity: 0, duration: 1.2, ease: 'expo.out', scrollTrigger: { trigger: orbit, start: 'top 80%', once: true } });
  }
})();
