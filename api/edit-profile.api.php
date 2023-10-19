<?php

require "../controller/config.php";
$response = [];
$marker = [];
$status = [];
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(
        isset($_POST["username"]) &&
        isset($_POST["new_user_bio"]) &&
        isset($_POST["current_pwd"]) &&
        isset($_POST["new_pwd"]) &&
        isset($_POST["con_new_pwd"]) &&
        // isset($_FILES["new_image"]) &&
        isset($_SESSION["uid"])
    ){
        // $image_folder = "./img/";
        $uid = $_SESSION["uid"];
        // $uid = "1";
        $check_uid = DB::query("SELECT id FROM linkrs WHERE id = :uid",array(":uid"=>$uid));
        if($check_uid){

            //saving bio
            $new_bio = $_POST["new_user_bio"];
            $new_bio_length = count(explode(" ",$new_bio));
            $db_user_bio = (DB::query("SELECT bio FROM linkrs WHERE id = :uid",array(":uid"=>$uid)))[0]["bio"];
            if($new_bio != $db_user_bio){
                if($new_bio_length <= 50){
                    DB::query("UPDATE linkrs SET bio = :bio WHERE id = :uid",array(":uid"=>$uid,":bio"=>$new_bio));
                    array_push($response,"bio updated successfully");
                    array_push($marker,"new-user-bio");
                    array_push($status,true);
                }else{
                    array_push($response,"Bio too long, remove ".($new_bio_length - 50)." word(s)");
                    array_push($marker,"new-user-bio");
                    array_push($status,false);
                }
            }

                
            //saving username
            $new_uname = $_POST["username"];
            $db_uname = (DB::query("SELECT uname FROM linkrs WHERE id = :uid",array(":uid"=>$uid)))[0]["uname"];
            $new_uname = str_replace("<","",$new_uname);
            $new_uname = str_replace(">","",$new_uname);
            $new_uname = str_replace("/","",$new_uname);
            $new_uname = str_replace("\\","",$new_uname);
	        $new_uname = str_replace(" ","",$new_uname); 
            if($db_uname != $new_uname){
                if(!(DB::query("SELECT uname FROM linkrs WHERE uname = :uname",array(":uname"=>$new_uname)))){
                    DB::query("UPDATE linkrs SET uname = :uname WHERE id = :uid",array(":uid"=>$uid,":uname"=>$new_uname));
                    array_push($response,"username updated successfully");
                    array_push($marker,"uname");
                    array_push($status,true);
                }else{
                    array_push($response,"<b>$new_uname</b> already exist");
                    array_push($marker,"uname");
                    array_push($status,false);
                }
            }


            //saving password
            if($_POST["current_pwd"] != ""){
                $current_password = $_POST["current_pwd"];
                $db_pwd = (DB::query("SELECT pwd FROM linkrs WHERE id = :uid",array(":uid"=>$uid)))[0]["pwd"];
                if(password_verify($current_password,$db_pwd)){
                    if($_POST["new_pwd"] != ""){
                        $new_password = $_POST["new_pwd"];
                        $confirm_new_password = $_POST["con_new_pwd"];
                        if(strlen($new_password) >= 8 ){
                            if($new_password == $_POST["con_new_pwd"]){
                                $new_password = password_hash($new_password,PASSWORD_DEFAULT);
                                DB::query("UPDATE linkrs SET pwd = :pwd WHERE id = :uid",array(":uid"=>$uid,":pwd"=>$new_password));
                                array_push($response,"password updated successfully");
                                array_push($marker,"currentPwd");
                                array_push($status,true);
                            }else{
                                array_push($response,"password mismatch");
                                array_push($marker,"conNewPwd");
                                array_push($status,false);
                            }
                        }else{
                            array_push($response,"8 characters minimum");
                            array_push($marker,"newPwd");
                            array_push($status,false);
                        }
                    }
                }else{
                    array_push($response,"incorrect password");
                    array_push($marker,"currentPwd");
                    array_push($status,false);
                }
            }

        }else{
            array_push($response,"user not found");
        }
    }else{
        array_push($response,"required field missing");
    }
}else{
    array_push($response,"invalid request method");
}

$response = [$response,$marker,$status];
echo json_encode($response);

?>