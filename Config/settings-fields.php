<?php

return [

  
  'icreditWithdrawalFundsForm' => [
    "onlySuperAdmin" => true,
    'name' => 'icredit::icreditFormicreditWithdrawalFundsForm',
    'value' => [],
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.qform.forms',
      'select' => ['label' => 'title', 'id' => 'id'],
    ],
    'props' => [
      'label' => 'icredit::credits.settings.icreditWithdrawalFundsForm',
      'multiple' => false,
      'clearable' => true,
    ],
  ],
];
