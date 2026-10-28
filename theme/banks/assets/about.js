/* About choreography. Every start state is set here, so the page reads in full without JS:
   the routes are drawn, every word is lit and the cards simply stack. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises, then the routes fly out from Lagos one by one */
  var title = document.querySelector('.ab-title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.ab-eyebrow, .ab-lede, .ab-actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.ab-map__grid', { opacity: 0, duration: 1.4 }, 0.2)
    .from('.ab-home__dot', { scale: 0, transformOrigin: '50% 50%', duration: 0.7, ease: 'back.out(3)' }, 0.5)
    .from('.ab-home__label', { opacity: 0, y: 6, duration: 0.6 }, 0.7);

  var routes = Array.prototype.slice.call(document.querySelectorAll('.ab-route'));
  var svg = document.querySelector('.ab-map__svg');
  routes.forEach(function (r, i) {
    var arc = r.querySelector('.ab-route__arc');
    var len = arc.getTotalLength();
    var at = 0.9 + i * 0.22;
    tl.fromTo(arc, { strokeDasharray: len, strokeDashoffset: len }, { strokeDashoffset: 0, duration: 1.3, ease: 'power2.inOut' }, at)
      .from(r.querySelector('.ab-route__pin'), { scale: 0, transformOrigin: '50% 50%', duration: 0.6, ease: 'back.out(3)' }, at + 1.05)
      .from(r.querySelector('.ab-route__label'), { opacity: 0, duration: 0.5 }, at + 1.1);
  });
  tl.add(function () { routes.forEach(function (r) { r.querySelector('.ab-route__arc').style.strokeDasharray = 'none'; }); });

  // Home pulses; a spark travels each route in turn, like work going out.
  gsap.fromTo('.ab-home__ring', { scale: 0.6, opacity: 0.9 }, { scale: 2.2, opacity: 0, duration: 2.4, ease: 'power2.out', repeat: -1, delay: 1 });
  if (!B.lite && svg && routes.length) {
    var spark = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    spark.setAttribute('r', '2.6');
    spark.setAttribute('class', 'ab-route__spark');
    spark.style.opacity = 0;
    svg.appendChild(spark);
    var live = true;
    var k = 0;
    var fly = function () {
      if (!live || document.hidden) { gsap.delayedCall(1, fly); return; }
      var arc = routes[k % routes.length].querySelector('.ab-route__arc');
      var len = arc.getTotalLength();
      var o = { t: 0 };
      k++;
      gsap.timeline({ onComplete: function () { gsap.delayedCall(0.5, fly); } })
        .set(spark, { opacity: 1 })
        .to(o, {
          t: 1, duration: 1.6, ease: 'power1.inOut',
          onUpdate: function () { var p = arc.getPointAtLength(o.t * len); spark.setAttribute('cx', p.x); spark.setAttribute('cy', p.y); }
        })
        .to(spark, { opacity: 0, duration: 0.25 });
    };
    gsap.delayedCall(3.4, fly);
    if (ST) ST.create({ trigger: svg, start: 'top bottom', end: 'bottom top', onToggle: function (self) { live = self.isActive; } });
  }

  if (!ST) return;

  /* Hero exit: the frame pulls in and rounds off */
  if (!B.lite) {
    var scrub = { trigger: '.ab-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.ab-stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.ab-copy', { yPercent: -14, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
    gsap.to('.ab-map', { yPercent: 8, scale: 0.94, ease: 'none', scrollTrigger: scrub });
  }

  /* 3. The story: each word lights as it passes the middle of the screen */
  var big = document.querySelector('[data-scrub]');
  if (big && B.split) {
    var words = B.split(big, 'words');
    gsap.fromTo(words, { opacity: 0.16 }, { opacity: 1, ease: 'none', stagger: 0.1, scrollTrigger: { trigger: big, start: 'top 78%', end: 'bottom 45%', scrub: 0.6 } });
  }

  /* 4. How we work: as each card arrives, the ones beneath it sink back */
  var cards = Array.prototype.slice.call(document.querySelectorAll('.ab-way'));
  cards.forEach(function (c, i) {
    var nextCard = cards[i + 1];
    if (!nextCard) return;
    var sink = { trigger: nextCard, start: 'top 85%', end: 'top 30%', scrub: true };
    gsap.to(c, { scale: 0.94 - (cards.length - i) * 0.005, ease: 'none', scrollTrigger: sink });
    gsap.to(c.querySelector('.ab-way__in'), { opacity: 0, ease: 'none', scrollTrigger: sink });
  });
  cards.forEach(function (c) {
    gsap.from(c.querySelector('.ab-way__in').children, { y: 30, opacity: 0, duration: 1, ease: 'expo.out', stagger: 0.07, scrollTrigger: { trigger: c, start: 'top 85%', once: true } });
  });

  /* 5. The portrait rises with a slow reveal */
  gsap.fromTo('.ab-portrait', { clipPath: 'inset(18% 10% 18% 10% round 26px)', scale: 1.06 }, { clipPath: 'inset(0% 0% 0% 0% round 26px)', scale: 1, duration: 1.6, ease: 'expo.out', scrollTrigger: { trigger: '.ab-portrait', start: 'top 82%', once: true }, clearProps: 'clipPath' });
})();
