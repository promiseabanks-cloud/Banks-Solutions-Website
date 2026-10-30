/* WordPress development choreography. Every start state is set here, so the page reads in full
   without JS: the whole file, the passed review and all five steps are in the HTML. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises, the file writes itself, then the review passes */
  var title = document.querySelector('.dv-title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.dv-eyebrow, .dv-lede, .dv-actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.dv-editor', { y: 70, rotationY: -10, rotationX: 6, opacity: 0, duration: 1.4, ease: 'expo.out', transformPerspective: 1400 }, 0.3);

  var lines = gsap.utils.toArray('.dv-ln');
  var review = document.querySelector('.dv-review');
  if (lines.length) {
    gsap.set(lines, { autoAlpha: 0 });
    if (review) {
      gsap.set(review, { autoAlpha: 0, y: 24, scale: 0.95 });
      gsap.set(review.querySelectorAll('li'), { autoAlpha: 0, x: -8 });
    }
    // Each line reveals left to right, like it is being typed.
    lines.forEach(function (l, i) {
      tl.fromTo(l, { autoAlpha: 1, clipPath: 'inset(0 100% 0 0)' }, { clipPath: 'inset(0 0% 0 0)', duration: B.lite ? 0.1 : 0.22, ease: 'none' }, i ? '>-0.06' : 0.8);
    });
    if (review) {
      tl.to(review, { autoAlpha: 1, y: 0, scale: 1, duration: 0.6, ease: 'back.out(1.7)' }, '+=0.2')
        .to(review.querySelectorAll('li'), { autoAlpha: 1, x: 0, duration: 0.35, stagger: 0.12, ease: 'power2.out' }, '-=0.2');
    }
  }

  if (!ST) return;

  /* Hero exit: the frame pulls in and rounds off */
  if (!B.lite) {
    var scrub = { trigger: '.dv-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.dv-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.dv-copy', { yPercent: -14, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
  }

  /* 3. How we work: on wide screens the steps slide past sideways while the section is pinned */
  var flow = document.querySelector('.dv-flow');
  var track = flow && flow.querySelector('.dv-track');
  if (flow && track) {
    var mm = gsap.matchMedia();
    mm.add('(min-width: 1024px) and (min-height: 640px)', function () {
      flow.classList.add('is-rail');
      var dist = function () { return Math.max(0, track.scrollWidth - window.innerWidth); };
      var cards = track.querySelectorAll('.dv-stepcard');
      var t = gsap.timeline({
        scrollTrigger: { trigger: flow, start: 'top top', end: function () { return '+=' + dist(); }, pin: flow.querySelector('.dv-flow__pin'), scrub: 0.6, invalidateOnRefresh: true }
      });
      t.to(track, { x: function () { return -dist(); }, ease: 'none' }, 0)
        .to('.dv-flow__bar span', { scaleX: 1, ease: 'none' }, 0)
        .from(cards, { rotationY: -18, opacity: 0.35, transformPerspective: 1000, stagger: 0.12, ease: 'none', duration: 0.4 }, 0);
      return function () { flow.classList.remove('is-rail'); gsap.set(track, { clearProps: 'all' }); };
    });
    mm.add('(max-width: 1023px), (max-height: 639px)', function () {
      gsap.from(track.children, { y: 40, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.08, scrollTrigger: { trigger: track, start: 'top 85%', once: true } });
    });
  }
})();
