<?php

/*
|--------------------------------------------------------------------------
| Administration Configuration
|--------------------------------------------------------------------------
|
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Application Title
    |--------------------------------------------------------------------------
    |
    | Sets the meta title for the application
    |
    */

    'title' => 'Fantasy Golf Insiders',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Sets the logo on top left side of application
    |
    */

    'logo_url' => '/images/fgi_logo.png',

    /*
    |--------------------------------------------------------------------------
    | Styles
    |--------------------------------------------------------------------------
    |
    | Allows user to extend styles by including their own
    | We recommend using Elixir for cache busting
    |
    */

    'styles' => [
        elixir('css/app.css'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Scripts
    |--------------------------------------------------------------------------
    |
    | Allows user to extend scripts by including their own
    |
    */

    'scripts' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Application Users
    |--------------------------------------------------------------------------
    |
    | Defines the base URI (eg. http://localhost/admin)
    |
    */

    'base_uri' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Application Users
    |--------------------------------------------------------------------------
    |
    | Defines the views path if the user chooses to place into a subdirectory
    |
    */

    'views_path' => '',

    /*
    |--------------------------------------------------------------------------
    |
    |--------------------------------------------------------------------------
    |
    | Sets the default controller when accessing the base route
    | Eg. \App\Http\Controllers\UsersController@listAllUsers
    |
    */

    'default_controller_route' => '\App\Http\Controllers\Admin\PlayersController@index',

    /*
    |--------------------------------------------------------------------------
    |
    |--------------------------------------------------------------------------
    |
    | Tells all the created routes to use authentication
    | Boolean value, default true
    |
    */

    'enable_auth_middleware' => false,

    /*
    |--------------------------------------------------------------------------
    |
    |--------------------------------------------------------------------------
    |
    | Define all toolbar buttons (If Any)
    | Array of strings.
    | eg.
    |    "Welcome username!",
    |    "<a href='/your/logout/route'>Logout</a>"
    |
    */

    'toolbar_buttons' => [],

    /*
    |--------------------------------------------------------------------------
    | Application Users
    |--------------------------------------------------------------------------
    |
    | Register all the controllers for the application
    |
    */

    'controllers' => [
        \App\Http\Controllers\Admin\PostsController::class,
        \App\Http\Controllers\Admin\PagesController::class,
        \App\Http\Controllers\Admin\ContactsController::class,
        \App\Http\Controllers\Admin\PlayersController::class,
        \App\Http\Controllers\Admin\UsersController::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Users
    |--------------------------------------------------------------------------
    |
    | Set which controllers belong in the navigation bar
    | Be sure to set the controller properties title and optional icon (FontAwesome)
    |
    */

    'navigation_controllers' => [
//        \App\Http\Controllers\Admin\PagesController::class,
//        \App\Http\Controllers\Admin\PostsController::class,
//        \App\Http\Controllers\Admin\UsersController::class,
        \App\Http\Controllers\Admin\PlayersController::class,
//        \App\Http\Controllers\Admin\ContactsController::class
    ],

];