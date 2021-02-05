## chatsApiController 記述

`````chatsApiController.php
//取得処理
public function getChat()
{
  $chats = Chat::orderBy('created_at', 'asc')->get();
  //json形式で返す $json = ["chats" => $chats];
  return response()->json($json);
  }
```

## Model でのキャスト

````Model
class Chat extends Model {
  protected $fillable = [ 'message', 'value', ];
  protected $casts = [
  'birthday' => 'date:Y-m-d',
  'joined_at' => 'datetime:Y-m-d H:00',
  'created_at' => 'datetime:Y/m/d H:i:s', ];
 }
`````

## app.php の timezone

`'timezone' => 'Asia/Tokyo',`

## DB 内の受け取り

![](https://i.gyazo.com/4f57858ec0e155525a2c288b22bf2491.png)

## chats.js の受け取り方

```chats.js
$.ajax({
  url: "getChat",
  dataType: "json",
  success: data => {
  以下略
```

## 原因だと思うこと/メモ

-   受け取った時点で UTC になっている(\$chats = Chat::orderBy('created_at', 'asc')->get();)
-   json での受け取りが原因か
-   ajax の受け取り方を datatype:json から type:get にしても変わらず UTC
-   同じ症状(https://teratail.com/questions/301738)
