<!-- Employee Modal create/Edit -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="employeeForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeModalLabel">Create Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Hidden Fields -->
                    <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                    <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">
                    <input type="hidden" name="type" value="employee">
                    <input type="hidden" name="_method" id="formMethod" value="POST">
<div class="row">
    <div class="col-md-6">       <div class="form-group">
                        <label>Employee Name</label>
                        <input type="text" name="employee_name" id="employee_name" class="form-control">
                    </div></div>
        <div class="col-md-6">       <div class="form-group">
                        <label>Designation</label>
                        <input type="text" name="designation" id="designation" required class="form-control">
                    </div></div>
            <div class="col-md-6">          <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" id="address" required class="form-control">
                    </div></div>
                <div class="col-md-6">  <div class="form-group">
                        <label>Telephone</label>
                        <input type="text" name="telephone" id="telephone" required class="form-control">
                    </div></div>
                    <div class="col-md-6">      <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="email" required class="form-control">
                    </div></div>
                         <div class="col-md-6">
                                     <div class="form-group">
                        <label>Employee Type</label>
                        <select name="employee_type" id="employee_type" class="form-control">
                            <option selected disabled>Select Employee Type</option>
                            <option value="top_management">Top Management</option>
                            <option value="management">Management</option>
                            <option value="technical">Technical</option>
                        </select>
                    </div>
                         </div>
