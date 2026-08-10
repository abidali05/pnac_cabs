<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HcbBasicInformation extends Model
{
    protected $table = 'hcb_basic_information';

    protected $fillable = ['application_id', 'organization_name', 'address', 'postcode', 'telephone', 'fax', 'contact_name', 'designation', 'contact_address', 'contact_postcode', 'contact_tel', 'contact_fax', 'contact_email', 'new_accreditation', 'extension_scope', 'halal_scope', 'city'];
}
