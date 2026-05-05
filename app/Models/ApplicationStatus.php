<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'certification_general_id', 'user_account_id','status', 'accreditation_status', 'message', 'certification_general_id', 'user_account_id',
    ];

    public function general()
    {
        return $this->belongsTo(CertificationGeneral::class, 'certification_general_id');
    }
    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class);
    }
}
