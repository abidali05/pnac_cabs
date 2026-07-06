@extends('admin.layouts.adminlayout')
@section('main-content')

<div class="main-content">



    <section class="section">


        <div class="search mb-2">
            <div class="row">
                <div class="col-4">
                    <label for="">Scheme</label>
                    <select name="scheme" class="form-control" id="">
                        <option value="">--Please Select--</option>
                    </select>
                </div>
                <div class="col-4">
                    <label for="">Category</label>
                    <select name="category" class="form-control" id="">
                        <option value="">--Please Select--</option>
                    </select>
                </div>
                <div class="col-4">
                    <label for="">File Program</label>
                    <select name="file_program" class="form-control" id="">
                        <option value="">--Please Select--</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

                @if(session('success'))
                <div class="alert alert-success w-100">
                    {{ session('success') }}
                </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Index</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped v_center" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>Scheme</th>
                                        <th>File Number</th>
                                        <th>Accreditation No</th>
                                        <th>Category/Programme Date</th>
                                        <th>Field</th>
                                        <th>Branch</th>
                                        <th>Site</th>
                                        <th>Accreditated Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            1
                                        </td>
                                        <td>Create a mobile app</td>
                                        <td class="align-middle">
                                            <div class="progress" data-height="4" data-toggle="tooltip" title="100%">
                                                <div class="progress-bar bg-success" data-width="100%"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <img alt="image" src="{{ asset('admin/assets/img/avatar/avatar-5.png') }}" class="rounded-circle" width="35" data-toggle="tooltip" title="Wildan Ahdian">
                                        </td>
                                        <td>Efg</td>
                                        <td>EOC</td>
                                        <td>EOB Pnac</td>
                                        <td>Abc</td>
                                        <td>
                                            <div>2018-01-20</div>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-success">Sigil</a>
                                            <a href="#" class="btn btn-danger">Skop</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Start app Footer part -->
<footer class="main-footer">
    <div class="footer-left">
        <div class="bullet"></div> <a href="templateshub.net">Templates Hub</a>
    </div>
    <div class="footer-right">

    </div>
</footer>



</div>
</div>

@endsection
