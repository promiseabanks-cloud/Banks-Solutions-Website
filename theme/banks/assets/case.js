/* Case study choreography. Every start state is set here, so the page reads in full without JS. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  if (!gsap || B.reduce) return;

  /* 1. Hero: the name rises line by line, the devices come up behind it */
  var title = document.querySelector('.cs-title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.3, ease: 'expo.out', stagger: 0.1 });
  tl.from('.cs-eyebrow, .cs-lede, .cs-actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.07 }, '-=1')
    .from('.cs-rig', { y: 140, opacity: 0, duration: 1.6, ease: 'expo.out' }, 0.35);

  if (!ST) return;

  /* The laptop opens flat and the phone swings in as you scroll toward them */
  var rig = document.querySelector('.cs-rig');
  if (rig) {
    var scrub = { trigger: rig, start: 'top 95%', end: 'center 55%', scrub: 0.8 };
    gsap.fromTo('.cs-rig__laptop', { rotationX: 34, scale: 0.86 }, { rotationX: 0, scale: 1, ease: 'none', scrollTrigger: scrub });
    gsap.fromTo('.cs-rig__phone', { xPercent: 60, yPercent: 10, rotationY: -40, opacity: 0.3 }, { xPercent: 0, yPercent: 0, rotationY: 0, opacity: 1, ease: 'none', transformPerspective: 1200, scrollTrigger: scrub });
    if (!B.lite) gsap.to('.cs-rig__phone .wk-device', { y: -12, duration: 3.2, ease: 'sine.inOut', yoyo: true, repeat: -1, delay: 2 });
  }

  /* 3. Next project: the name and the device rise as the band arrives */
  var next = document.querySelector('.cs-next');
  if (next) {
    gsap.from(next.querySelectorAll('.cs-next__copy > *'), { y: 40, opacity: 0, duration: 1.1, ease: 'expo.out', stagger: 0.08, scrollTrigger: { trigger: next, start: 'top 80%', once: true } });
    gsap.from(next.querySelector('.cs-next__rig'), { y: 90, opacity: 0, duration: 1.4, ease: 'expo.out', scrollTrigger: { trigger: next, start: 'top 80%', once: true } });
  }
})();
