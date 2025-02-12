<?php
require "controller/config.php";
session_start();
$uname = (DB::query("SELECT uname FROM linkrs WHERE id = :uid",array(":uid"=>$_SESSION["uid"])))[0]["uname"];
unset($_SESSION["linkAppToken"]);
unset($_SESSION["uid"]);
setcookie("linkAppToken",false,time()-3600,"/");
header("location: ./user/$uname");

?>