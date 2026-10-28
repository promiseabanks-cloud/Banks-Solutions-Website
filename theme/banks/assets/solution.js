/* Solution page choreography. Every start state is set here, so the page reads in full without JS. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises line by line, then the page's own visual plays */
  var title = document.querySelector('.so-hero__title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.so-crumbs, .so-hero__lede, .so-hero__actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.so-hero__facts li', { y: 20, opacity: 0, duration: 0.8, stagger: 0.07 }, '-=0.6');

  var visuals = {
    /* Websites: a wireframe draws, the blocks paint in, the phone version slides in with its load time */
    websites: function (vis) {
      var blocks = vis.querySelectorAll('.vw-browser .vw-b');
      var grid = vis.querySelector('.vw-grid');
      var speed = vis.querySelector('[data-vw-speed]');
      var v = gsap.timeline();
      gsap.set(blocks, { '--f': 0 });
      vis.classList.add('is-wire');
      v.from(vis.querySelector('.vw-browser'), { y: 60, rotationX: -14, opacity: 0, duration: 1.3, ease: 'expo.out', transformOrigin: '50% 100%' })
        .fromTo(grid, { opacity: 0 }, { opacity: 1, duration: 0.3 }, 0.4)
        .from(grid.querySelectorAll('i'), { scaleY: 0, duration: 0.8, ease: 'expo.inOut', stagger: 0.06 }, 0.4)
        .from(blocks, { scale: 0.92, opacity: 0, duration: 0.6, ease: 'expo.out', stagger: 0.035 }, 0.7)
        .to(blocks, { '--f': 1, duration: 0.7, ease: 'power2.out', stagger: 0.04 }, 1.7)
        .call(function () { vis.classList.remove('is-wire'); }, null, 1.9)
        .to(grid, { opacity: 0, duration: 0.6 }, 2.2)
        .from(vis.querySelector('.vw-phone'), { x: 80, y: 30, rotate: 8, opacity: 0, duration: 1.2, ease: 'expo.out' }, 2.3)
        .from(vis.querySelectorAll('.vw-phone .vw-b'), { opacity: 0, y: 10, duration: 0.5, stagger: 0.05 }, 2.6)
        .from(vis.querySelector('.vw-badge--speed'), { y: 30, scale: 0.8, opacity: 0, duration: 0.8, ease: 'back.out(1.8)' }, 2.9)
        .from(vis.querySelector('.vw-badge--lead'), { x: 50, opacity: 0, duration: 0.9, ease: 'expo.out' }, 3.5);
      if (speed) {
        var o = { s: 4.8 };
        v.to(o, { s: 1.2, duration: 1.4, ease: 'power3.out', onUpdate: function () { speed.textContent = o.s.toFixed(1); } }, 3);
      }
      tl.add(v, 0.3);

      // The cards float a little, and the browser leans towards the cursor.
      if (!B.lite) {
        [vis.querySelector('.vw-phone'), vis.querySelector('.vw-badge--speed'), vis.querySelector('.vw-badge--lead')].forEach(function (el, i) {
          if (el) gsap.to(el, { yPercent: i % 2 ? -5 : 5, duration: 3 + i * 0.6, ease: 'sine.inOut', yoyo: true, repeat: -1, delay: 4.5 });
        });
        if (fine) {
          var br = vis.querySelector('.vw-browser');
          var rx = gsap.quickTo(br, 'rotationX', { duration: 1.2, ease: 'power3.out' });
          var ry = gsap.quickTo(br, 'rotationY', { duration: 1.2, ease: 'power3.out' });
          document.querySelector('.so-hero__stage').addEventListener('mousemove', function (e) {
            ry((e.clientX / window.innerWidth - 0.5) * 8);
            rx((e.clientY / window.innerHeight - 0.5) * -6);
          });
        }
      }
      // On scroll, the page inside the browser scrolls too.
      if (ST) gsap.to(vis.querySelector('.vw-page'), { yPercent: -28, ease: 'none', scrollTrigger: { trigger: '.so-hero', start: 'top top', end: 'bottom top', scrub: true } });
    }
  };
  var vis = document.querySelector('.so-vis[data-visual]');
  if (vis && visuals[vis.getAttribute('data-visual')]) visuals[vis.getAttribute('data-visual')](vis);

  if (!ST) return;
  var once = function (trigger, start) { return { trigger: trigger, start: start || 'top 82%', once: true }; };

  /* Hero exit: the frame pulls in and rounds off, the copy drifts up */
  if (!B.lite) {
    var scrub = { trigger: '.so-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.so-hero__stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.so-hero__copy', { yPercent: -18, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
  }

  /* 2. Sound familiar: each box ticks as its row reaches the middle of the screen; the score keeps count */
  var score = document.querySelector('[data-so-score]');
  var syms = Array.prototype.slice.call(document.querySelectorAll('.so-sym'));
  var tally = function () { if (score) score.textContent = syms.filter(function (s) { return s.classList.contains('is-on'); }).length; };
  syms.forEach(function (row) {
    var tick = row.querySelector('.so-sym__box path');
    var len = tick && tick.getTotalLength ? tick.getTotalLength() : 0;
    if (len) gsap.set(tick, { strokeDasharray: len, strokeDashoffset: len });
    gsap.from(row.children, { y: 30, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.08, scrollTrigger: once(row, 'top 90%') });
    ST.create({
      trigger: row, start: 'top 58%', end: 'max',
      onToggle: function (self) {
        var on = self.isActive;
        row.classList.toggle('is-on', on);
        if (len) gsap.to(tick, { strokeDashoffset: on ? 0 : len, duration: on ? 0.5 : 0.25, ease: 'power2.out', delay: on ? 0.15 : 0 });
        if (on) gsap.fromTo(row.querySelector('.so-sym__box'), { scale: 0.7 }, { scale: 1, duration: 0.6, ease: 'back.out(2.4)' });
        tally();
      }
    });
  });
  if (score) gsap.from('.so-check__score', { y: 20, opacity: 0, duration: 0.8, scrollTrigger: once('.so-check__score', 'top 95%') });

  /* 3. The statement: the supporting paragraphs rise after it (the words light up in scenes.js) */
  gsap.from('.so-say__text p', { y: 40, opacity: 0, duration: 1, ease: 'expo.out', stagger: 0.12, scrollTrigger: once('.so-say__text', 'top 85%') });

  /* 4. What's included: each group's rule draws, then its cards tip up in turn */
  document.querySelectorAll('.so-group').forEach(function (g, i) {
    gsap.timeline({ scrollTrigger: once(g, 'top 85%') })
      .from(g.querySelector('.so-group__head'), { y: 20, opacity: 0, duration: 0.7, ease: 'expo.out' }, i * 0.1)
      .from(g.querySelectorAll('.so-item'), { y: 70, rotationX: -18, opacity: 0, duration: 1.1, ease: 'expo.out', stagger: 0.1, transformPerspective: 1000, transformOrigin: '50% 100%' }, i * 0.1 + 0.15);
  });

  /* 5. How it runs: the line draws with the scroll, each stage lights when the line reaches it */
  var line = document.querySelector('.so-run__line span');
  var stages = document.querySelectorAll('.so-stage');
  var mm = gsap.matchMedia();
  if (line) {
    mm.add('(min-width: 901px)', function () {
      gsap.fromTo(line, { scaleX: 0, scaleY: 1 }, { scaleX: 1, ease: 'none', scrollTrigger: { trigger: '.so-run__track', start: 'top 75%', end: 'bottom 45%', scrub: true,
        onUpdate: function (self) { stages.forEach(function (s, i) { s.classList.toggle('is-on', self.progress >= i / Math.max(1, stages.length - 1) - 0.02); }); } } });
    });
    mm.add('(max-width: 900px)', function () {
      gsap.fromTo(line, { scaleY: 0, scaleX: 1 }, { scaleY: 1, ease: 'none', scrollTrigger: { trigger: '.so-run__track', start: 'top 60%', end: 'bottom 60%', scrub: true } });
      stages.forEach(function (s) { ST.create({ trigger: s, start: 'top 60%', end: 'max', onToggle: function (self) { s.classList.toggle('is-on', self.isActive); } }); });
    });
  }
  stages.forEach(function (s, i) {
    gsap.timeline({ scrollTrigger: once('.so-run__track', 'top 80%') })
      .from(s.querySelector('.so-stage__dot'), { scale: 0, rotate: -90, duration: 0.7, ease: 'back.out(2.2)' }, i * 0.1)
      .from(s.querySelectorAll('.so-stage__when, h3, p:last-child'), { y: 24, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.06 }, i * 0.1 + 0.2);
  });

  /* 6. Fit: the two columns slide in from either side, the ticks and crosses pop in */
  gsap.from('.so-fit__col--yes', { x: -60, opacity: 0, duration: 1.1, ease: 'expo.out', scrollTrigger: once('.so-fit__grid') });
  gsap.from('.so-fit__col--no', { x: 60, opacity: 0, duration: 1.1, ease: 'expo.out', scrollTrigger: once('.so-fit__grid') });
  gsap.from('.so-fit__col li', { y: 16, opacity: 0, duration: 0.7, ease: 'expo.out', stagger: 0.05, scrollTrigger: once('.so-fit__grid', 'top 75%') });

  /* 7. Prices: the cards are dealt in, the featured one last and highest */
  gsap.from('.so-plan', { y: 90, rotationX: -20, scale: 0.94, opacity: 0, duration: 1.3, ease: 'expo.out', stagger: 0.12, transformPerspective: 1000, transformOrigin: '50% 100%', scrollTrigger: once('.so-plans__grid', 'top 85%') });
  gsap.from('.so-plans__note', { y: 20, opacity: 0, duration: 0.8, scrollTrigger: once('.so-plans__note', 'top 95%') });
})();