</div>
             
             
          
                  
              
           
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="submitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Document Modal for Edit/Create -->
<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="documentForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
            <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">
            <input type="hidden" name="type" value="document">
            <input type="hidden" name="_method" id="docFormMethod" value="POST">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentModalLabel">Create Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-6">    <div class="form-group">
                        <label>Document Name</label>
                        <select name="document_id" id="document_id" class="form-control" >
                            <option selected disabled>Select Document Name</option>
                            @foreach ($documents as $document)
                            <option value="{{ $document->id }}">{{ $document->document_name }}</option>
                            @endforeach
                        </select>
                    </div></div>   
                    <div class="col-md-6">      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="doc_name"  class="form-control">
                    </div></div> 
                    <div class="col-md-6">     <div class="form-group">
                        <label>Number</label>
                        <input type="text" name="number" id="doc_number"  class="form-control">
                    </div></div> 
                    <div class="col-md-6">       <div class="form-group">
                        <label>Upload Doc</label>
                        <input type="file" name="upload_doc" id="upload_doc" class="form-control">
                        <small id="existingFileText" class="form-text text-muted mt-1"></small>
                    </div></div>  
                    </div>
                

              
               
             
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="documentSubmitBtn">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Scope Modal -->
<div class="modal fade" id="scopeModal" tabindex="-1" aria-labelledby="scopeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="schemeModalLabel">Create Scope</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
            <input type="hidden" name="type" value="scope"> --}}
            <div class="modal-body">
                {{-- <div class="d-flex justify-content-center gap-2 mb-4">
                    @if($scheme_name == 'Certification Bodies')
                    <button type="button" class="btn btn-outline-success scope-btn" data-target="#ISO9001">ISO 9001</button>
                    <button type="button" class="btn btn-outline-success scope-btn" data-target="#ISO14001">ISO 14001</button>
                    <button type="button" class="btn btn-outline-success scope-btn" data-target="#ISO45001">ISO 45001</button>
                    <button type="button" class="btn btn-outline-success scope-btn" data-target="#ISO13485">ISO 13485</button>
                    <button type="button" class="btn btn-outline-success scope-btn" data-target="#ISO22000">ISO 22000</button>
                    @elseif($scheme_name == 'Testing')
                    <button type="button" class="btn btn-outline-success scope-btn active" data-target="#Testing">Testing</button>
                    @elseif($scheme_name == 'Calibration')
                    <button type="button" class="btn btn-outline-success scope-btn active" data-target="#Calibration">Calibration</button>
                    @elseif($scheme_name == 'Testing Calibration Laboratories')
                    <button type="button" class="btn btn-outline-success scope-btn active" data-target="#Testing">Testing</button>
                    <button type="button" class="btn btn-outline-success scope-btn" data-target="#Calibration">Calibration</button>
                    @elseif($scheme_name == 'Medical Laboratories')
                    <button type="button" class="btn btn-outline-success scope-btn active" data-target="#Medical">Medical Laboratories</button>
                    @elseif($scheme_name == 'Inspection Bodies')
                    <button type="button" class="btn btn-outline-success scope-btn active" data-target="#Inspection">Inspection Bodies</button>
                    @elseif($scheme_name == 'Halal Certification Bodies')
                    <button type="button" class="btn btn-outline-success scope-btn active" data-target="#Halal">Halal Certification Bodies</button>
                    @elseif($scheme_name == 'Proficiency Testing Provider')
                    <button type="button" class="btn btn-outline-success scope-btn active" data-target="#Proficiency">Proficiency Testing Provider</button>
                    @elseif($scheme_name == 'Product Certification Bodies')
                    <button type="button" class="btn btn-outline-success scope-btn active" data-target="#Product">Product Certification Bodies</button>
                    @elseif($scheme_name == 'Personnel Certification Bodies')
                    @endif
                    <!-- Add more buttons as needed -->
                </div> --}}
                @if($scheme_name == 'Certification Bodies')
                <div class="card-body scope-section" id="ISO9001" style="display: block;">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="scope">
                        <input type="hidden" name="scope_type" value="ISO9001">
                        <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">
                        <div class="form-group">
                            <h5>
                                A: Quality Management System ISO 9001:2015
                            </h5>
                        </div>
                        <div class="form-group">
                            <h6>
                                (As defined in IAF MD 17)
                            </h6>
                        </div>
                        <div class="form-group">
                            <label>Technical Cluster</label>
                            <select name="technical_cluster_id" class="form-control technical-cluster" id="technicalClusterSelectA">
                                <option selected disabled>Select Cluster</option>
                                @foreach($technicalClusters as $cluster)
                                <option value="{{ $cluster->id }}" data-cluster-code="9001">{{ $cluster->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>IAF Code</label>
                            <select name="iaf_code" class="form-control" id="iafCodeDropdownA">
                                <option selected disabled>Select IAF Code</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description of economic sector/activity, according to IAF ID1</label>
                            <select name="description" class="form-control" id="descriptionDropdownA">
                                <option selected disabled>Select Description</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="card-body scope-section" id="ISO14001" style="display: none;">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="scope">
                        <input type="hidden" name="scope_type" value="ISO14001">
                        <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">
                        <div class="form-group">
                            <h5>B: Environmental Management System ISO 14001:2015</h5>
                        </div>
                        <div class="form-group">
                            <h6>
                                (As defined in IAF MD 17)
                            </h6>
                        </div>
                        <div class="form-group">
                            <label>Technical Cluster</label>
                            <select name="technical_cluster_id" class="form-control technical-cluster" id="technicalClusterSelectB">
                                <option selected disabled>Select Cluster</option>
                                @foreach($technicalClusters as $cluster)
                                <option value="{{ $cluster->id }}" data-cluster-code="14001">{{ $cluster->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>IAF code</label>
                            <select name="iaf_code" class="form-control" id="iafCodeDropdownB">
                                <option selected disabled>Select IAF Code</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description of economic sector/activity, according to IAF ID1</label>
                            <select name="description" class="form-control" id="descriptionDropdownB">
                                <option selected disabled>Select Description</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>

                <div class="card-body scope-section" id="ISO45001" style="display: none;">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="scope">
                        <input type="hidden" name="scope_type" value="ISO45001">
                        <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                        <div class="form-group">
                            <h5>
                                C: Occupational Health & Safety ISO 45001:2018
                            </h5>
                        </div>
                        <div class="form-group">
                            <h5>
                                List all the sectors/areas which you seek accreditation. (if please attach extra sheets)
                            </h5>
                        </div>
                        <div class="form-group">
                            <h6>
                                (As defined in IAF MD 17)
                            </h6>
                        </div>
                        <div class="form-group">
                            <label>Technical Cluster</label>
                            <select name="technical_cluster_id" class="form-control technical-cluster" id="technicalClusterSelectC">
                                <option selected disabled>Select Cluster</option>
                                @foreach($technicalClusters as $clusters)
                                <option value="{{ $clusters->id }}" data-cluster-code="45001">{{ $clusters->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>IAF code</label>
                            <select name="iaf_code" class="form-control" id="iafCodeDropdownC">
                                <option selected disabled>Select IAF Code</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description of economic sector/activity, according to IAF ID1</label>
                            <select name="description" class="form-control" id="descriptionDropdownC">
                                <option selected disabled>Select Description</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="card-body scope-section" id="ISO13485" style="display: none;">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="scope">
                        <input type="hidden" name="scope_type" value="ISO13485">
                        <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                        <div class="form-group">
                            <h5>
                                E: Medical Device Quality Management Systems (ISO 13485)
                            </h5>
                        </div>
                        <div class="form-group">
                            <h5>
                                List all the sectors/areas which you seek accreditation. (if please attach extra sheets).
                            </h5>
                        </div>
                        <div class="form-group">
                            <h6>
                                (As defined in IAF MD 8)
                            </h6>
                        </div>

                        <div class="form-group">
                            <label>Main Technical</label>
                            <select name="main_technical_id" id="main-technical" class="form-control">
                                <option selected disabled>Select Main Technical</option>
                                @foreach ($mainTechnical13485s as $main)
                                <option value="{{ $main->id }}">{{ $main->technical_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Technical Area</label>
                            <select name="technical_area" id="technical-area" class="form-control">
                                <option selected disabled>Select Technical Area</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Product Categories / Descriptions</label>
                            <select name="description" id="description-select" class="form-control">
                                <option selected disabled>Select Description</option>
                            </select>
                        </div>



                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>

                <div class="card-body scope-section" id="ISO22000" style="display: none;">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="scope">
                        <input type="hidden" name="scope_type" value="ISO22000">
                        <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                        <div class="form-group">
                            <h5>
                                D: Food Safety Management System (FSMS) ISO 22000:2025
                            </h5>
                        </div>

                        <div class="form-group">
                            <h6>
                                As per the requirements id IAF-MD 16
                            </h6>
                        </div>

                        <div class="form-group">
                            <label>Cluster</label>
                            <select name="cluster_id" id="clusterSelect" class="form-control">
                                <option selected disabled>Select Cluster</option>
                                @foreach ($clusters22000 as $cluster)
                                <option value="{{ $cluster->id }}">{{ $cluster->cluster_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <select name="cluster_cat" id="categorySelect" class="form-control">
                                <option selected disabled>Select Category</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Sub-Category</label>
                            <select name="cluster_sub_cat" id="subcategorySelect" class="form-control">
                                <option selected disabled>Select Sub-Category</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="summernote" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>

                @elseif($scheme_name == 'Testing' || $scheme_name == 'Testing Calibration Laboratories')

                <div class="card-body scope-section" id="Testing">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="scope">
                        <input type="hidden" name="scope_type" value="Testing">
                        <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">
                        <div class="form-group">
                            <h5>
                                Scope of application: Testing
                            </h5>
                        </div>

                        <div class="form-group">
                            <label>Materials/Products tested*</label>
                            <textarea name="materials" required class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Testing Field (e.g. Environmental testing or mechanical testing)</label>
                            <textarea name="mechanical" required class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Types of test/Properties measured</label>
                            <textarea name="property_measured" required class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Reference to standardized method (e.g.ISO 14577-1:2003)/ Internal method reference</label>
                            <textarea name="standard" required class="form-control"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>

                </div>

                @elseif($scheme_name == 'Calibration' || $scheme_name == 'Testing Calibration Laboratories')

                <div class="card-body scope-section" id="Calibration" style="display: none;">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="scope">
                        <input type="hidden" name="scope_type" value="Calibration">
                        <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                        <div class="form-group">
                            <h4> Scope of application: Calibration</h4>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label>Measured quantity</label>
                                <textarea name="measurement" required class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Range</label>
                                <textarea name="range" required class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>*Expanded Uncertainty( + )</label>
                                <textarea name="expanded" required class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Technique, Reference Standard, Equipment</label>
                                <textarea name="technique" required class="form-control"></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

                @elseif($scheme_name == 'Medical Laboratories')

                <div class="card-body scope-section" id="Medical" style="display: block;">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="scope">
                        <input type="hidden" name="scope_type" value="Medical">
                        <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                        <div class="form-group">
                            <h4> Scope of application: Medical Laboratories</h4>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label>Materials/Products tested</label>
                                <textarea name="meterials" required class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Testing field (e.g.environmental testing or mechanical testing)</label>
                                <textarea name="chemical" required class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Types of test/Properties measured</label>
                                <textarea name="measured" required class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Reference to standardized method (e.g. ISO 14577-1:2003)/ Internal method reference</label>
                                <textarea name="standardized" required class="form-control"></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

                @elseif($scheme_name == 'Inspection Bodies')

                <div class="card-body scope-section" id="Inspection" style="display: block;">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="scope">
                        <input type="hidden" name="scope_type" value="Inspection">
                        <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                        <div class="form-group">
                            <h4> Scope of application: Inspection Bodies</h4>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label>
                                    <b>Description of Inspection(s), including the types of items inspected,</b>
                                    <p>for example: Product Design, Products
                                        (specified as Materials or Equipment),
                                        Installations, Plant, Premises, Processes,
                                        Services and Surveys, etc.
                                    </p>
                                </label>
                                <input type="text" name="description" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>
                                    <b>Type and Range of Inspection</b>
                                    <p>
                                        for example:
                                        In-Service Inspection or
                                        Inspection of New
                                        Products
                                    </p>
                                </label>
                                <input type="text" name="range" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>
                                    <b>Methods and Procedures</b>
                                    <p>
                                        such as: Regulations, Standards, Specifications, Internal Normative documents.
                                    </p>
                                </label>
                                <input type="text" name="procedures" required class="form-control">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>


                @elseif($scheme_name == 'Halal Certification Bodies')
                <div class="card-body scope-section" id="Halal" style="display: block;">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="scope">
                        <input type="hidden" name="scope_type" value="Halal">
                        <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                        <div class="form-group">
                            <h4> Scope of application: Halal Certification Bodies</h4>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label>Cat. Code</label>
                                <input type="text" name="cat_code" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <input type="text" name="scope_category" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Sub Category</label>
                                <input type="text" name="subcategory" required class="form-control">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

                @elseif($scheme_name == 'Proficiency Testing Provider')

                <div class="card-body scope-section" id="Proficiency" style="display: block;">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="scope">
                        <input type="hidden" name="scope_type" value="Proficiency">
                        <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                        <div class="form-group">
                            <h4> Scope of application: Proficiency Testing Provider</h4>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                {{-- <label>Proficiency Testing Field or Area or Parameter (eg Tensile Testing)</label> --}}
                                <label>Items/ Materials/ Matrix/Products</label>
                                <p>
                                    (e.g., Reinforced Steel Bars, water,
                                    waste water)
                                </p>
                                <input type="text" name="item_materials" required class="form-control">
                            </div>
                            <div class="form-group">
                                {{-- <label>Proficiency Testing Items/ Materials/ Matrix/Products (eg Reinforced Steel Bars)</label> --}}
                                <label>Type of Scheme/test/properties</label>
                                <input type="text" name="type_scheme" required class="form-control">
                            </div>
                            <div class="form-group">
                                {{-- <label>Number of Proficiency Test Item Round (e.g 5 nos)</label> --}}
                                <label>Scheme Protocol.Procedure/technique used</label>
                                <input type="text" name="scheme_protocol" required class="form-control">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>


                @elseif($scheme_name == 'Product Certification Bodies')

                <div class="card-body scope-section" id="Product" style="display: block;">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="scope">
                        <input type="hidden" name="scope_type" value="Product">
                        <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                        <div class="form-group">
                            <h4> Scope of application: Product Certification Bodies</h4>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label>Product</label>
                                <input type="text" name="product" required class="form-control">
                            </div>
                            <div class="form-group">
                                {{-- <label>Type of Scheme according to ISO/IEC 17067/ GLOBALGAP certification schemes</label> --}}
                                <label>Standard</label>
                                <input type="text" name="standard" required class="form-control">
                            </div>
                            <div class="form-group">
                                {{-- <label>Standards</label> --}}
                                <label>Type of Scheme (ISO/IEC 17067)</label>
                                <input type="text" name="type_scheme" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Countries where certificates are to be issued</label>
                                <input type="text" name="countries" required class="form-control">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>


                @elseif($scheme_name == 'Personnel Certification Bodies')

                <div class="card-body scope-section" id="Personnel" style="display: block;">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="scope">
                        <input type="hidden" name="scope_type" value="ISO9001">
                        <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                        <div class="form-group">
                            <label>PERSONNEL CERTIFICATION CATEGORIES </label>
                            <input type="text" name="technical_cluster" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>STANDARDS/NORMATIVE REFERENCES</label>
                            <input type="text" name="description_iaf" class="form-control">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>

                </div>

                {{-- <div class="card-body scope-section" id="ISO14001" style="display: none;">
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                <input type="hidden" name="type" value="scope">
                <input type="hidden" name="scope_type" value="ISO14001">
                <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                <div class="form-group">
                    <h6>
                        A: Quality Management System ISO 9001:2015
                    </h6>
                </div>

                <div class="form-group">
                    <p>
                        List all the sectors/areas which you seek accreditation <b>(As defined in IAF MD 17)</b>
                    </p>
                </div>
                <div class="form-group">
                    <label>Technical Cluster</label>
                    <input type="text" name="technical_cluster" class="form-control">
                </div>
                <div class="form-group">
                    <label>IAF code</label>
                    <input type="text" name="iaf_code" class="form-control">
                </div>
                <div class="form-group">
                    <label>Description, according to IAF ID1</label>
                    <input type="text" name="description_iaf" class="form-control">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
                </form>
            </div>

            <div class="card-body scope-section" id="ISO45001" style="display: none;">
                <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                    <input type="hidden" name="type" value="scope">
                    <input type="hidden" name="scope_type" value="ISO45001">
                    <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                    <div class="form-group">
                        <h6>
                            A: Quality Management System ISO 9001:2015
                        </h6>
                    </div>

                    <div class="form-group">
                        <p>
                            List all the sectors/areas which you seek accreditation <b>(As defined in IAF MD 17)</b>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Technical Cluster</label>
                        <input type="text" name="technical_cluster" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>IAF code</label>
                        <input type="text" name="iaf_code" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Description, according to IAF ID1</label>
                        <input type="text" name="description_iaf" class="form-control">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>

            <div class="card-body scope-section" id="ISO13485" style="display: none;">
                <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                    <input type="hidden" name="type" value="scope">
                    <input type="hidden" name="scope_type" value="ISO13485">
                    <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                    <div class="form-group">
                        <h5>
                            Medical Device Quality Management Systems (ISO 13485)
                        </h5>
                    </div>
                    <div class="form-group">
                        <p>
                            List all the sectors/areas which you seek accreditation <b>(As defined in IAF MD 17)</b>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Main Technical Area</label>
                        <input type="text" name="main_technical" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Technical Area</label>
                        <input type="text" name="technical_area" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Product Categories Covered by the Technical Areas</label>
                        <textarea name="product_category" id="summernote" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>

            <div class="card-body scope-section" id="ISO22000" style="display: none;">
                <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                    <input type="hidden" name="type" value="scope">
                    <input type="hidden" name="scope_type" value="ISO22000">
                    <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">

                    <div class="form-group">
                        <h5>
                            D: Food Safety Management System (FSMS)
                        </h5>
                    </div>

                    <div class="form-group">
                        <p>
                            List all the sectors/areas which you seek accreditation <b>(As defined in IAF MD 17)</b>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Main Technical Area</label>
                        <input type="text" name="main_technical" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Technical Area</label>
                        <input type="text" name="technical_area" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Product Categories Covered by the Technical Areas</label>
                        <textarea name="product_category" id="summernote1" class="form-control"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div> --}}

            @endif

        </div>
    </div>
</div>
</div>


<!-- Declaration Modal -->
<div class="modal fade" id="declarationModal" tabindex="-1" aria-labelledby="declarationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="documentForm" action="{{ route('document-detail.create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
            <input type="hidden" name="application" value="{{ urldecode(request()->query('application')) }}">
            <input type="hidden" name="type" value="declaration">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="schemeModalLabel">Create Declaration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <h6>
                            6.2. The CB/organisation agrees to conform, upon accreditation, with PNAC requirements as detailed in the Agreement [F-01/08].
                        </h6>
                    </div>
                    <div class="form-group">
                        <h6>
                            6.3. I enclose a copy of Quality Manual and other documents/information (see Note below)
                        </h6>
                    </div>
                    <div class="form-group">
                        <h6>6.4. I enclose a cheque (payable to PNAC) for the Applicant fee of ________. I understand that this fee is non-refundable. (see Note below).</h6>
                    </div>
                    <div class="form-group">
                        <h6>6.5. I understand the manner in which the accreditation system functions.
                        </h6>
                    </div>
                    <div class="form-group">
                        <h6>
                            I declare that the information given in this form is correct to the best of my knowledge and belief
                        </h6>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
