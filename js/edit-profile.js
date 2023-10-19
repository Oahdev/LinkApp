$(".backBtn").on("click",function(){
    var uname = $("#uname").val();
    location.href = "https://oah-linkapp.000webhostapp.com/user/"+uname;
});
$("#openPwdBtn").on("click",function(){
    $("#password_change").slideToggle();
});
$("document").ready(function(){
    $("#pImage").change(function(e){
        e.preventDefault();
        var cvImg = $('#pImage')[0].files;
        if (cvImg.length > 0) {
            var fd = new FormData();
            fd.append('new_image', cvImg[0]);
            $.ajax({
                url: "./api/edit-profile-photo.api.php",
                type: "POST",
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function(){
                    $("#pImage-response").html("processing...");
                    $("#pImage-response").css("color","green");
                },
                success: function(response) {
                    if(response.status==1){
                        $("#pImage-response").html(response.body[0]).fadeIn(400).fadeOut(3000);
                        $("#pImage-response").css("color","green");
                        $("#pImage").css("border-color","green");
                        $("#edit-preview-image").attr("src","https://oah-linkapp.000webhostapp.com/img/"+response.body[1]);
                    }else{
                        $("#pImage-response").html(response.body).fadeIn(400).fadeOut(3000);
                        $("#pImage-response").css("color","red");
                        $("#pImage").css("border-color","red");
                    }
                    
                }
            });

        }

    });
    $("#editProfileForm").on("submit",function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "./api/edit-profile.api.php",
            data: $(this).serialize(),
            beforeSend: function(){
                $("#editBtn").attr("disabled", "");
                $("#editBtn").html("processing...");
            },
            success: function (response) {
                var response = JSON.parse(response);
                $(".input-div input , textarea").css("border-color","#202020");
                $("div p").html("");
                for(var i in response[1]){
                    if(response[2][i] == 1){
                        $("#"+response[1][i]).css("border-color","green");
                        $("#"+response[1][i]+"-response").css("color","green");
                        $("#"+response[1][i]+"-response").html(response[0][i]).fadeIn(400).fadeOut(3000);
                    }else{
                        $("#"+response[1][i]).css("border-color","red");
                        $("#"+response[1][i]+"-response").html(response[0][i]);
                    }
                }
            },
            complete: function(){
                $("#editBtn").removeAttr("disabled");
                $("#editBtn").html("Save");
            }
        });
    });
});