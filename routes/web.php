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

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->get('/', function () use ($router) {
        return $router->app->version();
    });

    $router->group(['prefix' => 'users', 'middleware' => 'auth',], function () use ($router) {
        $router->get('/', 'UserController@getAllUsers');
        $router->post('/', 'UserController@create');
    
        $router->group(['prefix' => '{encodedUserId}'], function () use ($router) {
            $router->get('/', 'UserController@getUserById');
            $router->put('/', 'UserController@update');
            $router->delete('/', 'UserController@delete');
            $router->put('/activate', 'UserController@changeActivateStatus');
            $router->put('/block', 'UserController@changeBlockStatus');
    
            $router->group(['prefix' => '{encodedGroupId}'], function () use ($router) {
                $router->post('/', 'UserController@addToGroup');
                $router->delete('/', 'UserController@removeFromGroup');
            });
        });
    });
    
    $router->group(['prefix' => 'account'], function () use ($router) {
        $router->post('/register', 'AuthController@register');
        $router->post('/login', 'AuthController@login');
        
        $router->get('/', [
            'middleware' => 'auth',
            'uses' => 'AuthController@getDetails',
        ]);

        $router->delete('/logout', [
            'middleware' => 'auth',
            'uses' => 'AuthController@logout',
        ]);
    });
    
    $router->group(['prefix' => 'permissions', 'middleware' => 'auth'], function () use ($router) {
        $router->get('/', 'PermisionController@getAllPermissions');
    });
    
    $router->group(['prefix' => 'groups', 'middleware' => 'auth'], function () use ($router) {
        $router->get('/', 'GroupController@getAllGroups');
        $router->post('/', 'GroupController@create');
    
        $router->group(['prefix' => '{encodedGroupId}'], function () use ($router) {
            $router->get('/', 'GroupController@getById');
            $router->put('/', 'GroupController@update');
            $router->delete('/', 'GroupController@delete');
            $router->post('/permissions', 'GroupController@syncPermissions');
        });
    });
});