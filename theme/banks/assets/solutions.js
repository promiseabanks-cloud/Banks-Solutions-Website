/* Solutions hub choreography. Every start state is set here, so the page reads in full without JS. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises line by line while the reel frame tips up into place */
  var title = document.querySelector('.sl-hero__title');
  var reel = document.querySelector('.sl-reel');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.sl-hero__eyebrow, .sl-hero__lede, .sl-hero__actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.sl-reel__frame', { y: 80, rotationX: -16, opacity: 0, duration: 1.4, ease: 'expo.out', transformOrigin: '50% 100%' }, 0.3)
    .from('.sl-reel__tabs li', { y: 16, opacity: 0, duration: 0.7, ease: 'expo.out', stagger: 0.05 }, 0.8);

  /* The reel: each solution plays a short scene of itself working, then hands over to the next */
  if (reel) {
    var screens = Array.prototype.slice.call(reel.querySelectorAll('.sl-scr'));
    var tabs = Array.prototype.slice.call(reel.querySelectorAll('.sl-reel__tabs li'));
    var where = reel.querySelector('.sl-reel__where');
    var HOLD = B.lite ? 5 : 4.2;
    var cur = 0;
    var timer = null;
    var q = function (el, sel) { return el.querySelectorAll(sel); };
    var scenes = {
      site: function (el, t) {
        t.from(q(el, '.sl-scr__bar'), { scaleX: 0, transformOrigin: 'left', duration: 0.7, ease: 'expo.out', stagger: 0.08 })
          .from(q(el, '.sl-scr__pill'), { scale: 0.6, opacity: 0, duration: 0.6, ease: 'back.out(2)' }, 0.3)
          .from(q(el, '.sl-scr__tiles span'), { y: 24, opacity: 0, duration: 0.7, ease: 'expo.out', stagger: 0.07 }, 0.35)
          .from(q(el, '.sl-scr__toast'), { x: 60, opacity: 0, duration: 0.8, ease: 'expo.out' }, 1);
      },
      portal: function (el, t) {
        var n = el.querySelector('[data-reel-count]');
        var o = { v: 0 };
        t.from(q(el, '.sl-scr__side span'), { x: -14, opacity: 0, duration: 0.5, stagger: 0.05 })
          .from(q(el, '.sl-scr__main > em, .sl-scr__big'), { y: 14, opacity: 0, duration: 0.6, ease: 'expo.out', stagger: 0.06 }, 0.1)
          .from(q(el, '.sl-scr__meter span'), { scaleX: 0, duration: 1.4, ease: 'power3.inOut' }, 0.3)
          .to(o, { v: 68, duration: 1.4, ease: 'power3.inOut', onUpdate: function () { if (n) n.textContent = Math.round(o.v); } }, 0.3)
          .from(q(el, '.sl-scr__steps li'), { x: -12, opacity: 0, duration: 0.5, stagger: 0.12 }, 0.5)
          .from(q(el, '.sl-scr__pill'), { scale: 0.6, opacity: 0, duration: 0.6, ease: 'back.out(2)' }, 1.2);
      },
      flow: function (el, t) {
        var nodes = q(el, '.sl-scr__node');
        var links = q(el, '.sl-scr__link');
        t.from(nodes[0], { y: 18, opacity: 0, duration: 0.6, ease: 'expo.out' });
        for (var k = 0; k < links.length; k++) {
          t.from(links[k], { scaleY: 0, duration: 0.4, ease: 'power2.inOut' })
            .from(nodes[k + 1], { y: 18, opacity: 0, duration: 0.6, ease: 'expo.out' }, '-=0.05');
        }
      },
      chat: function (el, t) {
        q(el, '.sl-scr__msg').forEach(function (m, k) {
          var mine = m.classList.contains('sl-scr__msg--in');
          t.from(m, { y: 14, scale: 0.85, opacity: 0, duration: 0.5, ease: 'back.out(1.8)', transformOrigin: mine ? '100% 100%' : '0% 100%' }, k ? '+=0.35' : 0);
        });
      },
      care: function (el, t) {
        t.from(q(el, '.sl-scr__stat'), { y: 20, opacity: 0, duration: 0.6, ease: 'expo.out', stagger: 0.08 })
          .from(q(el, '.sl-scr__uptime span'), { scaleY: 0, duration: 0.5, ease: 'expo.out', stagger: 0.02 }, 0.3);
      },
      search: function (el, t) {
        var qy = el.querySelector('.sl-scr__query');
        var text = qy.getAttribute('data-text') || qy.textContent;
        qy.setAttribute('data-text', text);
        var o = { n: 0 };
        t.fromTo(o, { n: 0 }, { n: text.length, duration: 1.1, ease: 'none', onUpdate: function () { qy.textContent = text.slice(0, Math.round(o.n)); } })
          .from(q(el, '.sl-scr__answer'), { y: 22, opacity: 0, duration: 0.7, ease: 'expo.out' }, '+=0.2')
          .from(q(el, '.sl-scr__answer mark'), { backgroundColor: 'rgba(0,0,0,0)', duration: 0.6 }, '-=0.2')
          .from(q(el, '.sl-scr__src'), { scale: 0.6, opacity: 0, duration: 0.5, ease: 'back.out(2)' }, '-=0.3');
      }
    };
    var kind = function (el) { return el.className.match(/sl-scr--(\w+)/)[1]; };
    var running = [];
    var play = function (k) {
      var el = screens[k];
      // Finish any earlier run first, so every .from() starts from the screen's resting state.
      if (running[k]) running[k].progress(1).kill();
      var t = running[k] = gsap.timeline();
      var inner = gsap.timeline();
      t.fromTo(el, { opacity: 0, y: 18, filter: B.lite ? 'none' : 'blur(6px)' }, { opacity: 1, y: 0, filter: 'blur(0px)', duration: 0.55, ease: 'expo.out', clearProps: 'filter', overwrite: true });
      if (scenes[kind(el)]) scenes[kind(el)](el, inner);
      t.add(inner, 0.15);
    };
    var progress = function (k) {
      tabs.forEach(function (tab, i) {
        tab.classList.toggle('is-on', i === k);
        gsap.set(tab.querySelector('.sl-reel__prog span'), { scaleX: 0 });
      });
      if (timer) timer.kill();
      timer = gsap.fromTo(tabs[k].querySelector('.sl-reel__prog span'), { scaleX: 0 }, { scaleX: 1, duration: HOLD, ease: 'none', onComplete: function () { go((k + 1) % screens.length); } });
    };
    var go = function (k) {
      if (k === cur) { progress(k); return; }
      // Quick clicks can leave a screen mid-exit; anything that is neither leaving nor arriving goes now.
      screens.forEach(function (el, i) {
        if (i === cur || i === k || !el.classList.contains('is-on')) return;
        gsap.killTweensOf(el);
        if (running[i]) running[i].progress(1).kill();
        el.classList.remove('is-on');
        gsap.set(el, { clearProps: 'opacity,transform,filter' });
      });
      var out = screens[cur];
      var was = cur;
      gsap.to(out, { opacity: 0, y: -14, duration: 0.35, ease: 'power2.in', overwrite: true, onComplete: function () {
        if (cur === was) return;
        if (running[was]) running[was].progress(1).kill();
        out.classList.remove('is-on');
        gsap.set(out, { clearProps: 'opacity,transform' });
      } });
      cur = k;
      gsap.set(screens[k], { opacity: 0 });
      screens[k].classList.add('is-on');
      if (where) {
        gsap.timeline().to(where, { opacity: 0, duration: 0.2 }).add(function () { where.textContent = screens[k].getAttribute('data-where'); }).to(where, { opacity: 1, duration: 0.3 });
      }
      gsap.delayedCall(0.3, function () { if (cur === k) play(k); });
      progress(k);
    };
    tabs.forEach(function (tab, i) { tab.querySelector('button').addEventListener('click', function () { go(i); }); });
    reel.addEventListener('mouseenter', function () { if (timer) timer.pause(); });
    reel.addEventListener('mouseleave', function () { if (timer) timer.resume(); });
    tl.add(function () { play(0); progress(0); }, 1.1);
    if (ST) ST.create({ trigger: reel, start: 'top bottom', end: 'bottom top', onToggle: function (self) { if (timer) timer[self.isActive ? 'resume' : 'pause'](); } });

    // Depth: the frame leans gently towards the cursor.
    if (fine && !B.lite) {
      var frame = reel.querySelector('.sl-reel__frame');
      var rx = gsap.quickTo(frame, 'rotationX', { duration: 1.2, ease: 'power3.out' });
      var ry = gsap.quickTo(frame, 'rotationY', { duration: 1.2, ease: 'power3.out' });
      document.querySelector('.sl-hero__stage').addEventListener('mousemove', function (e) {
        ry((e.clientX / window.innerWidth - 0.5) * 9);
        rx((e.clientY / window.innerHeight - 0.5) * -7);
      });
    }
  }

  if (!ST) return;
  var once = function (trigger, start) { return { trigger: trigger, start: start || 'top 82%', once: true }; };

  /* Hero exit: the frame pulls in and rounds off, the reel sinks back as you scroll past */
  if (!B.lite) {
    var scrub = { trigger: '.sl-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.sl-hero__stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.sl-hero__copy', { yPercent: -18, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
    if (reel) gsap.to(reel, { yPercent: -10, scale: 0.94, opacity: 0.2, ease: 'none', scrollTrigger: scrub });
  }

  /* 2. Start where it hurts: each symptom rises in, the arrow draws, the answer slides in after it */
  document.querySelectorAll('.sl-row').forEach(function (row) {
    var pain = row.querySelector('.sl-row__pain');
    var line = row.querySelector('.sl-row__arrow span');
    var t = gsap.timeline({ scrollTrigger: once(row, 'top 88%') });
    t.from(row.querySelector('.sl-row__num'), { opacity: 0, x: -16, duration: 0.6 })
      .from(pain ? B.split(pain, 'words') : [], { yPercent: 110, duration: 0.9, ease: 'expo.out', stagger: 0.025 }, 0.05);
    if (line) t.fromTo(line, { clipPath: 'inset(0 100% 0 0)' }, { clipPath: 'inset(0 0% 0 0)', duration: 0.8, ease: 'expo.inOut', clearProps: 'clipPath' }, 0.35);
    t.from(row.querySelector('.sl-row__fix'), { x: 30, opacity: 0, duration: 0.8, ease: 'expo.out' }, 0.65);
  });

  /* 3. The six in depth: each card settles back and shrinks a little as the next one slides over it */
  var cards = Array.prototype.slice.call(document.querySelectorAll('.sl-card'));
  var mm = gsap.matchMedia();
  mm.add('(min-width: 901px) and (min-height: 701px)', function () {
    if (B.lite) return;
    cards.forEach(function (card, i) {
      var next = cards[i + 1];
      if (!next) return;
      var span = { trigger: next, start: 'top 85%', end: 'top 15%', scrub: true };
      gsap.to(card.querySelector('.sl-card__inner'), { scale: 0.92, ease: 'none', scrollTrigger: span });
      gsap.fromTo(card.querySelector('.sl-card__shade'), { opacity: 0 }, { opacity: 0.45, ease: 'none', scrollTrigger: span });
    });
  });
  cards.forEach(function (card) {
    var t = gsap.timeline({ scrollTrigger: once(card, 'top 75%') });
    t.from(card.querySelectorAll('.sl-card__main > *'), { y: 34, opacity: 0, duration: 1, ease: 'expo.out', stagger: 0.07 })
      .from(card.querySelector('.sl-card__big'), { yPercent: 40, opacity: 0, duration: 1.4, ease: 'expo.out' }, 0)
      .from(card.querySelectorAll('.sl-card__label, .sl-card__items li'), { y: 18, scale: 0.9, opacity: 0, duration: 0.7, ease: 'back.out(1.8)', stagger: 0.05 }, 0.3);
  });

  /* 4. Prices: rows rise in turn (scenes.js counts the naira figures up) */
  var prices = document.querySelector('.sl-table');
  if (prices) {
    gsap.from(prices.querySelectorAll('tr'), { y: 30, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.08, scrollTrigger: once(prices, 'top 85%') });
  }

  /* 5. Any field: the two lines of type drift in opposite directions as the section passes */
  var fields = document.querySelector('.sl-fields');
  if (fields) {
    fields.classList.add('is-moving');
    var rows = fields.querySelectorAll('.sl-fields__row');
    var span = function () { return { trigger: fields, start: 'top bottom', end: 'bottom top', scrub: true, invalidateOnRefresh: true }; };
    var far = function (row) { return function () { return -(row.scrollWidth - window.innerWidth * 0.6); }; };
    if (rows[0]) gsap.fromTo(rows[0], { x: '4vw' }, { x: far(rows[0]), ease: 'none', scrollTrigger: span() });
    if (rows[1]) gsap.fromTo(rows[1], { x: far(rows[1]) }, { x: '4vw', ease: 'none', scrollTrigger: span() });
  }
})();
