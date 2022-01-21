<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        "uuid",
        "customer_id",
        "tx_ref",
        "tx_id",
        "amount",
        "status",
        "meta",
        "completed",
        "success",
        "gateway_msg",
        "start",
        "ends",
    ];
}
