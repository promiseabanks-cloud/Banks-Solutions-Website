/* Homepage: hero entrance and the flow line. */
(function () {
  var gsap = window.gsap;
  var B = window.Banks || {};
  if (!gsap || B.reduce) return;

  var title = document.querySelector('[data-split-hero]');
  var line = document.querySelector('.h-flow__line');
  var bank = document.querySelector('.h-flow__bank');
  var tl = gsap.timeline({ delay: 0.15 });

  if (title) {
    tl.from(B.split(title, 'lines'), { yPercent: 105, duration: 1.2, ease: 'expo.out', stagger: 0.09 });
  }
  tl.from('.h-hero__eyebrow, .h-hero__lede, .h-hero__actions > *', { y: 24, opacity: 0, duration: 0.9, stagger: 0.08 }, '-=0.8');

  // Draw the river: the line flows in, the bank swells behind it, then the line drifts with scroll.
  if (line && line.getTotalLength) {
    var len = line.getTotalLength();
    gsap.set(line, { strokeDasharray: len, strokeDashoffset: len });
    tl.to(line, { strokeDashoffset: 0, duration: 2.2, ease: 'power2.inOut' }, 0.1);
    tl.from(bank, { opacity: 0, duration: 1.6 }, 0.5);
    if (window.ScrollTrigger && !B.lite) {
      gsap.to('.h-flow', { yPercent: 18, ease: 'none', scrollTrigger: { trigger: '.h-hero', start: 'top top', end: 'bottom top', scrub: true } });
    }
  }
})();
