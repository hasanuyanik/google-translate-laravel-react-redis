<?php

namespace App\Http\Controllers;

use Google\Cloud\Translate\V2\TranslateClient;
use GuzzleHttp\Cookie\SessionCookieJar;
use GuzzleHttp\Cookie\SetCookie;
use http\Cookie;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TranslateController extends Controller
{

    public function translate(Request $request){
        $targetLang = null;
        $validator = Validator::make($request->all(), [
            'targetLanguage' => 'required',
            'text' => 'required|string|min:1',
            'resultLanguage' => 'required|string'
        ]);

        if ( $validator->fails() ) {
            Log::error('API request validation failed.', [
                'request' => $request->all(),
                'errors' => $validator->errors()
            ]);

            return Response::json($validator->errors());
        }

        if($request->targetLanguage == $request->resultLanguage){
            Log::info("Translate - Exception: Aynı dilde çeviri talebi!!!");

            $response = ["message"=>"Aynı dilde çeviri yapılamaz"];

            return Response::json($response);
        }

        if($request->targetLanguage != 0){
            $targetLang = $request->targetLanguage;
        }
        $text = $request->text;
        $resultLang = $request->resultLanguage;

        $sourceTextArray = $targetLang.":".$text.":".$resultLang;

        if(Redis::keys($sourceTextArray)) {

            $dataArray = Redis::get($sourceTextArray);

            $response = ["resultText" => $dataArray];

            return Response::json($response);

        }

        $translate = new TranslateClient(['key'=>'AIzaSyAwbHYRc1LF8flQ3CfvL5RHhcvGTswXZa0']);

        $trOption = ($targetLang) ? [
            "source" => $targetLang,
            "target" => $resultLang
        ] : [
            "target" => $resultLang
        ];

        try{
            $resultText = $translate->translate($text,$trOption);
        }catch (\Exception $exception){

            Log::info("Translate - Exception:".$exception);

            $response = ["message"=>"Çeviri Yapılamadı!"];

            return Response::json($response);
        }

        $targetLang = ($targetLang) ? $targetLang: $resultText['source'];

        $resultTxt = $resultText["text"];

        $sourceTextArray = $targetLang.":".$text.":".$resultLang;

        Redis::set($sourceTextArray,$resultTxt);

        $response = ["resultText" => $resultTxt];

        return Response::json($response);



    }

    public function translate2(Request $request){

        $translate = new TranslateClient(['key'=>'AIzaSyAwbHYRc1LF8flQ3CfvL5RHhcvGTswXZa0']);

        $validator = Validator::make($request->all(), [
            'text' => 'required|string|min:1',
            'targetLanguage' => 'required|string'
        ]);

        if ( $validator->fails() ) {
            Log::error('API request validation failed.', [
                'request' => $request->all(),
                'errors' => $validator->errors()
            ]);

            return Response::json($validator->errors());
        }

        $text = $request->text;
        $resultLang = $request->targetLanguage;

        $trOption = [
            "target" => $resultLang
        ];

        $resultText = $translate->translate($text,$trOption);
        $targetLang = $resultText['source'];

        $resultTxt = $resultText["text"];

        $translateArray = [
            "targetText" => $text,
            "targetLang" => $targetLang,
            "resultLang" => $resultLang,
            "resultText" => $resultTxt
        ];

        $keyArray = [
            "targetText" => $text,
            "resultLang" => $resultLang
        ];

        $keyText = $targetLang.":".$text.":".$resultLang;

        $resultArray = [
            "resultText" => $resultTxt
        ];

        if(Session::has($keyArray)){
            return Response::json($resultArray);
        }

        Session::put($keyText,$translateArray);

//        print_r(Session::all());


        return Response::json($resultArray);

    }


    public function language(){

        $translate = new TranslateClient(['key'=>'AIzaSyAwbHYRc1LF8flQ3CfvL5RHhcvGTswXZa0']);

        return Response::json($translate->localizedLanguages());



    }

}
