@extends('admin.layouts.adminlayout')
@section('main-content')
@section('style')
<style>
    .card h6{
        font-size: 14px !important;
    }
    .card p{
        font-size: 14px;
    }
    .badge-success{
        background-color: #187a4c;
    }
    /* .card input{
        font-size: 12px !important;
    } */
</style>
@endsection

<div class="main-content">

    <section class="section">

        <div class="row">
            <div>
                <h5>Client Satisfication</h5>
            </div>
            <div class="col-12 col-md-12 col-lg-12">
                <form action="{{ route('client-satisfication.store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <strong>Client Satisfaction Monitoring Questionnaire</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2 form-group mt-1">
                                    <label>1) Name & Designation</label>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" value="{{ $user->name }}" readonly class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 form-group mt-1">
                                    <label>2) Organization</label>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="organization" value="{{ $user->userDetail->designation }}" readonly class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h6>3) Please try to answer the questions correctly in order to help us in planning our future activities related to accreditation and meet your expectations:</h6>
                                </div>
                                <div class="col-12">
                                    <p>You may tick more than one option (Where necessary).</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h6>Are you Accredited?</h6>
                                </div>
                                <div class="col-12">
                                    <select name="accredited" id="accredited" class="form-control" required>
                                        <option selected disabled>Select Accredited</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    {{-- <input type="radio" name="accredited" value="Yes" id="accreditedYes">
                                    <label for="">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="accredited" value="No" id="accreditedNo">
                                    <label for="">No</label> --}}
                                </div>
                            </div>


                            <div class="card border-success mt-3 rounded" id="accreditedCard" style="display: none;">
                                <div class="p-2 badge-success border rounded">
                                    <h6>For Accredited CABs</h6>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <label for="">a) When did you get Accreditation from PNAC?</label>
                                        <input type="date" name="date" class="form-control">
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label>b) Have you extended your scope of accreditation since then?</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" name="extended_scope" value="Yes">
                                            <label for="">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="extended_scope" value="No">
                                            <label for="">No</label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label>
                                                c) Aproximately how to many time did you do your scope extention?
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="aproximately" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label>
                                                d) if you have not extended your scope what is the reason for it?
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="checkbox" name="scope_reason[]" value="financial_problems">
                                            <label for="">Financial Problems</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" name="scope_reason[]" value="not_required">
                                            <label for="">Customer does not required</label>
                                            <input type="checkbox" name="scope_reason[]" value="technical_problems">
                                            <label for="">Technical Problems</label>
                                            <input type="checkbox" name="scope_reason[]" value="any other">
                                            <label for="">Any Other (Please Spacify)</label>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label>
                                                e) Have you been suspended from accreditation?
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" name="suspended" value="Yes">
                                            <label for="">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="suspended" value="No">
                                            <label for="">No</label>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label>
                                                f) Are you satisfied the performance of PNAC?
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" name="performance" value="Yes">
                                            <label for="">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="performance" value="No">
                                            <label for="">No</label>
                                            <input type="radio" name="performance" value="Partially">
                                            <label for="">Partially</label>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label>
                                                g) Is the MRA/MLA status of PNAC of nay help to your Business?
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" name="status_pnac" value="Yes">
                                            <label for="">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="status_pnac" value="No">
                                            <label for="">No</label>
                                            <input type="radio" name="status_pnac" value="Partially">
                                            <label for="">Partially</label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label>
                                                g) Do you want to PNAC to get MRA,MLA in other disciplines as well (such as product,certification,inspection,proficiency testing provider and medical laboratories etc)?
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" name="disciplines" value="Yes">
                                            <label for="">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="disciplines" value="No">
                                            <label for="">No</label>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="card border-success mt-3 rounded" id="bothAccreditedCard" style="display: none;">
                                <div class="p-2 badge-success border rounded">
                                    <h6>For both accredited and non-Accredited CABs:</h6>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <p>You may tick more than one option.</p>
                                        <p>
                                            What is the reason for getting accreditation? Please tick all the relevant onces
                                        </p>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <h6>I) Was it a government requirement? if it's government requirement is it</h6>
                                        </div>
                                        <div class="col-12">
                                            <input type="checkbox" name="government_req[]" value="govt_of_pakistan">
                                            <label for="">Govt.of.Pakistan</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" name="government_req[]" value="other_countries">
                                            <label for="">Other Countries</label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <h6>
                                                II) Was it a customer demand? if it is customer's requirement, is it
                                            </h6>
                                        </div>
                                        <div class="col-12">
                                            <input type="checkbox" name="customer_demand[]" value="local_customer">
                                            <label for="">Local Customer</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" name="customer_demand[]" value="from_abroad">
                                            <label for="">From Abroad</label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <h6>
                                                III) Was the purpose of getting accreditation fro improving quality of work?
                                            </h6>
                                            <p>
                                                if the purpose was to improve quality of work, to what extent have you improved your quality of work?
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" name="purpose" value="not_much">
                                            <label for="">Not Much</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="purpose" value="significantly">
                                            <label for="">Significantly</label>
                                            <input type="radio" name="purpose" value="very_much">
                                            <label for="">Very Much</label>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <h6>
                                                IV) If the purpose was to get more business, through accreditation, then have you increased your business?
                                            </h6>
                                            <p>
                                                To what Extent:
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" name="business_purpose" value="not_much">
                                            <label for="">Not Much</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="business_purpose" value="significantly">
                                            <label for="">Significantly</label>
                                            <input type="radio" name="business_purpose" value="very_much">
                                            <label for="">Very Much</label>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <h6>
                                                V) Did you get accredited as a general trend in the market?
                                            </h6>
                                            <p>
                                                if you followed the general trend in the market, was it of any use?
                                            </p>
                                            <p>
                                                To what Extent:
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" name="accredited_general" value="not_much">
                                            <label for="">Not Much</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="accredited_general" value="significantly">
                                            <label for="">Significantly</label>
                                            <input type="radio" name="accredited_general" value="very_much">
                                            <label for="">Very Much</label>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <h6>
                                                VI) Any other reason for getting accreditation?(Please Specify)?
                                            </h6>
                                        </div>
                                        <div class="col-12">
                                            <textarea name="other_reason" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="card border-success mt-3 rounded" id="weWantKnowCard" style="display: none;">
                                <div class="p-2 badge-success border rounded">
                                    <h6>We would want to know:</h6>
                                </div>
                                <div class="card-body">

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <h6>
                                                I) Are you reports/Certificates accepted internationally?
                                            </h6>
                                            <p>
                                                if the purpose was to improve quality of work, to what extent have you improved your quality of work?
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" name="reports" value="rarely">
                                            <label for="">Rarely</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="reports" value="frequently">
                                            <label for="">Frequently</label>
                                            <input type="radio" name="reports" value="always">
                                            <label for="">Always</label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <h6>
                                                II) If not excepted have you reported it to PNAC?
                                            </h6>
                                            <p>
                                                if the purpose was to improve quality of work, to what extent have you improved your quality of work?
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" name="excepted" value="Yes">
                                            <label for="">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="excepted" value="No">
                                            <label for="">No</label>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <h6>
                                                III) Was there any outcome of the report?
                                            </h6>
                                            <p>
                                                if the purpose was to improve quality of work, to what extent have you improved your quality of work?
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" name="outcome" value="Yes">
                                            <label for="">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="outcome" value="No">
                                            <label for="">No</label>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <h6>
                                                IV) Do you think your system has improved with accreditation?
                                            </h6>
                                            <p>
                                                if the purpose was to improve quality of work, to what extent have you improved your quality of work?
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" name="system_improved" value="Yes">
                                            <label for="">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="system_improved" value="No">
                                            <label for="">No</label>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <h6>
                                                V) Do you think your clientage has increased with accreditation if so,to what extent?
                                            </h6>
                                            <p>
                                                if the purpose was to improve quality of work, to what extent have you improved your quality of work?
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" name="clientage" value="not_much">
                                            <label for="">Not Much</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="clientage" value="significantly">
                                            <label for="">Significantly</label>
                                            <input type="radio" name="clientage" value="very_much">
                                            <label for="">Very Much</label>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <h6>
                                                VI) What do you expect from government regarding accreditation?
                                            </h6>
                                        </div>
                                        <div class="col-12">
                                            <textarea name="government_regarding" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <h6>
                                                VII) Do you have any suggestion to improve our services?
                                            </h6>
                                        </div>
                                        <div class="col-12">
                                            <textarea name="suggestion" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>



                                    {{-- <div class="row">
                                        <div class="col-2 form-group mt-1">
                                            <label>2) Organization</label>
                                        </div>
                                        <div class="col-6 form-group">
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                    </div> --}}
                                </div>

                            </div>


                        </div>

                        <div class="float-right pb-2 text-right pr-4 mb-0">
                            {{-- <a href="{{ route('client-satisfication') }}" class="btn btn-danger">Cancle</a> --}}
                            <button type="submit" class="btn btn-success">Save Client Suvery Form</button>
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
@section('script')
<script>
    $(document).ready(function () {
        // Show/hide card based on selection
        $('select[name="accredited"]').on('change', function () {
            if ($(this).val() === 'Yes') {
                $('#accreditedCard').slideDown();
                $('#bothAccreditedCard').slideDown();
                $('#weWantKnowCard').slideDown();
            }
            else if ($(this).val() === 'No') {
                $('#accreditedCard').slideUp();
                $('#bothAccreditedCard').slideDown();
                $('#weWantKnowCard').slideDown();
            }
            else {
                $('#accreditedCard').slideUp();
                $('#bothAccreditedCard').slideUp();
                $('#weWantKnowCard').slideUp();
            }
        });

        // Check on page load in case of old input (e.g. after validation fails)
        if ($('select[name="accredited"]:selected').val() === 'Yes') {
            $('#accreditedCard').show();
            $('#bothAccreditedCard').show();
            $('#weWantKnowCard').show();
        }
    });
</script>

@endsection
