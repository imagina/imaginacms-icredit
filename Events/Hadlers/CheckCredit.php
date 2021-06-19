<?php

namespace Modules\Icredit\Events\Handlers;

use Illuminate\Contracts\Mail\Mailer;
use Modules\Icredit\Repositories\CreditRepository;
use Modules\User\Entities\Sentinel\User;
use Modules\Notification\Services\Notification;

class CheckCredit
{

    public $creditRepository;
    public function __construct(CreditRepository $creditRepository)
    {
        $this->creditRepository = $creditRepository;

    }


    public function handle($event)
    {
        try {
            // Credit status config
            $orderStatusSync = config("asgard.icredit.config.orderStatusSync");

            // Icommerce order entity
            $order = $event->order;
            $items = $event->items;

            // finding credit object
            $params = ["filter" => ["field" => "related_id", "relatedType" => "Modules\Icommerce\Entities\Order"]];
            $credit = $this->creditRepository->getItem(json_decode(json_encode($params)));

            //if exist credit would be updated
            if(isset($credit->id)){

                // updating credit object
                $this->creditRepository->updateBy($credit->id, [
                    "amount" => $order->total,
                    "status" => $orderStatusSync[$order->status_id] ?? 3,
                ]);

            }else{//else credit would be created

                // creating credit object
                $this->creditRepository->create([
                    "amount" => $order->total,
                    "status" => $orderStatusSync[$order->status_id] ?? 3,
                    "related_id" => $order->id,
                    "related_type" => "Modules\Icommerce\Entities\Order",
                    "customer_id" => $order->store->user_id,
                    "description" => trans("icredit::credits.descriptions.orderWasCreated",["orderId" => $order->id]),
                ]);

            }

        } catch (\Exception $e) {
            \Log::error("Error | SendOrder Event: " . $e->getMessage() . "\n" . $e->getFile() . "\n" . $e->getLine() . $e->getTraceAsString());

        }

    }


}