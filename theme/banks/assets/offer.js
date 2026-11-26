/* Year-end offer (/offer/): the countdown, plan buttons and the form. The page reads fully without this. */
(function () {
  'use strict';
  var form = document.querySelector('.of-form');
  var alertBox = document.querySelector('.of-alert[hidden], .of-alert');

  // Countdown: days, hours, minutes until the offer ends.
  var count = document.querySelector('.of-count');
  if (count && count.getAttribute('data-ends')) {
    var end = new Date(count.getAttribute('data-ends')).getTime();
    var tick = function () {
      var ms = end - Date.now();
      if (ms <= 0) { count.textContent = 'This offer has ended'; return; }
      var d = Math.floor(ms / 86400000), h = Math.floor(ms % 86400000 / 3600000), m = Math.floor(ms % 3600000 / 60000);
      count.textContent = 'Ends in ' + d + ' days ' + h + ' hours ' + m + ' minutes';
    };
    tick();
    setInterval(tick, 30000);
  }

  // Plan buttons choose the plan and take the visitor to the form.
  document.querySelectorAll('[data-plan]').forEach(function (a) {
    a.addEventListener('click', function () {
      if (form && form.elements.plan) { form.elements.plan.value = a.getAttribute('data-plan'); }
    });
  });

  if (!form) { return; }
  if (form.elements.banks_t) { form.elements.banks_t.value = Math.floor(Date.now() / 1000); }
  var say = function (msg) {
    if (!alertBox) { return; }
    alertBox.textContent = msg;
    alertBox.hidden = false;
  };
  form.addEventListener('submit', function (e) {
    var bad = [];
    ['name', 'phone', 'email', 'business'].forEach(function (n) {
      var el = form.elements[n];
      var ok = el && el.value.trim() !== '' && (n !== 'email' || /\S+@\S+\.\S+/.test(el.value)) && (n !== 'phone' || el.value.replace(/\D/g, '').length >= 8);
      el.classList.toggle('is-bad', !ok);
      if (!ok) { bad.push(n); }
    });
    if (!form.elements.consent.checked) { bad.push('consent'); }
    if (bad.length) { e.preventDefault(); say('Please check the highlighted details.'); return; }
    if (!window.fetch || !window.FormData) { return; }
    e.preventDefault();
    var send = form.querySelector('.of-send');
    var label = send.textContent;
    send.disabled = true;
    send.textContent = 'Sending…';
    var headers = form.getAttribute('data-nonce') ? { 'X-WP-Nonce': form.getAttribute('data-nonce') } : {};
    fetch(form.getAttribute('data-rest'), { method: 'POST', body: new FormData(form), credentials: 'same-origin', headers: headers })
      .then(function (r) {
        if (r.status === 401 || r.status === 403 || r.status >= 500) { throw new Error('blocked'); }
        return r.json().then(function (d) { return { ok: r.ok, d: d }; });
      })
      .then(function (res) {
        if (res.ok) {
          var card = form.closest('.of-card');
          card.innerHTML = '<div class="of-done"><h2>Got it.</h2><p>We have emailed you a link. Click it to confirm that you are ready to start, and we will send your deposit details.</p></div>';
          return;
        }
        send.disabled = false;
        send.textContent = label;
        say(res.d.message || 'Something went wrong. Please try again.');
      })
      .catch(function () { form.submit(); });
  });
})();
