<?php

require "../controller/config.php";
$response = [];
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(
        isset($_POST["link_id"]) &&
        isset($_SESSION["uid"])
    ){
        $uid = $_SESSION["uid"];
        $link_id = $_POST["link_id"];
        $check_uid = DB::query("SELECT id FROM linkrs WHERE id = :uid",array(":uid"=>$uid));
        $check_link_id = DB::query("SELECT link_id FROM links WHERE link_id = :link_id AND user_id = :user_id",array(":user_id"=>$uid,":link_id"=>$link_id));
        if($check_uid){
            if($check_link_id){
                DB::query("DELETE FROM links WHERE link_id = :link_id AND user_id = :user_id",array(":user_id"=>$uid,":link_id"=>$link_id));
                $response["status"] = true;
                $response["body"] = "link deleted successfully";
            }else{
                $response["status"] = false;
                $response["body"] = "link does not exist";
            }
        }else{
            $response["status"] = false;
            $response["body"] = "user does not exist";
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