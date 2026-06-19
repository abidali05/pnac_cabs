<form method="POST" action="{{ $stepUrl('step4') }}" class="js-card-form hcb-js-card-form">
    @csrf

    @include('admin.application.certification_bodies._repeatable_table', [
        'title'    => 'Scope of Halal Certification',
        'target'   => 'hcbScopeRows',
        'name'     => 'scopes',
        'rows'     => $firstRow($scopes, ['category_code'=>'','category'=>'','subcategory'=>'','included_activities'=>'']),
        'columns'  => [
            'category_code'       => 'Cat. Code',
            'category'            => 'Category',
            'subcategory'         => 'Sub Category',
            'included_activities' => 'Included Activities',
        ],
        'isLocked' => $isLocked,
    ])

    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>
