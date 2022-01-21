<?php


namespace App\Services;

use App\Models\Customer;
use App\Repos\CustomerRepo;
use Illuminate\Http\Request;

/**
 * Class CustomerService
 * @package App\Services
 *
 * This class manages all activities related to the customer
 *
 */
class CustomerService extends CustomerRepo
{
    /**
     * @param int $perPage
     * @return mixed
     */
    public function load(){
        $selection = ["uuid", "first_name", "last_name", "email", "phone"];
        return $this->get($selection);
    }

    public function view($uuid){
        return $this->customerExist($uuid);
    }

    public function createCustomer(Request $request){
        $customer['uuid'] = $this->makeUuid();
        $customer['first_name'] = $request->input('first_name');
        $customer['last_name'] = $request->input('last_name');
        $customer['email'] = $request->input('email');
        $customer['phone'] = $request->input('phone');
        $customer = Customer::create($customer);
        return ["success"=>true,"account"=>$customer];
    }

}