<?php

require "../controller/config.php";
$response = [];
$image_folder = "../img/";
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $uid = $_SESSION["uid"];
    // $uid = "1";
    $check_uid = DB::query("SELECT id FROM linkrs WHERE id = :uid",array(":uid"=>$uid));
    if($check_uid){
        if($_FILES["new_image"]["error"] == 0){
            $new_image_name = $_FILES["new_image"]["name"];
            $new_image_tmp = $_FILES["new_image"]["tmp_name"];
            $new_image_size =$_FILES["new_image"]["size"];
            $new_file_type = explode("/",$_FILES["new_image"]["type"])[0];
            $new_image_type = explode("/",$_FILES["new_image"]["type"])[1];
            if($new_file_type == "image"){
                if($new_image_type == "jpeg" || $new_image_type == "jpg" || $new_image_type == "png"){
                    if ($new_image_size <= 2048000){
                        $new_image_name = "profile_image_".date("dmYhis").$uid.".png";
                        move_uploaded_file($new_image_tmp,$image_folder.$new_image_name);
                        DB::query("UPDATE linkrs SET profile_image = :new_profile_image WHERE id = :id",array(":new_profile_image"=>$new_image_name,":id"=>$uid));
                        $response["status"] = true;
                        $response["body"] = ["Profile image updated successfully",$new_image_name];
                    }else{
                        $response["status"] = false;
                        $response["body"] = "Image must be less than 2MB";
                    }  
                }else{
                    $response["status"] = false;
                    $response["body"] = "Choose a jpg,png or jpeg image";
                }
            }else{
                $response["status"] = false;
                $response["body"] = "Choose an image";
            }
        }else{
            $response["status"] = false;
            $response["body"] = "User not found";
        }
    }

}

echo json_encode($response);