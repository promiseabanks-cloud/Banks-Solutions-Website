(function () {
  var b = document.querySelector('.b-burger');
  if (!b) return;
  b.addEventListener('click', function () {
    var open = b.getAttribute('aria-expanded') === 'true';
    b.setAttribute('aria-expanded', String(!open));
    document.body.classList.toggle('b-nav-open', !open);
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && document.body.classList.contains('b-nav-open')) b.click();
  });
})();
