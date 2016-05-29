$().ready(function() {
  $("#login-form").submit(function(event) {
      $("#login-error").hide();
      var data = $("#login-form").serialize();
      $.post("index.php?route=user/user/login", data, function(data) {
        if (data == 1) {
          location.href = "/";
        } else {
          $("#login-error").text("Не правильный логин или пароль.").show();
        }
      });
      event.preventDefault();
  });
  
  $("#admin-logout").bind("click", function() {
    $.post("index.php?route=user/user/logout", function() { location.href = "/" });
  });

  var img;

  function onFileReaded(e) {
    var data = $("#send-review").serialize();
    data += "&image=";
    if (e) {
      img =  e.target.result;
    }
    $.post("index.php?route=common/home/preview", data, function(data) {
      $("#preview-container").html(data);
      if (img) {
        $("#preview-container img").attr("src", img);
      } else {
        $("#preview-container img").hide();
      }
    });
  }

  $("#preview-button").bind("click", function(event) {
    img = false;
    event.preventDefault();
    var input = document.getElementById("image");
    if (input && input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = onFileReaded;
      reader.readAsDataURL(input.files[0]);
    } else {
      onFileReaded();     
    }
  });

  $(".admin-review-accept").bind("click", function() {
      $.post("index.php?route=common/review/accept", {"id":$(this).attr("review-id")}, function() { location.href = "/" });
  });

  $(".admin-review-decline").bind("click", function() {
      $.post("index.php?route=common/review/decline", {"id":$(this).attr("review-id")}, function() { location.href = "/" });
  });

  $(".admin-review-edit").bind("click", function() {
      $.post("index.php?route=common/review/get", {"id":$(this).attr("review-id")}, function(data) {
        console.log(data);
        $("#image-row").hide();
        $("#username").val(data['add_name']);
        $("#email").val(data['add_email']);
        $("#text").val(data['comment']);
        var hidden_id = $("<input>");
        hidden_id.attr("type", "hidden").attr("name", "id").val(data["id"]);
        $("#send-review").append(hidden_id)
        location.href="#edit-form";
      });
  });
});