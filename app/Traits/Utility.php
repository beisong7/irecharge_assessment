<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Utility{

    /**
     * This generates uuid in string format. if you wish you can add a prefix
     * @param null $prefix
     * @return string
     */
    public function makeUuid($prefix=null){
        $uuid = (string)Str::uuid();
        return !empty($prefix)?$prefix.$uuid:$uuid;
    }

    /**
     * @param null $int
     * @return string
     * Generates a random string
     */
    public function randomString($int=null){
        return Str::random(empty($int)?36:$int);
    }

}