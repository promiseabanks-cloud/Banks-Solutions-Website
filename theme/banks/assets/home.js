/* Homepage choreography. Every start state is set here, so the page reads in full without JS. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

  if (!gsap || B.reduce) return;

  /* 1. Hero. The entrance plays on load; the story (one order, six beats) is scrubbed by the scroll
     while the stage sticks (CSS sticky, so no pin spacer and no relayout). Weak phones keep the flat layout from home.css and only get the entrance. */
  var hero = document.querySelector('.h-hero');
  var stage = hero && hero.querySelector('.h-hero__stage');
  var scene = hero && hero.querySelector('.h-scene');
  var q = function (sel) { return hero.querySelector(sel); };
  var qa = function (sel) { return Array.prototype.slice.call(hero.querySelectorAll(sel)); };
  var story = !!(hero && scene && ST && !B.lite && !document.documentElement.classList.contains('js-lite'));
  var phone = hero && q('.h-phone');

  var tl = gsap.timeline({ delay: 0.15 });
  var say = hero && q('[data-split-hero]');
  if (say) tl.from(B.split(say, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.h-hero__eyebrow, .h-hero__lede, .h-hero__actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.h-hero__proof li', { y: 20, opacity: 0, duration: 0.8, stagger: 0.07 }, '-=0.6')
    .from('.h-phone__float', { y: 90, rotation: 5, opacity: 0, duration: 1.4, ease: 'expo.out' }, 0.35)
    .from('.h-scene__halo', { scale: 0.6, opacity: 0, duration: 1.6 }, 0.35)
    .from('.h-rail', { opacity: 0, duration: 0.8 }, '-=0.6');

  var buildStory = function () {
    var beats = qa('[data-beat]');
    var last = beats.length - 1;
    // One scene unit in px. Read once and again after a resize, never between writes.
    var unit = 0;
    var u = function () { return unit || (unit = parseFloat(getComputedStyle(scene).fontSize) || 16); };
    ST.addEventListener('refreshInit', function () { unit = 0; });
    var em = function (v) { return function () { return v * u(); }; };
    var parts = beats.map(function (b, i) {
      return { lines: i ? [b.querySelector('.h-beat__rise')] : [], rest: Array.prototype.slice.call(b.querySelectorAll('.h-beat__tag, .h-beat__text')) };
    });
    // Start states: later beats wait below their masks, the props wait inside the phone.
    parts.forEach(function (p, i) {
      if (!i) return;
      gsap.set(p.lines, { yPercent: 104 });
      gsap.set(p.rest, { autoAlpha: 0, y: 24 });
      gsap.set(beats[i], { visibility: 'visible' });
    });
    gsap.set(qa('.h-prop, .h-scr--lock, .h-scr--chat, .h-scr__pay-b, .h-note, .h-msg'), { autoAlpha: 0 });
    gsap.set(q('.h-scr__sheet'), { autoAlpha: 1, yPercent: 105 });
    gsap.set(q('.h-scr__tap'), { autoAlpha: 1, scale: 0 });
    gsap.set(phone, { rotationY: -16, rotationX: 4 });

    // The timeline is built in a task of its own, to keep each one short on slow phones.
    setTimeout(function () {

    var dots = qa('[data-rail]');
    var step = 0;
    var setStep = function (i) {
      if (i === step) return;
      step = i;
      dots.forEach(function (b, n) { b.classList.toggle('is-on', n === i); });
    };
    var st = gsap.timeline({
      defaults: { ease: 'power2.inOut' },
      scrollTrigger: {
        trigger: hero, start: 'top top', end: 'bottom bottom', scrub: 0.7, invalidateOnRefresh: true,
        onUpdate: function (self) { setStep(Math.min(last, Math.floor(self.progress * st.duration() + 0.45))); }
      }
    });
    var swap = function (i) {
      var at = i - 1;
      if (i === 1) st.to(beats[0], { yPercent: -10, autoAlpha: 0, duration: 0.28, ease: 'power2.in' }, at);
      else st.to(parts[at].lines, { yPercent: -104, duration: 0.28, ease: 'power2.in' }, at).to(parts[at].rest, { autoAlpha: 0, y: -16, duration: 0.22, ease: 'power2.in' }, at);
      st.fromTo(parts[i].lines, { yPercent: 104 }, { yPercent: 0, duration: 0.42, ease: 'power3.out', immediateRender: false }, at + 0.26)
        .fromTo(parts[i].rest, { autoAlpha: 0, y: 24 }, { autoAlpha: 1, y: 0, duration: 0.36, ease: 'power2.out', stagger: 0.06, immediateRender: false }, at + 0.34);
    };
    var pop = function (el, from, at, dur, rot) {
      st.fromTo(el, Object.assign({ autoAlpha: 0 }, from), { autoAlpha: 1, scale: 1, x: 0, y: 0, rotation: rot || 0, duration: dur || 0.45, ease: 'back.out(1.3)', immediateRender: false }, at);
    };
    for (var i = 1; i <= last; i++) swap(i);
    st.fromTo(q('.h-rail__line span'), { scaleX: 0 }, { scaleX: 1, ease: 'none', duration: last }, 0);

    // Beat 1, the order: a tap on Pay, the button answers, the confirmation sheet slides up.
    st.to(phone, { rotationY: -6, rotationX: 2, x: em(-1.5), duration: 0.6 }, 0)
      .fromTo(q('.h-scr__tap'), { scale: 0, opacity: 0.9 }, { scale: 1, opacity: 0, duration: 0.22, ease: 'power1.out', immediateRender: false }, 0.1)
      .to(q('.h-scr__pay-a'), { autoAlpha: 0, duration: 0.06 }, 0.2)
      .to(q('.h-scr__pay-b'), { autoAlpha: 1, duration: 0.06 }, 0.22)
      .to(q('.h-scr__sheet'), { yPercent: 0, duration: 0.3, ease: 'power3.out' }, 0.36)
      .fromTo(q('.h-scr__tick'), { scale: 0 }, { scale: 1, duration: 0.22, ease: 'back.out(2.6)', immediateRender: false }, 0.5);
    pop(q('.h-chip--paid'), { scale: 0.5, x: em(-4) }, 0.5, 0.3);

    // Beat 2, WhatsApp: the phone locks, the notification drops in and the message lifts out of it.
    st.to(q('.h-chip--paid'), { autoAlpha: 0, y: em(-2), duration: 0.2 }, 1)
      .to(phone, { rotationY: 14, x: em(5.5), duration: 0.6 }, 1)
      .to(q('.h-scr--lock'), { autoAlpha: 1, duration: 0.22 }, 1.08)
      .fromTo(q('.h-note--wa'), { autoAlpha: 0, y: em(-3), scale: 0.9 }, { autoAlpha: 1, y: 0, scale: 1, duration: 0.3, ease: 'back.out(1.5)', immediateRender: false }, 1.3);
    pop(q('.h-wa'), { scale: 0.3, x: em(11), y: em(3), rotation: 10 }, 1.36, 0.45, -4);

    // Beat 3, the email: a second notification, and the receipt flies out the other side.
    st.to(q('.h-wa'), { autoAlpha: 0, y: em(-4), scale: 0.86, duration: 0.24 }, 2)
      .to(phone, { rotationY: -14, x: em(-6.5), duration: 0.6 }, 2)
      .fromTo(q('.h-note--mail'), { autoAlpha: 0, y: em(-3), scale: 0.9 }, { autoAlpha: 1, y: 0, scale: 1, duration: 0.3, ease: 'back.out(1.5)', immediateRender: false }, 2.22);
    pop(q('.h-mail'), { scale: 0.3, x: em(-11), y: em(2), rotation: -10 }, 2.3, 0.45, 3);
    st.fromTo(qa('.h-mail__rows li, .h-mail__foot'), { opacity: 0, x: em(-1) }, { opacity: 1, x: 0, duration: 0.18, stagger: 0.05, ease: 'power2.out', immediateRender: false }, 2.5);

    // Beat 4, the dashboard: the phone steps aside, the window rises, the numbers move.
    var rev = q('[data-dash-rev]');
    var ord = q('[data-dash-ord]');
    var stk = q('[data-dash-stk]');
    var num = { v: 1 };
    var count = function () {
      rev.textContent = Math.round(1260000 + 24500 * num.v).toLocaleString('en-NG');
      ord.textContent = num.v > 0.5 ? '37' : '36';
      stk.textContent = num.v > 0.5 ? '11' : '12';
    };
    st.to(q('.h-mail'), { autoAlpha: 0, y: em(-5), rotation: 8, duration: 0.24 }, 3)
      .to(phone, { x: em(-12.5), y: em(9.5), scale: 0.52, rotationY: 20, duration: 0.6 }, 3)
      .fromTo(q('.h-dash'), { autoAlpha: 0, y: em(14), rotationX: 26, scale: 0.9 }, { autoAlpha: 1, y: 0, rotationX: 0, scale: 1, duration: 0.55, ease: 'power3.out', immediateRender: false }, 3.08)
      .fromTo(qa('.h-dash__chart span'), { scaleY: 0 }, { scaleY: 1, duration: 0.3, stagger: 0.03, ease: 'power3.out', immediateRender: false }, 3.3)
      .fromTo(q('.h-dash__rows .is-new'), { opacity: 0, x: em(-2) }, { opacity: 1, x: 0, duration: 0.2, ease: 'power2.out', immediateRender: false }, 3.55)
      .fromTo(num, { v: 0 }, { v: 1, duration: 0.3, ease: 'power1.out', onUpdate: count, immediateRender: false }, 3.55);

    // Beat 5, AI: the dashboard falls back, the phone returns with the customer's question answered.
    st.to(q('.h-dash'), { scale: 0.8, x: em(5), y: em(-6), autoAlpha: 0.32, duration: 0.5 }, 4)
      .to(phone, { x: em(-2.5), y: 0, scale: 1, rotationY: -8, duration: 0.6 }, 4)
      .to(q('.h-scr--chat'), { autoAlpha: 1, duration: 0.18 }, 4.12)
      .fromTo(q('.h-msg--in'), { autoAlpha: 0, y: em(1.5) }, { autoAlpha: 1, y: 0, duration: 0.16, ease: 'power2.out', immediateRender: false }, 4.34)
      .to(q('.h-msg--typing'), { autoAlpha: 1, duration: 0.08 }, 4.5)
      .to(q('.h-msg--typing'), { autoAlpha: 0, duration: 0.06 }, 4.68)
      .fromTo(q('.h-msg--out'), { autoAlpha: 0, y: em(1.5), scale: 0.9 }, { autoAlpha: 1, y: 0, scale: 1, duration: 0.2, ease: 'back.out(1.4)', transformOrigin: '100% 100%', immediateRender: false }, 4.7);
    pop(q('.h-chip--ai'), { scale: 0.5, x: em(-5), y: em(3) }, 4.8, 0.3);
    st.to({}, { duration: 0.3 }, last);

    // The rail jumps to a beat.
    dots.forEach(function (b, n) {
      b.addEventListener('click', function () {
        var t = st.scrollTrigger;
        var y = t.start + (t.end - t.start) * Math.min(1, (n + (n ? 0.02 : 0)) / st.duration());
        if (B.lenis) B.lenis.scrollTo(y, { duration: 1.2 });
        else window.scrollTo({ top: y, behavior: 'smooth' });
      });
    });

    // The phone floats while the hero is on screen, and the scene leans a little with the cursor.
    var bob = gsap.to('.h-phone__float', { y: em(-0.7), duration: 3.2, ease: 'sine.inOut', yoyo: true, repeat: -1, delay: 2.2 });
    ST.create({ trigger: hero, start: 'top bottom', end: 'bottom top', onToggle: function (self) { bob.paused(!self.isActive); } });
    if (fine) {
      var tilt = q('.h-scene__tilt');
      var tx = gsap.quickTo(tilt, 'x', { duration: 1.1 });
      var ty = gsap.quickTo(tilt, 'y', { duration: 1.1 });
      stage.addEventListener('mousemove', function (e) {
        tx((e.clientX / window.innerWidth - 0.5) * -22);
        ty((e.clientY / window.innerHeight - 0.5) * -16);
      });
    }
    }, 0);
  };
  // Built one frame after the entrance starts, so the first paint never waits for it.
  if (story) requestAnimationFrame(function () { setTimeout(buildStory, 0); });

  if (!ST) return;

  /* Hero exit: once the story is done the frame pulls in and rounds off as it leaves */
  if (!B.lite && stage) {
    gsap.fromTo(stage, { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', immediateRender: false, scrollTrigger: { trigger: hero, start: story ? 'bottom bottom' : 'top top', end: 'bottom top', scrub: true } });
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

  /* Entrances for everything below the hero. Each runs once, the first time its section comes into view. */
  var once = function (trigger, start) { return { trigger: trigger, start: start || 'top 82%', once: true }; };

  // Clients: names rise out of a soft blur, one after another.
  gsap.fromTo('.h-marquee__track li', { y: 46, opacity: 0, filter: 'blur(8px)' }, { y: 0, opacity: 1, filter: 'blur(0px)', duration: 1.1, ease: 'expo.out', stagger: 0.06, clearProps: 'filter,opacity,transform', scrollTrigger: once('.h-clients', 'top 88%') });

  // The problem: a rule draws in from the left before the statement.
  gsap.from('.h-problem .b-eyebrow', { x: -30, opacity: 0, duration: 0.8, scrollTrigger: once('.h-problem') });

  // What we build: the dark stage opens out from a rounded card, then the panels sweep in.
  if (!B.lite) {
    gsap.fromTo('.h-build', { clipPath: 'inset(6% 4% 0% 4% round 40px)' }, { clipPath: 'inset(0% 0% 0% 0% round 0px)', ease: 'none', scrollTrigger: { trigger: '.h-build', start: 'top bottom', end: 'top 20%', scrub: true } });
  }
  mm.add('(min-width: 981px)', function () {
    gsap.from('.h-panel__card', { x: 160, rotationY: -18, opacity: 0, duration: 1.3, ease: 'expo.out', stagger: 0.09, transformPerspective: 1200, scrollTrigger: once('.h-build', 'top 60%') });
  });
  gsap.from('.h-panel__num', { yPercent: 100, opacity: 0, duration: 0.8, stagger: 0.06, scrollTrigger: once('.h-build', 'top 55%') });

  // Numbers: each rule draws across, then the figure rises into place.
  gsap.timeline({ scrollTrigger: once('.h-numbers') })
    .from('.h-stat__rule', { scaleX: 0, duration: 1.1, ease: 'expo.inOut', stagger: 0.12 })
    .from('.h-stat__num, .h-stat__plus', { yPercent: 60, opacity: 0, duration: 1, ease: 'expo.out', stagger: 0.08 }, '-=0.8')
    .from('.h-stat__label', { y: 12, opacity: 0, duration: 0.7, stagger: 0.08 }, '-=0.7');

  // Process: the heading block slides in; each step's dot pops, then its text follows.
  gsap.from('.h-process__head > *', { x: -40, opacity: 0, duration: 1, ease: 'expo.out', stagger: 0.08, scrollTrigger: once('.h-process') });
  document.querySelectorAll('.h-step').forEach(function (step) {
    gsap.timeline({ scrollTrigger: once(step, 'top 80%') })
      .from(step.querySelector('.h-step__dot'), { scale: 0, rotate: -90, duration: 0.7, ease: 'back.out(2.2)' })
      .from(step.querySelectorAll('h3, p'), { x: 36, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.08 }, '-=0.45');
  });

  // Products: the cards tip up from below, like they're being dealt onto the table.
  gsap.from('.h-product', { y: 90, rotationX: -24, scale: 0.94, opacity: 0, duration: 1.3, ease: 'expo.out', stagger: 0.12, transformPerspective: 1000, transformOrigin: '50% 100%', scrollTrigger: once('.h-products__grid', 'top 85%') });
})();
