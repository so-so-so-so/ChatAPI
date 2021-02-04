 //初期処理
 $(function() {
  getChat();
});
//関数
//取得処理
function getChat() {
  $.ajax({
    url: "getChat",
    dataType: "json",
    success: data => {
      //成功時htmlの追加
      $("#comment-data")
        .find(".comment-visible")
        .remove();
      for (var i = 0; i < data.chats.length; i++) {
        if(data.chats[i].value==1){
          var html = `
          <div class="media left comment-visible mb-2">
              <div class="media-body class${data.chats[i].value} comment-body ">
              <img class="icon${data.chats[i].value}" src="image/icon${data.chats[i].value}.png">
              <p class="Chat${data.chats[i].value}" id="text${data.chats[i].id}">${data.chats[i].message}
              </p>
              <label>${data.chats[i].created_at}</label>
              </div>
          </div>
          `;
        }
        else{
          var html = `
          <div class="media left comment-visible mb-2">
              <div class="media-body class${data.chats[i].value} comment-body ">
              <img class="icon${data.chats[i].value}" src="image/icon${data.chats[i].value}.png">
              <p class="Chat${data.chats[i].value}" id="text${data.chats[i].id}">${data.chats[i].message}
              <input class="soundButton" id="${data.chats[i].id}" type="button" value="▶︎">
              </p>
              <label>${data.chats[i].created_at}</label>
              </div>
          </div>
          `;
        }
          $("#comment-data").append(html);
      }
    },
    error: () => {
      alert("ajax Error");
    }
  });
  // setTimeout("getChat()", 1000);
}
//チャット追加処理
function addChat(data){
  console.log(data.value)
  //送ったチャットを表示させる
  $("#comment-data")
        .find(".comment-visible");
        if(data.value==2){
          var html = `
          <div class="media left comment-visible mb-2">
              <div class="media-body class${data.value} comment-body ">
              <img class="icon${data.value}" src="image/icon${data.value}.png">
              <p class="Chat${data.value}" id="text${data.id}">${data.message}
              <input class="soundButton" id="${data.id}" type="button" value="▶︎">
              </p>
              <label>${data.created_at}</label>
              </div>
      </div>
    `;
    }
    else{
      var html = `
          <div class="media left comment-visible mb-2">
              <div class="media-body class${data.value} comment-body ">
              <img class="icon${data.value}" src="image/icon${data.value}.png">
              <p class="Chat${data.value}" id="text${data.id}">${data.message}
              </p>
              <label>${data.created_at}</label>
              </div>
      </div>
    `;
    }
    $("#comment-data").append(html);
    //投稿したときスクロール位置を変える
    $('#comment-data').animate({ scrollTop: $('#comment-data')[0].scrollHeight});
}
//csv 
function getCsv(){
//ajax設定
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
//ajax処理
$.ajax({
  url: 'dlCSV',
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
}
function reset(){
  //ajax設定
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  //ajax処理
  $.ajax({
    url: 'delete',
    type: 'POST',
  }).done(function(results) {
    //通信が成功したときの処理
    console.log(results);
    getChat();
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
}
//オンクリック処理
//送信処理
$('#button').click(function(event) {
  var message = $('input[name="message"]').val();
  var value = $('input[name="value"]').val();
  var data = {
    'message': message,
    'value': value
  };
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
    for(var i = 0; i < results.length; i++){
      addChat(results[i]);
    }
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

//リセット処理
$('#delete').click(function(event) {
  reset();
});
//csv処理
$('#csv').click(function(event) {
    getCsv();
});

//テキスト読み上げ
$(document).on('click', '.soundButton', function(){
  var id = $(this).attr('id');
  console.log("text"+id);
  var speech = document.querySelector('#text'+id);
  var text = speech.textContent;
  var msg = new SpeechSynthesisUtterance();
  msg.text = text;
  msg.lang = 'ja-JP';
  window.speechSynthesis.speak(msg);
});
//ログイン
$('#login').click(function(event) {
  var email = $('input[name="email"]').val();
  var password = $('input[name="password"]').val();
  var data = {
    'email': email,
    'password': password
  };
  //ajax設定
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  //ajax処理
  $.ajax({
    url: 'login',
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
//登録
$('#regist').click(function(event) {
  var email = $('input[name="email"]').val();
  var password = $('input[name="password"]').val();
  var data = {
    'name': email,
    'password': password
  };
  //ajax設定
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  //ajax処理
  $.ajax({
    url: 'register',
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