<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        "uuid",
        "customer_id",
        "transaction_id",
        "amount",
        "reference_id",
        "comments",
        "success",
    ];
}
