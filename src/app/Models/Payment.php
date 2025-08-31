<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'user_id',
        
    ];
    protected $table = 'payments';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
