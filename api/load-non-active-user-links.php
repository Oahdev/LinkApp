<?php

$uid = (DB::query("SELECT id FROM linkrs WHERE uname = :uname",array(":uname"=>$username)))[0]["id"];
$user_data = DB::query("SELECT link_id,link_title,link_address FROM links WHERE user_id = :uid ORDER BY date DESC",array(":uid"=>$uid));
$links = "";
foreach ($user_data as $key => $value) {
    $links .= "
    <li class='link'>
        <div id='inner-container'>
            <a href='".$value["link_address"]."'><p style='width: 100%;'>".$value["link_title"]."</p></a>
        </div>
    </li>";
}
echo $links;

?>