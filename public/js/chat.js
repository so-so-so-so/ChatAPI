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
          var html = `
          <div class="media left comment-visible mb-2">
              <div class="media-body class${data.chats[i].value} comment-body ">
              <img class="icon${data.chats[i].value}" src="image/icon${data.chats[i].value}.png">
              <p id="Chat${data.chats[i].value}">${data.chats[i].message}</p>
              <label>${data.chats[i].created_at}</label>
              </div>
          </div>
          `;
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
  $("#comment-data")
        .find(".comment-visible");
          var html = `
          <div class="media left comment-visible mb-2">
              <div class="media-body class${data.value} comment-body ">
              <img class="icon${data.value}" src="image/icon${data.value}.png">
              <p id="Chat${data.value}">${data.message}</p>
              <label>${data.created_at}</label>
              </div>
      </div>
    `;
    $("#comment-data").append(html);
    $('#comment-data').animate({ scrollTop: $('#comment-data')[0].scrollHeight});
}

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
});
//csv処理
$('#csv').click(function(event) {
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
});