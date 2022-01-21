<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    protected $fillable = [
        "uuid",
        "gateway_id",
        "name",
        "link",
        "method",
    ];
}
