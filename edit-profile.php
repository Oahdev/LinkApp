<?php
session_start();
require "./controller/config.php";
if(isset($_SESSION["uid"])){
    $uid = $_SESSION["uid"];
    $check_uid = DB::query("SELECT id FROM linkrs WHERE id = :uid",array(":uid"=>$uid));
    if($check_uid){
        $user_data = DB::query("SELECT * FROM linkrs WHERE id = :uid",array(":uid"=>$uid));
        $page_title = "Edit ".$user_data[0]["uname"];
    }else{
        header("location: ./");
    }
}else{
    header("location: ./");
}
require "./header.php";
?>

<link rel="stylesheet" href="/style/edit-profile.css">
<body>
    <div class="container">
    <!-- <iframe width="480" height="360" src="https://www.youtube.com/embed/A185HevwQV0" title="Semena" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> -->
        <div id="edit_back">
           <a id="edit_back_button" class="backBtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                </svg>
           </a>
        </div> 
        <form method="POST" enctype="multipart/form-data" id="editProfileForm">
            <h1>Edit Profile</h1>
            <div class="input-div">
                <label for="Img-Preview" style="margin-bottom: 9px;width: 50%;text-align: start;">Profile Picture</label><br>
                <div id="Img-Preview">
                    <img id="edit-preview-image" src="./img/<?php echo $user_data[0]["profile_image"]?>" alt="user-image"><br>
                    <label for="pImage">
                        <img id="edit-profile-image-pen" src="./img/pen.png" alt="edit-profile-image"><br>
                    </label><br>
                    <input id="pImage" type="file" name="new_image" accept="image/png, image/jpg, image/jpeg" hidden><br>
                    <p id="pImage-response"></p>
                </div>
            </div>
            <div class="input-div">
                <label for="uname">Username</label><br>
                <input type="text" id="uname" name="username" value="<?php echo $user_data[0]["uname"];?>" required><br>
                <p id="uname-response"></p>
            </div>
            <div class="input-div">
                <label for="new_user_bio">Bio</label><br><br>
                <textarea name="new_user_bio" id="new-user-bio" cols="50" rows="3"><?php echo $user_data[0]["bio"];?></textarea><br>
                <p id="new-user-bio-response"></p>
            </div>
            <div class="input-div">
                <h2 id="openPwdBtn">Change Password &blacktriangledown;</h2>
                <div id="password_change">
                    <input type="password" id="currentPwd" name="current_pwd" placeholder="Current Password"><br>
                    <p id="currentPwd-response"></p>
                    <input type="password" id="newPwd" name="new_pwd" placeholder="New Password"><br>
                    <p id="newPwd-response"></p>
                    <input type="password" id="conNewPwd" name="con_new_pwd" placeholder="Confirm New Password"><br>
                    <p id="conNewPwd-response"></p>
                </div>
            </div>
            <br><br><button type="submit" id="editBtn">save</button>
        </form>
        <div id="response">

        </div>
    </div>
</body>
<?php 
require "./footer.php";
?>
<script src="./js/edit-profile.js"></script>
