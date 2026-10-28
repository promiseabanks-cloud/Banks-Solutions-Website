/* Knowledge hub. The topic chips and search are added here and work with reduced motion too;
   without JS every article shows. Motion: the cover fan opens, the glossary drifts in rows. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};

  /* Filter by topic and search, together */
  var items = Array.prototype.slice.call(document.querySelectorAll('.kn-grid__item'));
  var chips = Array.prototype.slice.call(document.querySelectorAll('.kn-chip'));
  var search = document.querySelector('.kn-search input');
  var empty = document.querySelector('.kn-empty');
  var more = document.querySelector('.kn-more');
  var topic = '';
  var all = false;
  var apply = function (quiet) {
    var q = search ? search.value.trim().toLowerCase() : '';
    var shown = [];
    // With no filter the library starts at 12 guides; a topic or a search shows every match.
    var cap = all || topic || q ? Infinity : 12;
    items.forEach(function (it) {
      var ok = (!topic || it.getAttribute('data-topic') === topic) && (!q || it.getAttribute('data-text').indexOf(q) !== -1);
      if (ok && shown.length >= cap) ok = false;
      it.hidden = !ok;
      if (ok) shown.push(it);
    });
    if (empty) empty.hidden = shown.length > 0;
    if (more) more.hidden = cap === Infinity || items.length <= cap;
    if (quiet !== true && gsap && !B.reduce && shown.length) gsap.fromTo(shown.slice(0, 9), { y: 18, opacity: 0 }, { y: 0, opacity: 1, duration: 0.5, ease: 'power2.out', stagger: 0.04, overwrite: true });
    if (ST) ST.refresh();
  };
  if (items.length) {
    document.querySelectorAll('.kn-tools, .kn-chips').forEach(function (el) { el.hidden = false; });
    chips.forEach(function (c) {
      c.addEventListener('click', function () {
        topic = c.getAttribute('data-topic');
        chips.forEach(function (o) { var on = o === c; o.classList.toggle('is-on', on); o.setAttribute('aria-pressed', on ? 'true' : 'false'); });
        apply();
      });
    });
    if (more) more.querySelector('button').addEventListener('click', function () { all = true; apply(); });
    // A topic link from an article (/knowledge/?topic=slug) opens the library on that topic.
    var want = (window.location.search.match(/[?&]topic=([a-z0-9-]+)/) || [])[1];
    var pick = want && chips.filter(function (c) { return c.getAttribute('data-topic') === want; })[0];
    if (pick) {
      topic = want;
      chips.forEach(function (o) { var on = o === pick; o.classList.toggle('is-on', on); o.setAttribute('aria-pressed', on ? 'true' : 'false'); });
    }
    apply(true);
    if (search) {
      var t;
      search.addEventListener('input', function () { clearTimeout(t); t = setTimeout(apply, 120); });
    }
  }

  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises and the covers fan out from a stack */
  var title = document.querySelector('.kn-title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.kn-eyebrow, .kn-lede, .kn-stats > div', { y: 28, opacity: 0, duration: 1, stagger: 0.07 }, '-=0.95');
  var fan = gsap.utils.toArray('.kn-fan__card');
  if (fan.length) {
    tl.from(fan, { y: 120, rotation: 0, xPercent: 0, opacity: 0, duration: 1.5, ease: 'expo.out', stagger: { each: 0.12, from: 'end' } }, 0.35);
    if (!B.lite && window.matchMedia('(pointer: fine)').matches) {
      var rig = document.querySelector('.kn-fan');
      var ry = gsap.quickTo(rig, 'rotationY', { duration: 0.8, ease: 'power3.out' });
      var rx = gsap.quickTo(rig, 'rotationX', { duration: 0.8, ease: 'power3.out' });
      document.querySelector('.kn-stage').addEventListener('mousemove', function (e) {
        ry((e.clientX / window.innerWidth - 0.5) * 14);
        rx(-(e.clientY / window.innerHeight - 0.5) * 10);
      });
    }
  }

  if (!ST) return;

  /* Hero exit: the frame pulls in and the covers spread as they leave */
  if (!B.lite) {
    var scrub = { trigger: '.kn-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.kn-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.kn-copy', { yPercent: -14, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
    if (fan[1]) gsap.to(fan[1], { rotation: -22, xPercent: -10, ease: 'none', scrollTrigger: scrub });
    if (fan[2]) gsap.to(fan[2], { rotation: 22, xPercent: 10, ease: 'none', scrollTrigger: scrub });
  }

  /* 3. Library cards rise as they arrive */
  ST.batch(items, { start: 'top 92%', once: true, onEnter: function (els) { gsap.fromTo(els, { y: 40, opacity: 0 }, { y: 0, opacity: 1, duration: 0.9, ease: 'expo.out', stagger: 0.06 }); } });

  /* 4. Glossary: the terms split into rows that drift opposite ways with the scroll */
  var gloss = document.querySelector('.kn-gloss');
  var list = gloss && gloss.querySelector('.kn-terms');
  if (list && !B.lite) {
    var terms = Array.prototype.slice.call(list.children);
    var n = window.innerWidth < 700 ? 4 : 3;
    var rows = [];
    for (var r = 0; r < n; r++) { var row = document.createElement('ul'); row.className = 'kn-row'; rows.push(row); }
    terms.forEach(function (li, i) { rows[i % n].appendChild(li); });
    rows.forEach(function (row) { var li = document.createElement('li'); li.appendChild(row); list.appendChild(li); });
    list.setAttribute('role', 'list');
    gloss.classList.add('is-rows');
    rows.forEach(function (row, i) {
      var dir = i % 2 ? 1 : -1;
      gsap.fromTo(row, { x: function () { return dir > 0 ? -(row.scrollWidth - window.innerWidth) * 0.6 : 0; } }, {
        x: function () { return dir > 0 ? 0 : -(row.scrollWidth - window.innerWidth) * 0.6; },
        ease: 'none',
        scrollTrigger: { trigger: gloss, start: 'top bottom', end: 'bottom top', scrub: 0.6, invalidateOnRefresh: true }
      });
    });
  }
})();
