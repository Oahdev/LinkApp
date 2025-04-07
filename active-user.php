<link rel="stylesheet" href="/style/user.css">
<?php 
$user_details = DB::query("SELECT profile_image,bio FROM linkrs WHERE uname = :uname",array(":uname"=>$username));
$profile_image = $user_details[0]["profile_image"];
$user_bio = $user_details[0]["bio"];

?>
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
                <a href="../register">Create Account</a>
                <button id="logout_button">Logout</button>
                <div id="logout_option">
                    <p>Are you sure?</p>
                    <form method="post" action="../logout.php" enctype="multipart/form-data" id="logoutBtn">
                        <button type="submit" id="logout_option_button">Yes</button>
                    </form>
                    <button id="logout_option_button">No</button>
                </div>
            </div>
        </div>
    </div>
    <div class="user-container">
        <div class="user-info">
            <div>
                <img src="../img/<?php echo $profile_image;?>">
            </div>
            <div>
                <p class="user-uname"><?php echo $username;?></p>
            </div>
            <div id="user-info_bio">
                <p style="color: var(--primary-color);"><?php echo $user_bio;?></p>
            </div>
            <div id="top_options">
                <button class="copy-url-btn" title="Copy url to clipboard" data-username="<?php echo $username;?>">
                    copy profile url
                </button>
                <a href="../edit-profile" id="edit_profile_button">edit profile</a>
            </div>
        </div>
        <div class="add-link">
            <form method="POST" enctype="multipart/form-data" id="addLinkForm">
                <div>
                    <input type="text" id="link_header" name="link_header" required pattern=".{1,100}" placeholder="link header   *my example link">
                    <input type="text" id="link_address" name="link_address" required placeholder="link address  https://@example.com" title=" *This is the link you want to access">
                    <input type="number" name="editRow" id="Er" value="" hidden>
                </div>

                <div id="link_buttons">
                    <button type="submit" name="add_submit" id="add_link_button">add</button>
                    <button id="cancel-edit-button">cancel</button>
                </div>
            </form>
        </div>
        <div id="add-link-response"></div>
        <div class="user-address">
            <ul class="user-list">
                
            </ul>
        </div>
    </div>
</body>
<script src="/js/active-user.js"></script>