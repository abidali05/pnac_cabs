@extends('admin.layouts.adminlayout')
@section('main-content')

<!-- Start app main Content -->
<div class="main-content">
    <section class="section">

        <div class="row">

            <div class="mb-2">
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Assessmen List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped v_center" id="table-1">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th class="text-center">#</th>
                                        <th>Cycle</th>
                                        <th>Assessment Type</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>No of Days</th>
                                        {{-- <th>Scope</th> --}}
                                        <th>Team Leader</th>
                                        <th>Technical Assessor</th>
                                        <th>Technical Expert</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody class="text-nowrap">
                                    @foreach ($assessmentPlans as $key => $plan)

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $plan->cabCycle->cycle_name }}</td>
                                        <td>{{ $plan->assessmentType->assessor_type }}</td>
                                        <td>{{ $plan->start_date }}</td>
                                        <td>{{ $plan->end_date }}</td>
                                        <td>{{ $plan->no_of_days }}</td>
                                        <td>
                                            <div>
                                                @foreach ($assessorUser as $user)
                                                @if($user->status === 'TL')
                                                <span>{{ $user->assessor_name }} </span>
                                                @endif
                                                @endforeach
                                            </div>
                                            {{-- <a href="#" class="btn btn-success addBtn" data-bs-toggle="modal" data-bs-target="#modalTL" data-start="{{ $plan->start_date }}" data-end="{{ $plan->end_date }}" data-days="{{ $plan->no_of_days }}" data-id="{{ $plan->id }}">Add TL --}}
                                            </a>
                                        </td>

                                        {{-- <td><a href="#" class="btn btn-success addBtn " data-bs-toggle="modal" data-bs-target="#modalTL">Add TL</a></td> --}}
                                        <td>
                                            <div>
                                                @foreach ($assessorUser as $user)
                                                @if($user->status === 'TA')
                                                <span>{{ $user->assessor_name }}, </span>
                                                @endif
                                                @endforeach
                                            </div>
                                            {{-- <a href="#" class="btn btn-success addBtn" data-bs-toggle="modal" data-bs-target="#modalTA" data-start="{{ $plan->start_date }}" data-end="{{ $plan->end_date }}" data-days="{{ $plan->no_of_days }}" data-id="{{ $plan->id }}">Add TA --}}
                                            </a>
                                        </td>
                                        <td>
                                            <div>
                                                @foreach ($assessorUser as $user)
                                                @if($user->status === 'TE')
                                                <span>{{ $user->assessor_name }}, </span>
                                                @endif
                                                @endforeach
                                            </div>
                                            {{-- <a href="#" class="btn btn-success addBtn" data-bs-toggle="modal" data-bs-target="#modalTE" data-start="{{ $plan->start_date }}" data-end="{{ $plan->end_date }}" data-days="{{ $plan->no_of_days }}" data-id="{{ $plan->id }}">Add TE --}}
                                            </a>
                                        </td>
                                        <td>
                                            @if($plan->status == 0)
                                            <span class="bg-danger p-1 rounded small text-white">Not Approved</span>
                                            @else
                                            <span class="bg-success p-1 rounded small text-white">Approved</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            {{-- <div class="d-flex gap-1">
                                                <a href="" class="btn btn-success btn-sm">Edit</a>
                                                <form action="" method="post" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
