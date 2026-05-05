<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_general_id',
        'approvals_name',
        'approvals_scope',
        'approvals_start_date',
        'approvals_end_date',
    ];

    public function general()
    {
        return $this->belongsTo(ApplicationGeneral::class, 'application_general_id');
    }
}
