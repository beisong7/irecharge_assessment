<?php

namespace App\Repos;

use App\Models\Customer;
use App\Traits\RepoTrait;
use App\Traits\Utility;

class CustomerRepo {
    use RepoTrait, Utility;

    /**
     * @param array $selection
     * @return mixed
     */
   public function get(array $selection){
       $query = Customer::query();
       $paginate = 30;
       $order = ["id","desc"];
       return $this->modify($query,$selection, $paginate, $order);
   }

    /**
     * @param $uuid
     */
   public function customerExist($uuid){
       $customer = Customer::whereUuid($uuid)
           ->with(['payments','transactions'])
           ->first();

       return $customer?$customer:['message'=>'customer record found'];
   }
}