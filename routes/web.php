<?php

$router->get('/', function () {
    return response()->json([
        'msg' => 'Welcome to Zomato Restaurant API Service',
   ]);
});

// $router->get('/', 'RestaurantController@index');


$router->group(
    [
        'prefix' => '/api/restaurants',
        'middleware' => ['auth', 'restaurant_validation'],
    ],
    function () use ($router) {
        $router->get('/', 'RestaurantController@index');
        $router->get('/{restaurant_id}', 'RestaurantController@show');
        $router->post('/', 'RestaurantController@store');
        $router->put('/{restaurant_id}', 'RestaurantController@update');
        $router->delete('/{restaurant_id}', 'RestaurantController@destroy');
    }
);


$router->group(
    [
        'prefix' => 'api/dishes',
        'middleware' => 'dish_validation',
    ],
    function () use ($router) {
        $router->get('/', 'DishController@index');
        $router->get('/{dish_id}', 'DishController@show');
        $router->post('/', 'DishController@store');
        $router->put('/{dish_id}', 'DishController@update');
        $router->delete('/{dish_id}', 'DishController@destroy');
    }
);

// Get all dishes of a restaurant
$router->get('/api/restaurants/{restaurant_id}/dishes', 'DishController@getDishesByRestaurantId');

// Auth
$router->post('/api/auth/login', 'AuthController@login');
$router->post('/api/auth/register', 'AuthController@register');
$router->get('/api/auth/me', 'AuthController@me');
