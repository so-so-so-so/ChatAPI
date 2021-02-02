<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <title>Document</title>
</head>

<body>
  <!-- 表示エリア -->
  <div id="comment-data"></div>
  <!-- 送信エリア -->
  <input id="message" name="message" type="text">
  <input id="value" name="value" type="hidden" value="1">
  <input id="button" type="button" value="送信">
  <!-- 削除 -->
  <input id="delete" type="button" value="削除">
  <script src="{{ asset('/js/chat.js') }}">
  </script>
</body>

</html>