<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $service;
    function __construct(PaymentService $paymentService)
    {
        $this->service = $paymentService;
    }

    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     * Returns the payments for a customer
     */
    public function customerPayments($uuid){
        return response()->json($this->service->fetchCustomerPayments($uuid));
    }

    public function initiatePayment(Request $request){
        return response()->json($this->service->initiateCardCharge($request));
    }

    public function completePayment(Request $request){
        return response()->json($this->service->authCardCharge($request));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


}
