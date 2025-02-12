$(document).ready(function(){
    const homeUrl = () => {
        const protocol = window.location.protocol;
        const hostname = window.location.hostname;
        const port = window.location.port;
        const homeUrl = port ? `${protocol}//${hostname}:${port}/` : `${protocol}//${hostname}/`;
        return homeUrl
    }
    $("#login").on("submit",function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "../api/login.api.php",
            data: $(this).serialize(),
            beforeSend: function(){
                $("#loginBtn").attr("disabled", "");
                $("#loginBtn").html("processing..");
            },
            success: function (response) {
                var response = JSON.parse(response);
                $(".input-div input").css("border-color","#f1f1f1");
                $("#login-error-response").html("");
                if(response.status==1){
                    $("#login-response").html(
                        '<div id="success-response" style="margin-top: 9px; padding: 6px; font-size: 15px; align-items:center;" class="alert alert-success" role="alert">'+
                            '<svg class="bi flex-shrink-0 me-2" width="24" height="18" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>'+
                            '<div>'+response.msg+'</div>'+
                        '</div>'
                    );
                    const redirectUrl = `${homeUrl()}user/${response.body}`;
                    location.href = redirectUrl
                }else{
                    $(".input-div input").css("border-color","red")
                    $("#login-response").html(
                        '<div id="error-response" style="margin-top: 9px; padding: 6px; font-size: 15px; align-items:center;" class="alert alert-danger" role="alert">'+
                            '<svg class="bi flex-shrink-0 me-2" width="24" height="18" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>'+
                            '<div>'+response.body+'</div>'+
                        '</div>'
                    );
                }
            },
            complete: function(){
                $("#loginBtn").removeAttr("disabled");
                $("#loginBtn").html("Login");
            }
        });
    })
})