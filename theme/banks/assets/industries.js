/* Industries hub. Without JS (or with reduced motion) the headline keeps its first field and the
   index is a plain list. Motion: the fields roll through the headline, a preview of each field
   follows the pointer over the index, the hero folds away on scroll. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises, then the field rolls over every couple of seconds */
  var tl = gsap.timeline({ delay: 0.15 });
  tl.from('.ix-title__line, .ix-roll', { yPercent: 110, opacity: 0, duration: 1.2, ease: 'expo.out', stagger: 0.12 })
    .from('.ix-eyebrow, .ix-lede, .ix-inner > .b-btn', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.9');

  var words = gsap.utils.toArray('.ix-roll__word');
  if (words.length > 1) {
    var at = 0;
    var live = true;
    words.forEach(function (w, i) { if (i) gsap.set(w, { yPercent: 110 }); w.classList.add('is-on'); });
    var roll = function () {
      if (!live || document.hidden) { gsap.delayedCall(1, roll); return; }
      var out = words[at];
      at = (at + 1) % words.length;
      gsap.to(out, { yPercent: -110, duration: 0.7, ease: 'power3.in' });
      gsap.fromTo(words[at], { yPercent: 110 }, { yPercent: 0, duration: 0.9, ease: 'expo.out', delay: 0.45, onComplete: function () { gsap.delayedCall(1.6, roll); } });
    };
    gsap.delayedCall(2.6, roll);
    if (ST) ST.create({ trigger: '.ix-hero', start: 'top bottom', end: 'bottom top', onToggle: function (self) { live = self.isActive; } });
  }

  if (!ST) return;

  /* Hero exit, as on every scene page */
  if (!B.lite) {
    var scrub = { trigger: '.ix-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.ix-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.ix-inner', { yPercent: -14, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
  }

  /* 2. The index rows slide in, then a preview of each field follows the pointer */
  ST.batch('.ix-row', { start: 'top 92%', once: true, onEnter: function (els) { gsap.from(els, { y: 40, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.06 }); } });

  var index = document.querySelector('.ix-index');
  var peek = document.querySelector('.ix-peek');
  if (index && peek && !B.lite && window.matchMedia('(pointer: fine) and (min-width: 901px)').matches) {
    var cards = peek.querySelectorAll('.ix-peek__card');
    index.classList.add('js-peek');
    gsap.set(peek, { yPercent: -50, autoAlpha: 0, scale: 0.7, transformOrigin: '0% 50%' });
    gsap.set(cards, { autoAlpha: 0 });
    var px = gsap.quickTo(peek, 'x', { duration: 0.55, ease: 'power3.out' });
    var py = gsap.quickTo(peek, 'y', { duration: 0.55, ease: 'power3.out' });
    var pr = gsap.quickTo(peek, 'rotation', { duration: 0.8, ease: 'power3.out' });
    var lastX = 0;
    var shown = -1;
    index.addEventListener('mousemove', function (e) {
      px(Math.min(e.clientX + 48, window.innerWidth - peek.offsetWidth - 24));
      py(e.clientY);
      pr(Math.max(-8, Math.min(8, (e.clientX - lastX) * 0.4)));
      lastX = e.clientX;
    });
    index.querySelectorAll('[data-peek]').forEach(function (row) {
      var i = parseInt(row.getAttribute('data-peek'), 10);
      row.addEventListener('mouseenter', function () {
        if (shown !== i) {
          if (cards[shown]) gsap.to(cards[shown], { autoAlpha: 0, duration: 0.25 });
          gsap.fromTo(cards[i], { autoAlpha: 0, y: 14 }, { autoAlpha: 1, y: 0, duration: 0.4, ease: 'power3.out' });
          shown = i;
        }
        gsap.to(peek, { autoAlpha: 1, scale: 1, duration: 0.45, ease: 'expo.out' });
      });
      row.addEventListener('mouseleave', function () { gsap.to(peek, { autoAlpha: 0, scale: 0.85, duration: 0.3, ease: 'power2.in' }); });
    });
  }

  /* 3. The three standards draw in */
  gsap.from('.ix-same__list li', { y: 50, opacity: 0, duration: 1, ease: 'expo.out', stagger: 0.12, scrollTrigger: { trigger: '.ix-same__list', start: 'top 85%', once: true } });
})();
