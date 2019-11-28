<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Str;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//Login
$router->post(
    'auth/login',
    [
       'uses' => 'AuthController@authenticate'
    ]
);

// Generate Key
$router->post('key', function(){
    return Str::random(32);
});

// Estimate
$router->group(['middleware' => 'jwt.auth'], function($app)
{

    // Get All Accommodation
    $app->get('accommodation/getAllAccommodation', 'AccommodationController@getAllAccommodation');

    // Get Single Accommodation
    $app->get('accommodation/getSingleAccommodation', 'AccommodationController@getSingleAccommodation');

    // Update Accommodation
    $app->put('accommodation/updateAccommodation', 'AccommodationController@updateAccommodation');

    // Delete Accommodation
    $app->delete('accommodation/deleteAccommodation', 'AccommodationController@deleteAccommodation');

    // Filter Accommodation
    $app->post('accommodation/filterAccommodation', 'AccommodationController@filterAccommodation');

    // Permission for role
    $app->group(['middleware' => 'admin'], function ($app) {
         // Create Accommodation
        $app->post('accommodation/createAccommodation', 'AccommodationController@createAccommodation');
    });

});
