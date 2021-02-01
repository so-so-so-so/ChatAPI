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
  <form method="post" action="/post">
    <input id="message" name="message" type="text">
    <input id="value" name="value" type="hidden" value="1">
    <input id="button" type="button" value="送信">
  </form>
  <script type="text/javascript">
    //取得処理
    $(function() {
      getChat();
    });

    function getChat() {
      $.ajax({
        url: "getChat",
        dataType: "json",
        success: data => {
          $("#comment-data")
            .find(".comment-visible")
            .remove();

          for (var i = 0; i < data.chats.length; i++) {
            if (data.chats[i].value == "1") {
              var html = `
              <div class="media comment-visible">
              <p id="userChat">${data.chats[i].message}</p>
              </div>`;
              $("#comment-data").append(html);
            } else if (data.chats[i].value == "2") {
              var html = `<div class="media comment-visible">
              <p id="apiChat">${data.chats[i].message}</p>
              </div>`;
              $("#comment-data").append(html);
            }
          }
        },
        error: () => {
          alert("ajax Error");
        }
      });
      setTimeout("getChat()", 1000);
    }
    //送信処理
    $('#button').click(function(event) {
      var message = $('input[name="message"]').val();
      var value = $('input[name="value"]').val();
      var data = {
        'message': message,
        'value': value
      };
      console.log(data);
      //ajax設定
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      //ajax処理
      $.ajax({
        url: 'post',
        type: 'POST',
        dataType: "json",
        data: data,
      }).done(function(results) {
        //通信が成功したときの処理
        console.log(results);
      }).fail(function(jqXHR, textStatus, errorThrown) {
        //通信が失敗したときの処理
        $('#error_message').empty();

        var text = $.parseJSON(jqXHR.responseText);
        var errors = text.errors;
        for (key in errors) {
          var errorMessage = errors[key][0];
          $('#error_message').append(`<li>${errorMessage}</li>`);
        }
      });
    });
  </script>
</body>

</html>