/* Start a project: the brief runs one step at a time and sends without leaving the page.
   Without this file every step shows at once and the form posts normally, so it all still works. */
(function () {
  var gsap = window.gsap;
  var B = window.Banks || {};
  var motion = gsap && !B.reduce;

  /* Entrance: the headline rises line by line, the promise and the card follow */
  if (motion) {
    var title = document.querySelector('.st-title');
    var tl = gsap.timeline({ delay: 0.15 });
    if (title && B.split) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
    tl.from('.st-eyebrow, .st-lede', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
      .from('.st-next__item', { x: -24, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.1 }, '-=0.7')
      .from('.st-next__dot', { scale: 0, duration: 0.6, ease: 'back.out(2.4)', stagger: 0.1 }, '<')
      .from('.st-direct', { opacity: 0, duration: 0.8 }, '-=0.4')
      .from('.st-card', { y: 80, rotationX: -10, opacity: 0, duration: 1.4, ease: 'expo.out', transformPerspective: 1400, transformOrigin: '50% 100%', clearProps: 'transform,opacity' }, 0.35);
  }

  var form = document.querySelector('.st-form');
  if (!form) return;
  var card = form.closest('.st-card');
  var wrap = form.querySelector('.st-steps');
  var steps = Array.prototype.slice.call(form.querySelectorAll('.st-step'));
  var nav = form.querySelector('.st-nav');
  var back = form.querySelector('.st-back');
  var go = form.querySelector('.st-go');
  var send = form.querySelector('.st-send');
  var bar = form.querySelector('.st-bar span');
  var alert = form.querySelector('.st-alert');
  var cur = 0;

  form.noValidate = true;
  form.elements.banks_t.value = Math.floor(Date.now() / 1000);
  card.classList.add('js-brief');
  nav.hidden = false;

  var setBar = function (i, animate) {
    var p = (i + 1) / steps.length;
    if (motion && animate) gsap.to(bar, { scaleX: p, duration: 0.7, ease: 'expo.out' });
    else bar.style.transform = 'scaleX(' + p + ')';
  };
  var setNav = function () {
    back.disabled = cur === 0;
    go.hidden = cur === steps.length - 1;
  };
  steps[0].classList.add('is-on');
  setBar(0);
  setNav();

  /* One step out, the next one in; the card eases to the new height */
  var show = function (i) {
    if (i === cur || i < 0 || i >= steps.length) return;
    var from = steps[cur];
    var to = steps[i];
    var dir = i > cur ? 1 : -1;
    var h0 = wrap.offsetHeight;
    from.classList.remove('is-on');
    to.classList.add('is-on');
    cur = i;
    setNav();
    setBar(i, true);
    hideAlert();
    if (motion) {
      var h1 = wrap.offsetHeight;
      gsap.fromTo(wrap, { height: h0 }, { height: h1, duration: 0.6, ease: 'expo.out', clearProps: 'height' });
      gsap.fromTo(to.querySelectorAll('.st-step__head, .st-tile, .st-field, .st-check, .st-send'), { x: 46 * dir, opacity: 0 }, { x: 0, opacity: 1, duration: 0.7, ease: 'expo.out', stagger: 0.035, clearProps: 'transform,opacity' });
    }
    // On a phone the top of the card may be off screen; bring the new question into view.
    var top = card.getBoundingClientRect().top;
    if (top < 0 || top > window.innerHeight * 0.6) {
      var y = window.scrollY + top - 90;
      if (B.lenis) B.lenis.scrollTo(y, { duration: 0.8 });
      else window.scrollTo({ top: y, behavior: motion ? 'smooth' : 'auto' });
    }
    var first = to.querySelector('input:not([type="hidden"]), select, textarea');
    if (first && window.matchMedia('(hover: hover)').matches) first.focus({ preventScroll: true });
  };

  var hideAlert = function () { alert.hidden = true; };
  var say = function (text) {
    alert.textContent = text;
    alert.hidden = false;
    if (motion) gsap.fromTo(alert, { y: -8, opacity: 0 }, { y: 0, opacity: 1, duration: 0.5, ease: 'expo.out', clearProps: 'transform,opacity' });
  };

  /* A step is complete when every required answer in it is valid; groups need one choice */
  var check = function (step) {
    var bad = [];
    var groups = {};
    step.querySelectorAll('input, select, textarea').forEach(function (el) {
      if (el.type === 'checkbox' && el.name === 'needs[]') { groups.needs = groups.needs || el.closest('.st-tiles'); return; }
      if (el.type === 'radio') { groups[el.name] = groups[el.name] || el.closest('.st-tiles'); return; }
      var holder = el.closest('.st-field, .st-check');
      if (holder) holder.classList.remove('is-wrong');
      if (!el.checkValidity()) bad.push(holder || el);
    });
    Object.keys(groups).forEach(function (name) {
      var g = groups[name];
      var picked = g.querySelector('input:checked');
      g.classList.toggle('is-wrong', !picked);
      if (!picked) bad.push(g);
    });
    bad.forEach(function (b) { b.classList.add('is-wrong'); });
    if (bad.length && motion) gsap.fromTo(step, { x: 0 }, { keyframes: { x: [-10, 9, -6, 4, 0] }, duration: 0.45, ease: 'none', clearProps: 'transform' });
    if (bad.length) {
      var f = bad[0].querySelector ? bad[0].querySelector('input, select, textarea') : bad[0];
      if (f) f.focus({ preventScroll: true });
    }
    return !bad.length;
  };

  go.addEventListener('click', function () { if (check(steps[cur])) show(cur + 1); });
  back.addEventListener('click', function () { show(cur - 1); });

  // Clear a warning as soon as it is answered; a single-choice answer moves straight on.
  form.addEventListener('change', function (e) {
    var t = e.target;
    var holder = t.closest('.is-wrong');
    if (holder) holder.classList.remove('is-wrong');
    if (t.type === 'radio' || t.type === 'checkbox') {
      var tile = t.closest('.st-tile');
      if (tile && t.checked && motion) gsap.fromTo(tile.querySelector('span'), { scale: 0.96 }, { scale: 1, duration: 0.5, ease: 'back.out(3)', clearProps: 'transform' });
    }
    if (t.type === 'radio') setTimeout(function () { if (steps[cur].contains(t)) show(cur + 1); }, 380);
  });
  form.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && e.target.tagName === 'INPUT' && e.target.type !== 'checkbox' && cur < steps.length - 1) {
      e.preventDefault();
      go.click();
    }
  });

  /* The thank-you panel, built the same way the page draws it after a plain post */
  var done = function (ref) {
    var wa = (document.querySelector('.st-direct a') || {}).href || '';
    var box = document.createElement('div');
    box.className = 'st-done';
    box.setAttribute('role', 'status');
    box.innerHTML = '<span class="st-done__tick" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7"/></svg></span>' +
      '<h2 class="st-done__title">Brief received.</h2><p>Your reference is <strong class="st-done__ref"></strong>. We have emailed you a copy.</p>' +
      '<p>Within two working days we’ll reply with what we’d build, how long it takes and what it costs.</p>' +
      (wa ? '<a class="b-btn b-btn--line" href="">Message us on WhatsApp</a>' : '');
    box.querySelector('.st-done__ref').textContent = ref;
    if (wa) box.querySelector('a').href = wa;
    var h0 = card.offsetHeight;
    form.replaceWith(box);
    if (!motion) return;
    var h1 = card.offsetHeight;
    var path = box.querySelector('path');
    var len = path.getTotalLength ? path.getTotalLength() : 0;
    gsap.timeline()
      .fromTo(card, { height: h0 }, { height: h1, duration: 0.8, ease: 'expo.out', clearProps: 'height' })
      .fromTo(box.querySelector('.st-done__tick'), { scale: 0, rotate: -90 }, { scale: 1, rotate: 0, duration: 0.8, ease: 'back.out(2)', clearProps: 'transform' }, 0.1)
      .fromTo(path, { strokeDasharray: len, strokeDashoffset: len }, { strokeDashoffset: 0, duration: 0.6, ease: 'power2.out' }, 0.45)
      .fromTo(box.querySelectorAll('h2, p, .b-btn'), { y: 24, opacity: 0 }, { y: 0, opacity: 1, duration: 0.9, ease: 'expo.out', stagger: 0.08, clearProps: 'transform,opacity' }, 0.3);
  };

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    if (!check(steps[cur])) return;
    if (!window.fetch || !window.FormData) { form.submit(); return; }
    send.disabled = true;
    var label = send.textContent;
    send.textContent = 'Sending…';
    fetch(form.getAttribute('data-rest'), { method: 'POST', body: new FormData(form), credentials: 'same-origin' })
      .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, d: d }; }); })
      .then(function (res) {
        if (res.ok && res.d.ref) { done(res.d.ref); return; }
        send.disabled = false;
        send.textContent = label;
        // Send the visitor back to the first step with a missing answer.
        var fields = res.d.fields || [];
        var at = steps.findIndex(function (s) {
          return fields.some(function (f) { return s.querySelector('[name="' + (f === 'needs' ? 'needs[]' : f) + '"]'); });
        });
        if (at > -1 && at !== cur) show(at);
        if (at > -1) check(steps[at]);
        say(res.d.message || 'Something went wrong. Please try again.');
      })
      .catch(function () {
        // If the quick route fails, post the ordinary way; the page comes back with the result.
        form.submit();
      });
  });
})();
