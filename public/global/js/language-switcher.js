function closeAllHeaderDropdowns() {
    document.querySelectorAll('.language-dropdown-menu').forEach(function (dd) {
        dd.style.display = 'none';
    });
    document
        .querySelectorAll(
            '.admin-lang-toggle[aria-expanded], .tg-header-lang-toggle[aria-expanded], .offCanvas__lang-toggle[aria-expanded], .language-btn-icon[aria-expanded], .admin-language-btn-icon[aria-expanded]',
        )
        .forEach(function (btn) {
            btn.setAttribute('aria-expanded', 'false');
        });
    document
        .querySelectorAll(
            '.admin-currency-toggle[aria-expanded], .offCanvas__currency-toggle[aria-expanded], .tg-filter-currency-toggle[aria-expanded]',
        )
        .forEach(function (btn) {
            btn.setAttribute('aria-expanded', 'false');
        });
}

// Admin header + off-canvas + services filter currency menus
function toggleCurrencyDropdown(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    const button =
        e && e.currentTarget
            ? e.currentTarget
            : e && e.closest
              ? e.closest('.admin-currency-toggle, .offCanvas__currency-toggle, .tg-filter-currency-toggle')
              : e;
    if (!button) {
        return;
    }

    const parent = button.parentElement;
    const dropdown =
        parent &&
        parent.querySelector(
            '.admin-currency-dropdown, .offCanvas__currency-dropdown, .tg-filter-currency-dropdown',
        );

    const wasOpen =
        dropdown &&
        dropdown.style.display !== 'none' &&
        dropdown.style.display !== '';

    closeAllHeaderDropdowns();

    if (!wasOpen && dropdown) {
        dropdown.style.display = 'block';
        button.setAttribute('aria-expanded', 'true');
    }

    return false;
}

function toggleLanguageDropdown(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    const button =
        e && e.currentTarget
            ? e.currentTarget
            : e && e.closest
              ? e.closest(
                    '.admin-lang-toggle, .tg-header-lang-toggle, .offCanvas__lang-toggle, .language-btn-icon, .admin-language-btn-icon',
                )
              : e;
    if (!button) {
        return;
    }

    const parent = button.parentElement;
    const dropdown = parent && parent.querySelector('.language-dropdown-menu');

    const wasOpen =
        dropdown &&
        dropdown.style.display !== 'none' &&
        dropdown.style.display !== '';

    closeAllHeaderDropdowns();

    if (!wasOpen && dropdown) {
        dropdown.style.display = 'block';
        button.setAttribute('aria-expanded', 'true');
    }

    return false;
}

document.addEventListener(
    'click',
    function (e) {
        const el = e.target && e.target.nodeType === 3 ? e.target.parentElement : e.target;
        if (
            el &&
            el.closest &&
            (el.closest('[data-lang-dropdown]') || el.closest('[data-currency-dropdown]'))
        ) {
            return;
        }
        closeAllHeaderDropdowns();
    },
    true,
);
