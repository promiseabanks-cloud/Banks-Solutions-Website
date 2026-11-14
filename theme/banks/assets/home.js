/* Homepage choreography. Every start state is set here, so the page reads in full without JS. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};

  if (!gsap || B.reduce) return;

  /* 1. Hero. The copy rises in, then one enquiry walks down the rail once: the form sends, the
     lead is qualified in the CRM, the messages go out, and AI drafts the next step. Then it rests.
     Start states are set here, so without JS (or with reduced motion) every step shows finished. */
  var hero = document.querySelector('.h-hero');
  var sys = hero && hero.querySelector('.h-sys');
  var tl = gsap.timeline({ delay: 0.1 });
  var say = hero && hero.querySelector('[data-split-hero]');
  if (say) tl.from(B.split(say, 'lines'), { yPercent: 110, rotate: 2, duration: 1.15, ease: 'expo.out', stagger: 0.08 });
  tl.from('.h-hero__eyebrow, .h-hero__lede, .h-hero__actions > *, .h-hero__assure', { y: 24, opacity: 0, duration: 0.9, stagger: 0.07 }, '-=0.95')
    .from('.h-hero__proof li', { y: 16, opacity: 0, duration: 0.7, stagger: 0.06 }, '-=0.6');

  if (sys) {
    var nodes = Array.prototype.slice.call(sys.querySelectorAll('[data-node]'));
    var cards = nodes.map(function (n) { return n.querySelector('.h-card'); });
    var stages = sys.querySelectorAll('.h-crm__stages li');
    var rows = sys.querySelectorAll('.h-auto__row');
    var sendA = sys.querySelector('.h-web__send-a');
    var sendB = sys.querySelector('.h-web__send-b');
    var on = function (i) { return function () { nodes[i].classList.add('is-on'); }; };
    var stage = function (i) { return function () { stages.forEach(function (s, n) { s.classList.toggle('is-on', n === i); }); }; };
    stage(0)();
    gsap.set(sys.querySelector('.h-sys__rail span'), { scaleY: 0 });
    gsap.set(rows, { opacity: 0.2 });
    gsap.set(sys.querySelectorAll('.h-ai__text, .h-ai__btns'), { opacity: 0.2 });

    // Steps not reached yet sit dimmed, never empty. The cards arrive with the copy and the walk
    // starts once they have settled.
    tl.from(nodes, { y: 40, opacity: 0, duration: 1, ease: 'expo.out', stagger: 0.09 }, 0.3);
    var walk = gsap.timeline({ paused: true, defaults: { ease: 'power2.out' } });
    walk.add(on(0))
      .to(sendA, { opacity: 0, duration: 0.2 }, 0.5)
      .to(sendB, { opacity: 1, duration: 0.2 }, 0.55)
      .fromTo(cards[0], { scale: 1 }, { scale: 1.02, duration: 0.18, yoyo: true, repeat: 1 }, 0.5)
      .to(sys.querySelector('.h-sys__rail span'), { scaleY: 1, duration: 2.6, ease: 'power1.inOut' }, 0.7)
      .add(on(1), 1.3).add(stage(1), 1.5)
      .add(on(2), 2.1).to(rows, { opacity: 1, duration: 0.4, stagger: 0.18 }, 2.15)
      .add(on(3), 2.9).to(sys.querySelectorAll('.h-ai__text, .h-ai__btns'), { opacity: 1, duration: 0.45, stagger: 0.12 }, 3);
    tl.add(function () { walk.play(); }, '>-0.2');
  }

  if (!ST) return;

  /* Hero exit: the frame pulls in and rounds off as it leaves */
  var heroStage = hero && hero.querySelector('.h-hero__stage');
  if (!B.lite && heroStage) {
    gsap.fromTo(heroStage, { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true } });
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
