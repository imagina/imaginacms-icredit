<?php

namespace Modules\Icredit\Events;

use Illuminate\Queue\SerializesModels;

class WithdrawalFundsRequestWasAcepted
{
    public $requestable;
    public $oldRequest;
    public $notificationService;
    public $requestCreator;

    public function __construct($requestable, $oldRequest)
    {

        \Log::info('Icredit: Events|Handler|WithdrawalFundsRequestWasAcepted');
        
        $this->requestable = $requestable;
        $this->oldRequest = $oldRequest;
        $this->requestCreator = $oldRequest->creator();
        $this->notificationService = app("Modules\Notification\Services\Inotification");
    }


    public function notification()
    {

        $this->notificationService->to([
            "email" => $this->requestCreator->email,
            "broadcast" => $this->requestCreator->id,
            "push" => $this->requestCreator->id,
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
