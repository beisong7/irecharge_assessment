<?php

namespace App\Repos;

use App\Models\Payment;
use App\Traits\RepoTrait;
use App\Traits\Utility;
use Illuminate\Support\Facades\DB;

class PaymentRepo {
    use RepoTrait, Utility;

    /**
     * returns all transaction for a single customer
     * @param @requires $uuid
     * @return mixed
     */
    public function get($uuid){
        $query = Payment::query()->where("customer_id", $uuid);
        $paginate = 30;
        $order = ["id","desc"];
        return $this->modify($query,[], $paginate, $order);
    }

    public function save(array $data){

        DB::beginTransaction();
        $payment = Payment::create($data);
        DB::commit();
        return $payment;
    }
}