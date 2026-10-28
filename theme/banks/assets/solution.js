/* Solution page choreography. Every start state is set here, so the page reads in full without JS. */
(function () {
  var gsap = window.gsap;
  var ST = window.ScrollTrigger;
  var B = window.Banks || {};
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  if (!gsap || B.reduce) return;

  /* 1. Hero: the headline rises line by line, then the page's own visual plays */
  var title = document.querySelector('.so-hero__title');
  var tl = gsap.timeline({ delay: 0.15 });
  if (title) tl.from(B.split(title, 'lines'), { yPercent: 110, rotate: 2, duration: 1.25, ease: 'expo.out', stagger: 0.1 });
  tl.from('.so-crumbs, .so-hero__lede, .so-hero__actions > *', { y: 28, opacity: 0, duration: 1, stagger: 0.08 }, '-=0.95')
    .from('.so-hero__facts li', { y: 20, opacity: 0, duration: 0.8, stagger: 0.07 }, '-=0.6');

  var visuals = {
    /* Websites: a wireframe draws, the blocks paint in, the phone version slides in with its load time */
    websites: function (vis) {
      var blocks = vis.querySelectorAll('.vw-browser .vw-b');
      var grid = vis.querySelector('.vw-grid');
      var speed = vis.querySelector('[data-vw-speed]');
      var v = gsap.timeline();
      gsap.set(blocks, { '--f': 0 });
      vis.classList.add('is-wire');
      v.from(vis.querySelector('.vw-browser'), { y: 60, rotationX: -14, opacity: 0, duration: 1.3, ease: 'expo.out', transformOrigin: '50% 100%' })
        .fromTo(grid, { opacity: 0 }, { opacity: 1, duration: 0.3 }, 0.4)
        .from(grid.querySelectorAll('i'), { scaleY: 0, duration: 0.8, ease: 'expo.inOut', stagger: 0.06 }, 0.4)
        .from(blocks, { scale: 0.92, opacity: 0, duration: 0.6, ease: 'expo.out', stagger: 0.035 }, 0.7)
        .to(blocks, { '--f': 1, duration: 0.7, ease: 'power2.out', stagger: 0.04 }, 1.7)
        .call(function () { vis.classList.remove('is-wire'); }, null, 1.9)
        .to(grid, { opacity: 0, duration: 0.6 }, 2.2)
        .from(vis.querySelector('.vw-phone'), { x: 80, y: 30, rotate: 8, opacity: 0, duration: 1.2, ease: 'expo.out' }, 2.3)
        .from(vis.querySelectorAll('.vw-phone .vw-b'), { opacity: 0, y: 10, duration: 0.5, stagger: 0.05 }, 2.6)
        .from(vis.querySelector('.vw-badge--speed'), { y: 30, scale: 0.8, opacity: 0, duration: 0.8, ease: 'back.out(1.8)' }, 2.9)
        .from(vis.querySelector('.vw-badge--lead'), { x: 50, opacity: 0, duration: 0.9, ease: 'expo.out' }, 3.5);
      if (speed) {
        var o = { s: 4.8 };
        v.to(o, { s: 1.2, duration: 1.4, ease: 'power3.out', onUpdate: function () { speed.textContent = o.s.toFixed(1); } }, 3);
      }
      tl.add(v, 0.3);

      // The cards float a little, and the browser leans towards the cursor.
      if (!B.lite) {
        [vis.querySelector('.vw-phone'), vis.querySelector('.vw-badge--speed'), vis.querySelector('.vw-badge--lead')].forEach(function (el, i) {
          if (el) gsap.to(el, { yPercent: i % 2 ? -5 : 5, duration: 3 + i * 0.6, ease: 'sine.inOut', yoyo: true, repeat: -1, delay: 4.5 });
        });
        if (fine) {
          var br = vis.querySelector('.vw-browser');
          var rx = gsap.quickTo(br, 'rotationX', { duration: 1.2, ease: 'power3.out' });
          var ry = gsap.quickTo(br, 'rotationY', { duration: 1.2, ease: 'power3.out' });
          document.querySelector('.so-hero__stage').addEventListener('mousemove', function (e) {
            ry((e.clientX / window.innerWidth - 0.5) * 8);
            rx((e.clientY / window.innerHeight - 0.5) * -6);
          });
        }
      }
      // On scroll, the page inside the browser scrolls too.
      if (ST) gsap.to(vis.querySelector('.vw-page'), { yPercent: -28, ease: 'none', scrollTrigger: { trigger: '.so-hero', start: 'top top', end: 'bottom top', scrub: true } });
    },

    /* Web apps: a booking board that runs itself. A cursor drags each new booking to Confirmed,
       the numbers tick up, a deposit lands, and confirmed bookings move on to Done. */
    'web-apps': function (vis) {
      var app = vis.querySelector('.va-app');
      var cursor = vis.querySelector('.va-cursor');
      var toast = vis.querySelector('.va-toast');
      var toastText = vis.querySelector('[data-va-toast]');
      var kBook = vis.querySelector('[data-va-kpi="bookings"]');
      var kPaid = vis.querySelector('[data-va-kpi="paid"]');
      var lists = {};
      vis.querySelectorAll('.va-col').forEach(function (c) { lists[c.getAttribute('data-col')] = c.querySelector('.va-col__list'); });
      var heads = function () {
        vis.querySelectorAll('.va-col').forEach(function (c) { c.querySelector('.va-col__head span').textContent = c.querySelectorAll('.va-card').length; });
      };
      heads();
      var cards = function () { return Array.prototype.slice.call(vis.querySelectorAll('.va-card')); };
      // Move cards between columns and let every card glide from where it was to where it lands.
      var flip = function (mutate, dur) {
        var all = cards();
        var before = all.map(function (c) { return c.getBoundingClientRect(); });
        mutate();
        all.forEach(function (c, i) {
          var a = before[i];
          var b = c.getBoundingClientRect();
          if (Math.abs(a.left - b.left) > 0.5 || Math.abs(a.top - b.top) > 0.5) gsap.fromTo(c, { x: a.left - b.left, y: a.top - b.top }, { x: 0, y: 0, duration: dur, ease: 'power3.inOut' });
        });
        heads();
      };
      var at = function (el) {
        var r = el.getBoundingClientRect();
        var v = vis.getBoundingClientRect();
        return { x: r.left - v.left + r.width * 0.62, y: r.top - v.top + r.height * 0.55 };
      };
      var bump = function (el, to, fmt) {
        var o = { v: parseInt(el.textContent, 10) || 0 };
        gsap.to(o, { v: to, duration: 0.8, ease: 'power2.out', onUpdate: function () { el.textContent = fmt ? fmt(o.v) : Math.round(o.v); } });
      };
      gsap.set(toast, { autoAlpha: 0, y: 20 });

      var v = gsap.timeline();
      v.from(app, { y: 60, rotationX: -14, opacity: 0, duration: 1.3, ease: 'expo.out', transformOrigin: '50% 100%' })
        .from(vis.querySelectorAll('.va-side span'), { x: -14, opacity: 0, duration: 0.5, stagger: 0.05 }, 0.5)
        .from(vis.querySelectorAll('.va-kpi'), { y: 20, opacity: 0, duration: 0.7, ease: 'expo.out', stagger: 0.08 }, 0.6)
        .from(vis.querySelectorAll('.va-col'), { y: 30, opacity: 0, duration: 0.8, ease: 'expo.out', stagger: 0.08 }, 0.8)
        .from(cards(), { y: -16, opacity: 0, duration: 0.6, ease: 'back.out(1.6)', stagger: 0.06, clearProps: 'opacity' }, 1.1);
      tl.add(v, 0.3);

      var live = true;
      if (ST) ST.create({ trigger: vis, start: 'top bottom', end: 'bottom top', onToggle: function (self) { live = self.isActive; } });
      var step = function () {
        if (!live || document.hidden) { gsap.delayedCall(1, step); return; }
        var card = lists['new'].querySelector('.va-card');
        if (!card) {
          // Board cleared: everything done goes back to New and the week starts again.
          flip(function () { Array.prototype.slice.call(lists['done'].querySelectorAll('.va-card')).forEach(function (c) { lists['new'].appendChild(c); }); }, 0.9);
          gsap.delayedCall(1.6, step);
          return;
        }
        var from = at(card);
        var name = card.querySelector('b').textContent;
        var t = gsap.timeline({ onComplete: function () { gsap.delayedCall(2.2, step); } });
        t.set(cursor, { x: from.x + 40, y: from.y + 50 })
          .to(cursor, { opacity: 1, duration: 0.3 })
          .to(cursor, { x: from.x, y: from.y, duration: 0.8, ease: 'power3.inOut' }, '<')
          .add(function () { card.classList.add('is-held'); gsap.to(card, { scale: 1.05, rotate: -2, duration: 0.25 }); gsap.to(cursor, { scale: 0.85, duration: 0.15 }); })
          .add(function () {
            var to;
            flip(function () { lists.confirmed.appendChild(card); to = at(card); }, 0.9);
            gsap.to(cursor, { x: to.x, y: to.y, duration: 0.9, ease: 'power3.inOut' });
          }, '+=0.25')
          .add(function () {
            card.classList.remove('is-held');
            gsap.to(card, { scale: 1, rotate: 0, duration: 0.3, ease: 'back.out(2)' });
            gsap.to(cursor, { scale: 1, opacity: 0, duration: 0.4, delay: 0.2 });
            bump(kBook, (parseInt(kBook.textContent, 10) || 0) + 1);
            bump(kPaid, (parseInt(kPaid.textContent, 10) || 0) + 45);
            toastText.textContent = '₦45,000 from ' + name;
            gsap.fromTo(toast, { autoAlpha: 0, y: 20, scale: 0.94 }, { autoAlpha: 1, y: 0, scale: 1, duration: 0.6, ease: 'back.out(1.8)' });
          }, '+=0.95')
          .add(function () {
            var oldest = lists.confirmed.querySelector('.va-card');
            if (oldest && oldest !== card) flip(function () { lists.done.appendChild(oldest); }, 0.8);
          }, '+=1.2')
          .to(toast, { autoAlpha: 0, y: 12, duration: 0.4 }, '+=1.2');
      };
      gsap.delayedCall(3.4, step);

      if (fine && !B.lite) {
        var rx = gsap.quickTo(app, 'rotationX', { duration: 1.2, ease: 'power3.out' });
        var ry = gsap.quickTo(app, 'rotationY', { duration: 1.2, ease: 'power3.out' });
        document.querySelector('.so-hero__stage').addEventListener('mousemove', function (e) {
          ry((e.clientX / window.innerWidth - 0.5) * 7);
          rx((e.clientY / window.innerHeight - 0.5) * -5);
        });
      }
    },

    /* Automation: enquiries flow along the river. Every one is replied to; some are quoted;
       some of those pay. Each stage pulses and counts as a dot passes it. */
    'automation-crm': function (vis) {
      var panel = vis.querySelector('.vf-panel');
      var river = vis.querySelector('.vf-river');
      var path = vis.querySelector('.vf-line');
      var dots = vis.querySelector('.vf-dots');
      var stages = Array.prototype.slice.call(vis.querySelectorAll('.vf-stage'));
      var counts = stages.map(function (st) { return st.querySelector('[data-vf-count]'); });
      var msg = vis.querySelector('.vf-msg');
      var msgText = vis.querySelector('[data-vf-msg]');
      var paid = vis.querySelector('.vf-paid');
      var paidText = vis.querySelector('[data-vf-paid]');
      var follow = vis.querySelector('[data-vf-follow]');
      var L = path.getTotalLength ? path.getTotalLength() : 0;
      var asks = ['Hi, can I get a quote for 200 units?', 'Do you deliver to Port Harcourt?', 'Is the 3 pm slot still free on Friday?', 'How much for the full package?', 'Can I pay half now and half later?'];
      var bills = ['₦320,000', '₦85,000', '₦1,150,000', '₦240,000', '₦560,000'];
      var ai = 0;
      var inv = 187;
      gsap.set([msg, paid], { autoAlpha: 0 });

      var v = gsap.timeline();
      v.from(panel, { y: 60, rotationX: -14, opacity: 0, duration: 1.3, ease: 'expo.out', transformOrigin: '50% 100%' })
        .from(vis.querySelector('.vf-bank'), { opacity: 0, duration: 1.2 }, 0.5)
        .from(vis.querySelectorAll('.vf-stage__node'), { scale: 0, duration: 0.7, ease: 'back.out(2.4)', stagger: 0.12 }, 0.8)
        .from(vis.querySelectorAll('.vf-stage__label'), { y: 10, opacity: 0, duration: 0.6, ease: 'expo.out', stagger: 0.12 }, 1)
        .from(vis.querySelectorAll('.vf-foot span'), { y: 10, opacity: 0, duration: 0.6, stagger: 0.1 }, 1.3)
        .fromTo(msg, { autoAlpha: 0, x: -30 }, { autoAlpha: 1, x: 0, duration: 0.8, ease: 'expo.out' }, 1.6);
      if (L) {
        gsap.set(path, { strokeDashoffset: 0 });
        v.from(path, { opacity: 0, duration: 0.8 }, 0.7);
        gsap.to(path, { strokeDashoffset: -40, duration: 2, ease: 'none', repeat: -1 });
      }
      tl.add(v, 0.3);
      if (!L) return;

      var bump = function (i) {
        var n = counts[i];
        n.textContent = (parseInt(n.textContent, 10) || 0) + 1;
        gsap.fromTo(stages[i].querySelector('.vf-stage__node'), { scale: 1.5 }, { scale: 1, duration: 0.6, ease: 'expo.out' });
        gsap.fromTo(n, { y: -4 }, { y: 0, duration: 0.6, clearProps: 'transform' });
        n.classList.add('is-hot');
        gsap.delayedCall(0.3, function () { n.classList.remove('is-hot'); });
      };
      var spawn = function () {
        var dot = document.createElement('span');
        dot.className = 'vf-dot';
        dots.appendChild(dot);
        var w = river.clientWidth / 520;
        var h = river.clientHeight / 300;
        var fate = Math.random();
        var end = fate < 0.45 ? 1 : (fate < 0.85 ? 0.82 : 0.5);
        var hit = 0;
        var o = { p: 0 };
        bump(0);
        hit = 1;
        if (follow) follow.textContent = (parseInt(follow.textContent, 10) || 0) + 1;
        gsap.to(o, {
          p: end, duration: 5.2 * end, ease: 'none',
          onUpdate: function () {
            var pt = path.getPointAtLength(o.p * L);
            dot.style.transform = 'translate(' + pt.x * w + 'px,' + pt.y * h + 'px)';
            while (hit < 4 && o.p >= hit / 3 - 0.001) {
              bump(hit);
              if (hit === 3) {
                inv += 1;
                paidText.textContent = bills[inv % bills.length] + ' · Invoice #0' + inv;
                gsap.fromTo(paid, { autoAlpha: 0, y: 16, scale: 0.94 }, { autoAlpha: 1, y: 0, scale: 1, duration: 0.6, ease: 'back.out(1.8)', overwrite: true });
                gsap.to(paid, { autoAlpha: 0, y: 10, duration: 0.4, delay: 2.4 });
              }
              hit += 1;
            }
          },
          onComplete: function () { gsap.to(dot, { scale: end === 1 ? 2.4 : 0.2, opacity: 0, duration: 0.6, onComplete: function () { dot.remove(); } }); }
        });
      };
      var live = true;
      if (ST) ST.create({ trigger: vis, start: 'top bottom', end: 'bottom top', onToggle: function (self) { live = self.isActive; } });
      var tick = function () {
        if (live && !document.hidden) {
          spawn();
          // Every few enquiries, the WhatsApp bubble shows the next one arriving.
          if (Math.random() < 0.4) {
            ai = (ai + 1) % asks.length;
            gsap.timeline().to(msg, { autoAlpha: 0, y: -8, duration: 0.3 }).add(function () { msgText.textContent = asks[ai]; }).fromTo(msg, { autoAlpha: 0, y: 12 }, { autoAlpha: 1, y: 0, duration: 0.6, ease: 'back.out(1.6)' });
          }
        }
        gsap.delayedCall(B.lite ? 2.6 : 1.5, tick);
      };
      gsap.delayedCall(2.6, tick);

      if (fine && !B.lite) {
        var rx = gsap.quickTo(panel, 'rotationX', { duration: 1.2, ease: 'power3.out' });
        var ry = gsap.quickTo(panel, 'rotationY', { duration: 1.2, ease: 'power3.out' });
        document.querySelector('.so-hero__stage').addEventListener('mousemove', function (e) {
          ry((e.clientX / window.innerWidth - 0.5) * 7);
          rx((e.clientY / window.innerHeight - 0.5) * -5);
        });
      }
    },

    /* AI: messages arrive and are read, tagged with how sure the AI is, and routine ones get a
       drafted reply that waits for a person to approve it */
    ai: function (vis) {
      var panel = vis.querySelector('.vi-panel');
      var list = vis.querySelector('.vi-list');
      var draft = vis.querySelector('.vi-draft');
      var draftText = vis.querySelector('[data-vi-draft]');
      var state = vis.querySelector('[data-vi-state]');
      var approve = vis.querySelector('[data-vi-approve]');
      var sorted = vis.querySelector('[data-vi-sorted]');
      var tags = { quote: 'Quote', booking: 'Booking', payment: 'Payment', support: 'Support' };
      var inbox = [
        ['A', 'Amaka U.', 'What would a logo and website cost together?', 'quote', 97, 'Hi Amaka, a logo and five-page website together start at ₦640,000. Want me to book a short call to scope it?'],
        ['T', 'Tunde S.', 'Can I move my fitting to Thursday?', 'booking', 95, 'Hi Tunde, Thursday at 2 pm is free. Shall I move your fitting and send a reminder the day before?'],
        ['H', 'Halima B.', 'Transfer done, please confirm', 'payment', 93, 'Hi Halima, we have received your ₦85,000 transfer. Your receipt is attached and your order is confirmed.'],
        ['E', 'Emeka J.', 'Where can I see my order status?', 'support', 98, null],
        ['R', 'Rita O.', 'Price for 300 printed flyers?', 'quote', 99, 'Hi Rita, 300 A5 flyers in full colour come to ₦48,000, ready in 3 days. Shall I send the invoice?'],
        ['S', 'Seun A.', 'Any slots this Saturday morning?', 'booking', 96, 'Hi Seun, Saturday has 9 am and 11 am open. Reply with the one you want and I will hold it for you.'],
        ['G', 'Gbemi L.', 'The app logged me out again', 'support', 91, null]
      ];
      var k = 0;
      var sentText = 'Approved by you · sent';

      var v = gsap.timeline();
      v.from(panel, { y: 60, rotationX: -14, opacity: 0, duration: 1.3, ease: 'expo.out', transformOrigin: '50% 100%' })
        .from(vis.querySelectorAll('.vi-cat'), { y: 14, opacity: 0, duration: 0.7, ease: 'expo.out', stagger: 0.07 }, 0.5)
        .from(vis.querySelectorAll('.vi-row'), { x: -24, opacity: 0, duration: 0.8, ease: 'expo.out', stagger: 0.08 }, 0.7)
        .from(vis.querySelectorAll('.vi-row .vi-tag'), { scale: 0.6, opacity: 0, duration: 0.6, ease: 'back.out(2.2)', stagger: 0.08 }, 1)
        .from(vis.querySelectorAll('.vi-foot span'), { y: 10, opacity: 0, duration: 0.6, stagger: 0.1 }, 1.3)
        .from(draft, { y: 40, scale: 0.94, opacity: 0, duration: 1, ease: 'expo.out' }, 1.5);
      tl.add(v, 0.3);

      var bump = function (el) {
        el.textContent = (parseInt(el.textContent, 10) || 0) + 1;
        gsap.fromTo(el, { y: -5 }, { y: 0, duration: 0.6, ease: 'expo.out', clearProps: 'transform' });
        el.classList.add('is-hot');
        gsap.delayedCall(0.3, function () { el.classList.remove('is-hot'); });
      };

      // The draft card writes the reply, waits, then a person approves it.
      var write = function (text) {
        draft.classList.remove('is-sent');
        approve.textContent = 'Approve & send';
        state.textContent = 'Writing a draft…';
        var t = { n: 0 };
        gsap.timeline()
          .fromTo(draft, { y: 10 }, { y: 0, duration: 0.5, ease: 'expo.out' })
          .to(t, { n: text.length, duration: Math.min(2.2, text.length * 0.022), ease: 'none', onUpdate: function () { draftText.textContent = text.slice(0, Math.round(t.n)); } }, 0)
          .add(function () { state.textContent = 'Draft ready · waiting for you'; })
          .fromTo(approve, { scale: 1 }, { scale: 1.08, duration: 0.25, yoyo: true, repeat: 3, ease: 'sine.inOut' }, '+=0.4')
          .add(function () {
            draft.classList.add('is-sent');
            approve.textContent = 'Sent ✓';
            state.textContent = sentText;
          }, '+=0.2');
      };

      var arrive = function () {
        var m = inbox[k];
        k = (k + 1) % inbox.length;
        var row = document.createElement('div');
        row.className = 'vi-row is-new';
        row.setAttribute('data-tag', m[3]);
        row.innerHTML = '<span class="vi-row__av"></span><span class="vi-row__text"><b></b><span></span></span><span class="vi-tag"></span>';
        row.querySelector('.vi-row__av').textContent = m[0];
        row.querySelector('b').textContent = m[1];
        row.querySelector('.vi-row__text span').textContent = m[2];
        var tag = row.querySelector('.vi-tag');
        tag.innerHTML = tags[m[3]] + ' <em>0%</em>';
        var conf = tag.querySelector('em');
        var scan = document.createElement('span');
        scan.className = 'vi-scan';
        row.appendChild(scan);

        // Everything below slides down to make room; the oldest message leaves the bottom.
        var olds = Array.prototype.slice.call(list.children);
        list.insertBefore(row, list.firstChild);
        var shift = row.offsetHeight + 7;
        gsap.fromTo(olds, { y: -shift }, { y: 0, duration: 0.8, ease: 'expo.out', clearProps: 'transform' });
        if (olds.length > 5) olds.slice(5).forEach(function (o) { gsap.to(o, { opacity: 0, duration: 0.4, onComplete: function () { o.remove(); } }); });
        olds.forEach(function (o) { o.classList.remove('is-new'); });

        var c = { n: 0 };
        var r = gsap.timeline();
        r.fromTo(row, { x: -30, opacity: 0 }, { x: 0, opacity: 1, duration: 0.7, ease: 'expo.out', clearProps: 'transform,opacity' })
          .set(tag, { autoAlpha: 0, scale: 0.6 }, 0)
          .fromTo(scan, { xPercent: -110 }, { xPercent: 270, duration: 1, ease: 'power2.inOut' }, 0.3)
          .add(function () { scan.remove(); })
          .to(tag, { autoAlpha: 1, scale: 1, duration: 0.6, ease: 'back.out(2.4)', clearProps: 'all' })
          .to(c, { n: m[4], duration: 0.7, ease: 'power2.out', onUpdate: function () { conf.textContent = Math.round(c.n) + '%'; } }, '<')
          .add(function () {
            var cat = vis.querySelector('[data-vi-cat="' + m[3] + '"]');
            if (cat) bump(cat);
            bump(sorted);
            if (m[5]) write(m[5]);
          });
      };

      var live = true;
      if (ST) ST.create({ trigger: vis, start: 'top bottom', end: 'bottom top', onToggle: function (self) { live = self.isActive; } });
      var tick = function () {
        if (live && !document.hidden) arrive();
        gsap.delayedCall(B.lite ? 6.5 : 4.8, tick);
      };
      gsap.delayedCall(3.4, tick);

      if (fine && !B.lite) {
        var rx = gsap.quickTo(panel, 'rotationX', { duration: 1.2, ease: 'power3.out' });
        var ry = gsap.quickTo(panel, 'rotationY', { duration: 1.2, ease: 'power3.out' });
        document.querySelector('.so-hero__stage').addEventListener('mousemove', function (e) {
          ry((e.clientX / window.innerWidth - 0.5) * 7);
          rx((e.clientY / window.innerHeight - 0.5) * -5);
        });
      }
    },

    /* Care plans: the pulse keeps beating, tonight's routine runs check by check, and a support
       request from the portal goes from received to done */
    'care-plans': function (vis) {
      var panel = vis.querySelector('.vc-panel');
      var checks = Array.prototype.slice.call(vis.querySelectorAll('.vc-check'));
      var finals = checks.map(function (c) { return c.querySelector('.vc-check__state').textContent; });
      var clock = vis.querySelector('[data-vc-time]');
      var backup = vis.querySelector('[data-vc-backup]');
      var ticket = vis.querySelector('.vc-ticket');
      var tid = vis.querySelector('[data-vc-id]');
      var ask = vis.querySelector('[data-vc-ask]');
      var status = vis.querySelector('[data-vc-status]');
      var dot = vis.querySelector('.vc-pulse__dot');
      var asks = [
        ['Please update our opening hours for the holiday', '1h 40m'],
        ['Add the new branch address to the contact page', '2h 05m'],
        ['Swap the homepage photo for the new one attached', '55m'],
        ['A customer says the form is not sending. Can you check?', '35m'],
        ['Add our new price list as a downloadable PDF', '1h 20m']
      ];
      var n = 1;
      var id = 214;

      var v = gsap.timeline();
      v.from(panel, { y: 60, rotationX: -14, opacity: 0, duration: 1.3, ease: 'expo.out', transformOrigin: '50% 100%' })
        .from(vis.querySelectorAll('.vc-kpi'), { y: 14, opacity: 0, duration: 0.7, ease: 'expo.out', stagger: 0.08 }, 0.5)
        .from(vis.querySelector('.vc-pulse'), { scaleX: 0.6, opacity: 0, duration: 1, ease: 'expo.out' }, 0.7)
        .from(checks, { x: -24, opacity: 0, duration: 0.8, ease: 'expo.out', stagger: 0.08 }, 0.9)
        .from(ticket, { y: 40, scale: 0.94, opacity: 0, duration: 1, ease: 'expo.out' }, 1.4);
      tl.add(v, 0.3);

      // The heartbeat: two drawn copies slide left forever, a dot rides the leading edge.
      gsap.to(vis.querySelector('.vc-beat'), { x: -600, duration: B.lite ? 9 : 6, ease: 'none', repeat: -1 });
      gsap.to(dot, { opacity: 1, duration: 0.6, delay: 1.6 });
      gsap.to(dot, { scale: 1.5, duration: 0.5, yoyo: true, repeat: -1, ease: 'sine.inOut' });

      var hot = function (el, text) {
        el.textContent = text;
        el.classList.add('is-hot');
        gsap.fromTo(el, { y: -5 }, { y: 0, duration: 0.6, ease: 'expo.out', clearProps: 'transform' });
        gsap.delayedCall(0.3, function () { el.classList.remove('is-hot'); });
      };

      // Tonight's routine: each check waits, spins while its bar fills, then ticks.
      var routine = function () {
        var r = gsap.timeline();
        var t = { m: 0 };
        checks.forEach(function (c) {
          c.classList.remove('is-done', 'is-busy');
          c.querySelector('.vc-check__state').textContent = 'Waiting';
        });
        r.to(t, { m: 4, duration: 5.2, ease: 'none', onUpdate: function () { clock.textContent = '02:0' + Math.floor(t.m); } }, 0);
        checks.forEach(function (c, i) {
          var icon = c.querySelector('.vc-check__icon');
          var bar = c.querySelector('.vc-check__bar');
          var state = c.querySelector('.vc-check__state');
          var at = 0.4 + i * 1.2;
          r.add(function () { c.classList.add('is-busy'); state.textContent = 'Running'; }, at)
            .fromTo(icon, { rotation: 0 }, { rotation: 360, duration: 1, ease: 'none' }, at)
            .fromTo(bar, { scaleX: 0, opacity: 1 }, { scaleX: 1, duration: 1, ease: 'power1.inOut' }, at)
            .add(function () {
              c.classList.remove('is-busy');
              c.classList.add('is-done');
              state.textContent = finals[i];
              if (i === 1) hot(backup, 'Just now');
            }, at + 1)
            .fromTo(icon, { scale: 0.6 }, { scale: 1, duration: 0.5, ease: 'back.out(2.6)', clearProps: 'transform' }, at + 1)
            .to(bar, { opacity: 0, duration: 0.4 }, at + 1.1);
        });
        return r;
      };

      // A support request arrives from the portal and is worked through to done.
      var request = function () {
        var a = asks[n];
        n = (n + 1) % asks.length;
        id += 1;
        var r = gsap.timeline();
        r.to(ticket, { y: 12, opacity: 0, duration: 0.35, ease: 'power2.in' })
          .add(function () {
            tid.textContent = '#' + id;
            ask.textContent = a[0];
            status.textContent = 'Received';
            status.setAttribute('data-state', 'busy');
          })
          .fromTo(ticket, { y: 24, opacity: 0 }, { y: 0, opacity: 1, duration: 0.7, ease: 'back.out(1.6)', clearProps: 'transform,opacity' })
          .add(function () { status.textContent = 'In progress'; }, '+=1.2')
          .fromTo(status, { scale: 0.85 }, { scale: 1, duration: 0.4, ease: 'back.out(2.4)' }, '<')
          .add(function () { status.textContent = 'Done · ' + a[1]; status.removeAttribute('data-state'); }, '+=1.6')
          .fromTo(status, { scale: 0.85 }, { scale: 1, duration: 0.5, ease: 'back.out(2.4)', clearProps: 'transform' }, '<');
        return r;
      };

      var live = true;
      if (ST) ST.create({ trigger: vis, start: 'top bottom', end: 'bottom top', onToggle: function (self) { live = self.isActive; } });
      var cycle = function () {
        if (live && !document.hidden) {
          routine();
          gsap.delayedCall(2.8, request);
        }
        gsap.delayedCall(B.lite ? 11 : 8.5, cycle);
      };
      gsap.delayedCall(3, cycle);

      if (fine && !B.lite) {
        var rx = gsap.quickTo(panel, 'rotationX', { duration: 1.2, ease: 'power3.out' });
        var ry = gsap.quickTo(panel, 'rotationY', { duration: 1.2, ease: 'power3.out' });
        document.querySelector('.so-hero__stage').addEventListener('mousemove', function (e) {
          ry((e.clientX / window.innerWidth - 0.5) * 7);
          rx((e.clientY / window.innerHeight - 0.5) * -5);
        });
      }
    },

    /* SEO & AI search: a question goes to an AI assistant, the answer cites you, and your
       Google result climbs to the top beside it */
    'seo-aeo': function (vis) {
      var chat = vis.querySelector('.vs-chat');
      var thread = vis.querySelector('.vs-thread');
      var ask = vis.querySelector('[data-vs-ask]');
      var answer = vis.querySelector('[data-vs-answer]');
      var sources = vis.querySelector('.vs-sources');
      var cited = vis.querySelector('[data-vs-cited]');
      var serp = vis.querySelector('.vs-serp');
      var query = vis.querySelector('[data-vs-q]');
      var list = vis.querySelector('.vs-serp__list');
      var fields = [
        { q: 'Which hotel in Ilorin is best for a business trip?', s: 'business hotel ilorin', pre: 'For business travel in Ilorin, ', post: ' stands out: fast Wi-Fi, a meeting room you can book online and airport pickup included.', title: 'Business hotel in Ilorin with meeting rooms',
          others: [['hotels.ng', 'Ilorin hotels: compare prices'], ['travelnaija.com', 'Where to stay in Ilorin'], ['booking.com', 'Hotels in Ilorin, Kwara']] },
        { q: 'Where can I get a custom suit made in Lagos?', s: 'custom suits lagos', pre: 'For made-to-measure suits in Lagos, ', post: ' is often recommended. Fittings are booked online, and the first fitting is about a week away.', title: 'Made-to-measure suits in Lagos',
          others: [['lagosstyle.ng', 'Best tailors in Lagos'], ['fashionnaija.com', 'Bespoke suits: what to expect'], ['jiji.ng', 'Tailors in Lagos']] },
        { q: 'Who are good corporate lawyers in Lagos?', s: 'corporate lawyers lagos', pre: 'For company and property work in Lagos, ', post: ' is a strong choice. They publish fixed fees, answer within a day and have advised over 200 Nigerian companies.', title: 'Corporate and property lawyers in Lagos',
          others: [['lagoslegalhub.com', 'Top 10 law firms in Lagos (2026)'], ['naijadirectory.ng', 'Lawyers near you: compare and contact'], ['legalnaija.com', 'How to choose a law firm in Nigeria']] }
      ];
      var k = 0;
      var score = 7;

      var v = gsap.timeline();
      v.from(chat, { y: 60, rotationX: -14, opacity: 0, duration: 1.3, ease: 'expo.out', transformOrigin: '50% 100%' })
        .from(ask, { y: 16, opacity: 0, duration: 0.7, ease: 'expo.out' }, 0.6)
        .from(vis.querySelector('.vs-answer'), { y: 16, opacity: 0, duration: 0.8, ease: 'expo.out' }, 0.8)
        .from(sources.children, { scale: 0.7, opacity: 0, duration: 0.5, ease: 'back.out(2.2)', stagger: 0.08 }, 1.1)
        .from(serp, { y: 40, scale: 0.94, opacity: 0, duration: 1, ease: 'expo.out' }, 1.3);
      tl.add(v, 0.3);

      var el = function (tag, cls, text) {
        var e = document.createElement(tag);
        if (cls) e.className = cls;
        if (text) e.textContent = text;
        return e;
      };
      var words = function (text, into) {
        text.split(/(\s+)/).forEach(function (w) { if (w) into.appendChild(el('span', 'vs-w', w)); });
      };

      // Swap a result with the one above it, sliding both into their new places.
      var climb = function (li) {
        var prev = li.previousElementSibling;
        if (!prev) return;
        var a = li.offsetTop;
        var b = prev.offsetTop;
        list.insertBefore(li, prev);
        gsap.fromTo(li, { y: a - li.offsetTop }, { y: 0, duration: 0.7, ease: 'expo.out', clearProps: 'transform' });
        gsap.fromTo(prev, { y: b - prev.offsetTop }, { y: 0, duration: 0.7, ease: 'expo.out', clearProps: 'transform' });
      };

      var round = function () {
        var f = fields[k];
        k = (k + 1) % fields.length;
        var r = gsap.timeline();
        r.to(thread.children, { opacity: 0, y: -10, duration: 0.35, ease: 'power2.in', stagger: 0.04 })
          .to(list, { opacity: 0, duration: 0.3 }, 0)
          .add(function () {
            ask.textContent = f.q;
            query.textContent = f.s;
            answer.textContent = '';
            var dots = el('span', 'vs-dots');
            dots.innerHTML = '<i></i><i></i><i></i>';
            answer.appendChild(dots);
            gsap.fromTo(dots.children, { y: 0 }, { y: -5, duration: 0.3, yoyo: true, repeat: 3, ease: 'sine.inOut', stagger: 0.1 });
            sources.innerHTML = '';
            [['1 · yourbusiness.ng', 'vs-src is-you'], ['2 · ' + f.others[0][0], 'vs-src'], ['3 · ' + f.others[1][0], 'vs-src']].forEach(function (s) { sources.appendChild(el('span', s[1], s[0])); });
            gsap.set(sources, { opacity: 0 });
            // Your result starts fourth on Google and works its way up.
            list.innerHTML = '';
            f.others.concat([['yourbusiness.ng', f.title, true]]).forEach(function (o) {
              var li = el('li', 'vs-res' + (o[2] ? ' is-you' : ''));
              li.appendChild(el('em', '', o[0]));
              li.appendChild(el('b', '', o[1]));
              list.appendChild(li);
            });
          })
          .set(vis.querySelectorAll('.vs-ask, .vs-answer'), { opacity: 1, y: 0 })
          .fromTo(ask, { y: 16, opacity: 0 }, { y: 0, opacity: 1, duration: 0.6, ease: 'expo.out', clearProps: 'transform,opacity' }, '<')
          .to(list, { opacity: 1, duration: 0.4 }, '<')
          .add(function () {
            answer.textContent = '';
            words(f.pre, answer);
            answer.appendChild(el('mark', '', 'Your Business'));
            words(f.post, answer);
            var parts = answer.children;
            gsap.fromTo(parts, { opacity: 0, y: 6 }, { opacity: 1, y: 0, duration: 0.3, ease: 'power2.out', stagger: B.lite ? 0.02 : 0.035, clearProps: 'transform,opacity' });
            var mark = answer.querySelector('mark');
            gsap.fromTo(mark, { scale: 0.8 }, { scale: 1, duration: 0.6, ease: 'back.out(3)', delay: f.pre.split(/\s+/).length * 0.07 });
          }, '+=1.1')
          .add(function () {
            gsap.set(sources, { opacity: 1, y: 0 });
            gsap.fromTo(sources.children, { scale: 0.7, opacity: 0 }, { scale: 1, opacity: 1, duration: 0.5, ease: 'back.out(2.2)', stagger: 0.08, clearProps: 'transform,opacity' });
          }, '+=1.8')
          .add(function () {
            score = score >= 9 ? 7 : score + 1;
            cited.textContent = 'Cited ' + score + ' of 10';
          }, '<')
          .add(function () { climb(list.querySelector('.is-you')); }, '-=1.6')
          .add(function () { climb(list.querySelector('.is-you')); }, '+=0.7')
          .add(function () { climb(list.querySelector('.is-you')); }, '+=0.7');
        return r;
      };

      var live = true;
      if (ST) ST.create({ trigger: vis, start: 'top bottom', end: 'bottom top', onToggle: function (self) { live = self.isActive; } });
      var cycle = function () {
        if (live && !document.hidden) round();
        gsap.delayedCall(B.lite ? 11 : 8.5, cycle);
      };
      gsap.delayedCall(4, cycle);

      if (fine && !B.lite) {
        var rx = gsap.quickTo(chat, 'rotationX', { duration: 1.2, ease: 'power3.out' });
        var ry = gsap.quickTo(chat, 'rotationY', { duration: 1.2, ease: 'power3.out' });
        document.querySelector('.so-hero__stage').addEventListener('mousemove', function (e) {
          ry((e.clientX / window.innerWidth - 0.5) * 7);
          rx((e.clientY / window.innerHeight - 0.5) * -5);
        });
      }
    }
  };
  var vis = document.querySelector('.so-vis[data-visual]');
  if (vis && visuals[vis.getAttribute('data-visual')]) visuals[vis.getAttribute('data-visual')](vis);

  if (!ST) return;
  var once = function (trigger, start) { return { trigger: trigger, start: start || 'top 82%', once: true }; };

  /* Hero exit: the frame pulls in and rounds off, the copy drifts up */
  if (!B.lite) {
    var scrub = { trigger: '.so-hero', start: 'top top', end: 'bottom top', scrub: true };
    gsap.fromTo('.so-hero__stage', { clipPath: 'inset(0% 0% 0% 0% round 0px)' }, { clipPath: 'inset(0% 2.5% 6% 2.5% round 32px)', ease: 'none', scrollTrigger: scrub });
    gsap.to('.so-hero__copy', { yPercent: -18, opacity: 0.15, ease: 'none', scrollTrigger: scrub });
  }

  /* 2. Sound familiar: each box ticks as its row reaches the middle of the screen; the score keeps count */
  var score = document.querySelector('[data-so-score]');
  var syms = Array.prototype.slice.call(document.querySelectorAll('.so-sym'));
  var tally = function () { if (score) score.textContent = syms.filter(function (s) { return s.classList.contains('is-on'); }).length; };
  syms.forEach(function (row) {
    var tick = row.querySelector('.so-sym__box path');
    var len = tick && tick.getTotalLength ? tick.getTotalLength() : 0;
    if (len) gsap.set(tick, { strokeDasharray: len, strokeDashoffset: len });
    gsap.from(row.children, { y: 30, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.08, scrollTrigger: once(row, 'top 90%') });
    ST.create({
      trigger: row, start: 'top 58%', end: 'max',
      onToggle: function (self) {
        var on = self.isActive;
        row.classList.toggle('is-on', on);
        if (len) gsap.to(tick, { strokeDashoffset: on ? 0 : len, duration: on ? 0.5 : 0.25, ease: 'power2.out', delay: on ? 0.15 : 0 });
        if (on) gsap.fromTo(row.querySelector('.so-sym__box'), { scale: 0.7 }, { scale: 1, duration: 0.6, ease: 'back.out(2.4)' });
        tally();
      }
    });
  });
  if (score) gsap.from('.so-check__score', { y: 20, opacity: 0, duration: 0.8, scrollTrigger: once('.so-check__score', 'top 95%') });

  /* 3. The statement: the supporting paragraphs rise after it (the words light up in scenes.js) */
  gsap.from('.so-say__text p', { y: 40, opacity: 0, duration: 1, ease: 'expo.out', stagger: 0.12, scrollTrigger: once('.so-say__text', 'top 85%') });

  /* 4. What's included: each group's rule draws, then its cards tip up in turn */
  document.querySelectorAll('.so-group').forEach(function (g, i) {
    gsap.timeline({ scrollTrigger: once(g, 'top 85%') })
      .from(g.querySelector('.so-group__head'), { y: 20, opacity: 0, duration: 0.7, ease: 'expo.out' }, i * 0.1)
      .from(g.querySelectorAll('.so-item'), { y: 70, rotationX: -18, opacity: 0, duration: 1.1, ease: 'expo.out', stagger: 0.1, transformPerspective: 1000, transformOrigin: '50% 100%' }, i * 0.1 + 0.15);
  });

  /* 5. How it runs: the line draws with the scroll, each stage lights when the line reaches it */
  var line = document.querySelector('.so-run__line span');
  var stages = document.querySelectorAll('.so-stage');
  var mm = gsap.matchMedia();
  if (line) {
    mm.add('(min-width: 901px)', function () {
      gsap.fromTo(line, { scaleX: 0, scaleY: 1 }, { scaleX: 1, ease: 'none', scrollTrigger: { trigger: '.so-run__track', start: 'top 75%', end: 'bottom 45%', scrub: true,
        onUpdate: function (self) { stages.forEach(function (s, i) { s.classList.toggle('is-on', self.progress >= i / Math.max(1, stages.length - 1) - 0.02); }); } } });
    });
    mm.add('(max-width: 900px)', function () {
      gsap.fromTo(line, { scaleY: 0, scaleX: 1 }, { scaleY: 1, ease: 'none', scrollTrigger: { trigger: '.so-run__track', start: 'top 60%', end: 'bottom 60%', scrub: true } });
      stages.forEach(function (s) { ST.create({ trigger: s, start: 'top 60%', end: 'max', onToggle: function (self) { s.classList.toggle('is-on', self.isActive); } }); });
    });
  }
  stages.forEach(function (s, i) {
    gsap.timeline({ scrollTrigger: once('.so-run__track', 'top 80%') })
      .from(s.querySelector('.so-stage__dot'), { scale: 0, rotate: -90, duration: 0.7, ease: 'back.out(2.2)' }, i * 0.1)
      .from(s.querySelectorAll('.so-stage__when, h3, p:last-child'), { y: 24, opacity: 0, duration: 0.9, ease: 'expo.out', stagger: 0.06 }, i * 0.1 + 0.2);
  });

  /* 6. Fit: the two columns slide in from either side, the ticks and crosses pop in */
  gsap.from('.so-fit__col--yes', { x: -60, opacity: 0, duration: 1.1, ease: 'expo.out', scrollTrigger: once('.so-fit__grid') });
  gsap.from('.so-fit__col--no', { x: 60, opacity: 0, duration: 1.1, ease: 'expo.out', scrollTrigger: once('.so-fit__grid') });
  gsap.from('.so-fit__col li', { y: 16, opacity: 0, duration: 0.7, ease: 'expo.out', stagger: 0.05, scrollTrigger: once('.so-fit__grid', 'top 75%') });

  /* 7. Prices: the cards are dealt in, the featured one last and highest */
  gsap.from('.so-plan', { y: 90, rotationX: -20, scale: 0.94, opacity: 0, duration: 1.3, ease: 'expo.out', stagger: 0.12, transformPerspective: 1000, transformOrigin: '50% 100%', scrollTrigger: once('.so-plans__grid', 'top 85%') });
  gsap.from('.so-plans__note', { y: 20, opacity: 0, duration: 0.8, scrollTrigger: once('.so-plans__note', 'top 95%') });
})();
