<?php


namespace App\Services;

use App\Models\Customer;
use App\Models\Transaction;
use App\Repos\PaymentRepo;
use App\Traits\HttpTrait;
use App\Traits\PaymentTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class CustomerService
 * @package App\Services
 *
 * This class manages all activities related to the customer
 *
 */
class PaymentService extends PaymentRepo
{
    use PaymentTrait, HttpTrait;

    private $transactionService;
    function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * handles BL to fetch customer transaction
     * @param int $perPage
     * @return mixed
     */
    public function fetchCustomerPayments($customerId){
        $customer = Customer::whereUuid($customerId)->first();

        return empty($customer)? ["error"=>"account not found"] :$this->get($customerId);
    }

    /**
     * Initiate a card charge requiring authorization
     * @param Request $request
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function initiateCardCharge(Request $request){
        //handle validation
        $validator = Validator::make($request->all(), $this->requiredFields());

        //validate fields
        if($validator->fails()){
            return ["success"=>false,"messages"=>$validator->getMessageBag()];
        }



        //get form data
        $data = $this->formData($request);

        //create transaction
        $tranResponse = $this->transactionService->startTransaction($data);

        //actions to do on success
        if($tranResponse['success']){

            $transaction = $tranResponse['transaction'];

            //encrypt data !PASS IN tx_ref
            $data['tx_ref'] = $transaction->tx_ref;
            $encryptedData = $this->encrypt($data);

            $url = config('app.flutterwave.url');
            $chargeRes = $this->makeRequest("POST", $url."v3/charges?type=card", $encryptedData);


            //actions to do on success
            if($chargeRes['success']){
                //update transaction
                $newPayload['status'] = "authorizing";
                $newPayload['gateway_msg'] = $chargeRes['data']['message'];
                $this->transactionService->itemUpdate($transaction, $newPayload);
            }
            $chargeRes['transaction']=$transaction;
            return $chargeRes;

        }
        return $tranResponse;

    }

    /**
     * @param Request $request
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function authCardCharge(Request $request){
        //handle validation
        //add tx_ref to validation
        $currentStage = $request->input('stage');
        $requiredFields = $this->requiredFields($currentStage);
        $requiredFields["tx_ref"]="required";

        $validator = Validator::make($request->all(), $requiredFields);

        //validate fields
        if($validator->fails()){
            return ["success"=>false,"messages"=>$validator->getMessageBag()];
        }

        //get form data
        $data = $this->formData($request, $currentStage);

        //append authorizations
        if($currentStage==="pin"){
            $data['authorization'] = $request->input('authorization');
        }

        //create transaction
        $tranResponse = $this->transactionService->preTransactionCardAuth($data);

        //actions to do on success
        if($tranResponse['success']){

            $transaction = $tranResponse['transaction'];

            if($currentStage==="pin"){
                $data = $this->encrypt($data);
            }



            $link = $this->setLink($currentStage);
            $chargeRes = $this->makeRequest("POST", $link, $data);



//            return $chargeData;

            //actions to do on success
            if($chargeRes['success']){
                $chargeData = $chargeRes['data']['data'];

                $status = $chargeData['status'];
                $tx_id = $chargeData['id'];

                $message = $chargeData['processor_response'];
                //check status
                if($status==='pending'){


                    $flw_ref = $chargeData['flw_ref'];

                    // update transaction

                    $newPayload['gateway_msg'] = $message;
                    $newPayload['tx_id'] = $tx_id;
                    $transaction->tx_id = $tx_id;


                    //handle stage
                    if($currentStage==='pin'){
                        $newPayload['status'] = "otp";
                        $this->transactionService->itemUpdate($transaction, $newPayload);
                        return ["status"=>$status, "message"=>$message, "flw_ref"=>$flw_ref, "tx_ref"=>$transaction->tx_ref];
                    }elseif ($currentStage==="otp"){
                        return $chargeRes;
                    }

                    //verify payment
//                    return $this->verifyPayment($transaction);
                }elseif ($status==="successful"){
                    $d['transaction_id'] = $transaction->uuid;
                    $d['customer_id'] = $transaction->customer_id;
                    $d['amount'] = $transaction->amount;
                    $payment = $this->save($this->paymentData($d));
                    $verifyRes['payment'] = $payment;

                    //update transaction
                    $newPayload['status'] = "completed";
                    $newPayload['completed'] = true;
                    $newPayload['success'] = true;
                    $newPayload['ends'] = time();
                    $newPayload['gateway_msg'] = $message;
                    $this->transactionService->itemUpdate($transaction, $newPayload);
                    return $chargeRes;
                }
            }
            return $chargeRes;

        }
        return $tranResponse;

    }

    public function verifyPayment(Transaction $transaction){
        $url = config('app.flutterwave.url');
        $tx_id = $transaction->tx_id;
        $verifyRes = $this->makeRequest("GET", $url."v3/transactions/{$tx_id}/verify");

        //update customer records
        if($verifyRes['success']){

            $response = $verifyRes['data']['processor_response'];
            if($verifyRes['data']['data']['status']==="success"){

                //create payment if successful
                $data['transaction_id'] = $transaction->uuid;
                $payment = $this->save($this->paymentData($data));
                $verifyRes['payment'] = $payment;

                //update transaction
                $newPayload['status'] = "completed";
                $newPayload['completed'] = true;
                $newPayload['success'] = true;
                $newPayload['ends'] = time();
                $newPayload['gateway_msg'] = "{$response}";
                $this->transactionService->itemUpdate($transaction, $newPayload);
            }
        }

        return $verifyRes;
    }

    private function setLink($stage){
        $url = config('app.flutterwave.url');
        return $stage==="pin"? $url."v3/charges?type=card":$url."v3/validate-charge";
    }

}