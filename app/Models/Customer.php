<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        "uuid",
        "first_name",
        "last_name",
        "email",
        "phone",
    ];

    protected $appends = ['view'];

    public function getViewAttribute(){
        return route('customer.show', $this->uuid);
    }

    public function getPaymentAttribute(){
        return route('customer.payments', $this->uuid);
    }

    public function getTransAttribute(){
        return route('customer.transactions', $this->uuid);
    }

    public function payments(){
        return $this->hasMany(Payment::class, 'customer_id', 'uuid')
            ->orderBy('created_at','desc')->take(10);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class, 'customer_id', 'uuid')
            ->orderBy('created_at','desc')->take(10);
    }

    public function getLatestTransactionAttribute(){
        return Transaction::where('customer_id', $this->uuid)->orderBy('id', 'desc')->first();
    }


}
