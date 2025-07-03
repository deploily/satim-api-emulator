<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'username',
        'password',
        'orderNumber',
        'amount',
        'currency',
        'returnUrl',
        'failUrl',
        'isConfirmed',
        'isFailed',
        
    ];
    protected $table = 'payments';
}
