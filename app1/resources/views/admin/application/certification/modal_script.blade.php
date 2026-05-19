<script>
    // Employee
    function openEmployeeModal(data = null) {
        const form = $('#employeeForm');
        const methodField = $('#formMethod');
        const modalTitle = $('#employeeModalLabel');
        const submitBtn = $('#submitBtn');

        // Reset the form
        form[0].reset();
        methodField.val('POST');
        form.attr('action', '{{ route("application.store.certification") }}');
        modalTitle.text('Create Employee');
        submitBtn.text('Submit');

        if (data) {
            // Editing mode
            form.attr('action', `/application/update/certification-bodies/${data.id}`); // Your update route
            methodField.val('PUT');
            modalTitle.text('Edit Employee');
            submitBtn.text('Update');

            // Populate data
            $('#employee_name').val(data.employee_name);
            $('#designation').val(data.designation);
            $('#address').val(data.address);
            $('#telephone').val(data.telephone);
            $('#email').val(data.email);
            $('#employee_type').val(data.employee_type);
        }

        // Open modal
        $('#employeeModal').modal('show');
    }




    // document
    function openDocumentModal(data = null) {
        const form = $('#documentForm');
        const methodField = $('#docFormMethod');
        const modalTitle = $('#documentModalLabel');
        const submitBtn = $('#documentSubmitBtn');
        const fileInfo = $('#existingFileText');

        // Reset the form
        form.trigger('reset');
        methodField.val('POST');
        form.attr('action', '{{ route("application.store.certification") }}');
        modalTitle.text('Create Document');
        submitBtn.text('Submit');
        fileInfo.text('');

        if (data) {
            // Edit mode
            form.attr('action', `/application/update/certification-bodies/${data.id}`); // Your update route
            methodField.val('PUT');
            modalTitle.text('Edit Document');
            submitBtn.text('Update');

            $('#document_id').val(data.document_id);
            $('#doc_name').val(data.name);
            $('#doc_number').val(data.number);

            if (data.upload_doc) {
                fileInfo.text(`Current file: ${data.upload_doc}`);
            }
        }

        $('#documentModal').modal('show');
    }

</script>


{{-- i coded --}}

<script>
$(document).ready(function() {

    // Clear errors when modal opens
    $('#employeeModal').on('show.bs.modal', function() {
        $('#employeeForm').find('.text-danger').remove();
        $('#employeeForm')[0].reset();
    });

    // Handle form submission
    $('#employeeForm').submit(function(e) {
        e.preventDefault(); // prevent default submit

        let form = $(this);
        let valid = true;

        // Clear previous errors
        form.find('.text-danger').remove();

        // Get values
        const employee_name = $('#employee_name').val().trim();
        const designation   = $('#designation').val().trim();
        const address       = $('#address').val().trim();
        const telephone     = $('#telephone').val().trim();
        const email         = $('#email').val().trim();
        const employee_type = $('#employee_type').val();

        // Validation rules
        if(employee_name === '') {
            $('#employee_name').after('<span class="text-danger">Employee Name is required.</span>');
            valid = false;
        }

        if(designation === '') {
            $('#designation').after('<span class="text-danger">Designation is required.</span>');
            valid = false;
        }

        if(address === '') {
            $('#address').after('<span class="text-danger">Address is required.</span>');
            valid = false;
        }

        if(telephone === '') {
            $('#telephone').after('<span class="text-danger">Telephone is required.</span>');
            valid = false;
        } else if(!/^[0-9]+$/.test(telephone)) {
            $('#telephone').after('<span class="text-danger">Telephone must be numeric.</span>');
            valid = false;
        }

        if(email === '') {
            $('#email').after('<span class="text-danger">Email is required.</span>');
            valid = false;
        } else if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            $('#email').after('<span class="text-danger">Email must be valid.</span>');
            valid = false;
        }

        if(!employee_type) {
            $('#employee_type').after('<span class="text-danger">Please select Employee Type.</span>');
            valid = false;
        }

        // If everything is valid, submit the form normally
        if(valid) {
            form.unbind('submit').submit();
        }
    });
});
</script>

<script>
$(document).ready(function() {

    // Clear errors when modal opens
    $('#documentModal').on('show.bs.modal', function() {
        $('#documentForm').find('.text-danger').remove();
        $('#documentForm')[0].reset();
        $('#existingFileText').text('');
    });

    // Handle form submission
    $('#documentForm').submit(function(e) {
        e.preventDefault();

        let form = $(this);
        let valid = true;

        // Clear previous errors
        form.find('.text-danger').remove();

        // Get values
        const document_id = $('#document_id').val();
        const doc_name    = $('#doc_name').val().trim();
        const doc_number  = $('#doc_number').val().trim();
        const upload_doc  = $('#upload_doc').val();

        // Validate Document Name select
        if(!document_id) {
            $('#document_id').after('<span class="text-danger">Please select a Document Name.</span>');
            valid = false;
        }

        // Validate Name
        if(doc_name === '') {
            $('#doc_name').after('<span class="text-danger">Name is required.</span>');
            valid = false;
        }

        // Validate Number
        if(doc_number === '') {
            $('#doc_number').after('<span class="text-danger">Number is required.</span>');
            valid = false;
        }

        // Validate file upload
        if(upload_doc === '') {
            $('#upload_doc').after('<span class="text-danger">Please upload a document.</span>');
            valid = false;
        } 

        // Submit form if valid
        if(valid) {
            form.unbind('submit').submit(); // submit normally
        }
    });
});
</script>


{{-- i coded --}}