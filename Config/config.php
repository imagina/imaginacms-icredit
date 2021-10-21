<?php

return [
  'name' => 'Icredit',
    'paymentName' => 'icredit',
  
  /*-----------------------------------------------------------------------------------------------------------------
  /* Status config description
   * 1 => pending
   * 2 => available
   * 3 => canceled / by default for all another order status
   *///---------------------------------------------------------------------------------------------------------------
  'orderStatusSync' => [
    1 => 1,
    2 => 1,
    4 => 2,
    13 => 1
  ],
  
  /*
|--------------------------------------------------------------------------
| Requestable config
|--------------------------------------------------------------------------
*/
  "requestable" => [
    
    [
      "useDefaultStatuses" => true,
      
      'deleteWhenStatus' => [
        1 => false,
        2 => true,
        3 => false,
        4 => true
      ],
      
      "type" => "withdrawalFunds",
      "title" => " Withdrawal Funds",
      
      'defaultStatus' => 1,
      
      "events" => [
        "create" => "Modules\\Icredit\\Events\\WithdrawalFundsRequestWasCreated",
        //"update" => "Modules\\Iteam\\Events\\JoinToTeamRequestWasUpdated",
        //"delete" => "Modules\\Fhia\\Events\\InspectionRequestWasDeleted",
      ],
      
      "statusEvents" => [
        2 => "Modules\\Icredit\\Events\\WithdrawalFundsRequestWasAcepted",
        3 => "Modules\\Icredit\\Events\\WithdrawalFundsRequestWasRejected",
      ],
      
      // Time elapsed to cancel in days
      "timeElapsedToCancel" => 30,
      
      // "etaEvent" => "Modules\\Iteam\\Events\\JoinToTeamRequestWasAccepted",
      
      "rquestableId" => [
        'value' => '',
        "label" => "Credit",
        'type' => 'number',
        'loadEntity' => [
          'apiRoute' => 'api.icredit.credits',
        ]
      ],
      "requestableType" => "Modules\\Icredit\\Entities\\Credit",
      "formId" => "icredit::icreditFormicreditWithdrawalFundsForm",
      
      
      "forms" => [
        "main" => [
          "name" => "main",
          "label" => "General Info",
          "fields" => [
            "amount" => [
              'value' => null,
              'type' => 'input',
              'props' => [
                'type' => 'number',
                'label' => 'Amount',
              
              ],
            ],
          ]
        ],
      
      
      ]
    ]
  
  
  ]

];
