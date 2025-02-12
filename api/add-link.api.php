<?php

require "../controller/config.php";
$response = [];
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(
        !(empty($_POST["link_header"])) &&
        !(empty($_POST["link_address"])) &&
        isset($_SESSION["uid"])
    ){
        $uid = $_SESSION["uid"];
        $link_title = $_POST["link_header"];
        $link_adrs = $_POST["link_address"];
        if(!str_contains(substr($link_adrs,0,8),"https://") && !str_contains(substr($link_adrs,0,8),"http://")){
            $link_adrs = "https://".$link_adrs;
        }
        $check_uid = DB::query("SELECT id FROM linkrs WHERE id = :uid",array(":uid"=>$uid));
        if($check_uid){
            $check_link = DB::query("SELECT link_title,link_address FROM links WHERE 
            link_title = :link_title AND 
            link_address = :link_address AND 
            user_id = :user_id
            ",array(
                ":user_id"=>$uid,
                ":link_title"=>$link_title,
                ":link_address"=>$link_adrs
            ));
            if(!$check_link){
                #check for edit
                if($_POST["editRow"] > 0){
                    $edit_row = $_POST["editRow"];
                    $check_row = DB::query("SELECT link_id FROM links WHERE link_id = :link_id AND user_id = :user_id",array(":link_id"=>$edit_row,":user_id"=>$uid));
                    if($check_row){
                        DB::query("UPDATE links SET 
                            link_title = :link_title,
                            link_address = :link_address
                            WHERE user_id = :user_id AND link_id = :link_id
                        ",array(
                            ":user_id"=>$uid,
                            ":link_id"=>$edit_row,
                            ":link_title"=>$link_title,
                            ":link_address"=>$link_adrs,
                        ));
                        $response["status"] = true;
                        $response["body"] = "link edited successfully";
                    }else{
                        $response["status"] = false;
                        $response["body"] = "link not found";
                    }
                }else{
                    DB::query("INSERT INTO links(
                        user_id,
                        link_title,
                        link_address,
                        date_created
                    ) VALUES(
                        :user_id,
                        :link_title,
                        :link_address,
                        NOW()
                    )",array(
                        ":user_id"=>$uid,
                        ":link_title"=>$link_title,
                        ":link_address"=>$link_adrs
                    ));
                    $response["status"] = true;
                    $response["body"] = "link added successfully";
                }
            }else{
                $response["status"] = false;
                $response["body"] = "link already exists";
            }
        }else{
            $response["status"] = false;
            $response["body"] = "user not found";
        }
    }else{
        $response["status"] = false;
        $response["body"] = "required field missing";
    }
}else{
    $response["status"] = false;
    $response["body"] = "invalid request method";
}

echo json_encode($response);
?>