<?php

namespace App\Http\Controllers;

use Google\Cloud\Translate\V2\TranslateClient;
use GrahamCampbell\Throttle\Facades\Throttle;
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
            'targetText' => 'required|string|min:1',
            'resultLanguage' => 'required|string'
        ]);

        if ( $validator->fails() ) {
            Log::error('API request validation failed.', [
                'request' => $request->all(),
                'errors' => $validator->errors()
            ]);

            return Response::json($validator->errors(),400);
        }

        if($request->targetLanguage == $request->resultLanguage){
            Log::info("Translate - Exception: Aynı dilde çeviri talebi!!!");

            $response = ["message"=>"Aynı dilde çeviri yapılamaz"];

            return Response::json($response,400);
        }

        if($request->targetLanguage != 0){

            $targetLang = $request->targetLanguage;

        }

        $text = $request->targetText;

        $resultLang = $request->resultLanguage;

        $sourceTextArray = $targetLang.":".$text.":".$resultLang;

        if(Redis::keys($sourceTextArray)) {

            $dataArray = Redis::get($sourceTextArray);

            $response = [
                "targetText" => $text,
                "targetLanguage" => $targetLang,
                "resultText" => $dataArray,
                "resultLanguage" => $resultLang
            ];

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

            return Response::json($response,400);
        }

        $targetLang = $resultText['source'];

        $resultTxt = $resultText["text"];

        $sourceTextArray = $targetLang.":".$text.":".$resultLang;

        Redis::set($sourceTextArray,$resultTxt);

        $response = [
            "targetText" => $text,
            "targetLanguage" => $targetLang,
            "resultText" => $resultTxt,
            "resultLanguage" => $resultLang,
            "source" => $resultText
        ];

        return Response::json($response);

    }

    public function language(){

        $translate = new TranslateClient(['key'=>'AIzaSyAwbHYRc1LF8flQ3CfvL5RHhcvGTswXZa0']);

        return Response::json($translate->localizedLanguages());

    }

}
