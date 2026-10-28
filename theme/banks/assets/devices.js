/* Device screens: a recording starts when its screen comes into view and pauses when it leaves.
   Screens without a recording scroll their poster or stand-in slowly instead, like someone
   reading the page. Weak phones, data saver and reduced motion get the poster, still. */
(function () {
  var gsap = window.gsap;
  var B = window.Banks || {};
  var saver = !!(navigator.connection && navigator.connection.saveData);
  var still = B.reduce || B.lite || saver || !gsap;
  var screens = document.querySelectorAll('[data-screen]');
  if (still || !screens.length || !('IntersectionObserver' in window)) return;

  // The view showing now: the one marked on, else the first.
  var current = function (screen) {
    return screen.querySelector('.wk-view.is-on') || screen.querySelector('.wk-view');
  };

  var pan = function (view) {
    if (view._pan) return view._pan;
    var page = view.querySelector('.wk-shot, .wk-mock');
    var travel = page ? page.offsetHeight - view.offsetHeight : 0;
    if (travel < 20) return null;
    view._pan = gsap.timeline({ repeat: -1, yoyo: true, repeatDelay: 1.4, paused: true, delay: 0.8 })
      .to(page, { y: -travel, duration: Math.min(14, 3 + travel / 120), ease: 'power1.inOut' });
    return view._pan;
  };

  var start = function (screen) {
    if (screen._hold) return;
    var view = current(screen);
    if (!view) return;
    var vid = view.querySelector('.wk-vid');
    if (vid) {
      if (!vid.src) {
        vid.src = vid.getAttribute('data-src');
        vid.addEventListener('playing', function () { vid.classList.add('is-playing'); });
      }
      var p = vid.play();
      if (p && p.catch) p.catch(function () {});
      return;
    }
    var t = pan(view);
    if (t) t.play();
  };
  var stop = function (screen) {
    screen.querySelectorAll('.wk-vid').forEach(function (v) { v.pause(); });
    screen.querySelectorAll('.wk-view').forEach(function (v) { if (v._pan) v._pan.pause(); });
  };

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      e.target._seen = e.isIntersecting;
      if (e.isIntersecting && !document.hidden) start(e.target);
      else stop(e.target);
    });
  }, { rootMargin: '120px 0px', threshold: 0.15 });
  screens.forEach(function (s) { io.observe(s); });

  document.addEventListener('visibilitychange', function () {
    screens.forEach(function (s) { if (document.hidden) stop(s); else if (s._seen) start(s); });
  });

  // Pages that swap what a screen shows call this so the new view starts and the old one rests.
  B.screen = function (screen) {
    stop(screen);
    if (screen._seen) start(screen);
  };
  // Hold a screen still even while it is in view (a carousel's side slides, a hidden preview).
  B.hold = function (screen, on) {
    screen._hold = !!on;
    if (on) stop(screen);
    else if (screen._seen && !document.hidden) start(screen);
  };
})();
