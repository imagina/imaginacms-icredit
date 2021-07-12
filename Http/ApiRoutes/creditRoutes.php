<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/credits','middleware' => ['auth:api']], function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => $locale . 'api.icredit.credits.create',
        'uses' => 'CreditApiController@create',
    ]);
    $router->get('/', [
        'as' => $locale . 'api.icredit.credits.index',
        'uses' => 'CreditApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => $locale . 'api.icredit.credits.update',
        'uses' => 'CreditApiController@update',
    ]);
    $router->delete('/{criteria}', [
        'as' => $locale . 'api.icredit.credits.delete',
        'uses' => 'CreditApiController@delete',
    ]);
    $router->get('/{criteria}', [
        'as' => $locale . 'api.icredit.credits.show',
        'uses' => 'CreditApiController@show',
    ]);


});
