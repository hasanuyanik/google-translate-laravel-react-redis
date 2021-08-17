<?php


use Google\Cloud\Translate\V2\TranslateClient;
use Illuminate\Support\Facades\Route;
use Stichoza\GoogleTranslate\GoogleTranslate;
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

