<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    protected $fillable = [
        "uuid",
        "name",
        "live",
        "test_public_key",
        "test_private_key",
        "test_encryption_key",
        "live_public_key",
        "live_private_key",
        "live_encryption_key",
        "link",
    ];
}
