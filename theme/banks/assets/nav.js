(function () {
  var b = document.querySelector('.b-burger');
  if (b) {
    b.addEventListener('click', function () {
      var open = b.getAttribute('aria-expanded') === 'true';
      b.setAttribute('aria-expanded', String(!open));
      document.body.classList.toggle('b-nav-open', !open);
    });
  }

  /* Dropdowns: a click (or Enter) opens one panel and closes the others. On desktop hover
     opens them too (CSS); on the phone menu they open in place. */
  var tops = [].slice.call(document.querySelectorAll('.b-nav__top'));
  function setOpen(btn, on) {
    btn.setAttribute('aria-expanded', String(on));
    btn.parentNode.classList.toggle('is-open', on);
  }
  function closeAll(except) {
    tops.forEach(function (t) { if (t !== except) setOpen(t, false); });
  }
  tops.forEach(function (t) {
    t.addEventListener('click', function () {
      var on = t.getAttribute('aria-expanded') !== 'true';
      closeAll(t);
      setOpen(t, on);
    });
  });
  document.addEventListener('click', function (e) {
    if (!e.target.closest('.has-panel') && !document.body.classList.contains('b-nav-open')) closeAll();
  });

  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    var open = tops.filter(function (t) { return t.getAttribute('aria-expanded') === 'true'; })[0];
    if (open) { closeAll(); open.focus(); return; }
    if (b && document.body.classList.contains('b-nav-open')) b.click();
  });
})();
