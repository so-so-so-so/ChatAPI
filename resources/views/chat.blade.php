<!DOCTYPE html>
<html lang="ja">

<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <title>Document</title>
</head>

<body>
  <!-- 表示エリア -->
  <div class="card mx-auto  mt-5" style="width: 900px; ">
    <div class="card-header">
      TalkAPIと会話する
    </div>
    <div class="card-body">
      <div id="comment-data"></div>
    </div>
  </div>
  <!-- 送信エリア -->
  <div class="form">
    <input id="message" name="message" type="text" placeholder="文章を書いてください">
    <input id="value" name="value" type="hidden" value="1">
    <input class="btn btn-outline-success" id="button" type="button" value="送信" style="height: 70px; width:195px; ">
    <!-- 削除 -->
    <input class="btn btn-outline-success" id="delete" type="button" value="削除" style="height: 70px; width:195px; ">
    <!-- csv出力 -->
    <input class="btn btn-outline-success mt-1" id="csv" type="button" value="csv出力" style="height: 70px; width:900px; ">
  </div>
  <!-- ログイン -->
  <script src="{{ asset('/js/chat.js') }}">
  </script>
</body>

</html>