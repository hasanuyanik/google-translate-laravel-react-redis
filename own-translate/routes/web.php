<?php


use Google\Cloud\Translate\V2\TranslateClient;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $translate = new TranslateClient(['key'=>'AIzaSyAwbHYRc1LF8flQ3CfvL5RHhcvGTswXZa0']);

    echo 'Ne Yapıyorsun:';
    print_r($translate->detectLanguage('Ne yapıyorsun'));
    echo '<br>';
    print_r($translate->languages());
    echo '<br>';
    print_r($translate->localizedLanguages());
    echo '<br>';

    return view('welcome');
});

Route::get('/cache', function () {
    $cacheData = Redis::keys('dataArray:*');
    dd(Redis::keys('*'));
    return Response::json($cacheData);
});

Route::get('/session', function () {
    $SsAll = Session::all();
    return $SsAll;
});

Route::get('/translate',[\App\Http\Controllers\TranslateController::class,'translatePage'])->name('translate');
