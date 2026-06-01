(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var el = document.querySelector('.js-header-datetime');
        if (!el) {
            return;
        }

        var dateEl = el.querySelector('.js-header-datetime-date');
        var timeEl = el.querySelector('.js-header-datetime-time');
        if (!dateEl || !timeEl) {
            return;
        }

        var locale = el.getAttribute('data-locale') || document.documentElement.lang || 'en';
        var tz = el.getAttribute('data-timezone');
        var optsBase = {};
        if (tz) {
            optsBase.timeZone = tz;
        }

        function tick() {
            var now = new Date();
            var dateOpts = Object.assign({}, optsBase, {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric',
            });
            var timeOpts = Object.assign({}, optsBase, {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            });

            try {
                dateEl.textContent = new Intl.DateTimeFormat(locale, dateOpts).format(now);
                timeEl.textContent = new Intl.DateTimeFormat(locale, timeOpts).format(now);
            } catch (e) {
                dateEl.textContent = now.toLocaleDateString();
                timeEl.textContent = now.toLocaleTimeString();
            }
        }

        tick();
        setInterval(tick, 1000);
    });
})();
