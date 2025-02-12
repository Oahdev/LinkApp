$(document).ready(function(){
    const homeUrl = () => {
        const protocol = window.location.protocol;
        const hostname = window.location.hostname;
        const port = window.location.port;
        const homeUrl = port ? `${protocol}//${hostname}:${port}/` : `${protocol}//${hostname}/`;
        return homeUrl
    }

    $("#register").on("submit",function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "./api/signup.api.php",
            data: $(this).serialize(),
            beforeSend: function(){
                $("#signupBtn").html("processing..");
                $("#signupBtn").attr("disabled", "");
            },
            success: function (response) {
                var response = JSON.parse(response);
                $(".input-div input").css("border-color","#f1f1f1");
                $("div p").html("");
                for(var i in response[2]){
                    $("#"+response[2][i]).css("border-color","red");
                    $("#"+response[2][i]+"-error").html(response[1][i]);
                };
                if(response[0]==1){
                    $("#register-response").html(
                        '<div id="success-response" style="margin-top: 9px; padding: 6px; font-size: 15px; align-items:center;" class="alert alert-success" role="alert">'+
                            '<svg class="bi flex-shrink-0 me-2" width="24" height="18" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>'+
                            '<div>'+response[1]+'</div>'+
                        '</div>'
                    );
                    const redirectUrl = `${homeUrl()}user/${response[3]}`;
                    location.href = redirectUrl;                    
                }
            },
            complete: function(){
                $("#signupBtn").html("Create account");
                $("#signupBtn").removeAttr("disabled");
            }
        });
    });
});