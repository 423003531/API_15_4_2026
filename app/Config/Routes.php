<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', function() {
    return service('response')->setJSON([
        'message' => 'Welcome to the Cat API!',
        'endpoints' => [
            'GET /api/v1/cats' => 'List all cats',
            'POST /api/v1/cats' => 'Add a new cat'
        ]
    ]);
});


$routes->group('api/v1', ['filter' => 'cat_admin'], function ($routes) {
    $routes->resource('cats', ['controller' => 'Api\CatsController']);

    $routes->put('cats', function() {
        return service('response')->setStatusCode(404)->setJSON([
            'status'  => 'error',
            'message' => 'API function does not exist. Please provide a Pusakat ID in the URL (e.g., /api/v1/cats/CAT-001).'
        ]);
    });
    $routes->delete('cats', function() {
        return service('response')->setStatusCode(404)->setJSON([
            'status'  => 'error',
            'message' => 'API function does not exist. Please provide a Pusakat ID in the URL (e.g., /api/v1/cats/CAT-001).'
        ]);
    });
});
