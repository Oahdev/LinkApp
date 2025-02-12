<link rel="stylesheet" href="/style/user.css">
<?php 
$user_details = DB::query("SELECT profile_image,bio FROM linkrs WHERE uname = :uname",array(":uname"=>$username));
$profile_image = $user_details[0]["profile_image"];
$user_bio = $user_details[0]["bio"];
?>
<style>
    li #inner-container:hover{
        background-color: var(--primary-color);
        transition: .4s;
    }
</style>
<body>
    <div class="nav-options">
        <div class="dropdown">
            <div class="menuBtn" id="menuBtn">
                <div id="line"></div>
                <div id="line"></div>
                <div id="line"></div>
            </div>
            <div id="navAccountDrop">
                <a href="../">Login</a>
                <a href="../register">Register</a>
            </div>
        </div>
    </div>
    <div class="user-container">
        <div class="user-info">
            <img src="../img/<?php echo $profile_image;?>">
            <p class="user-uname"><?php echo $username;?></p>
        </div>
        <div id="user-info_bio" style="margin-bottom: 27px;">
            <p style="color: var(--primary-color);text-align: center;margin: auto;margin-top: 18px;"><?php echo $user_bio;?></p>
        </div>
        <div class="user-address">
            <ul class="user-list">
                <?php require "./api/load-non-active-user-links.php"?>
            </ul>
        </div>
    </div>
</body>
<script>
    $(document).on("click","#menuBtn",function(){
        $("#navAccountDrop").slideToggle();
    })
</script>
