/* One industry page. Without JS (or with reduced motion) every note, card and line shows as it is.
   Motion: the feed fills in one task at a time and starts again, the hero folds away on scroll,
   the sections arrive as they're reached. Device screens are handled by devices.js. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises, then the feed handles its tasks in turn */
  var title = document.querySelector('.in-title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.in-crumbs, .in-lede, .in-actions', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.in-feed', { y: 80, rotationX: -14, opacity: 0, duration: 1.4, ease: 'expo.out', transformPerspective: 1200, transformOrigin: '50% 100%' }, 0.3);

  var notes = gsap.utils.toArray('.in-note');
  if (notes.length) {
    var ticks = notes.map(function (n) { return n.querySelector('.in-note__tick'); });
    var live = true;
    var run = function (first) {
      if (!live || document.hidden) { gsap.delayedCall(1.5, function () { run(false); }); return; }
      var t = gsap.timeline({ onComplete: function () { gsap.delayedCall(3.2, function () { run(false); }); } });
      if (!first) t.to(notes, { y: -12, opacity: 0, duration: 0.4, ease: 'power2.in', stagger: 0.05 });
      t.set(ticks, { scale: 0 });
      notes.forEach(function (n, i) {
        t.fromTo(n, { y: 26, opacity: 0 }, { y: 0, opacity: 1, duration: 0.6, ease: 'expo.out' }, (first ? 0 : 0.5) + i * 0.75)
          .to(ticks[i], { scale: 1, duration: 0.45, ease: 'back.out(2.4)' }, '>-0.05');
      });
    };
    tl.add(function () { run(true); }, 0.9);
    gsap.set(notes, { opacity: 0 });
    if (ST) ST.create({ trigger: '.in-feed', start: 'top bottom', end: 'bottom top', onToggle: function (self) { live = self.isActive; } });
  }

  if (!ST) return;

  /* Hero exit, as on every scene page */
  if (!B.lite) {
    var scrub = { trigger: '.in-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.in-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.in-copy', { yPercent: -14, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
  }

  /* 2. Each problem slides in as it's reached */
  gsap.utils.toArray('.in-pain').forEach(function (p) {
    gsap.from(p.children, { x: 40, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.06, scrollTrigger: { trigger: p, start: 'top 85%', once: true } });
  });

  /* 3. The builds rise in pairs */
  ST.batch('.in-build', { start: 'top 90%', once: true, onEnter: function (els) { gsap.from(els, { y: 60, opacity: 0, duration: 1.1, ease: 'expo.out', stagger: 0.1 }); } });

  /* 4. Projects: the laptop and phone come together */
  gsap.utils.toArray('.in-proj').forEach(function (p) {
    var t = gsap.timeline({ scrollTrigger: { trigger: p, start: 'top 80%', once: true } });
    t.from(p.querySelector('.in-proj__laptop'), { y: 70, opacity: 0, duration: 1.2, ease: 'expo.out' })
      .from(p.querySelector('.in-proj__phone'), { y: 120, x: 30, opacity: 0, duration: 1.2, ease: 'expo.out' }, 0.15)
      .from(p.querySelector('.in-proj__info').children, { y: 24, opacity: 0, duration: 0.8, stagger: 0.07 }, 0.25);
  });

  /* 5. The lines over each careful point draw across */
  var care = gsap.utils.toArray('.in-care__item');
  if (care.length) {
    gsap.set(care, { '--on': 0 });
    gsap.to(care, { '--on': 1, duration: 1.2, ease: 'expo.out', stagger: 0.15, scrollTrigger: { trigger: '.in-care__list', start: 'top 85%', once: true } });
  }
})();
