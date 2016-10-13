<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('test2', function(){
    echo "<iframe style='width:1100px;height:400px;border:solid 1px #000;' src='http://fantasygolf.dev/lineup-generator'></iframe>";
});

Route::group(['prefix' => 'lineup-generator'], function() {

    Route::get('/', ['uses' => 'LineUpController@index']);
    Route::post('/generate', ['uses' => 'LineUpController@generate']);
    Route::get('/players', ['uses' => 'LineUpController@players']);
    Route::get('/export', ['uses' => 'LineUpController@export']);

});

/*

Route::get('/', 'HomeController@index');

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

//Route::get('/home', 'HomeController@index');
Route::get('confirmation', 'HomeController@confirmation');
Route::any('/select-plan', 'UserController@selectPlan');

Route::group(['prefix' => 'article'], function() {
    Route::get('{slug}', ['uses' => 'PageController@getArticle']);
});

Route::any('/ownership-percentage-predictions', ['uses' => 'PageController@ownershipPercentagePredictions']);
Route::get('/contact-us', ['uses' => 'PageController@contactUs']);
Route::post('/contact-us' , ['uses' => 'PageController@submitContactUs']);
Route::get('/columns/{section}', ['uses' => 'PageController@getColumns']);

Route::get('/p/{page}', ['uses' => 'PageController@getPage']);

//--- Test Routes ---\\
//region <--- View

Route::group(['prefix' => 'test'], function() {

    Route::get('cointent', function() {
        $cointent = App::make('Cointent');

//        dd($cointent->lookUpPrice(6279)); //Works
//        dd($cointent->checkUnlockStatus(6173, "dalton@activelogiclabs.com")); //Works
//        dd($cointent->createUser("dalton11@email.com")); //Works
//        dd($cointent->getUserPasscode('dalton2@email.com')); //Works
//        dd($cointent->getUserLinkToken('dalton@activelogiclabs.com')); //No Access
//        dd($cointent->grantUserSubscription("dalton@activelogiclabs.com", 4, 6));
//        dd($cointent->cancelUserSubscription('dalton@activelogiclabs.com', 4));
//        dd($cointent->cutoffUserSubscription("dalton@activelogiclabs.com", 4));

        $user = \App\User::find(1);
        dd($user->load('plan'));

    });

    Route::any('avg', function() {
        $player = \App\Player::first();

        dd($player->combined_prediction);
    });

    Route::any('excel',  function() {
        return view('page-template');
    });

    Route::any('db', ['uses' => 'HomeController@testDb']);

});


//Route::get('images/{filepath?}', function(\Illuminate\Http\Request $request, $filename) {
//    dd($request);
//    $path = storage_path() . '/app/public/uploads/' . $filename;
//
//    if(!\Illuminate\Support\Facades\File::exists($path)) abort(404);
//
//    $url = \Illuminate\Support\Facades\Storage::url($filename);
//    $filecontents = \Illuminate\Support\Facades\Storage::get("public/uploads/$filename");
//
//    $file = \Illuminate\Support\Facades\File::get($path);
//    $type = \Illuminate\Support\Facades\File::mimeType($path);
//
//    $response = \Illuminate\Support\Facades\Response::make($file, 200);
//    $response->header("Content-Type", $type);
//
//    return $response;
//});

Route::get('images/{filepath?}', ['uses' => 'PageController@images'])->where('filepath', '.*');

//endregion

*/