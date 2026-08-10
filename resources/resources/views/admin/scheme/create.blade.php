@extends('admin.layouts.adminlayout')
@section('main-content')

<div class="main-content">

    <section class="section">

        <div class="row" id="Application-Form">
            <div class="col-12 col-md-12 col-lg-12">
                <form action="{{ route('scheme.store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Scheme Form</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Scheme Name</label>
                                <input type="text" name="scheme_name" class="form-control">
                            </div>
                        </div>
                        <div class="float-right pb-2 text-right pr-4 mb-0">
                            <a href="{{ route('scheme.index') }}" class="btn btn-danger">Cancle</a>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
</div>
</div>

@endsection
