<form method="POST" action="{{ $stepUrl('step5') }}" class="js-card-form hcb-js-card-form">
    @csrf
    @php
        $qSections = [
            'Organisation & Management' => [
                'om_1' =>
                    '1. Does the HCB have a defined organisational structure showing main activities, lines of responsibility and reporting?',
                'om_2' =>
                    '2. Is it clear from the structure that the certification function is independent from other company activities?',
                'om_3' => '3. Are there documented policies and objectives for the Halal certification system?',
                'om_4' =>
                    '4. Are the policy and objectives communicated to all staff involved in the certification process?',
                'om_5' => '5. Is there a documented Quality Manual covering all aspects of the certification system?',
                'om_6' => '6. Are procedures established for the control of all quality documents and records?',
                'om_7' =>
                    '7. Does the HCB have documented procedures for communication with customers and interested parties?',
                'om_8' => '8. Is there a documented procedure for handling Halal status issues and emergency recalls?',
            ],
            'Quality Audit & Review' => [
                'qa_1' => '1. Does the HCB have a documented procedure for internal quality audits?',
                'qa_2' =>
                    '2. Are internal audits conducted at planned intervals to determine whether the system conforms to requirements?',
                'qa_3' => '3. Are results of internal audits and corrective actions documented?',
                'qa_4' =>
                    '4. Does top management periodically review the certification system for suitability and effectiveness?',
                'qa_5' => '5. Are results of management reviews and follow-up actions documented?',
            ],
            'HCB Staff' => [
                'hs_1' =>
                    '1. Does the HCB have sufficient qualified staff for all aspects of the certification process?',
                'hs_2' => '2. Are qualifications and experience of all staff documented and on file?',
                'hs_3' =>
                    '3. Are there documented procedures for selection, training and monitoring of Halal auditors?',
            ],
            'Procedures' => [
                'pr_1' =>
                    '1. Are there documented procedures for all stages of the certification process (application, audit, decision, certification, surveillance)?',
                'pr_2' =>
                    '2. Are certification criteria and the basis for granting, maintaining, suspending or withdrawing certification documented?',
            ],
            'Records' => [
                're_1' => '1. Does the HCB maintain records of all applications, audits and certification decisions?',
                're_2' =>
                    '2. Are audit records sufficient to demonstrate that all certification requirements have been fulfilled?',
                're_3' => '3. Are records of complaints and appeals maintained?',
                're_4' => '4. Are records kept for a defined period and in a secure manner?',
            ],
            'Complaints and Anomalies' => [
                'ca_1' =>
                    '1. Does the HCB have a documented procedure for handling complaints from applicants or certified organisations?',
                'ca_2' => '2. Are all complaints investigated and resolved in accordance with the procedure?',
            ],
            'Sub Contracting' => [
                'sc_1' =>
                    '1. Where the HCB sub-contracts audit work, are there documented criteria for selecting sub-contractors?',
                'sc_2' =>
                    '2. Does the HCB have documented agreements with sub-contractors defining their responsibilities?',
                'sc_3' => '3. Does the HCB maintain a list of all sub-contractors and their qualifications?',
            ],
            'Outside Support Services' => [
                'os_1' =>
                    '1. Where outside support services are used, are there documented agreements defining the services provided?',
                'os_2' => '2. Is the competence of outside support service providers verified and documented?',
            ],
        ];
        $compliesValue = $nonComply->isNotEmpty() ? 'no' : 'yes';
    @endphp

    @foreach ($qSections as $sectionTitle => $questions)
        <h6 class="fw-bold text-success mt-3 mb-2">{{ $sectionTitle }}</h6>
        <div class="table-responsive mb-3">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:55%">Question</th>
                        <th style="width:8%">Yes</th>
                        <th style="width:8%">No</th>
                        <th>Comments / QM Reference</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $code => $label)
                        <tr>
                            <td>{{ $label }}</td>
                            <td class="text-center">
                                <input type="radio" name="qs[{{ $code }}][answer]" value="yes"
                                    @if (($qs[$code]->answer ?? '') === 'yes') checked @endif>
                            </td>
                            <td class="text-center">
                                <input type="radio" name="qs[{{ $code }}][answer]" value="no"
                                    @if (($qs[$code]->answer ?? '') === 'no') checked @endif>
                            </td>
                            <td>
                                <textarea class="form-control form-control-sm" name="qs[{{ $code }}][comments]" rows="1">{{ $qs[$code]->comments ?? '' }}</textarea>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    {{-- Overall Compliance --}}
    <div class="mt-3 mb-2">
        <label class="fw-semibold">Does the HCB comply with PNAC requirements for Halal Certification Bodies?</label>
        <div class="mt-1">
            <label class="form-check form-check-inline">
                <input class="form-check-input hcb-comply-toggle" type="radio" name="complies" value="yes"
                    @checked($compliesValue === 'yes')> Yes
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input hcb-comply-toggle" type="radio" name="complies" value="no"
                    @checked($compliesValue === 'no')> No
            </label>
        </div>
    </div>

    <div class="hcb-non-comply-wrap {{ $compliesValue === 'yes' ? 'd-none' : '' }}">
        @include('admin.application.certification_bodies._repeatable_table', [
            'title' => 'Non-Compliance Areas',
            'target' => 'hcbNonComplyRows',
            'name' => 'non_compliances',
            'rows' => $firstRow($nonComply, ['area_of_non_compliance' => '', 'rectified_by_date' => '']),
            'columns' => [
                'area_of_non_compliance' => 'Area of Non-Compliance',
                'rectified_by_date' => 'Rectified By Date',
            ],
            'isLocked' => $isLocked,
            'disableRequired' => true, // 👈 ADD THIS
        ])
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm" type="submit">Save Draft</button>
    </div>
</form>
