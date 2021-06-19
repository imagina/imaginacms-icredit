<?php

namespace Modules\Icredit\Services;

use Modules\Icredit\Entities\Credit;
use Modules\Icredit\Repositories\CreditRepository;
use Illuminate\Http\Request;

class CreditService
{

    public function __construct(

        CreditRepository $credit
    )
    {
        $this->credit = $credit;

    }

    /**
     * CREATE A ITEM
     *
     * @param Request $request
     * @return mixed
     */
    public function create($data)
    {

        $needTobeCreated = true;
        if (isset($data['creditId'])) {
            $credit = $this->credit->find($data['creditId']);
            $needTobeCreated = false;
        } elseif (isset($data['credit']->id)) {
            $credit = $data['credit'];
            $needTobeCreated = false;
            if(!isset($credit->id)){
                $needTobeCreated = true;
            }
        }

        if($needTobeCreated) {

            $creditData = [
                "ip" => request()->ip(),
                "session_id" => session('_token'),
                "user_id" => $data["userId"] ?? $data["customerId"] ?? \Auth::id()
            ];

            //Create credit
            $credit = $this->credit->create($creditData);

        }
        return $credit;
    }

}