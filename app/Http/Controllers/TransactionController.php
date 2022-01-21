<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $service;
    function __construct(TransactionService $transactionService)
    {
        $this->service = $transactionService;
    }

    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     * Returns the transactions for a customer
     */
    public function customerTransactions($uuid){
        return response()->json($this->service->fetchCustomerTransactions($uuid));
    }
}
