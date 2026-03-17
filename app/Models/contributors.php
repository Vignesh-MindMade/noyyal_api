<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class contributors extends Model
{
    use HasApiTokens;
    
    protected $fillable = [
        'full_name',
        'username',
        'mobile_no',
        'email',
        'password',
        'remember_token',
        'total_contribution',
    ];
}
