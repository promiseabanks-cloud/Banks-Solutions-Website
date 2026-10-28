/* Scene behaviour shared by every page built on the theme: smooth questions, the cursor light on
   dark scenes, decoding section labels, card spotlights, and the questions and closing-call entrances.
   Start states are set here, so everything reads in full without JS. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

  /* Questions: smooth open and close (without the motion libraries the native details still works) */
  document.querySelectorAll('.s-qa').forEach(function (d) {
    var s = d.querySelector('summary');
    var a = d.querySelector('.s-qa__a');
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

  if (fine) {
    /* Light that follows the cursor across the scene that holds it */
    document.querySelectorAll('.s-glow').forEach(function (glow) {
      var el = glow.parentElement;
      var o = { x: 72, y: 28 };
      var set = function () { glow.style.setProperty('--gx', o.x + '%'); glow.style.setProperty('--gy', o.y + '%'); };
      el.addEventListener('mousemove', function (e) {
        var r = el.getBoundingClientRect();
        gsap.to(o, { x: ((e.clientX - r.left) / r.width) * 100, y: ((e.clientY - r.top) / r.height) * 100, duration: 1.2, ease: 'power3.out', onUpdate: set, overwrite: true });
      });
    });

    /* Spotlight that follows the cursor across a card */
    document.querySelectorAll('[data-spot]').forEach(function (card) {
      card.addEventListener('mousemove', function (e) {
        var r = card.getBoundingClientRect();
        card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
        card.style.setProperty('--my', (e.clientY - r.top) + 'px');
      });
    });
  }

  if (!ST) return;

  var once = function (trigger, start) { return { trigger: trigger, start: start || 'top 82%', once: true }; };

  // Section labels decode from random characters into their text. Hero labels arrive with their hero.
  var glyphs = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/·+';
  document.querySelectorAll('main .b-eyebrow').forEach(function (el) {
    if (el.closest('[data-hero]')) return;
    var text = el.textContent;
    el.setAttribute('aria-label', text);
    ST.create({
      trigger: el, start: 'top 90%', once: true,
      onEnter: function () {
        var o = { p: 0 };
        gsap.to(o, {
          p: 1, duration: 0.9, ease: 'power2.out',
          onUpdate: function () {
            var n = Math.floor(o.p * text.length);
            el.textContent = text.slice(0, n) + text.slice(n).replace(/[^\s]/g, function () { return glyphs[Math.floor(Math.random() * glyphs.length)]; });
          },
          onComplete: function () { el.textContent = text; }
        });
      }
    });
  });

  // Statements light up word by word as they scroll through.
  document.querySelectorAll('[data-scrub-words]').forEach(function (p) {
    var words = window.SplitText ? window.SplitText.create(p, { type: 'words', aria: 'auto' }).words : [p];
    gsap.fromTo(words, { opacity: 0.14 }, { opacity: 1, stagger: 0.1, ease: 'none', scrollTrigger: { trigger: p, start: 'top 78%', end: 'bottom 42%', scrub: true } });
  });

  // Naira figures count up to their value the first time they come into view.
  document.querySelectorAll('[data-naira]').forEach(function (el) {
    var end = parseInt(el.getAttribute('data-naira'), 10);
    var o = { v: 0 };
    gsap.to(o, {
      v: end, duration: 1.6, ease: 'power3.out', scrollTrigger: once(el, 'top 90%'),
      onUpdate: function () { el.textContent = Math.round(o.v).toLocaleString('en-NG'); },
      onComplete: function () { el.textContent = end.toLocaleString('en-NG'); }
    });
  });

  // Questions: rows slide in one by one, their icons spin into place.
  document.querySelectorAll('.s-faq__list').forEach(function (list) {
    gsap.timeline({ scrollTrigger: once(list) })
      .from(list.querySelectorAll('.s-qa'), { x: 60, opacity: 0, duration: 1, ease: 'expo.out', stagger: 0.08 })
      .from(list.querySelectorAll('.s-qa__icon'), { scale: 0, rotate: -180, duration: 0.8, ease: 'back.out(1.8)', stagger: 0.08 }, 0.2);
  });

  // Closing call: the headline scales up into place, then the line and the button arrive.
  document.querySelectorAll('.s-cta').forEach(function (cta) {
    var title = cta.querySelector('.s-cta__title');
    if (title && !B.lite) gsap.from(title, { scale: 0.86, opacity: 0.4, ease: 'none', scrollTrigger: { trigger: cta, start: 'top bottom', end: 'top 30%', scrub: true } });
    gsap.timeline({ scrollTrigger: once(cta, 'top 65%') })
      .from(cta.querySelectorAll('.s-cta__inner > p'), { y: 30, opacity: 0, duration: 0.9, ease: 'expo.out' }, 0.35)
      .from(cta.querySelectorAll('.s-cta__inner > .b-btn'), { scale: 0.6, opacity: 0, duration: 1.1, ease: 'elastic.out(1, 0.55)' }, 0.5);
  });
})();
