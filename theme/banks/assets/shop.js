/* Shop choreography. Every start state is set here, so the page reads in full without JS:
   the key, its status and the update notice are all in the HTML in their final state. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises, the card swings in and its key activates */
  var title = document.querySelector('.sh-title');
  var card = document.querySelector('.sh-card');
  var notice = document.querySelector('.sh-notice');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.sh-eyebrow, .sh-lede, .sh-actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95');

  if (card) {
    var segs = Array.prototype.slice.call(card.querySelectorAll('.sh-seg'));
    var words = segs.map(function (s) { return s.textContent; });
    var status = card.querySelector('.sh-status__t');
    var done = status ? status.textContent : '';
    var chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    var noise = function (n) { var o = ''; for (var i = 0; i < n; i++) o += chars[Math.floor(Math.random() * chars.length)]; return o; };
    var sheen = gsap.quickTo(card, '--sx', { duration: 0.8, ease: 'power3.out', unit: '%' });

    // Each segment shuffles, then settles left to right, as if the key were being issued.
    var activate = function () {
      var t = gsap.timeline();
      card.classList.add('is-pending');
      if (status) status.textContent = 'Checking…';
      segs.forEach(function (s, i) {
        var o = { p: 0 };
        t.to(o, {
          p: 1, duration: B.lite ? 0.3 : 0.7, ease: 'none',
          onUpdate: function () {
            var keep = Math.floor(o.p * words[i].length);
            s.textContent = words[i].slice(0, keep) + noise(words[i].length - keep);
          },
          onComplete: function () { s.textContent = words[i]; }
        }, i * 0.22);
      });
      t.add(function () { card.classList.remove('is-pending'); if (status) status.textContent = done; })
        .fromTo(card, { '--sx': '-30%' }, { '--sx': '30%', duration: 1.1, ease: 'power2.inOut' }, '>-0.1');
      if (notice) t.fromTo(notice, { autoAlpha: 0, y: 20, scale: 0.94 }, { autoAlpha: 1, y: 0, scale: 1, duration: 0.6, ease: 'back.out(1.8)' }, '-=0.6');
      return t;
    };

    if (notice) gsap.set(notice, { autoAlpha: 0 });
    segs.forEach(function (s, i) { s.textContent = noise(words[i].length); });
    tl.from(card, { y: 90, rotationY: -28, rotationX: 10, opacity: 0, duration: 1.6, ease: 'expo.out', transformPerspective: 1200 }, 0.35)
      .add(activate(), 0.9);

    // The light follows the pointer across the card.
    if (window.matchMedia('(pointer: fine)').matches) {
      card.addEventListener('mousemove', function (e) {
        var r = card.getBoundingClientRect();
        sheen(((e.clientX - r.left) / r.width - 0.5) * 80);
      });
    }

    // While the hero is on screen the card floats; it pauses once scrolled past.
    if (!B.lite) {
      var rig = document.querySelector('.sh-rig');
      var float = gsap.to(rig, { y: -12, duration: 3.2, ease: 'sine.inOut', yoyo: true, repeat: -1, paused: true });
      tl.add(function () { float.play(); });
      if (ST) ST.create({ trigger: rig, start: 'top bottom', end: 'bottom top', onToggle: function (self) { if (self.isActive && tl.progress() === 1) float.play(); else float.pause(); } });
    }
  }

  if (!ST) return;

  /* Hero exit: the frame pulls in and rounds off */
  if (!B.lite) {
    var scrub = { trigger: '.sh-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.sh-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.sh-copy', { yPercent: -14, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
  }

  /* 2. The shelf: the feature tags on each product drop in after the card */
  document.querySelectorAll('.sh-product').forEach(function (p) {
    gsap.from(p.querySelectorAll('.sh-product__feats li'), { y: 14, opacity: 0, duration: 0.6, ease: 'back.out(1.8)', stagger: 0.06, scrollTrigger: { trigger: p, start: 'top 75%', once: true } });
  });

  /* The engine's card plays its own small story: question, answer, lead, alert */
  var art = document.querySelector('.sh-art');
  if (art) {
    gsap.from(art.children, { y: 24, scale: 0.92, opacity: 0, duration: 0.6, ease: 'back.out(1.7)', stagger: 0.35, scrollTrigger: { trigger: art, start: 'top 75%', once: true } });
  }

  /* 4. How buying works: the line runs and each step lights as it passes */
  var steps = document.querySelector('.sh-steps');
  if (steps) {
    var nums = steps.querySelectorAll('.sh-step__n');
    steps.style.setProperty('--fill', 0);
    gsap.set(nums, { scale: 0.6, opacity: 0.3 });
    var run = gsap.timeline({ scrollTrigger: { trigger: steps, start: 'top 75%', end: 'bottom 55%', scrub: 0.6 } });
    run.to(steps, { '--fill': 1, ease: 'none', duration: 1 }, 0);
    Array.prototype.forEach.call(nums, function (n, i) {
      run.to(n, { scale: 1, opacity: 1, duration: 0.12, ease: 'back.out(2)' }, i / (nums.length - 1) * 0.88);
    });
  }
})();
