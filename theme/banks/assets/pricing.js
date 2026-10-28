/* Pricing choreography. Every start state is set here, so the page reads in full without JS. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises, the board tips up, then every tile flaps to its letter */
  var title = document.querySelector('.pr-title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.pr-eyebrow, .pr-lede, .pr-actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.pr-board', { y: 70, rotationX: -14, opacity: 0, duration: 1.3, ease: 'expo.out', transformPerspective: 1400, transformOrigin: '50% 100%' }, 0.3);

  var GLYPHS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789₦';
  var rows = Array.prototype.slice.call(document.querySelectorAll('.pr-row'));
  // Each tile runs through a few random letters, flipping on its hinge, then lands on its own.
  var flap = function (tile, delay) {
    var end = tile.textContent;
    var turns = B.lite ? 2 : 4 + Math.floor(Math.random() * 5);
    var t = gsap.timeline({ delay: delay });
    for (var i = 0; i < turns; i++) {
      (function (last) {
        t.add(function () { tile.textContent = last ? end : GLYPHS.charAt(Math.floor(Math.random() * GLYPHS.length)); })
          .fromTo(tile, { rotationX: -75 }, { rotationX: 0, duration: 0.07, ease: 'power1.out' });
      })(i === turns - 1);
    }
    return t;
  };
  var flapRow = function (row, delay) {
    row.querySelectorAll('.pr-ch').forEach(function (tile, i) {
      if (tile.textContent.trim()) flap(tile, delay + i * 0.018);
    });
  };
  rows.forEach(function (row, r) { flapRow(row, 1 + r * 0.12); });

  // Every few seconds one row flips again, like a board refreshing.
  var live = true;
  var board = document.querySelector('.pr-board');
  if (ST && board) ST.create({ trigger: board, start: 'top bottom', end: 'bottom top', onToggle: function (self) { live = self.isActive; } });
  if (!B.lite) {
    var again = function () {
      if (live && !document.hidden) flapRow(rows[Math.floor(Math.random() * rows.length)], 0);
      gsap.delayedCall(3.6, again);
    };
    gsap.delayedCall(6, again);
  }

  if (!ST) return;
  var once = function (trigger, start) { return { trigger: trigger, start: start || 'top 82%', once: true }; };

  /* Hero exit: the frame pulls in and rounds off */
  if (!B.lite) {
    var scrub = { trigger: '.pr-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.pr-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.pr-copy', { yPercent: -16, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
  }

  /* 2. The cards are dealt in, then each one's ticks pop down the list */
  gsap.from('.pr-card', { y: 90, rotationX: -18, opacity: 0, duration: 1.3, ease: 'expo.out', stagger: 0.09, transformPerspective: 1000, transformOrigin: '50% 100%', scrollTrigger: once('.pr-grid', 'top 85%') });
  document.querySelectorAll('.pr-card').forEach(function (card, i) {
    gsap.from(card.querySelectorAll('.pr-card__list li'), { x: -14, opacity: 0, duration: 0.6, ease: 'expo.out', stagger: 0.06, delay: 0.5 + i * 0.09, scrollTrigger: once('.pr-grid', 'top 85%') });
  });

  /* 3. Payment: the line draws across, each stop pops as it passes */
  var steps = document.querySelector('.pr-pay__steps');
  if (steps) {
    var p = gsap.timeline({ scrollTrigger: once(steps, 'top 78%') });
    if (window.matchMedia('(min-width: 861px)').matches) p.fromTo(steps, { '--line': 0 }, { '--line': 1, duration: 1.4, ease: 'power2.inOut' }, 0);
    p.from('.pr-pay__n', { scale: 0, rotate: -90, duration: 0.7, ease: 'back.out(2.2)', stagger: 0.45 }, 0.05)
      .from('.pr-pay__step h3, .pr-pay__step p', { y: 24, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.06 }, 0.15);
  }

  /* 4. What changes a price: each row rises, its number counts in */
  document.querySelectorAll('.pr-change').forEach(function (row) {
    gsap.from(row.children, { y: 26, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.06, scrollTrigger: once(row, 'top 90%') });
  });
})();
