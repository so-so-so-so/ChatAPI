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
          <div class="media left comment-visible mb-2">
              <div class="media-body user comment-body ">
              <img class="usericon" src="image/icon.png">
              <p id="userChat">${data.chats[i].message}</p>
              <label>${data.chats[i].created_at}</label>
              </div>
          </div>
          `;
          $("#comment-data").append(html);
        } else if (data.chats[i].value == "2") {
          var html = `
          <div class="media right comment-visible mb-2">
              <div class="media-body api comment-body">
              <img class="apiicon" src="image/api_icon.png">
              <p id="apiChat">${data.chats[i].message}</p>
              <label>${data.chats[i].created_at}</label>
              </div>
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
  // window.Echo.channel("charming-bed-688").listen("PusherEvent", e => {
  //   getChat()
  // });
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