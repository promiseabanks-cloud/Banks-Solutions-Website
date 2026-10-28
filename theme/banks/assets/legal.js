/* Legal pages. The contents list highlights the section being read and a thin bar shows how far
   down the page you are. The page reads in full without any of it. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};

  /* The section in view, marked in the contents list (works with reduced motion too) */
  var links = Array.prototype.slice.call(document.querySelectorAll('.lg-toc a'));
  var secs = links.map(function (a) { return document.querySelector(a.getAttribute('href')); });
  if ('IntersectionObserver' in window && links.length) {
    var mark = function (i) { links.forEach(function (a, k) { a.classList.toggle('is-on', k === i); if (k === i) a.setAttribute('aria-current', 'true'); else a.removeAttribute('aria-current'); }); };
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) { if (e.isIntersecting) mark(secs.indexOf(e.target)); });
    }, { rootMargin: '-30% 0px -60% 0px' });
    secs.forEach(function (s) { if (s) io.observe(s); });
  }

  if (!gsap || B.reduce) return;

  /* Hero: the title rises in */
  var title = document.querySelector('.lg-title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.2, ease: 'expo.out', stagger: 0.1 });
  tl.from('.lg-eyebrow, .lg-lede, .lg-meta', { y: 24, opacity: 0, duration: 0.9, stagger: 0.08 }, '-=0.9');

  if (!ST) return;

  /* Reading progress */
  var bar = document.querySelector('.lg-progress');
  if (bar) {
    bar.classList.add('is-on');
    gsap.fromTo(bar.firstElementChild, { scaleX: 0 }, { scaleX: 1, ease: 'none', scrollTrigger: { trigger: '.lg-body', start: 'top 60%', end: 'bottom bottom', scrub: 0.3 } });
  }

  /* Hero exit, as on every scene page */
  if (!B.lite) {
    gsap.fromTo('.lg-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: { trigger: '.lg-hero', start: 'top top', end: 'bottom top', scrub: true } });
  }
})();
