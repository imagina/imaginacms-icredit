<?php

namespace Modules\Icredit\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model Repository
use Modules\Icredit\Repositories\CreditRepository;
use Modules\Icredit\Entities\Credit;

use Illuminate\Http\Request;

//Transformer Requestable
use Modules\Requestable\Transformers\RequestableTransformer;

class CreditApiController extends BaseCrudController
{
    
    public $model;
    public $modelRepository;

    public function __construct(Credit $model, CreditRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }


    /*
    * WithdrawalFunds with Requestable Module
    */
    public function withdrawalFunds(Request $request)
    {
        \DB::beginTransaction();
        try {

            //Get model data
            $modelData = $request->input('attributes') ?? [];
          
            //Validate Request
            if (isset($this->model->requestValidation['withdrawalFunds'])) {
                $this->validateRequestApi(new $this->model->requestValidation['withdrawalFunds']($modelData));
            }

            // Requestable Service
            $modelData['type'] = "withdrawalFunds";
            $model = app('Modules\Requestable\Services\RequestableService')->create($modelData);
          
            //Response type Requestable Transformer
            $response = ["data" => new RequestableTransformer($model)];
          
            \DB::commit(); //Commit to Data Base

        } catch (\Exception $e) {

            \Log::error('Icredit: CreditApiController|withdrawalFunds|Message: '.$e->getMessage().' | FILE: '.$e->getFile().' | LINE: '.$e->getLine());

            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }


   
}
