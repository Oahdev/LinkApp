<?php

require "../controller/config.php";
$response = [];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(
        isset($_POST["login_name"]) &&
        isset($_POST["login_password"])
    ){
        $token = password_hash("h#xCxyRFGm42F\v5qN8Qrh5+S-b8",PASSWORD_DEFAULT);
        $login_name = $_POST["login_name"];
        $login_pwd = $_POST["login_password"];

        @$check_db_uname_uname = (DB::query("SELECT uname FROM linkrs WHERE uname = :uname",array(":uname"=>$login_name)))[0]["uname"];
        @$check_db_pwd_uname = (DB::query("SELECT pwd FROM linkrs WHERE uname = :uname",array(":uname"=>$login_name)))[0]["pwd"];

        @$check_db_uname_email = (DB::query("SELECT email FROM linkrs WHERE email = :email",array(":email"=>$login_name)))[0]["email"];
        @$check_db_pwd_email = (DB::query("SELECT pwd FROM linkrs WHERE email = :email",array(":email"=>$login_name)))[0]["pwd"];

        if($check_db_uname_email == $login_name || $check_db_uname_uname == $login_name){
            @$check_login_name_token = $token;
        }
        if(password_verify($login_pwd,$check_db_pwd_email) || password_verify($login_pwd,$check_db_pwd_uname)){
            @$check_login_pwd_token = $token;
        }

        if(@$check_login_name_token && @$check_login_pwd_token == $token){
            $response["status"] = true;
            $user_session_token = (DB::query("SELECT session_token FROM linkrs WHERE uname = :uname OR email = :email",array(":uname"=>$login_name,":email"=>$login_name)))[0]["session_token"];
            $username = (DB::query("SELECT uname FROM linkrs WHERE session_token = :ss_token",array(":ss_token"=>$user_session_token)))[0]["uname"];
            session_start();
            $num = rand(0,9);
            $new_token = substr($user_session_token,0,26).$num.substr($user_session_token,26);
            if(isset($_POST["remember_me_option"])){
                setcookie("linkAppToken",$new_token,time()+3600*24*30,"/");
                unset($_SESSION["linkAppToken"]);
            }else{
                setcookie("linkAppToken",false,time()-3600,"/");
                $_SESSION["linkAppToken"] = $new_token;
            }
            $response["body"] = $username;
            $response["msg"] = "login successful";
        }else{
            $response["body"] = "invalid details";
        }

    }else{
        $response["body"] = "required field is missing";
    }
}else{
    $response["body"] = "invalid request";
}

echo json_encode($response);

?>