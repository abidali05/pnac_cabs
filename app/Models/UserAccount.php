<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserAccount extends Authenticatable
{
    use HasFactory, HasRoles;
    protected $guard_name = 'web';
    protected $table = 'user_accounts';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // public function role()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }
}
