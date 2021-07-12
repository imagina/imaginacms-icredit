<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/amount','middleware' => ['auth:api']], function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->get('/list', [
        'as' => $locale . 'api.icredit.credits.amount',
        'uses' => 'CreditApiController@amount',
    ]);

});
