<?php

require "../controller/config.php";

$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(
        isset($_POST["email"]) &&
        !empty($_POST["issue"])
    ){
        $issue = $_POST["issue"];
        $email = $_POST["email"];
        DB::query("INSERT INTO issues(
            email,
            issue,
            date_created
        ) 
        VALUES(
            :email,
            :issue,
            NOW()
        )",
        array(
            ":email"=>$email,
            ":issue"=>$issue
        ));
        $response["status"] = true;
        $response["body"] = "Thanks!! We will work on it.";
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