<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<form id="hcbForm" method="POST" action="{{ $stepUrl('step1') }}" class="js-card-form hcb-js-card-form">
    @csrf

    <div class="row g-3">

        {{-- HCB Information --}}
        <div class="col-12">
            <h6 class="fw-bold border-bottom pb-1">1.1 HCB Information</h6>
        </div>

        <div class="col-md-6">
            <label class="form-label">Organization Name <span class="text-danger">*</span></label>
            <input class="form-control" name="organization_name"
                value="{{ old('organization_name', $basicInfo->organization_name ?? '') }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Address <span class="text-danger">*</span></label>
            <textarea class="form-control" name="address" rows="2" required>{{ old('address', $basicInfo->address ?? '') }}</textarea>
        </div>

        <div class="col-md-4">
            <label class="form-label">Postcode <span class="text-danger">*</span></label>
            <input class="form-control" name="postcode" value="{{ old('postcode', $basicInfo->postcode ?? '') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Telephone <span class="text-danger">*</span></label>
            <input class="form-control" name="telephone" value="{{ old('telephone', $basicInfo->telephone ?? '') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Fax <span class="text-danger">*</span></label>
            <input class="form-control" name="fax" value="{{ old('fax', $basicInfo->fax ?? '') }}">
        </div>

        {{-- Contact Person --}}
        <div class="col-12 mt-2">
            <h6 class="fw-bold border-bottom pb-1">1.2 Contact Person</h6>
        </div>

        <div class="col-md-4">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input class="form-control" name="contact_name"
                value="{{ old('contact_name', $basicInfo->contact_name ?? '') }}" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Designation <span class="text-danger">*</span></label>
            <input class="form-control" name="designation"
                value="{{ old('designation', $basicInfo->designation ?? '') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="contact_email"
                value="{{ old('contact_email', $basicInfo->contact_email ?? '') }}">
        </div>

        <div class="col-md-12">
            <label class="form-label">Contact Address <span class="text-danger">*</span></label>
            <textarea class="form-control" name="contact_address" rows="2">{{ old('contact_address', $basicInfo->contact_address ?? '') }}</textarea>
        </div>

        <div class="col-md-4">
            <label class="form-label">Contact Postcode <span class="text-danger">*</span></label>
            <input class="form-control" name="contact_postcode"
                value="{{ old('contact_postcode', $basicInfo->contact_postcode ?? '') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Contact Tel <span class="text-danger">*</span></label>
            <input class="form-control" name="contact_tel"
                value="{{ old('contact_tel', $basicInfo->contact_tel ?? '') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Contact Fax <span class="text-danger">*</span></label>
            <input class="form-control" name="contact_fax"
                value="{{ old('contact_fax', $basicInfo->contact_fax ?? '') }}">
        </div>

    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>

{{-- ================= JS VALIDATION ================= --}}
<script>
    document.getElementById("hcbForm").addEventListener("submit", function(e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);

        fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(res => res.json())
            .then(data => {

                // ✅ SUCCESS
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                    });

                    return;
                }

                // ❌ VALIDATION ERROR
                if (!data.success && data.errors) {

                    let messages = [];

                    Object.keys(data.errors).forEach(key => {
                        messages.push(data.errors[key][0]);
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Required Fields',
                        html: messages.join('<br>')
                    });

                    return;
                }

                // ❌ OTHER ERROR
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Something went wrong'
                });

            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Please try again later'
                });
            });
    });
</script>
