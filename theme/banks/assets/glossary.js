/* Glossary. The search and the A to Z highlight are added here and work with reduced motion
   too; without JS every term shows. Motion: the hero card cycles through definitions. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};

  /* Search: hide terms that don't match, and letters left empty */
  var wrap = document.querySelector('.gl-search');
  var input = wrap && wrap.querySelector('input');
  var groups = Array.prototype.slice.call(document.querySelectorAll('.gl-group'));
  var empty = document.querySelector('.gl-empty');
  var letters = Array.prototype.slice.call(document.querySelectorAll('.gl-az__list a'));
  if (input && groups.length) {
    wrap.hidden = false;
    var t;
    input.addEventListener('input', function () {
      clearTimeout(t);
      t = setTimeout(function () {
        var q = input.value.trim().toLowerCase();
        var any = false;
        groups.forEach(function (g, i) {
          var n = 0;
          g.querySelectorAll('.gl-item').forEach(function (it) { var ok = !q || it.getAttribute('data-text').indexOf(q) !== -1; it.hidden = !ok; if (ok) n++; });
          g.hidden = n === 0;
          if (letters[i]) letters[i].parentNode.style.opacity = n ? '' : '0.3';
          if (n) any = true;
        });
        if (empty) empty.hidden = any;
        if (ST) ST.refresh();
      }, 120);
    });
  }

  /* The letter being read, marked in the A to Z bar */
  if ('IntersectionObserver' in window && letters.length) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        var i = groups.indexOf(e.target);
        letters.forEach(function (a, k) { a.classList.toggle('is-on', k === i); });
      });
    }, { rootMargin: '-35% 0px -55% 0px' });
    groups.forEach(function (g) { io.observe(g); });
  }

  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises, then the card turns over to a new term every few seconds */
  var title = document.querySelector('.gl-title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.gl-eyebrow, .gl-lede, .gl-copy .b-btn', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.gl-card', { y: 80, rotationX: -14, opacity: 0, duration: 1.4, ease: 'expo.out', transformPerspective: 1200, transformOrigin: '50% 100%' }, 0.3);

  var card = document.querySelector('.gl-card');
  var data = card && card.querySelector('.gl-card__data');
  if (card && data) {
    var list = [];
    try { list = JSON.parse(data.textContent); } catch (err) {}
    var term = card.querySelector('.gl-card__term');
    var def = card.querySelector('.gl-card__def');
    var go = card.querySelector('.gl-card__go');
    var idx = card.querySelector('.gl-card__i');
    var at = 0;
    var live = true;
    var next = function () {
      if (!live || document.hidden || list.length < 2) { gsap.delayedCall(2, next); return; }
      at = (at + 1) % list.length;
      gsap.timeline({ onComplete: function () { gsap.delayedCall(4.5, next); } })
        .to([term, def], { y: -14, opacity: 0, duration: 0.35, ease: 'power2.in', stagger: 0.05 })
        .add(function () {
          term.textContent = list[at].title;
          def.textContent = list[at].def;
          go.setAttribute('href', list[at].url);
          idx.textContent = (at + 1 < 10 ? '0' : '') + (at + 1);
        })
        .fromTo([term, def], { y: 18, opacity: 0 }, { y: 0, opacity: 1, duration: 0.55, ease: 'expo.out', stagger: 0.07 });
    };
    gsap.delayedCall(5, next);
    if (ST) ST.create({ trigger: card, start: 'top bottom', end: 'bottom top', onToggle: function (self) { live = self.isActive; } });
  }

  if (!ST) return;

  /* Hero exit, as on every scene page */
  if (!B.lite) {
    var scrub = { trigger: '.gl-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.gl-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.gl-copy', { yPercent: -14, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
  }

  /* 2. Each letter's terms slide in as the letter arrives */
  groups.forEach(function (g) {
    gsap.from(g.querySelectorAll('.gl-item'), { x: 30, opacity: 0, duration: 0.7, ease: 'expo.out', stagger: 0.05, scrollTrigger: { trigger: g, start: 'top 85%', once: true } });
  });
})();
