<?php

return [
    'list resource' => 'Lista creditos',
    'create resource' => 'Crear creditos',
    'edit resource' => 'Editar creditos',
    'destroy resource' => 'Eliminar creditos',
    'title' => [
        'credits' => 'Créditos',
        'create credit' => 'Crear un credito',
        'edit credit' => 'Editar un credito',
        "WithdrawalFundsRequestWasCreated" => "Tiene un nueva solicitud de retiro de fondos",
        "WithdrawalFundsRequestWasAcepted" => "Su solicitud para retirar fondos ha sido aprobada",
        "WithdrawalFundsRequestWasRejacted" => "Su solicitud para retirar fondos ha sido rechazada",
    ],
    'description' => "",
    'button' => [
        'create credit' => 'Crear un credito',
    ],
    'table' => [
    ],
    'form' => [
    ],
    'messages' => [
        "WithdrawalFundsRequestWasCreated" => "Tiene una nueva solicitud de retiro de fondos por parte de cliente :requestUserName identificado con cedula numero :requestableId, por un valor de :requestAmount",
        "WithdrawalFundsRequestWasAcepted" => "Su solicitud de retiro de fondos #:requestableId ha sido aprobada, ¡Qué bien!",
        "WithdrawalFundsRequestWasAceptedWithETA" => "Su solicitud de retiro de fondos #:requestableId ha sido aprobada, y lo tendrás disponible para la fecha :requestableETA, ¡Qué bien!",
        "WithdrawalFundsRequestWasRejacted" => "Su solicitud para retirar fondos #:requestableId, ha sido rechazada para mayor informaccion comunicarce al :emailTo",
    ],
    'validation' => [
    ],
    'descriptions' => [
        "orderWasCreated" => "Credito aplicado por la orden #:orderId",
        "WithdrawalFundsRequestWasEffected" => "Retiro efectivo aplicado por la solicitud #:requestableId"
    ]
];
