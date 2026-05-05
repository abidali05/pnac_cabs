<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('pnacVerticalForm');
    if (!form) return;

    const storageKey = 'pnacVerticalFormStateV1';
    const messageBox = document.getElementById('stepSaveMessage');
    const repeatableIds = ['staffRows', 'calibrationRows', 'testingRows', 'equipmentRows', 'approvalRows'];
    let state = { values: {}, savedSteps: {}, rowsHtml: {} };

    function showMessage(text, isSuccess) {
        messageBox.className = 'alert mt-2 ' + (isSuccess ? 'alert-success' : 'alert-warning');
        messageBox.textContent = text;
        messageBox.classList.remove('d-none');
    }

    function updateBadge(step, saved) {
        const badge = document.getElementById('status-step-' + step);
        if (!badge) return;
        badge.textContent = saved ? 'Saved' : 'Unsaved';
        badge.classList.toggle('bg-success', saved);
        badge.classList.toggle('bg-warning', !saved);
        badge.classList.toggle('text-dark', !saved);
    }

    function updateBasicBadge(saved) {
        const badge = document.getElementById('status-basic');
        if (!badge) return;
        badge.textContent = saved ? 'Saved' : 'Unsaved';
        badge.classList.toggle('bg-success', saved);
        badge.classList.toggle('bg-warning', !saved);
        badge.classList.toggle('text-dark', !saved);
    }

    function saveLocalState() {
        localStorage.setItem(storageKey, JSON.stringify(state));
    }

    function loadLocalState() {
        const raw = localStorage.getItem(storageKey);
        if (!raw) return;
        try {
            state = JSON.parse(raw);
        } catch (error) {
            state = { values: {}, savedSteps: {}, rowsHtml: {} };
        }
    }

    function collectStepData(stepCard) {
        const values = {};
        stepCard.querySelectorAll('input, select, textarea').forEach(function (field) {
            if (!field.name) return;
            if (field.type === 'checkbox') {
                if (!values[field.name]) values[field.name] = [];
                if (field.checked) values[field.name].push(field.value || '1');
            } else if (field.type === 'radio') {
                if (field.checked) values[field.name] = field.value;
            } else {
                values[field.name] = field.value;
            }
        });
        return values;
    }

    function collectBasicData() {
        const values = {};
        form.querySelectorAll('.pnac-basic-card input, .pnac-basic-card select, .pnac-basic-card textarea').forEach(function (field) {
            if (!field.name) return;
            values[field.name] = field.value;
        });
        return values;
    }

    function validateStep(stepCard) {
        const requiredFields = stepCard.querySelectorAll('input[required], select[required], textarea[required]');
        for (const field of requiredFields) {
            if (!field.checkValidity()) {
                field.reportValidity();
                return false;
            }
        }
        return true;
    }

    function persistRepeatables() {
        repeatableIds.forEach(function (id) {
            const tbody = document.getElementById(id);
            if (tbody) state.rowsHtml[id] = tbody.innerHTML;
        });
    }

    function restoreRepeatables() {
        repeatableIds.forEach(function (id) {
            const tbody = document.getElementById(id);
            if (tbody && state.rowsHtml[id]) tbody.innerHTML = state.rowsHtml[id];
        });
    }

    function applyFieldValues() {
        Object.keys(state.values || {}).forEach(function (name) {
            const value = state.values[name];
            const fields = form.querySelectorAll('[name="' + CSS.escape(name) + '"]');
            fields.forEach(function (field) {
                if (field.type === 'checkbox') {
                    field.checked = Array.isArray(value) && value.includes(field.value || '1');
                } else if (field.type === 'radio') {
                    field.checked = field.value === value;
                } else {
                    field.value = value;
                }
            });
        });
    }

    function toggleStep1ConditionalFields() {
        const ownershipOtherWrap = document.getElementById('ownershipOtherWrap');
        const ownershipOtherDescription = document.getElementById('ownershipOtherDescription');
        const ownershipType = form.querySelector('input[name="step1[ownership][type]"]:checked');
        const showOwnershipOther = ownershipType && ownershipType.value === 'Other';
        if (ownershipOtherWrap) {
            ownershipOtherWrap.classList.toggle('d-none', !showOwnershipOther);
            ownershipOtherDescription.required = !!showOwnershipOther;
        }

        const parentActivityWrap = document.getElementById('parentActivityDescriptionWrap');
        const parentActivityDescription = document.getElementById('parentActivityDescription');
        const mainActivity = form.querySelector('input[name="step1[parent_main_activity][is_main]"]:checked');
        const showMainActivityDescription = mainActivity && mainActivity.value === 'no';
        if (parentActivityWrap) {
            parentActivityWrap.classList.toggle('d-none', !showMainActivityDescription);
            parentActivityDescription.required = !!showMainActivityDescription;
        }
    }

    function rowTemplate(type, index) {
        if (type === 'staffRows') return '<tr><td><input class="form-control" name="step2[staff][' + index + '][name]" required></td><td><input class="form-control" name="step2[staff][' + index + '][qualifications]" required></td><td><input class="form-control" name="step2[staff][' + index + '][experience]" required></td></tr>';
        if (type === 'calibrationRows') return '<tr><td><input class="form-control" name="step3[rows][' + index + '][quantity]" required></td><td><input class="form-control" name="step3[rows][' + index + '][range]" required></td><td><input class="form-control" name="step3[rows][' + index + '][uncertainty]" required></td><td><input class="form-control" name="step3[rows][' + index + '][technique]" required></td></tr>';
        if (type === 'testingRows') return '<tr><td><input class="form-control" name="step4[testing][' + index + '][materials]" required></td><td><input class="form-control" name="step4[testing][' + index + '][types]" required></td><td><input class="form-control" name="step4[testing][' + index + '][range]" required></td><td><input class="form-control" name="step4[testing][' + index + '][mdl]"></td><td><input class="form-control" name="step4[testing][' + index + '][uncertainty]"></td><td><input class="form-control" name="step4[testing][' + index + '][standard]"></td></tr>';
        if (type === 'equipmentRows') return '<tr><td><input class="form-control" name="step4[equipment][' + index + '][description]" required></td><td><input class="form-control" name="step4[equipment][' + index + '][working_range]" required></td><td><input class="form-control" name="step4[equipment][' + index + '][mdl]"></td></tr>';
        if (type === 'approvalRows') return '<tr><td><input class="form-control" name="step6[rows][' + index + '][body]" required></td><td><input class="form-control" name="step6[rows][' + index + '][scope]" required></td><td><input class="form-control" name="step6[rows][' + index + '][certificate]" required></td><td><input type="date" class="form-control" name="step6[rows][' + index + '][start_date]" required></td><td><input type="date" class="form-control" name="step6[rows][' + index + '][expiry_date]" required></td></tr>';
        return '';
    }

    function addRow(tbodyId) {
        const tbody = document.getElementById(tbodyId);
        if (!tbody) return;
        const index = tbody.querySelectorAll('tr').length;
        tbody.insertAdjacentHTML('beforeend', rowTemplate(tbodyId, index));
    }

    form.querySelectorAll('.save-step-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const step = button.getAttribute('data-step');
            const stepCard = form.querySelector('.pnac-step-card[data-step="' + step + '"]');
            if (!validateStep(stepCard)) {
                showMessage('Please complete required fields in Step ' + step + '.', false);
                return;
            }
            state.values = Object.assign(state.values || {}, collectStepData(stepCard));
            state.savedSteps[step] = true;
            persistRepeatables();
            saveLocalState();
            updateBadge(step, true);
            showMessage('Step ' + step + ' saved successfully.', true);
        });
    });

    const saveBasicButton = document.getElementById('saveBasicInfo');
    if (saveBasicButton) {
        saveBasicButton.addEventListener('click', function () {
            const basicCard = form.querySelector('.pnac-basic-card');
            if (!validateStep(basicCard)) {
                showMessage('Please complete required basic information.', false);
                return;
            }
            state.values = Object.assign(state.values || {}, collectBasicData());
            state.savedSteps.basic = true;
            saveLocalState();
            updateBasicBadge(true);
            showMessage('Basic information saved successfully.', true);
        });
    }

    form.addEventListener('input', function (event) {
        if (event.target.closest('.pnac-basic-card')) {
            state.savedSteps.basic = false;
            updateBasicBadge(false);
            return;
        }

        const stepCard = event.target.closest('.pnac-step-card');
        if (!stepCard) return;
        const step = stepCard.getAttribute('data-step');
        state.savedSteps[step] = false;
        updateBadge(step, false);

        if (
            event.target.name === 'step1[ownership][type]' ||
            event.target.name === 'step1[parent_main_activity][is_main]'
        ) {
            toggleStep1ConditionalFields();
        }
    });

    document.getElementById('addStaffRow').addEventListener('click', function () { addRow('staffRows'); });
    document.getElementById('addCalibrationRow').addEventListener('click', function () { addRow('calibrationRows'); });
    document.getElementById('addTestingRow').addEventListener('click', function () { addRow('testingRows'); });
    document.getElementById('addEquipmentRow').addEventListener('click', function () { addRow('equipmentRows'); });
    document.getElementById('addApprovalRow').addEventListener('click', function () { addRow('approvalRows'); });

    document.getElementById('submitApplicationBtn').addEventListener('click', function () {
        showMessage('Backend submission will be integrated later.', false);
    });

    loadLocalState();
    restoreRepeatables();
    applyFieldValues();
    toggleStep1ConditionalFields();
    Object.keys(state.savedSteps || {}).forEach(function (step) {
        if (step === 'basic') {
            updateBasicBadge(!!state.savedSteps[step]);
        } else {
            updateBadge(step, !!state.savedSteps[step]);
        }
    });
});
</script>
