<?php
session_start();
if(isset($_GET["name"])){
    $username = $_GET["name"];
    $page_title = $username;
    require "./header.php";
    require "./controller/config.php";
    //check if username exists
    if(DB::query("SELECT uname FROM linkrs WHERE uname = :uname",array(":uname"=>$username))){
        //check if an active cookie is set
        if(isset($_COOKIE["linkAppToken"])){
            $token = substr_replace($_COOKIE["linkAppToken"], '', 26, 1);
            @$check_token_uname = (DB::query("SELECT uname FROM linkrs WHERE session_token = :sess_token",array(":sess_token"=>$token)))[0]["uname"];
            if(@$check_token_uname == $username){
                $_SESSION["uid"] = (DB::query("SELECT id FROM linkrs WHERE uname = :uname",array(":uname"=>$username)))[0]["id"];
                require("./active-user.php");
            }else{
                require("./non-active-user.php");
            }
        }
        //check if an active session is set
        if(isset($_SESSION["linkAppToken"])){
            $token = substr_replace($_SESSION["linkAppToken"], '', 26, 1);
            @$check_token_uname = (DB::query("SELECT uname FROM linkrs WHERE session_token = :sess_token",array(":sess_token"=>$token)))[0]["uname"];
            if(@$check_token_uname == $username){
                $_SESSION["uid"] = (DB::query("SELECT id FROM linkrs WHERE uname = :uname",array(":uname"=>$username)))[0]["id"];
                require("./active-user.php");
            }else{
                require("./non-active-user.php");
            }
        }
        //check if *no* active cookie or session is set
        if(!(isset($_SESSION["linkAppToken"])) && !(isset($_COOKIE["linkAppToken"]))){
            require("./non-active-user.php");
        }

    }else{
        require("./user-not-found.php");
    }
}else{
    header("location: ./");
}

require "./footer.php";
?>