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
    
   
}
