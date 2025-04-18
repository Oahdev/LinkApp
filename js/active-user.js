function load_active_user_links() {
    
    $.ajax({
        type: "GET",
        url: "../api/load-active-user-links.php",
        success: function(response) {
            try {
                // Parse the response only if it's a string (for safety)
                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }

                // Handle the response based on status
                if (response.status == 1) {
                    $(".user-list").html(response.body);
                } else {
                    $(".user-list").html(response.body);
                }

            } catch (e) {
                console.error('Error parsing response:', e);
            }
        },
        error: function(err) {
            console.error('AJAX Error:', err);
            // You might want to show a message to the user in case of an error.
            $(".user-list").html('<div class="error">Failed to load user links. Please try again later.</div>');
        }
    });
}

const homeUrl = () => {
    const protocol = window.location.protocol;
    const hostname = window.location.hostname;
    const port = window.location.port;
    const homeUrl = port ? `${protocol}//${hostname}:${port}/` : `${protocol}//${hostname}/`;
    return homeUrl
}

$(document).on("click",".copy-url-btn",function(){
    let thisUser = $(this).data('username');
    let userUrl = `${homeUrl()}user/${thisUser}`;
    console.log(userUrl);
    navigator.clipboard.writeText(userUrl);

    $(this).text("copied!");
    const self = $(this);
    setTimeout(() => {
        self.text('copy profile url');
    }, 2000);

})


function delete_link(val){
    $.ajax({
        type: "POST",
        url: "../api/delete-link.api.php",
        data: {link_id: val},
        success: function (response) {
            var response = JSON.parse(response);
            if(response.status == 1){
                load_active_user_links();
                $("#add-link-response").html(
                    '<div id="success-response" style="margin-top: 9px; padding: 6px; font-size: 15px; align-items:center;" class="alert alert-success" role="alert">'+
                        '<svg class="bi flex-shrink-0 me-2" width="24" height="18" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>'+
                        '<div>'+response.body+'</div>'+
                    '</div>'
                ).fadeIn(400).fadeOut(2000);
            }else{
                $("#add-link-response").html(
                    '<div id="error-response" style="margin-top: 9px; padding: 6px; font-size: 15px; align-items:center;" class="alert alert-danger" role="alert">'+
                        '<svg class="bi flex-shrink-0 me-2" width="24" height="18" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>'+
                        '<div>'+response.body+'</div>'+
                    '</div>'
                ).fadeIn(400).fadeOut(2000);
            }
        }
    });
}

$(document).on("click","#menuBtn",function(){
    $("#navAccountDrop").slideToggle();
})
$(document).on("click","#logout_button",function(){
    $("#logout_option").slideToggle();
})

function edit_link(val){
    $("#link_header").val($("#"+val+" a p").html());
    $("#link_address").val($("#"+val+" a").attr("href"));
    document.getElementById("Er").setAttribute("value",parseInt(val));
    $("#cancel-edit-button").css({display:"block"});
    $("#add_link_button").html("edit");
}

$("document").ready(function(){
    load_active_user_links();
    
    $("#cancel-edit-button").click(function(){
        $("#link_header").val("");
        $("#link_address").val("");
        $("#Er").attr("value","");
        $("#cancel-edit-button").css({display:"none"});
        $("#add_link_button").html("add");
    });

    $("#addLinkForm").on("submit",function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "../api/add-link.api.php",
            data: $(this).serialize(),
            beforeSend: function(){
                $("#add_link_button").attr("disabled", "");
                $("#cancel-edit-button").attr("disabled", "");
            },
            success: function (response) {
                var response = JSON.parse(response);
                if(response.status==1){
                    load_active_user_links();
                    $("#add-link-response").html(
                        '<div id="success-response" style="margin-top: 9px; padding: 6px; font-size: 15px; align-items:center;" class="alert alert-success" role="alert">'+
                            '<svg class="bi flex-shrink-0 me-2" width="24" height="18" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>'+
                            '<div>'+response.body+'</div>'+
                        '</div>'
                    ).fadeIn(400).fadeOut(2000);

                    $("#link_header").val("");
                    $("#link_address").val("");
                    $("#cancel-edit-button").css({display:"none"});
                    $("#add_link_button").html("add");
                    $("#Er").attr("value","");
                }else{
                    $("#add-link-response").html(
                        '<div id="error-response" style="margin-top: 9px; padding: 6px; font-size: 15px; align-items:center;" class="alert alert-danger" role="alert">'+
                            '<svg class="bi flex-shrink-0 me-2" width="24" height="18" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>'+
                            '<div>'+response.body+'</div>'+
                        '</div>'
                    ).fadeIn(400).fadeOut(2000);
                }
            },
            complete: function(){
                $("#add_link_button").removeAttr("disabled");
                $("#cancel-edit-button").removeAttr("disabled");
            },
            error: function(err){
                console.error(err);
            }
        });
    })


})