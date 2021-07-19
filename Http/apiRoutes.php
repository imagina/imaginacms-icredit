<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/icredit/v1'/*,'middleware' => ['auth:api']*/], function (Router $router) {
    //======  CATEGORIES
    require('ApiRoutes/creditRoutes.php');

    //======  AMOUNTS
    require('ApiRoutes/amountRoutes.php');

    //======  PaymentMethod
    require('ApiRoutes/paymentRoutes.php');


});