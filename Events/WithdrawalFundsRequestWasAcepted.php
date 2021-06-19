<?php

namespace Modules\Icredit\Events;

use Illuminate\Queue\SerializesModels;

class WithdrawalFundsRequestWasAcepted
{
    public $requestable;
    public $notificationService;
    public $requestUser;
    public $requestConfig;

    public function __construct($requestable,$requestConfig,$requestUser)
    {
        $this->requestable = $requestable;
        $this->requestUser = $requestUser;
        $this->requestConfig = $requestConfig;
        $this->notificationService = app("Modules\Notification\Services\Inotification");
    }


    public function notification()
    {

        $this->notificationService->to([
            "email" => $this->requestUser->email,
            "broadcast" => $this->requestUser->id,
            "push" => $this->requestUser->id,
        ])->push(
            [
                "title" => trans("icredit::credits.title.WithdrawalFundsRequestWasAcepted"),
                "message" => !empty($this->requestable->eta) ?
                    trans("icredit::credits.messages.WithdrawalFundsRequestWasAceptedWithETA",["requestableId" => $this->requestable->id,"requestableETA" => $this->requestable->eta])
                    : trans("icredit::credits.messages.WithdrawalFundsRequestWasAcepted",["requestableId" => $this->requestable->id]),
                "icon_class" => "fa fa-bell",

            ]
        );
    }
}
