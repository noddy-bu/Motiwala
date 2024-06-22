<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'payment_id',
        'payment_amount',
        'payment_details',
        'comments',
        'payment_status',
        'payment_response',
        'date_of_installment',
        'redemption_id',
        'installment',
    ];   
     
}
