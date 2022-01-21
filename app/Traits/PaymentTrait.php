<?php

namespace App\Traits;

use App\Models\Gateway;
use Illuminate\Http\Request;

trait PaymentTrait
{
    use Utility;
    /**
     * encrypts data to be sent
     * @param array $data
     * @return array
     */
    public function encrypt(array $data){
        $key = config('app.flutterwave.encryptKey');
        $encData = openssl_encrypt(json_encode($data), 'DES-EDE3', $key, OPENSSL_RAW_DATA);
        return ["client"=>base64_encode($encData)];
    }


    /**
     * returns array of required fields
     * @return array
     */
    private function fields(){
        return [
            "card_number", "cvv", "expiry_month",
            "expiry_year", "currency", "amount",
            "email", "fullname", "tx_ref",
            "redirect_url", "customer_id",
        ];
    }

    /**
     * fields for otp
     * @return array
     */
    private function otpFields(){
        return [
            "flw_ref", "tx_ref", "otp", "type", "stage"
        ];
    }

    /**
     * Returns array of data gotten from form;
     * @param Request $request
     * @param $stage
     * @return array
     */
    private function formData(Request $request, $stage=null){
        $data = [];
        $fields = $stage==="otp"? $this->otpFields() : $this->fields();
        foreach ($fields as $item){
            if(!empty($request->input($item))){
                $data[$item] = $request->input($item);
            }
        }
        return $data;
    }

    /**
     * returns required validation fields
     * @param $currentStage
     * @return array
     */
    public function requiredFields($currentStage = null){
        if($currentStage==="otp"){
            return [
                "flw_ref"=>"required",
                "tx_ref"=>"required",
                "otp"=>"required",
                "type"=>"required",
                "stage"=>"required",
            ];
        }
        return [
            "card_number"=>"required|numeric",
            "cvv"=>"required|numeric",
            "expiry_month"=>"required",
            "expiry_year"=>"required",
            "currency"=>"required",
            "amount"=>"required|numeric",
            "email"=>"required",
            "fullname"=>"required",
            "redirect_url"=>"required",
            "customer_id"=>"required"
        ];
    }


    /**provides data for payment record creation
     * @param array $raw
     * @return mixed
     */
    public function paymentData(array $raw){
        $data['uuid'] = $this->makeUuid();
        $data['customer_id'] = $raw['customer_id'];
        $data['transaction_id'] = $raw['transaction_id'];
        $data['amount'] = floatval($raw['amount']);
        $data['comments'] = "none";
        $data['success'] = true;
        return $data;
    }
}