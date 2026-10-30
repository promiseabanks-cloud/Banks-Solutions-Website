/* Banks Labs choreography. Every start state is set here, so the page reads in full without
   JS: the whole release log and every rule are in the HTML in their final state. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises, then the release runs line by line */
  var title = document.querySelector('.lb-title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.lb-eyebrow, .lb-lede, .lb-actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.lb-term', { y: 70, rotationX: -14, opacity: 0, duration: 1.4, ease: 'expo.out', transformPerspective: 1400, transformOrigin: '50% 100%' }, 0.3);

  var term = document.querySelector('.lb-term');
  if (term) {
    var cmd = term.querySelector('.lb-type');
    var text = cmd ? cmd.textContent : '';
    var lines = Array.prototype.slice.call(term.querySelectorAll('.lb-line:not(.lb-line--cmd)'));
    var cursor = term.querySelector('.lb-cursor');
    var blink = gsap.to(cursor, { opacity: 1, duration: 0.5, ease: 'steps(1)', repeat: -1, yoyo: true, paused: true });
    var live = true;

    var run = function () {
      var t = gsap.timeline({ onComplete: function () { gsap.delayedCall(6, again); } });
      gsap.set(lines, { autoAlpha: 0, x: -10 });
      lines.forEach(function (l) { var s = l.querySelector('.lb-line__s'); if (s) gsap.set(s, { autoAlpha: 0, scale: 0.6 }); });
      if (cmd) cmd.textContent = '';
      blink.play();
      var o = { n: 0 };
      t.to(o, { n: text.length, duration: B.lite ? 0.4 : 1.1, ease: 'none', onUpdate: function () { cmd.textContent = text.slice(0, Math.round(o.n)); } });
      lines.forEach(function (l) {
        var s = l.querySelector('.lb-line__s');
        t.to(l, { autoAlpha: 1, x: 0, duration: 0.35, ease: 'power2.out' }, '+=0.25');
        if (s) t.to(s, { autoAlpha: 1, scale: 1, duration: 0.4, ease: 'back.out(2.4)' }, '+=0.25');
      });
      t.add(function () { blink.pause(); gsap.set(cursor, { opacity: 0 }); });
    };
    var again = function () {
      if (!live || document.hidden) { gsap.delayedCall(2, again); return; }
      gsap.to(lines, { autoAlpha: 0, duration: 0.4, stagger: 0.03, onComplete: run });
    };
    tl.add(run, 0.9);
    if (ST) ST.create({ trigger: term, start: 'top bottom', end: 'bottom top', onToggle: function (self) { live = self.isActive; } });
  }

  if (!ST) return;

  /* Hero exit: the frame pulls in and rounds off */
  if (!B.lite) {
    var scrub = { trigger: '.lb-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.lb-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.lb-copy', { yPercent: -14, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
  }

  /* 4. How we build: each rule's line draws across as it enters */
  document.querySelectorAll('.lb-rule').forEach(function (r, i) {
    r.style.setProperty('--on', 0);
    gsap.to(r, { '--on': 1, duration: 1.1, ease: 'expo.inOut', delay: (i % 4) * 0.12, scrollTrigger: { trigger: r, start: 'top 85%', once: true } });
  });
})();
