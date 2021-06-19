<?php

namespace Modules\Icredit\Events;

use Illuminate\Queue\SerializesModels;
use Modules\User\Entities\Sentinel\User;

class WithdrawalFundsRequestWasRejected
{
    public $requestable;
    public $notificationService;
    public $requestUser;
    public $requestConfig;

    public function __construct($requestable, $oldRequest, $requestConfig,$requestUser)
    {
        $this->requestable = $requestable;
        $this->requestUser = $requestUser;
        $this->requestConfig = $requestConfig;
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


        $this->notificationService->to([
            "email" =>  $this->requestUser->email,
            "broadcast" =>  $this->requestUser->id,
            "push" =>  $this->requestUser->id,
        ])->push(
            [
                "title" => trans("icredit::credits.title.WithdrawalFundsRequestWasRejacted"),
                "message" => trans("icredit::credits.messages.WithdrawalFundsRequestWasRejacted",["requestableId" => $this->requestable->id,"emailTo" => join($emailTo,",")]),
                "icon_class" => "fa fa-bell",
              "setting" => [
                "saveInDatabase" => true
              ]

            ]
        );
    }
}
