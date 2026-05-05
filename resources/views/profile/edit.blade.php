    @extends('admin.layouts.adminlayout')
    @section('main-content')

    <!-- Start app main Content -->
    <div class="main-content">
        <section class="section">

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endsection

  @section('script')
  <script>
     document.querySelectorAll('.numericValue').forEach(input => {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
  </script>
  @endsection
