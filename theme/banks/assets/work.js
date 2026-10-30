/* Work choreography. Every start state is set here, so the page reads in full without JS:
   the reel is a list, the index shows every project, the hero shows the first one. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  var hold = function (screen, on) { if (B.hold) B.hold(screen, on); };
  var wake = function (screen) { if (B.screen) B.screen(screen); };
  var chips = document.querySelector('.wk-chips');
  var rows = Array.prototype.slice.call(document.querySelectorAll('.wk-row'));

  /* Filters work with reduced motion too; only the animation is skipped */
  if (chips) {
    chips.hidden = false;
    chips.addEventListener('click', function (e) {
      var chip = e.target.closest('.wk-chip');
      if (!chip) return;
      var tag = chip.getAttribute('data-tag');
      chips.querySelectorAll('.wk-chip').forEach(function (c) {
        var on = c === chip;
        c.classList.toggle('is-on', on);
        c.setAttribute('aria-pressed', on ? 'true' : 'false');
      });
      var shown = rows.filter(function (r) {
        var keep = !tag || (' ' + r.getAttribute('data-tags') + ' ').indexOf(' ' + tag + ' ') > -1;
        r.hidden = !keep;
        return keep;
      });
      if (gsap && !B.reduce) gsap.fromTo(shown, { y: 18, opacity: 0 }, { y: 0, opacity: 1, duration: 0.7, ease: 'expo.out', stagger: 0.05, clearProps: 'transform,opacity' });
      if (ST) ST.refresh();
    });
  }

  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises, the devices tip up out of the dark */
  var title = document.querySelector('.wk-title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.wk-eyebrow, .wk-lede, .wk-actions > *, .wk-stats > div', { y: 28, opacity: 0, duration: 1, stagger: 0.07 }, '-=0.95')
    .from('.wk-show .wk-device--laptop', { y: 120, rotationX: 38, rotationY: -18, opacity: 0, duration: 1.8, ease: 'expo.out', transformPerspective: 1600, transformOrigin: '50% 100%' }, 0.25)
    .from('.wk-show .wk-device--phone', { y: 160, rotationY: 30, opacity: 0, duration: 1.6, ease: 'expo.out', transformPerspective: 1200 }, 0.55)
    .from('.wk-show__now', { opacity: 0, duration: 0.8 }, 1.2);

  // The rig leans toward the cursor, and the phone drifts on its own.
  var rig = document.querySelector('.wk-show__rig');
  if (rig && fine) {
    var ry = gsap.quickTo(rig, 'rotationY', { duration: 1.2, ease: 'power3.out' });
    var rx = gsap.quickTo(rig, 'rotationX', { duration: 1.2, ease: 'power3.out' });
    document.querySelector('.wk-hero').addEventListener('mousemove', function (e) {
      ry((e.clientX / window.innerWidth - 0.5) * 14);
      rx(-(e.clientY / window.innerHeight - 0.5) * 9);
    });
  }
  if (!B.lite) gsap.to('.wk-show .wk-device--phone', { y: -14, rotation: 1.5, duration: 3.2, ease: 'sine.inOut', yoyo: true, repeat: -1, delay: 2 });

  // Every few seconds both screens wipe to the next project, together.
  var show = document.querySelector('.wk-show');
  if (show) {
    var screens = Array.prototype.slice.call(show.querySelectorAll('[data-screen]'));
    var bar = show.querySelector('.wk-bar em');
    var now = show.querySelector('.wk-show__now strong');
    var names = Array.prototype.map.call(document.querySelectorAll('.wk-slide__name a'), function (a) { return a.textContent; });
    var total = screens[0] ? screens[0].querySelectorAll('.wk-view').length : 0;
    var at = 0;
    var inView = true;
    if (total > 1) {
      screens.forEach(function (s) {
        var views = s.querySelectorAll('.wk-view');
        s.classList.add('is-cycling');
        gsap.set(views, { autoAlpha: 0, zIndex: 0 });
        gsap.set(views[0], { autoAlpha: 1, zIndex: 1 });
        views[0].classList.add('is-on');
      });
      var next = function () {
        if (inView && !document.hidden) {
          var to = (at + 1) % total;
          screens.forEach(function (s, k) {
            var views = s.querySelectorAll('.wk-view');
            var from = views[at];
            var into = views[to];
            from.classList.remove('is-on');
            into.classList.add('is-on');
            gsap.set(into, { autoAlpha: 1, zIndex: 2 });
            gsap.fromTo(into, { clipPath: 'inset(100% 0% 0% 0%)' }, {
              clipPath: 'inset(0% 0% 0% 0%)', duration: 1.1, ease: 'expo.inOut', delay: k * 0.12,
              onComplete: function () { gsap.set(from, { autoAlpha: 0, zIndex: 0 }); gsap.set(into, { zIndex: 1, clearProps: 'clipPath' }); }
            });
            wake(s);
          });
          if (bar) bar.textContent = screens[0].querySelectorAll('.wk-view')[to].getAttribute('data-domain');
          if (now && names[to]) {
            gsap.to(now, { opacity: 0, y: -6, duration: 0.25, onComplete: function () { now.textContent = names[to]; gsap.to(now, { opacity: 1, y: 0, duration: 0.4 }); } });
          }
          at = to;
        }
        gsap.delayedCall(B.lite ? 6 : 4.6, next);
      };
      gsap.delayedCall(5, next);
      if (ST) ST.create({ trigger: show, start: 'top bottom', end: 'bottom top', onToggle: function (self) { inView = self.isActive; } });
    }
  }

  if (!ST) return;
  var once = function (trigger, start) { return { trigger: trigger, start: start || 'top 85%', once: true }; };

  /* Hero exit: the frame pulls in and rounds off */
  if (!B.lite) {
    var scrub = { trigger: '.wk-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.wk-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.wk-copy', { yPercent: -14, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
    gsap.to('.wk-show__rig', { yPercent: 10, ease: 'none', scrollTrigger: scrub });
  }

  /* 2. The reel */
  var reel = document.querySelector('.wk-reel');
  var slides = Array.prototype.slice.call(document.querySelectorAll('.wk-slide'));
  if (reel && slides.length) {
    var mm = gsap.matchMedia();

    // Wide screens: pinned, every project on a curved track, turning past as you scroll.
    mm.add('(min-width: 1024px) and (min-height: 640px)', function () {
      var n = slides.length;
      var track = reel.querySelector('.wk-reel__track');
      var count = reel.querySelector('.wk-reel__now');
      var fill = reel.querySelector('.wk-reel__bar span');
      var active = -1;
      reel.classList.add('is-3d');
      slides.forEach(function (s) { s._screens = s.querySelectorAll('[data-screen]'); s._copy = s.querySelector('.wk-slide__copy'); s._phone = s.querySelector('.wk-device--phone'); });

      var place = function (p) {
        var w = slides[0].offsetWidth;
        slides.forEach(function (s, i) {
          var d = i - p;
          var ad = Math.abs(d);
          var c = Math.max(-2.4, Math.min(2.4, d));
          gsap.set(s, {
            xPercent: -50, yPercent: -50,
            x: c * w * 0.72 + (d - c) * w * 0.2,
            z: -Math.min(ad, 3) * 380,
            rotationY: -c * 30,
            opacity: ad > 2.2 ? Math.max(0, 1 - (ad - 2.2) * 2) : 1,
            zIndex: 100 - Math.round(ad * 10),
            '--dim': Math.min(0.62, ad * 0.42)
          });
          gsap.set(s._phone, { opacity: Math.max(0, 1 - ad * 1.6) });
          gsap.set(s._copy, { opacity: Math.max(0, 1 - ad * 2.4), y: ad * 20 });
        });
        var a = Math.round(p);
        if (a !== active) {
          active = a;
          if (count) count.textContent = (a < 9 ? '0' : '') + (a + 1);
          slides.forEach(function (s, i) {
            s.classList.toggle('is-active', i === a);
            s._screens.forEach(function (sc) { hold(sc, i !== a); });
          });
        }
        if (fill) gsap.set(fill, { scaleX: n > 1 ? p / (n - 1) : 1 });
      };

      var st = ST.create({
        trigger: reel,
        start: 'top top',
        end: '+=' + Math.round((n - 1) * window.innerHeight * 0.55),
        pin: reel.querySelector('.wk-reel__pin'),
        scrub: 0.6,
        snap: n > 1 ? { snapTo: 1 / (n - 1), duration: { min: 0.25, max: 0.7 }, ease: 'power2.inOut', delay: 0.08 } : false,
        invalidateOnRefresh: true,
        onUpdate: function (self) { place(self.progress * (n - 1)); },
        onRefresh: function (self) { place(self.progress * (n - 1)); }
      });
      place(0);

      // The whole track leans a little toward the cursor.
      var ty = gsap.quickTo(track, 'rotationY', { duration: 1, ease: 'power3.out' });
      var tx = gsap.quickTo(track, 'rotationX', { duration: 1, ease: 'power3.out' });
      var lean = function (e) { ty((e.clientX / window.innerWidth - 0.5) * 6); tx(-(e.clientY / window.innerHeight - 0.5) * 4); };
      if (fine) reel.addEventListener('mousemove', lean);

      // A side project is one click (or one Tab) away: scroll it to the front instead of opening it.
      var goTo = function (i) {
        var y = st.start + (st.end - st.start) * (n > 1 ? i / (n - 1) : 0);
        if (B.lenis) B.lenis.scrollTo(y, { duration: 1.1 });
        else window.scrollTo({ top: y, behavior: 'smooth' });
      };
      var onClick = function (e) {
        var s = e.target.closest('.wk-slide');
        if (!s || s.classList.contains('is-active')) return;
        e.preventDefault();
        goTo(slides.indexOf(s));
      };
      var onFocus = function (e) {
        var s = e.target.closest('.wk-slide');
        if (s && !s.classList.contains('is-active')) goTo(slides.indexOf(s));
      };
      track.addEventListener('click', onClick);
      track.addEventListener('focusin', onFocus);

      return function () {
        reel.classList.remove('is-3d');
        reel.removeEventListener('mousemove', lean);
        track.removeEventListener('click', onClick);
        track.removeEventListener('focusin', onFocus);
        gsap.set(slides, { clearProps: 'all' });
        gsap.set(track, { clearProps: 'transform' });
        slides.forEach(function (s) { gsap.set([s._copy, s._phone], { clearProps: 'all' }); s.classList.remove('is-active'); s._screens.forEach(function (sc) { hold(sc, false); }); });
      };
    });

    // Phones and tablets: swipe the row; each project turns to face you as it reaches the middle.
    mm.add('(max-width: 1023px)', function () {
      var track = reel.querySelector('.wk-reel__track');
      var count = reel.querySelector('.wk-reel__now');
      var active = -1;
      var ticking = false;
      reel.classList.add('is-swipe');
      var turn = function () {
        ticking = false;
        var mid = track.scrollLeft + track.clientWidth / 2;
        slides.forEach(function (s, i) {
          var d = (s.offsetLeft + s.offsetWidth / 2 - mid) / s.offsetWidth;
          var c = Math.max(-1, Math.min(1, d));
          gsap.set(s.querySelector('.wk-slide__rig'), { rotationY: -c * 26, scale: 1 - Math.abs(c) * 0.08, transformPerspective: 1000 });
        });
        var a = Math.max(0, Math.min(slides.length - 1, Math.round(track.scrollLeft / (slides[0].offsetWidth + 18))));
        if (a !== active) {
          active = a;
          if (count) count.textContent = (a < 9 ? '0' : '') + (a + 1);
          slides.forEach(function (s, i) { s.querySelectorAll('[data-screen]').forEach(function (sc) { hold(sc, i !== a); }); });
        }
      };
      var onScroll = function () { if (!ticking) { ticking = true; requestAnimationFrame(turn); } };
      track.addEventListener('scroll', onScroll, { passive: true });
      window.addEventListener('resize', onScroll);
      turn();
      gsap.from(slides.slice(0, 2), { x: 90, opacity: 0, duration: 1.3, ease: 'expo.out', stagger: 0.12, scrollTrigger: once(track, 'top 85%') });
      return function () {
        reel.classList.remove('is-swipe');
        track.removeEventListener('scroll', onScroll);
        window.removeEventListener('resize', onScroll);
        slides.forEach(function (s) { gsap.set(s.querySelector('.wk-slide__rig'), { clearProps: 'all' }); s.querySelectorAll('[data-screen]').forEach(function (sc) { hold(sc, false); }); });
      };
    });

    // Wide but short windows: the list, each project tipping up as it arrives.
    mm.add('(min-width: 1024px) and (max-height: 639px)', function () {
      slides.forEach(function (s) {
        gsap.from(s.querySelector('.wk-device--laptop'), { y: 70, rotationX: 24, opacity: 0, duration: 1.3, ease: 'expo.out', transformPerspective: 1200, transformOrigin: '50% 100%', scrollTrigger: once(s, 'top 88%') });
        gsap.from(s.querySelectorAll('.wk-slide__copy > *'), { y: 24, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.06, delay: 0.2, scrollTrigger: once(s, 'top 88%') });
      });
    });
  }

  /* 3. The index: rows slide in; on a mouse, a live preview follows the cursor */
  if (rows.length) {
    gsap.set(rows, { x: -24, opacity: 0 });
    ST.batch(rows, { start: 'top 92%', once: true, onEnter: function (b) { gsap.to(b, { x: 0, opacity: 1, duration: 0.9, ease: 'expo.out', stagger: 0.05, clearProps: 'transform,opacity' }); } });
  }
  var index = document.querySelector('.wk-index');
  var peek = document.querySelector('.wk-peek');
  if (index && peek && fine) {
    var items = peek.querySelectorAll('.wk-peek__item');
    index.classList.add('js-peek');
    gsap.set(peek, { yPercent: -50, autoAlpha: 0, scale: 0.7, transformOrigin: '0% 50%' });
    // Beside the cursor, so the name stays readable, and never off the right edge.
    var spot = function (x) { return Math.min(x + 56, window.innerWidth - peek.offsetWidth - 24); };
    gsap.set(items, { autoAlpha: 0 });
    items.forEach(function (it) { it._screen = it.querySelector('[data-screen]'); hold(it._screen, true); });
    var px = gsap.quickTo(peek, 'x', { duration: 0.55, ease: 'power3.out' });
    var py = gsap.quickTo(peek, 'y', { duration: 0.55, ease: 'power3.out' });
    var pr = gsap.quickTo(peek, 'rotation', { duration: 0.8, ease: 'power3.out' });
    var lastX = 0;
    var on = -1;
    var list = index.querySelector('.wk-list');
    list.addEventListener('mousemove', function (e) {
      px(spot(e.clientX));
      py(e.clientY);
      pr(Math.max(-8, Math.min(8, (e.clientX - lastX) * 0.4)));
      lastX = e.clientX;
    });
    list.addEventListener('mouseover', function (e) {
      var row = e.target.closest('.wk-row');
      if (!row) return;
      var i = parseInt(row.getAttribute('data-peek'), 10);
      if (i === on) return;
      if (on > -1) { gsap.to(items[on], { autoAlpha: 0, duration: 0.3 }); hold(items[on]._screen, true); }
      if (on === -1) { gsap.set(peek, { x: spot(e.clientX), y: e.clientY }); lastX = e.clientX; }
      on = i;
      gsap.fromTo(items[i], { autoAlpha: 0, scale: 1.08 }, { autoAlpha: 1, scale: 1, duration: 0.45, ease: 'expo.out' });
      gsap.to(peek, { autoAlpha: 1, scale: 1, duration: 0.5, ease: 'expo.out' });
      hold(items[i]._screen, false);
    });
    list.addEventListener('mouseleave', function () {
      gsap.to(peek, { autoAlpha: 0, scale: 0.7, duration: 0.4, ease: 'power2.in' });
      if (on > -1) { hold(items[on]._screen, true); gsap.set(items[on], { autoAlpha: 0, delay: 0.4 }); }
      on = -1;
    });
  }
})();
