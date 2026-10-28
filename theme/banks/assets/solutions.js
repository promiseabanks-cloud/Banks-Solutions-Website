/* Solutions hub choreography. Every start state is set here, so the page reads in full without JS. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises line by line while the orbit assembles around "your business" */
  var title = document.querySelector('.sl-hero__title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.sl-hero__eyebrow, .sl-hero__lede, .sl-hero__actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.sl-orbit__ring', { scale: 0.6, opacity: 0, duration: 1.6, ease: 'expo.out', stagger: 0.12 }, 0.2)
    .from('.sl-orbit__core', { scale: 0, opacity: 0, duration: 1.1, ease: 'back.out(1.8)' }, 0.45)
    .from('.sl-node__spoke', { scaleX: 0, duration: 1, ease: 'expo.inOut', stagger: 0.08 }, 0.7)
    .from('.sl-node__chip', { scale: 0, opacity: 0, duration: 0.9, ease: 'back.out(2)', stagger: 0.08 }, 1);

  var orbit = document.querySelector('.sl-orbit');
  if (orbit && !B.lite) {
    // The six drift slowly around the core, and pause while the cursor is over them.
    var spin = gsap.to(orbit, { '--spin': '360deg', duration: 140, ease: 'none', repeat: -1 });
    orbit.addEventListener('mouseenter', function () { gsap.to(spin, { timeScale: 0.1, duration: 0.8 }); });
    orbit.addEventListener('mouseleave', function () { gsap.to(spin, { timeScale: 1, duration: 0.8 }); });
    if (fine) {
      var rx = gsap.quickTo(orbit, 'rotationX', { duration: 1.2, ease: 'power3.out' });
      var ry = gsap.quickTo(orbit, 'rotationY', { duration: 1.2, ease: 'power3.out' });
      gsap.set(orbit, { transformPerspective: 1200 });
      document.querySelector('.sl-hero__stage').addEventListener('mousemove', function (e) {
        ry((e.clientX / window.innerWidth - 0.5) * 16);
        rx((e.clientY / window.innerHeight - 0.5) * -12);
      });
    }
  }

  if (!ST) return;
  var once = function (trigger, start) { return { trigger: trigger, start: start || 'top 82%', once: true }; };

  /* Hero exit: the frame pulls in and rounds off, the orbit grows and fades as you pass through it */
  if (!B.lite) {
    var scrub = { trigger: '.sl-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.sl-hero__stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.sl-hero__copy', { yPercent: -18, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
    if (orbit) gsap.to(orbit, { scale: 1.3, opacity: 0, ease: 'none', scrollTrigger: scrub });
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

  /* 4. Prices: rows rise in turn and the naira figures count up to their value */
  var prices = document.querySelector('.sl-table');
  if (prices) {
    gsap.from(prices.querySelectorAll('tr'), { y: 30, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.08, scrollTrigger: once(prices, 'top 85%') });
    prices.querySelectorAll('[data-naira]').forEach(function (el) {
      var end = parseInt(el.getAttribute('data-naira'), 10);
      var o = { v: 0 };
      gsap.to(o, {
        v: end, duration: 1.6, ease: 'power3.out', scrollTrigger: once(el, 'top 90%'),
        onUpdate: function () { el.textContent = Math.round(o.v).toLocaleString('en-NG'); },
        onComplete: function () { el.textContent = end.toLocaleString('en-NG'); }
      });
    });
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
