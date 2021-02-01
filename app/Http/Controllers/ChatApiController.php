<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;

class ChatApiController extends Controller
{
  //
  public function post(Request $request)
  {
    //DB登録処理
    $parmas = Chat::create([
      'message' => $request['message'],
      'value' => $request['value'],
    ]);
    //api処理
    $api = "https://api.a3rt.recruit-tech.co.jp/talk/v1/smalltalk";
    $key = "DZZtwdcJVT9TTp1WlnDajtu8pfuV90cO";

    $data = [
      'apikey' => $key,
      'query' => $request->message,
    ];
    //test
    //curl開始
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $api);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $responseJsonStr = curl_exec($curl);

    curl_close($curl);
    //curl終了
    $result = json_decode($responseJsonStr, true);
    return $result['results'];
  }

  public function  getChat()
  {
    $chats = Chat::orderBy('created_at', 'desc')->get();
    $json = ["chats" => $chats];
    return response()->json($json);
  }
}
