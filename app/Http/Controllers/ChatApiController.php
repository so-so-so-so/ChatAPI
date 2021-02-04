<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;
use App\Events\chatEvent;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
    // return  $parmas;
    //api処理
    $api = "https://api.a3rt.recruit-tech.co.jp/talk/v1/smalltalk";
    $key = "DZZtwdcJVT9TTp1WlnDajtu8pfuV90cO";

    $data = [
      'apikey' => $key,
      'query' => $request->message,
    ];
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
    $apiMessage = $result['results'][0];
    $apiParmas = Chat::create([
      'message' => $apiMessage['reply'],
      'value' => 2,
    ]);
    return [$parmas, $apiParmas];
  }
  //取得処理
  public function  getChat()
  {
    $chats = Chat::orderBy('created_at', 'asc')->get();
    $json = ["chats" => $chats];
    return response()->json($json);
    // return $chats;
  }
  //削除処理
  public function delete()
  {
    Chat::orderBy('created_at', 'desc')->delete();
    $mess = "削除完了";
    return $mess;
  }
  //ファイル出力
  public  function  dlCSV(Request $request)
  {
    $response = new StreamedResponse(function () use ($request) {
      $tables = Chat::all();
      $head = ['id', 'チャットメッセージ', '判別値', '作成日', '更新日'];
      $stream = fopen('php://output', 'w');

      // stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');
      fputcsv($stream, $head);
      foreach ($tables as $table) {
        fputcsv($stream, [$table->id, $table->message, $table->value, $table->created_at, $table->updated_at]);
      };
      fclose($stream);
    });
    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename="DB出力.csv"');
    return $response;
  }
}
