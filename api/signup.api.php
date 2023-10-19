<?php
require "../controller/config.php";
$response = [];
$status = false;
$marker = [];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(
        isset($_POST["username"]) &&
        isset($_POST["email"]) &&
        isset($_POST["newPassword"]) &&
        isset($_POST["conPassword"])
    ){
        $token = password_hash(str_shuffle("8b-S+5hrQ8Nq5v\F24mGFRyxCx#h"),PASSWORD_DEFAULT);
        $uname = $_POST["username"];
        $email = $_POST["email"];
        $newPwd = $_POST["newPassword"];
        $conPwd = $_POST["conPassword"];
        if(!(DB::query("SELECT uname FROM linkrs WHERE uname = :uname",array(":uname"=>$uname)))){
            @$uname_token = $token; 
        }else{
            array_push($response,"<b>$uname</b> is already registered");
            array_push($marker,"username");
        }
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            if(!(DB::query("SELECT email FROM linkrs WHERE email = :email",array(":email"=>$email)))){
                @$email_token = $token;
            }else{
                array_push($response,"<b>$email</b> is already registered");
                array_push($marker,"email");
            }
        }else{
            array_push($response,"<b>$email</b> is not valid email");
            array_push($marker,"email");
        }
        if(strlen($newPwd) >= 8){
            if($newPwd === $conPwd){
                @$pwd_token = $token;
                $newPwd = password_hash($newPwd,PASSWORD_DEFAULT);
            }else{
                array_push($response,"password mismatch");
                array_push($marker,"conPassword");
            }
        }else{
            array_push($response,"8 characters minimum");
            array_push($marker,"newPassword");
        }


        
        if((@$uname_token && @$email_token && @$pwd_token) == $token){
            $uname = str_replace("<","",$uname);
            $uname = str_replace(">","",$uname);
            $uname = str_replace("/","",$uname);
            $uname = str_replace("\\","",$uname);
	        $uname = str_replace(" ","",$uname); 
            DB::query("INSERT INTO linkrs(session_token,uname,email,pwd,profile_image,bio,date) VALUES(
                :session_token,
                :uname,
                :email,
                :pwd,
                :profile_image,
                '',
                NOW()
            )",array(
                ":session_token"=>$token,
                ":uname"=>$uname,
                ":email"=>$email,
                ":pwd"=>$newPwd,
                ":profile_image"=>"person-circle.svg",  
            ));
            $status = true;
            array_push($response,"Account created successfully");
            $num = rand(0,9);
            $new_token = substr($token,0,26).$num.substr($token,26);
            setcookie("linkAppToken",$new_token,time()+3600*24*30,"/");
        }
    }else{
        $status = false;
        array_push($response,"required field missing");
    }
}else{
    $status = false;
    array_push($response,"invalid request");
}

$response = [$status,$response,$marker,$uname];
echo json_encode($response);

?>