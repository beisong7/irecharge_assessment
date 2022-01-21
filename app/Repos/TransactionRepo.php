<?php

namespace App\Repos;

use App\Models\Transaction;
use App\Traits\RepoTrait;
use App\Traits\Utility;
use Illuminate\Support\Facades\DB;

class TransactionRepo {
    use RepoTrait, Utility;

    /**
     * returns all transaction for a single customer
     * @param @requires $uuid
     * @return mixed
     */
    public function get($uuid){
        $query = Transaction::query()->where("customer_id", $uuid);
        $paginate = 30;
        $order = ["id","desc"];
        return $this->modify($query,[], $paginate, $order);
    }

    /**
     * creates transactions
     * @param $data
     * @return mixed
     */
    public function save($data){
        DB::beginTransaction();
        $tran = Transaction::create($data);
        DB::commit();
        return $tran;
    }

    /**
     * prevent double payment instance
     * @param array $raw
     * @return bool
     */
    public function doubleInstanceTest(array $raw){
        $id = $raw['customer_id'];
        $amount = floatval($raw['amount']);
        $exist = Transaction::where("customer_id", $id)
            ->where("amount", $amount)
            ->where('completed', false)
            ->where('status', "attempting")
            ->first();
        return empty($exist)?true:false;
    }


    public function itemUpdate(Transaction $tran, array $payload){
        DB::beginTransaction();
        $tran->update($payload);
        DB::commit();
    }

    public function getPendingByRef($ref){
        return Transaction::where('tx_ref', $ref)->where('completed', false)->where('status','authorizing')->first();
    }
}