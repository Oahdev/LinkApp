<?php
require "../controller/config.php";
session_start();
$response = [];
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_SESSION["uid"])){
        $uid = $_SESSION["uid"];
        $check_uid = DB::query("SELECT id FROM linkrs WHERE id = :uid",array(":uid"=>$uid));
        if($check_uid){
            $user_data = DB::query("SELECT link_id,link_title,link_address FROM links WHERE user_id = :uid ORDER BY date DESC",array(":uid"=>$uid));
            $links = "";
            foreach ($user_data as $key => $value) {
                $links .= "
                <li class='link' id='".$value["link_id"]."'>
                    <div id='inner-container'>
                        <span onclick=edit_link('".$value["link_id"]."')><img id='editBtn' src='../img/edit-icon.svg'></span><a href='".$value["link_address"]."'><p>".$value["link_title"]."</p></a><span id='deleteBtn' onclick=delete_link('".$value["link_id"]."')><img id='editBtn' src='../img/delete-icon.png'></span>
                    </div>
                </li>
                ";
            }
                
            $response["status"] = true;
            $response["body"] = $links;
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