// Shared helpers for the admin dashboard: a small fetch wrapper that
// authenticates via Sanctum's stateful (session cookie) mode by sending
// the XSRF-TOKEN cookie Laravel already set on page load, plus the
// confirm-before-save price diff UI and the Admins/Account form handlers.

function getCookie(name) {
    const match = document.cookie.match(new RegExp('(?:^|; )' + name + '=([^;]*)'));
    return match ? decodeURIComponent(match[1]) : null;
}

async function apiFetch(url, body) {
    const response = await fetch(url, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-XSRF-TOKEN': getCookie('XSRF-TOKEN'),
        },
        body: JSON.stringify(body),
    });

    const data = await response.json().catch(() => ({}));

    if (!response.ok) {
        const error = new Error(data.message || 'Request failed');
        error.data = data;
        throw error;
    }

    return data;
}

function formatError(error) {
    if (error.data && error.data.errors) {
        return Object.values(error.data.errors).flat().join('\n');
    }
    return error.message;
}

function notify(title, text, icon) {
    if (typeof Sweetalert2 !== 'undefined') {
        return Sweetalert2.fire({ title, text, icon, confirmButtonText: 'OK' });
    }
    alert(`${title}: ${text}`);
    return Promise.resolve();
}

function confirmDialog(title, html, confirmButtonText, confirmButtonColor) {
    if (typeof Sweetalert2 !== 'undefined') {
        return Sweetalert2.fire({
            title,
            html,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText,
            cancelButtonText: 'Cancel',
            confirmButtonColor,
        }).then((result) => result.isConfirmed);
    }
    return Promise.resolve(confirm(title));
}

// --- Prices tab: diff-confirm before saving ---

const savePricesBtn = document.getElementById('save-prices-btn');
const resetPricesBtn = document.getElementById('reset-prices-btn');

if (savePricesBtn) {
    savePricesBtn.addEventListener('click', async () => {
        const priceInputs = document.querySelectorAll('.price-input');
        const extraDayRateInput = document.getElementById('extra-day-rate');

        const prices = {};
        const diffLines = [];

        priceInputs.forEach((input) => {
            const days = input.dataset.days;
            const original = Number(input.dataset.original);
            const current = Number(input.value);
            prices[days] = current;

            if (current !== original) {
                diffLines.push(`Day ${days}: ${original} &rarr; ${current} RSD`);
            }
        });

        const extraOriginal = Number(extraDayRateInput.dataset.original);
        const extraCurrent = Number(extraDayRateInput.value);

        if (extraCurrent !== extraOriginal) {
            diffLines.push(`Extra day rate (41+ days): ${extraOriginal} &rarr; ${extraCurrent} RSD/day`);
        }

        if (diffLines.length === 0) {
            await notify('No changes', 'Nothing was changed.', 'info');
            return;
        }

        const listHtml = '<ul class="text-start">' + diffLines.map((line) => `<li>${line}</li>`).join('') + '</ul>';
        const confirmed = await confirmDialog('Confirm price changes', listHtml, 'Save changes', '#0d6efd');

        if (!confirmed) return;

        try {
            await apiFetch('/api/admin/prices', { prices, extra_day_rate: extraCurrent });
            await notify('Saved', 'Prices updated successfully.', 'success');
            window.location.reload();
        } catch (error) {
            await notify('Error', formatError(error), 'error');
        }
    });
}

if (resetPricesBtn) {
    resetPricesBtn.addEventListener('click', async () => {
        const confirmed = await confirmDialog(
            'Reset all prices to default?',
            'This overwrites every price and the extra-day rate with the built-in defaults. This cannot be undone.',
            'Reset to default',
            '#dc3545',
        );

        if (!confirmed) return;

        try {
            await apiFetch('/api/admin/prices/reset', {});
            await notify('Reset', 'Prices reset to default values.', 'success');
            window.location.reload();
        } catch (error) {
            await notify('Error', formatError(error), 'error');
        }
    });
}

// --- Admins tab: register a new admin ---

const newAdminForm = document.getElementById('new-admin-form');

if (newAdminForm) {
    newAdminForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const name = document.getElementById('new-admin-name').value.trim();
        const email = document.getElementById('new-admin-email').value.trim();
        const password = document.getElementById('new-admin-password').value;
        const passwordConfirmation = document.getElementById('new-admin-password-confirmation').value;

        try {
            await apiFetch('/api/admin/admins', {
                name,
                email,
                password,
                password_confirmation: passwordConfirmation,
            });
            await notify('Admin registered', `${name} can now log in.`, 'success');
            window.location.reload();
        } catch (error) {
            await notify('Error', formatError(error), 'error');
        }
    });
}

// --- Account tab: change own password ---

const changePasswordForm = document.getElementById('change-password-form');

if (changePasswordForm) {
    changePasswordForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const currentPassword = document.getElementById('current-password').value;
        const password = document.getElementById('new-password').value;
        const passwordConfirmation = document.getElementById('new-password-confirmation').value;

        try {
            await apiFetch('/api/admin/password', {
                current_password: currentPassword,
                password,
                password_confirmation: passwordConfirmation,
            });
            await notify('Password changed', 'Your password was updated.', 'success');
            changePasswordForm.reset();
        } catch (error) {
            await notify('Error', formatError(error), 'error');
        }
    });
}
