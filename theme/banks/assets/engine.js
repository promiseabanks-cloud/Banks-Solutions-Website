/* Banks Business Engine choreography. Every start state is set here, so the page reads in full
   without JS: the whole conversation, the finished lead and all three screens are in the HTML. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};

  /* "Try it live" opens the real assistant when the plugin is running on this page */
  var launcher = document.querySelector('[data-bbe-ai-launcher]');
  var tryBtn = document.querySelector('.en-try');
  if (launcher && tryBtn) {
    tryBtn.hidden = false;
    var setup = document.querySelector('.en-setup');
    if (setup) { setup.classList.remove('b-btn--signal'); setup.classList.add('b-btn--line'); setup.removeAttribute('data-magnetic'); }
    tryBtn.addEventListener('click', function () { launcher.click(); });
  }

  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises, then the console plays an enquiry through to a booking */
  var title = document.querySelector('.en-title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.en-eyebrow, .en-lede, .en-actions > *:not([hidden])', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.en-console__chat, .en-console__lead', { y: 80, rotationX: -12, opacity: 0, duration: 1.4, ease: 'expo.out', stagger: 0.12, transformPerspective: 1400, transformOrigin: '50% 100%' }, 0.3);

  var chat = document.querySelector('.en-chat');
  var msgs = chat ? Array.prototype.slice.call(chat.querySelectorAll('.en-msg')) : [];
  var fields = Array.prototype.slice.call(document.querySelectorAll('.en-field dd'));
  var score = document.querySelector('.en-score');
  var scoreN = document.querySelector('.en-score__n');
  var booked = document.querySelector('.en-booked');
  var toast = document.querySelector('.en-toast');
  if (msgs.length) {
    var full = fields.map(function (f) { return f.textContent; });
    var end = parseInt(scoreN.getAttribute('data-score'), 10) || 0;
    var dots = document.createElement('li');
    dots.className = 'en-msg en-typing';
    dots.setAttribute('aria-hidden', 'true');
    dots.innerHTML = '<i></i><i></i><i></i>';
    var bob = gsap.to(dots.children, { y: -4, duration: 0.35, ease: 'sine.inOut', stagger: 0.12, yoyo: true, repeat: -1, paused: true });
    var live = true;
    chat.style.minHeight = chat.offsetHeight + 'px';
    var reset = function () {
      gsap.set(msgs, { display: 'none', opacity: 1, y: 0 });
      fields.forEach(function (f) { f.textContent = '—'; f.style.opacity = 0.4; });
      score.style.setProperty('--p', 0);
      scoreN.textContent = '0';
      gsap.set([booked, toast], { autoAlpha: 0 });
    };
    var play = function () {
      reset();
      var t = gsap.timeline({ onComplete: function () { gsap.delayedCall(5, again); } });
      msgs.forEach(function (m) {
        var mine = m.classList.contains('en-msg--in');
        t.add(function () {
          dots.className = 'en-msg en-typing ' + (mine ? 'en-msg--in' : 'en-msg--out');
          chat.insertBefore(dots, m);
          bob.play();
        })
          .fromTo(dots, { scale: 0.6, opacity: 0 }, { scale: 1, opacity: 1, duration: 0.3, ease: 'back.out(2)' })
          .to({}, { duration: B.lite ? 0.5 : Math.min(1.6, 0.5 + m.textContent.length / 80) })
          .add(function () { bob.pause(); if (dots.parentNode) dots.parentNode.removeChild(dots); gsap.set(m, { display: 'block' }); })
          .fromTo(m, { y: 14, scale: 0.94, opacity: 0 }, { y: 0, scale: 1, opacity: 1, duration: 0.45, ease: 'back.out(1.8)' })
          .to({}, { duration: 0.5 });
      });
      // The lead fills in as if the assistant were writing it down.
      fields.forEach(function (f, i) {
        var o = { n: 0 };
        t.to(o, {
          n: full[i].length, duration: 0.5, ease: 'none',
          onStart: function () { f.style.opacity = 1; },
          onUpdate: function () { f.textContent = full[i].slice(0, Math.round(o.n)) || '—'; }
        }, i ? '-=0.15' : '+=0.1');
      });
      var s = { v: 0 };
      t.to(s, { v: end, duration: 1, ease: 'power2.out', onUpdate: function () { score.style.setProperty('--p', s.v / 100); scoreN.textContent = Math.round(s.v); } }, '-=0.6')
        .fromTo(booked, { autoAlpha: 0, y: 10 }, { autoAlpha: 1, y: 0, duration: 0.5, ease: 'back.out(2)' }, '+=0.2')
        .fromTo(toast, { autoAlpha: 0, y: 24, scale: 0.96 }, { autoAlpha: 1, y: 0, scale: 1, duration: 0.6, ease: 'back.out(1.6)' }, '+=0.5');
    };
    var again = function () {
      if (!live || document.hidden) { gsap.delayedCall(2, again); return; }
      gsap.to(msgs.concat([booked, toast]), { opacity: 0, duration: 0.5, stagger: 0.04, onComplete: play });
    };
    gsap.delayedCall(1.5, play);
    if (ST) ST.create({ trigger: chat, start: 'top bottom', end: 'bottom top', onToggle: function (self) { live = self.isActive; } });
  }

  if (!ST) return;

  /* Hero exit: the frame pulls in and rounds off */
  if (!B.lite) {
    var scrub = { trigger: '.en-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.en-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.en-copy', { yPercent: -14, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
  }

  /* 2. The 9pm problem lights up word by word */
  var big = document.querySelector('[data-scrub]');
  if (big && B.split) {
    gsap.fromTo(B.split(big, 'words'), { opacity: 0.16 }, { opacity: 1, ease: 'none', stagger: 0.1, scrollTrigger: { trigger: big, start: 'top 78%', end: 'bottom 45%', scrub: 0.6 } });
  }

  /* 3. What it does: pinned on wide screens, one job and its screen at a time */
  var does = document.querySelector('.en-does');
  var steps = Array.prototype.slice.call(document.querySelectorAll('.en-step'));
  var screens = Array.prototype.slice.call(document.querySelectorAll('.en-screen'));
  var enter = function (sc) {
    if (sc.classList.contains('en-screen--answer')) gsap.fromTo(sc.querySelectorAll('.en-q, .en-a'), { y: 20, scale: 0.94, opacity: 0 }, { y: 0, scale: 1, opacity: 1, duration: 0.6, ease: 'back.out(1.8)', stagger: 0.35 });
    if (sc.classList.contains('en-screen--qualify')) gsap.fromTo(sc.querySelectorAll('.en-checks li'), { x: 30, opacity: 0 }, { x: 0, opacity: 1, duration: 0.6, ease: 'expo.out', stagger: 0.12 });
    if (sc.classList.contains('en-screen--pattern')) gsap.fromTo(sc.querySelectorAll('.en-bars span'), { scaleY: 0 }, { scaleY: 1, duration: 0.8, ease: 'expo.out', stagger: 0.05 });
  };
  if (does && steps.length === screens.length) {
    var mm = gsap.matchMedia();
    mm.add('(min-width: 961px) and (min-height: 640px)', function () {
      var at = -1;
      does.classList.add('is-pinned');
      gsap.set(screens, { autoAlpha: 0 });
      var show = function (i) {
        if (i === at) return;
        var from = screens[at];
        at = i;
        steps.forEach(function (s, k) { s.classList.toggle('is-on', k === i); });
        if (from) gsap.to(from, { autoAlpha: 0, y: -30, duration: 0.45, ease: 'power2.in' });
        gsap.fromTo(screens[i], { autoAlpha: 0, y: 40, rotationX: -8 }, { autoAlpha: 1, y: 0, rotationX: 0, duration: 0.8, ease: 'expo.out', delay: from ? 0.2 : 0, transformPerspective: 1200 });
        enter(screens[i]);
      };
      ST.create({
        trigger: does,
        start: 'top top',
        end: '+=' + Math.round(window.innerHeight * 0.8 * steps.length),
        pin: does.querySelector('.en-does__pin'),
        onUpdate: function (self) { show(Math.min(steps.length - 1, Math.floor(self.progress * steps.length))); }
      });
      show(0);
      return function () {
        does.classList.remove('is-pinned');
        steps.forEach(function (s) { s.classList.remove('is-on'); });
        gsap.set(screens, { clearProps: 'all' });
      };
    });
    mm.add('(max-width: 960px), (max-height: 639px)', function () {
      screens.forEach(function (sc) { ST.create({ trigger: sc, start: 'top 80%', once: true, onEnter: function () { enter(sc); } }); });
    });
  }

  /* 4. What's inside: the grid fills in */
  gsap.from('.en-feat', { y: 30, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: { each: 0.05, grid: 'auto', from: 'start' }, scrollTrigger: { trigger: '.en-grid', start: 'top 85%', once: true } });

  /* 5. The vault turns while it is on screen */
  var rings = document.querySelectorAll('.en-vault__ring');
  if (rings.length && !B.lite) {
    var spin = gsap.timeline({ repeat: -1, paused: true })
      .to(rings[0], { rotation: 360, duration: 40, ease: 'none' }, 0)
      .to(rings[2], { rotation: -360, duration: 28, ease: 'none' }, 0);
    ST.create({ trigger: '.en-vault', start: 'top bottom', end: 'bottom top', onToggle: function (self) { if (self.isActive) spin.play(); else spin.pause(); } });
    gsap.from('.en-vault__core', { scale: 0.4, opacity: 0, duration: 1.2, ease: 'back.out(1.6)', scrollTrigger: { trigger: '.en-vault', start: 'top 80%', once: true } });
  }
})();
