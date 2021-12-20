<?php

namespace Modules\Icredit\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model Repository
use Modules\Icredit\Repositories\CreditRepository;
use Modules\Icredit\Entities\Credit;

use Illuminate\Http\Request;

class CreditApiController extends BaseCrudController
{
    
    public $model;
    public $modelRepository;

    public function __construct(Credit $model, CreditRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
    

    
    
    /**
     * GET amount
     *
     * @return mixed
     */
    /*
    public function amount(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $models = $this->modelRepository->amount($params);
            //Response
            $response = ["data" => CrudResource::transformData($models)];
           
            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($credits)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }
    */
   
}
