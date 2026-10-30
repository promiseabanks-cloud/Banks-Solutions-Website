/* Articles and glossary terms. The progress bar, contents highlight and copy-link button are
   added here and work with reduced motion too; without JS the page reads as plain text.
   Motion: the masthead rises, the cover settles as you scroll, the definition lights up. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  var article = document.querySelector('.rd');

  /* Reading progress across the article */
  var bar = document.querySelector('.rd-progress');
  if (bar && article) {
    bar.hidden = false;
    var fill = bar.querySelector('span');
    var tick = false;
    var draw = function () {
      tick = false;
      var r = article.getBoundingClientRect();
      var span = r.height - window.innerHeight;
      var p = span > 0 ? Math.min(1, Math.max(0, -r.top / span)) : 1;
      fill.style.setProperty('--p', p.toFixed(4));
    };
    window.addEventListener('scroll', function () { if (!tick) { tick = true; requestAnimationFrame(draw); } }, { passive: true });
    window.addEventListener('resize', draw);
    draw();
  }

  /* Contents: open on wide screens, folded on phones; the part being read is marked */
  var toc = document.querySelector('.rd-toc');
  if (toc) {
    var wide = window.matchMedia('(min-width: 1100px)');
    var fold = function () { toc.open = wide.matches; };
    fold();
    if (wide.addEventListener) wide.addEventListener('change', fold);
    var links = Array.prototype.slice.call(toc.querySelectorAll('a'));
    var heads = links.map(function (a) { return document.getElementById(decodeURIComponent(a.getAttribute('href').slice(1))); });
    links.forEach(function (a, i) {
      a.addEventListener('click', function (e) {
        if (!heads[i]) return;
        e.preventDefault();
        if (B.scrollTo) B.scrollTo(heads[i]); else heads[i].scrollIntoView();
        if (!wide.matches) toc.open = false;
        history.replaceState(null, '', a.getAttribute('href'));
      });
    });
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
          if (!e.isIntersecting) return;
          var i = heads.indexOf(e.target);
          links.forEach(function (a, k) { a.classList.toggle('is-on', k === i); });
        });
      }, { rootMargin: '0px 0px -70% 0px' });
      heads.forEach(function (h) { if (h) io.observe(h); });
    }
  }

  /* Copy link */
  var copy = document.querySelector('.rd-copy');
  if (copy && navigator.clipboard) {
    copy.parentNode.hidden = false;
    copy.addEventListener('click', function () {
      navigator.clipboard.writeText(copy.getAttribute('data-url')).then(function () {
        copy.textContent = 'Copied';
        setTimeout(function () { copy.textContent = 'Copy link'; }, 2000);
      });
    });
  }

  if (!gsap || B.reduce) return;

  /* 1. Masthead: the headline rises line by line, then the details and the cover */
  var title = document.querySelector('.rd-title, .tm-title');
  var tl = gsap.timeline({ delay: 0.12 });
  if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.2, ease: 'expo.out', stagger: 0.09 });
  tl.from('.rd-crumbs, .rd-lead, .rd-meta, .tm-label', { y: 24, opacity: 0, duration: 0.9, stagger: 0.07 }, '-=0.9');
  if (document.querySelector('.rd-cover')) tl.from('.rd-cover__frame', { y: 90, clipPath: 'inset(18% 6% 0% 6% round 28px)', duration: 1.5, ease: 'expo.out' }, 0.35);
  if (document.querySelector('.tm-def')) tl.from('.tm-def', { y: 70, rotationX: -12, opacity: 0, duration: 1.3, ease: 'expo.out', transformPerspective: 1200, transformOrigin: '50% 100%' }, 0.4);

  if (!ST) return;

  /* The cover eases out of its zoom as it passes */
  var img = document.querySelector('.rd-cover img');
  if (img && !B.lite) {
    gsap.fromTo(img, { scale: 1.14, yPercent: -4 }, { scale: 1, yPercent: 4, ease: 'none', scrollTrigger: { trigger: '.rd-cover', start: 'top bottom', end: 'bottom top', scrub: true } });
  }

  /* 2. Headings and pictures in the text arrive as they're reached; long reads stay calm */
  gsap.utils.toArray('.rd-prose h2, .rd-prose img, .rd-prose blockquote').forEach(function (el) {
    gsap.from(el, { y: 30, opacity: 0, duration: 0.9, ease: 'expo.out', scrollTrigger: { trigger: el, start: 'top 88%', once: true } });
  });
  if (document.querySelector('.rd-qa')) gsap.from('.rd-qa', { y: 20, opacity: 0, duration: 0.7, ease: 'power3.out', stagger: 0.06, scrollTrigger: { trigger: '.rd-faqs', start: 'top 80%', once: true } });
  if (document.querySelector('.rd-note')) gsap.from('.rd-note', { y: 50, opacity: 0, duration: 1.1, ease: 'expo.out', scrollTrigger: { trigger: '.rd-note', start: 'top 88%', once: true } });

  /* Answers open smoothly */
  document.querySelectorAll('.rd-qa').forEach(function (d) {
    var sum = d.querySelector('summary');
    var body = d.querySelector('.rd-qa__a');
    sum.addEventListener('click', function (e) {
      e.preventDefault();
      if (d.open) {
        gsap.to(body, { height: 0, duration: 0.35, ease: 'power2.inOut', onComplete: function () { d.open = false; gsap.set(body, { clearProps: 'height' }); } });
      } else {
        d.open = true;
        gsap.from(body, { height: 0, duration: 0.45, ease: 'power2.out', clearProps: 'height' });
      }
    });
  });

  /* Glossary term: once the card lands, the definition lights up word by word */
  var def = document.querySelector('.tm-def__text');
  if (def && B.split) tl.from(B.split(def, 'words'), { opacity: 0.15, duration: 0.6, ease: 'power1.out', stagger: 0.035 }, 0.9);

  /* Cards and terms further down */
  ST.batch('.rd-card, .tm-pn__link', { start: 'top 90%', once: true, onEnter: function (els) { gsap.from(els, { y: 40, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.08 }); } });
  if (document.querySelector('.tm-terms')) gsap.from('.tm-terms li', { y: 16, opacity: 0, duration: 0.5, ease: 'power2.out', stagger: 0.015, scrollTrigger: { trigger: '.tm-terms', start: 'top 85%', once: true } });
})();
