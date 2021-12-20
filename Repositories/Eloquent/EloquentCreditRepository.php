<?php

namespace Modules\Icredit\Repositories\Eloquent;

use Modules\Icredit\Repositories\CreditRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentCreditRepository extends EloquentCrudRepository implements CreditRepository
{

    /**
    * Filter name to replace
    * @var array
    */
    protected $replaceFilters = [];

    /**
    * Filter query
    *
    * @param $query
    * @param $filter
    * @return mixed
    */
    public function filterQuery($query, $filter)
    {
    
    /**
     * Note: Add filter name to replaceFilters attribute to replace it
     *
     * Example filter Query
     * if (isset($filter->status)) $query->where('status', $filter->status);
     *
     */


        // Filter amount Available
        if (isset($filter->amountAvailable)){

            //AVAILABLE
            $query->where('status',2);

            //custom select
            $query->select(
                'customer_id',
                \DB::raw('SUM(amount) as amount'),
                );

            //group by client Id
            $query->groupBy("customer_id");

        }
        

        //Response
        return $query;
    }


    /**
     * Calculates in Checkout
     *
     * @param $parameters
     * @param $conf
     * @return 
     */
    public function calculate($parameters,$conf){
  
  
        $response["status"] = "success";

        // Search Cart
        if(isset($parameters["cartId"])){
          $cartRepository = app('Modules\Icommerce\Repositories\CartRepository');
          $cart = $cartRepository->find($parameters["cartId"]);
        }
    
        // Validating Min Amount Order
        if(isset($conf->minimunAmount) && !empty($conf->minimunAmount)) {
            if (isset($cart->total) || isset($parameters["total"]))
              if(($cart->total ?? $parameters["total"]) < $conf->minimunAmount){
                
                $response["status"] = "error";
                $response["msj"] = trans("icommerce::common.validation.minimumAmount",["minimumAmount" =>formatMoney($conf->minimunAmount)]);

                return $response;
              }
        }
       
        // Validating User has credit
        /*
        $authUser = \Auth::user();
        if(isset($cart) && isset($authUser->id)){

            //\Log::info('Icredit: EloquentCalculate|ValidateUserHasCredit');

            $paymentService = app('Modules\Icredit\Services\PaymentService');

            // Get Credit
            $credit = $paymentService->getCreditByUser($authUser->id);

            // Process Payment Valid
            $processPayment = $paymentService->validateProcessPayment($credit,$cart->total);
          
            if($processPayment==false){
                $response["status"] = "error";
                $response["msj"] = trans("icredit::icredit.validation.no credit");

                return $response;
            }

        }
        */
       

        return $response;
    
    }

}