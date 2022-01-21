<?php


namespace App\Services;

use App\Models\Customer;
use App\Models\Transaction;
use App\Repos\CustomerRepo;
use App\Repos\TransactionRepo;
use App\Traits\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class CustomerService
 * @package App\Services
 *
 * This class manages all activities related to the customer
 *
 */
class TransactionService extends TransactionRepo
{
    use Utility;
    /**
     * handles BL to fetch customer transaction
     * @param int $perPage
     * @return mixed
     */
    public function fetchCustomerTransactions($customerId){
        $customer = Customer::whereUuid($customerId)->first();

        return empty($customer)? ["error"=>"account not found"] :$this->get($customerId);
    }

    /**
     * create transaction for lifecycle
     * @param array $raw
     * @return mixed
     */
    public function createTransaction(array $raw){
        $data['uuid'] = $this->makeUuid();
        $data['customer_id'] = $raw['customer_id'];
        $data['tx_ref'] = $this->randomString(16);
        $data['amount'] = floatval($raw['amount']);
        $data['status'] = "attempting";
        $data['meta'] = "test pay";
        $data['completed'] = false;
        $data['start'] = time();
        $tran = $this->save($data);
        return ["success"=>true,"transaction"=>$tran];
    }

    /**
     * handles check on new payment requests
     * @param array $raw
     * @return array|mixed
     */
    public function startTransaction(array $raw){
        if($this->doubleInstanceTest($raw)){
            return $this->createTransaction($raw);
        }
        return ["success"=>false, "message"=>"This transaction appears to be duplicate. Wait for 10 mins then try again"];
    }


    public function preTransactionCardAuth(array  $raw){
        $ref = $raw['tx_ref'];
        $transaction = $this->getPendingByRef($ref);
        return empty($transaction)?["success"=>false, "message"=>"Payment might already be completed. check customer payments and try again"]:['success'=>true,'transaction'=>$transaction];
    }


}