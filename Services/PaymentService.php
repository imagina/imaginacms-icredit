<?php

namespace Modules\Icredit\Services;

use Modules\Icredit\Entities\Credit;
use Modules\Icredit\Repositories\CreditRepository;
use Illuminate\Http\Request;

class PaymentService
{

    public function __construct(
        CreditRepository $credit
    )
    {
        $this->credit = $credit;
    }

    /**
    * Get Credit User  
    * @param  $customer Id
    * @return
    */
    function getCreditByUser($customerId){

        // Get Credit
        $criteria = $customerId;
        $params = [
            'filter' => [
                "field" => "customerId"
            ]
        ];
        $credit = $this->credit->getItem($criteria,$params);

        return $credit;
    }

    /**
    * Validate if process the payment  
    * @param  $credit
    * @param  $order
    * @return
    */
    function validateProcessPayment($credit,$order){
        $processPayment = false;
        if($credit->amount>=$order->total){
            $processPayment = true;
        }

        return $processPayment;
    }

}