<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationAboutSelves extends Model
{
    use HasFactory;

    protected $fillable = [
        'about', 'selves_title', 'selves_name', 'selves_position', 'selves_parent',
        'selves_parent_organization', 'selves_relationship', 'selves_with_parent',
        'selves_address', 'selves_postcode', 'selves_tel', 'selves_fax',
        'selves_organization_three', 'selves_address_three', 'selves_postcode_three',
        'selves_tel_three', 'selves_fax_three', 'selves_individual', 'selves_public',
        'selves_private', 'selves_learned', 'selves_industry', 'selves_academic',
        'selves_other_describe', 'selves_activities', 'selves_own_organisation',
        'selves_other_organisation', 'selves_name_seven', 'selves_organisation_any',
        'selves_address_seven', 'selves_postcode_seven', 'selves_tel_seven',
        'selves_fax_seven', 'selves_email_seven',
    ];

    public function general()
    {
        return $this->belongsTo(ApplicationGeneral::class, 'application_general_id');
    }
}
