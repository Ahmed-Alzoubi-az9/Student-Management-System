/* Shared site behaviour: dark mode toggle (theme preference in localStorage). */
(function () {
    var STORAGE_KEY = 'sm-theme';

    function applyTheme(theme) {
        var dark = theme === 'dark';
        document.documentElement.setAttribute('data-bs-theme', dark ? 'dark' : 'light');
        var toggle = document.getElementById('themeToggle');
        if (toggle) {
            var icon = toggle.querySelector('[data-theme-icon]');
            if (icon) {
                icon.className = dark ? 'bi bi-sun' : 'bi bi-moon-stars';
                icon.setAttribute('data-theme-icon', dark ? 'light' : 'dark');
            }
            toggle.setAttribute('aria-pressed', dark ? 'true' : 'false');
        }
    }

    function currentTheme() {
        var saved = null;
        try { saved = localStorage.getItem(STORAGE_KEY); } catch (e) {}
        if (saved !== 'dark' && saved !== 'light') {
            saved = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        return saved;
    }

    // Boot immediately to avoid a flash of the wrong theme.
    document.addEventListener('DOMContentLoaded', function () {
        applyTheme(currentTheme());
        var toggle = document.getElementById('themeToggle');
        if (toggle) {
            toggle.addEventListener('click', function () {
                var next = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                try { localStorage.setItem(STORAGE_KEY, next); } catch (e) {}
                applyTheme(next);
            });
        }
    });
})();
