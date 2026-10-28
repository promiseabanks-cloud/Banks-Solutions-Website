/* Contact choreography. Every start state is set here, so the page reads in full without JS:
   the whole conversation is in the HTML and the clock shows the time the page was made. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};

  /* The Lagos clock keeps time, motion or not */
  var clock = document.querySelector('[data-clock]');
  if (clock && window.Intl && Intl.DateTimeFormat) {
    var fmt = new Intl.DateTimeFormat('en-GB', { hour: '2-digit', minute: '2-digit', timeZone: 'Africa/Lagos' });
    var tick = function () { clock.textContent = fmt.format(new Date()); };
    tick();
    setInterval(tick, 15000);
  }

  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises, the chat window lifts in */
  var title = document.querySelector('.ct-title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.ct-eyebrow, .ct-lede, .ct-actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.ct-chat', { y: 80, rotationX: -12, opacity: 0, duration: 1.4, ease: 'expo.out', transformPerspective: 1400, transformOrigin: '50% 100%' }, 0.3);

  // The conversation plays out: a typing indicator, then each message, then it starts over.
  var log = document.querySelector('.ct-chat__log');
  var msgs = log ? Array.prototype.slice.call(log.querySelectorAll('.ct-msg')) : [];
  if (msgs.length) {
    var dots = document.createElement('li');
    dots.className = 'ct-msg ct-typing';
    dots.setAttribute('aria-hidden', 'true');
    dots.innerHTML = '<i></i><i></i><i></i>';
    var bob = gsap.to(dots.children, { y: -4, duration: 0.35, ease: 'sine.inOut', stagger: 0.12, yoyo: true, repeat: -1, paused: true });
    var live = true;
    // Hold the window at its full height so it doesn't grow as messages arrive.
    log.style.minHeight = log.offsetHeight + 'px';
    gsap.set(msgs, { display: 'none' });
    var play = function () {
      var t = gsap.timeline({ onComplete: function () { gsap.delayedCall(5, again); } });
      msgs.forEach(function (m) {
        var out = m.classList.contains('ct-msg--out');
        t.add(function () {
          dots.className = 'ct-msg ct-typing ' + (out ? 'ct-msg--out' : 'ct-msg--in');
          log.insertBefore(dots, m);
          bob.play();
        })
          .fromTo(dots, { scale: 0.6, opacity: 0 }, { scale: 1, opacity: 1, duration: 0.3, ease: 'back.out(2)', transformOrigin: out ? '100% 100%' : '0% 100%' })
          .to({}, { duration: B.lite ? 0.6 : Math.min(1.8, 0.5 + m.textContent.length / 70) })
          .add(function () { bob.pause(); if (dots.parentNode) dots.parentNode.removeChild(dots); gsap.set(m, { display: 'block' }); })
          .fromTo(m, { y: 16, scale: 0.92, opacity: 0 }, { y: 0, scale: 1, opacity: 1, duration: 0.5, ease: 'back.out(1.8)', transformOrigin: out ? '100% 100%' : '0% 100%' })
          .to({}, { duration: 0.9 });
      });
    };
    var again = function () {
      if (!live || document.hidden) { gsap.delayedCall(2, again); return; }
      gsap.to(msgs, { opacity: 0, y: -10, duration: 0.5, stagger: 0.05, onComplete: function () { gsap.set(msgs, { display: 'none', clearProps: 'transform' }); play(); } });
    };
    gsap.delayedCall(1.4, play);
    if (ST) ST.create({ trigger: log, start: 'top bottom', end: 'bottom top', onToggle: function (self) { live = self.isActive; } });
  }

  if (!ST) return;

  /* Hero exit: the frame pulls in and rounds off */
  if (!B.lite) {
    var scrub = { trigger: '.ct-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.ct-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.ct-copy', { yPercent: -14, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
  }

  /* 2. The three ways are dealt in */
  gsap.from('.ct-way', { y: 90, rotationX: -18, opacity: 0, duration: 1.3, ease: 'expo.out', stagger: 0.1, transformPerspective: 1000, transformOrigin: '50% 100%', scrollTrigger: { trigger: '.ct-grid', start: 'top 85%', once: true } });

  /* 3. The city names slide in from the side */
  document.querySelectorAll('.ct-city__name').forEach(function (n, i) {
    gsap.from(n, { xPercent: i % 2 ? 12 : -12, ease: 'none', scrollTrigger: { trigger: n, start: 'top bottom', end: 'top 50%', scrub: true } });
  });
})();
