<?php

namespace Modules\Icredit\Events;

use Modules\User\Entities\Sentinel\User;
use Modules\Requestable\Entities\Requestable;

class WithdrawalFundsRequestWasCreated
{
    public $requestable;
    public $notificationService;
    public $requestUser;


    public function __construct($requestable)
    {
        $this->requestable = $requestable;
        $this->requestUser = $requestUser;

        $this->notificationService = app("Modules\Notification\Services\Inotification");
        
        $this->notification();
    }


    public function notification()
    {
        $emailTo = json_decode(setting("icommerce::form-emails", null, "[]"));
        $usersToNotity = json_decode(setting("icommerce::usersToNotify", null, "[]"));

        if (empty($emailTo))
            $emailTo = explode(',', setting('icommerce::form-emails'));

        $users = User::whereIn("id", $usersToNotity)->get();
        $emailTo = array_merge($emailTo, $users->pluck('email')->toArray());
  
        $fields = $this->requestable->fields()->get();
      $amount = $fields->where("name","amount")->first()->value;
        $this->notificationService->to([
            "email" => $emailTo,
            "broadcast" => $users->pluck('id')->toArray(),
            "push" => $users->pluck('id')->toArray(),
        ])->push(
            [
                "title" => trans("icredit::credits.title.WithdrawalFundsRequestWasCreated"),
                "message" => trans("icredit::credits.messages.WithdrawalFundsRequestWasCreated",["requestUserName" => $this->requestUser->present()->fullname,"requestAmount" => $amount,"requestableId" => $this->requestable->id]),
                "icon_class" => "fa fa-bell",
              "setting" => [
                "saveInDatabase" => true
              ]

            ]
        );
    }
}

