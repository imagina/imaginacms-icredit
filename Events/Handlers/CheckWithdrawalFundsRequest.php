<?php

namespace Modules\Icredit\Events\Handlers;

use Illuminate\Contracts\Mail\Mailer;
use Modules\Icredit\Repositories\CreditRepository;
use Modules\User\Entities\Sentinel\User;
use Modules\Notification\Services\Notification;

class CheckWithdrawalFundsRequest
{

    public $creditRepository;

    public function __construct(CreditRepository $creditRepository)
    {
        $this->creditRepository = $creditRepository;

    }


    public function handle($event)
    {
        $requestable = $event->oldRequest;

        $this->creditRepository->create([
            "amount" => $requestable->fields->amount * -1,
            "status" => 2,
            "related_id" => $requestable->id,
            "related_type" => "Modules\Requestable\Entities\Requestable",
            "customer_id" => $requestable->created_by,
            "description" => trans("icredit::credits.descriptions.WithdrawalFundsRequestWasEffected",["requestableId" => $requestable->id]),
        ]);
    }
}