document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cb-application-form .js-add-row').forEach(function (button) {
        button.addEventListener('click', function () {
            const tbody = document.getElementById(button.dataset.target);
            if (!tbody) return;
            const row = tbody.querySelector('tr');
            if (!row) return;

            const clone = row.cloneNode(true);
            const index = tbody.querySelectorAll('tr').length;
            clone.querySelectorAll('input, textarea, select').forEach(function (field) {
                field.value = '';
                field.name = field.name.replace(/\[\d+\]/, '[' + index + ']');
            });
            tbody.appendChild(clone);
        });
    });

    document.addEventListener('click', function (event) {
        if (!event.target.classList.contains('js-remove-row')) return;
        const tbody = event.target.closest('tbody');
        if (tbody && tbody.querySelectorAll('tr').length > 1) {
            event.target.closest('tr').remove();
        }
    });

    function toggleOther() {
        const checked = document.querySelector('.cb-other-toggle[value="Other"]')?.checked;
        document.querySelectorAll('.cb-other-wrap').forEach(el => el.classList.toggle('d-none', !checked));
    }

    function toggleOwnership() {
        const show = document.querySelector('.cb-ownership-select')?.value === 'Other';
        document.querySelectorAll('.cb-ownership-other').forEach(el => el.classList.toggle('d-none', !show));
    }

    function toggleActivity() {
        const show = document.querySelector('.cb-main-activity-select')?.value === 'no';
        document.querySelectorAll('.cb-main-activity-description').forEach(el => el.classList.toggle('d-none', !show));
    }

    function toggleQuality() {
        const value = document.querySelector('.cb-quality-toggle:checked')?.value;
        document.querySelectorAll('.cb-non-compliance-wrap').forEach(el => el.classList.toggle('d-none', value !== 'no'));
    }

    document.addEventListener('change', function (event) {
        if (event.target.classList.contains('cb-other-toggle')) toggleOther();
        if (event.target.classList.contains('cb-ownership-select')) toggleOwnership();
        if (event.target.classList.contains('cb-main-activity-select')) toggleActivity();
        if (event.target.classList.contains('cb-quality-toggle')) toggleQuality();
    });

    document.querySelectorAll('.cb-js-card-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const submitter = event.submitter;
            const formData = new FormData(form);
            if (submitter && submitter.name) {
                formData.set(submitter.name, submitter.value || '1');
            }

            fetch(form.action, {
                method: form.method || 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            }).then(async function (response) {
                const data = await response.json().catch(function () {
                    return {};
                });
                if (!response.ok) {
                    const errors = data.errors || {};
                    const firstKey = Object.keys(errors)[0];
                    alert(firstKey ? errors[firstKey][0] : (data.message || 'Unable to save this section.'));
                    return;
                }
                const url = new URL(window.location.href);
                url.searchParams.delete('edit_section');
                url.searchParams.set('open_section', data.open_section || form.closest('[data-section]')?.dataset.section || 'basic_info');
                window.location.href = url.toString();
            }).catch(function () {
                alert('Unable to save this section. Please try again.');
            });
        });
    });

    toggleOther();
    toggleOwnership();
    toggleActivity();
    toggleQuality();
});
