/* Homepage choreography. Every start state is set here, so the page reads in full without JS. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

  /* FAQ: smooth open and close (also without motion libraries, the native details still works) */
  document.querySelectorAll('.h-qa').forEach(function (d) {
    var s = d.querySelector('summary');
    var a = d.querySelector('.h-qa__a');
    if (!gsap || B.reduce || !s || !a) return;
    s.addEventListener('click', function (e) {
      e.preventDefault();
      if (d.open) {
        gsap.to(a, { height: 0, duration: 0.45, ease: 'power2.inOut', onComplete: function () { d.open = false; gsap.set(a, { clearProps: 'height' }); } });
      } else {
        d.open = true;
        gsap.from(a, { height: 0, duration: 0.55, ease: 'power3.out', clearProps: 'height' });
      }
    });
  });

  if (!gsap || B.reduce) return;

  /* Light that follows the cursor across dark scenes */
  if (fine) {
    document.querySelectorAll('.h-hero__stage, .h-cta').forEach(function (el) {
      var glow = el.querySelector('.h-hero__glow');
      if (!glow) return;
      var o = { x: 72, y: 28 };
      var set = function () { glow.style.setProperty('--gx', o.x + '%'); glow.style.setProperty('--gy', o.y + '%'); };
      el.addEventListener('mousemove', function (e) {
        var r = el.getBoundingClientRect();
        gsap.to(o, { x: ((e.clientX - r.left) / r.width) * 100, y: ((e.clientY - r.top) / r.height) * 100, duration: 1.2, ease: 'power3.out', onUpdate: set, overwrite: true });
      });
    });
  }

  /* 1. Hero entrance: the headline rises line by line while the river draws itself */
  var title = document.querySelector('[data-split-hero]');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.3, ease: 'expo.out', stagger: 0.1 });
  tl.from('.h-hero__eyebrow, .h-hero__lede, .h-hero__actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.h-hero__proof li', { y: 20, opacity: 0, duration: 0.8, stagger: 0.07 }, '-=0.6')
    .from('.h-hero__scroll', { opacity: 0, duration: 0.6 }, '-=0.3');
  document.querySelectorAll('.h-flow__line').forEach(function (line, i) {
    if (!line.getTotalLength) return;
    var len = line.getTotalLength();
    gsap.set(line, { strokeDasharray: len, strokeDashoffset: len });
    tl.to(line, { strokeDashoffset: 0, duration: 2.4, ease: 'power2.inOut' }, 0.1 + i * 0.35);
  });
  tl.from('.h-flow__bank', { opacity: 0, duration: 1.6 }, 0.5);

  if (!ST) return;

  /* Hero exit: the frame pulls in and rounds off, the content drifts up and fades */
  if (!B.lite) {
    var stage = document.querySelector('.h-hero__stage');
    if (stage) {
      gsap.fromTo(stage, { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: { trigger: '.h-hero', start: 'top top', end: 'bottom top', scrub: true } });
      gsap.to('.h-hero__inner', { yPercent: -18, opacity: 0.15, ease: 'none', scrollTrigger: { trigger: '.h-hero', start: 'top top', end: 'bottom top', scrub: true } });
      gsap.to('.h-flow', { yPercent: 16, ease: 'none', scrollTrigger: { trigger: '.h-hero', start: 'top top', end: 'bottom top', scrub: true } });
    }
  }

  /* 2. Marquee: drifts on its own, runs faster (and backwards) with the scroll */
  var mq = document.querySelector('.h-marquee');
  if (mq) {
    mq.querySelectorAll('.h-marquee__dupe').forEach(function (li) { li.hidden = false; });
    mq.classList.add('is-running');
    var track = mq.querySelector('.h-marquee__track');
    var loop = gsap.to(track, { xPercent: -50, duration: B.lite ? 60 : 40, ease: 'none', repeat: -1 });
    if (!B.lite) {
      ST.create({
        trigger: mq, start: 'top bottom', end: 'bottom top',
        onUpdate: function (self) {
          var dir = self.direction < 0 ? -1 : 1;
          var boost = Math.min(6, Math.max(1, Math.abs(self.getVelocity()) / 300));
          gsap.to(loop, { timeScale: dir * boost, duration: 0.3, overwrite: true, onComplete: function () { gsap.to(loop, { timeScale: dir, duration: 1.2 }); } });
        }
      });
    }
    mq.addEventListener('mouseenter', function () { gsap.to(loop, { timeScale: 0.2, duration: 0.6 }); });
    mq.addEventListener('mouseleave', function () { gsap.to(loop, { timeScale: 1, duration: 0.6 }); });
  }

  /* 3. The problem paragraph lights up word by word */
  document.querySelectorAll('[data-scrub-words]').forEach(function (p) {
    var words = window.SplitText ? window.SplitText.create(p, { type: 'words', aria: 'auto' }).words : [p];
    gsap.fromTo(words, { opacity: 0.14 }, { opacity: 1, stagger: 0.1, ease: 'none', scrollTrigger: { trigger: p, start: 'top 78%', end: 'bottom 42%', scrub: true } });
  });

  /* 4. What we build: pinned, scrolls sideways on large screens; a reveal everywhere else */
  var build = document.querySelector('.h-build');
  var mm = gsap.matchMedia();
  if (build) {
    mm.add('(min-width: 981px)', function () {
      if (B.lite) return;
      var track = build.querySelector('.h-build__track');
      var bar = build.querySelector('.h-build__bar span');
      build.classList.add('is-horizontal');
      var dist = function () { return Math.max(0, track.scrollWidth - window.innerWidth); };
      var run = gsap.to(track, {
        x: function () { return -dist(); }, ease: 'none',
        scrollTrigger: { trigger: build, start: 'top top', end: function () { return '+=' + dist(); }, pin: true, scrub: 0.8, invalidateOnRefresh: true, anticipatePin: 1 }
      });
      if (bar) gsap.fromTo(bar, { scaleX: 0 }, { scaleX: 1, ease: 'none', scrollTrigger: { trigger: build, start: 'top top', end: function () { return '+=' + dist(); }, scrub: true, invalidateOnRefresh: true } });
      // Each panel's orb drifts against the run for depth.
      build.querySelectorAll('.h-panel__orb').forEach(function (orb) {
        gsap.fromTo(orb, { xPercent: 30 }, { xPercent: -30, ease: 'none', scrollTrigger: { trigger: orb.closest('.h-panel'), containerAnimation: run, start: 'left right', end: 'right left', scrub: true } });
      });
      return function () { build.classList.remove('is-horizontal'); gsap.set(track, { clearProps: 'transform' }); };
    });
    mm.add('(max-width: 980px)', function () {
      gsap.from(build.querySelectorAll('.h-panel'), { y: 50, opacity: 0, duration: 1, stagger: 0.08, scrollTrigger: { trigger: build.querySelector('.h-build__track'), start: 'top 85%', once: true } });
    });
  }

  /* 6. Process rail fills with the scroll, each step lights as the rail reaches it */
  var rail = document.querySelector('.h-steps__rail span');
  if (rail) {
    gsap.fromTo(rail, { scaleY: 0 }, { scaleY: 1, ease: 'none', scrollTrigger: { trigger: '.h-steps', start: 'top 60%', end: 'bottom 60%', scrub: true } });
    document.querySelectorAll('.h-step').forEach(function (step) {
      ST.create({ trigger: step, start: 'top 60%', onToggle: function (self) { step.classList.toggle('is-on', self.isActive || self.progress > 0); }, end: 'max' });
    });
  }

  /* 7. Spotlight on product cards */
  if (fine) {
    document.querySelectorAll('[data-spot]').forEach(function (card) {
      card.addEventListener('mousemove', function (e) {
        var r = card.getBoundingClientRect();
        card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
        card.style.setProperty('--my', (e.clientY - r.top) + 'px');
      });
    });
  }

  /* 9. Closing call: the headline scales up into place */
  var cta = document.querySelector('.h-cta__title');
  if (cta && !B.lite) gsap.from(cta, { scale: 0.86, opacity: 0.4, ease: 'none', scrollTrigger: { trigger: '.h-cta', start: 'top bottom', end: 'top 30%', scrub: true } });
})();
