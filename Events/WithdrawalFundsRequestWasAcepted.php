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

        //\Log::info('Icredit: Events|WithdrawalFundsRequestWasAcepted|Requestable: '.json_encode($requestable));

        $this->requestable = $requestable;
        $this->oldRequest = $oldRequest;
        $this->notificationService = app("Modules\Notification\Services\Inotification");

        $this->notification();
    }


    public function notification()
    {

        //\Log::info('Icredit: Events|WithdrawalFundsRequestWasAcepted|Notification');

        $this->notificationService->to([
            "email" =>  $this->requestable->createdByUser->email,
            "broadcast" => $this->requestable->createdByUser->id,
            "push" => $this->requestable->createdByUser->id
        ])->push(
            [
                "title" => trans("icredit::credits.title.WithdrawalFundsRequestWasAcepted"),
                "message" => !empty($this->requestable->eta) ?
                    trans("icredit::credits.messages.WithdrawalFundsRequestWasAceptedWithETA",["requestableId" => $this->requestable->id,"requestableETA" => $this->requestable->eta])
                    : trans("icredit::credits.messages.WithdrawalFundsRequestWasAcepted",["requestableId" => $this->requestable->id]),
                "icon_class" => "fa fa-bell",
                "setting" => [
                    "saveInDatabase" => true
                ]

            ]
        );
    }
}
