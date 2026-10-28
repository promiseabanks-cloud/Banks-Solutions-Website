/* Homepage choreography. Every start state is set here, so the page reads in full without JS. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

  if (!gsap || B.reduce) return;

  /* 1. Hero entrance: the headline rises line by line, the system assembles beside it */
  var tl = gsap.timeline({ delay: 0.15 });
  var says = document.querySelectorAll('[data-split-hero]');
  var rot = document.querySelector('.h-rot');
  var words = rot ? Array.prototype.slice.call(rot.querySelectorAll('.h-rot__word')) : [];
  if (says.length) tl.from([].concat(B.split(says[0], 'lines'), words[0] || [], says[1] ? B.split(says[1], 'lines') : []), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.h-hero__eyebrow, .h-hero__lede, .h-hero__actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.h-hero__proof li', { y: 20, opacity: 0, duration: 0.8, stagger: 0.07 }, '-=0.6')
    .from('.h-sys__card', { y: 70, rotateX: -22, opacity: 0, duration: 1.3, ease: 'expo.out', stagger: 0.12, transformOrigin: '50% 100%' }, 0.45)
    .from('.h-hero__scroll', { opacity: 0, duration: 0.6 }, '-=0.3');
  var spark = document.querySelector('.h-sys__spark path');
  if (spark && spark.getTotalLength) {
    var sl = spark.getTotalLength();
    gsap.set(spark, { strokeDasharray: sl, strokeDashoffset: sl });
    tl.to(spark, { strokeDashoffset: 0, duration: 1.8, ease: 'power2.inOut' }, 1.1);
  }

  /* The rotating word: each one slides up and out as the next rises in; the underline resizes to fit */
  if (words.length > 1) {
    var cur = 0;
    var fit = function (w) { rot.style.setProperty('--rw', w.offsetWidth + 'px'); };
    words.forEach(function (w, i) { w.style.visibility = 'visible'; if (i) gsap.set(w, { yPercent: 110 }); });
    fit(words[0]);
    gsap.delayedCall(3, function next() {
      var a = words[cur];
      cur = (cur + 1) % words.length;
      var b = words[cur];
      gsap.to(a, { yPercent: -110, duration: 0.8, ease: 'expo.inOut' });
      gsap.fromTo(b, { yPercent: 110 }, { yPercent: 0, duration: 0.8, ease: 'expo.inOut' });
      fit(b);
      gsap.delayedCall(2.6, next);
    });
  }

  /* The system keeps working: new leads arrive, the count ticks up */
  var msg = document.querySelector('[data-sys-msg]');
  var toast = document.querySelector('.h-sys__toast');
  var count = document.querySelector('[data-sys-count]');
  if (msg && toast && !B.lite) {
    var leads = ['Ada wants a quote for a new website', 'Tunde booked a call for Friday, 10am', 'Grace asked about paying in two parts', 'Kemi wants a client portal for her firm'];
    var li = 0;
    gsap.delayedCall(4.5, function lead() {
      li = (li + 1) % leads.length;
      gsap.timeline()
        .to(toast, { x: 40, opacity: 0, duration: 0.45, ease: 'power2.in' })
        .add(function () { msg.textContent = leads[li]; if (count) count.textContent = String(parseInt(count.textContent, 10) + 1); })
        .fromTo(toast, { x: -40, opacity: 0 }, { x: 0, opacity: 1, duration: 0.7, ease: 'expo.out' });
      gsap.delayedCall(3.6, lead);
    });
  }

  /* Depth: the cards drift with the cursor and float gently on their own */
  var sys = document.querySelector('.h-sys');
  if (sys && !B.lite) {
    var cards = Array.prototype.slice.call(sys.querySelectorAll('.h-sys__card'));
    cards.forEach(function (c, i) {
      gsap.to(c, { yPercent: i % 2 ? -4 : 4, duration: 3 + i * 0.7, ease: 'sine.inOut', yoyo: true, repeat: -1, delay: 1.6 });
    });
    if (fine) {
      var movers = cards.map(function (c) {
        var d = parseFloat(c.getAttribute('data-depth')) || 1;
        return { d: d, x: gsap.quickTo(c, 'x', { duration: 1 }), y: gsap.quickTo(c, 'y', { duration: 1 }), rx: gsap.quickTo(c, 'rotationY', { duration: 1 }) };
      });
      document.querySelector('.h-hero__stage').addEventListener('mousemove', function (e) {
        var nx = e.clientX / window.innerWidth - 0.5;
        var ny = e.clientY / window.innerHeight - 0.5;
        movers.forEach(function (m) { m.x(nx * 30 * m.d); m.y(ny * 22 * m.d); m.rx(nx * 8); });
      });
    }
  }

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
