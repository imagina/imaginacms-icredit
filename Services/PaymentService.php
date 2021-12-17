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
    public function getCreditByUser($customerId){

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
    * @param  $total
    * @return
    */
    public function validateProcessPayment($credit,$total){

        $processPayment = false;

        if(!is_null($credit)){
            if($credit->amount>=$total){
                $processPayment = true;
            }
        }

        return $processPayment;
    }

}