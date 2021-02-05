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
    //keyとAPIに送るテキストを配列に格納
    $data = [
      'apikey' => $key,
      'query' => $request->message,
    ];
    //curl開始
    $curl = curl_init();
    //curl設定
    curl_setopt($curl, CURLOPT_URL, $api);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    //実行処理
    $responseExe = curl_exec($curl);
    //curl終了
    curl_close($curl);
    //jsonコードのデコード
    $result = json_decode($responseExe, true);
    //result内のメッセージの取得
    $apiMessage = $result['results'][0];
    $apiParmas = Chat::create([
      'message' => $apiMessage['reply'],
      'value' => 2,
    ]);
    //jsの処理のため二つ返す
    return [$parmas, $apiParmas];
  }
  //取得処理
  public function  getChat()
  {
    $chats = Chat::orderBy('created_at', 'asc')->get();
    //json形式で返す
    $json = ["chats" => $chats];
    return response()->json($json);
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
    //csv設定
    $response = new StreamedResponse(function () {
      //table内の取得
      $tables = Chat::all();
      //ヘッダー設定
      $head = ['id', 'チャットメッセージ', '判別値', '作成日', '更新日'];
      //入出力ストリームの設定
      $stream = fopen('php://output', 'w');
      //ヘッダーの書き込み
      fputcsv($stream, $head);
      //table内の書き込み
      foreach ($tables as $table) {
        fputcsv($stream, [$table->id, $table->message, $table->value, $table->created_at, $table->updated_at]);
      };
      //書き込み終了
      fclose($stream);
    });
    //csv出力処理
    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename="DB出力.csv"');
    return $response;
  }
}
