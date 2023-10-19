<?php 
$page_title = "Login"; 
require "header.php"; 
?>
<nav>
    <div id="logo">
        <a href=""><h1>LinkApp</h1></a>
    </div>
</nav>
<main>
    <div class="main-container">
        <form method="POST" id="login" autocomplete="off" enctype="multipart/form-data">
            <div id="login-response"></div>
            <div class="input-div">
                <input type="text" id="login_name" name="login_name" placeholder="Email or Username" required><br>
            </div>
            <div class="input-div">
                <input type="password" id="login_password" name="login_password" placeholder="Password" required><br>
            </div>
            <div id="remember_me_div">
                <input type="checkbox" checked id="remember_me_btn" name="remember_me_option">
                <label for="remember_me_btn">remember me</label><br>
            </div>
            <button type="submit" id="loginBtn" name="submit">Login</button><br> 
            <div id="extra_options">
                <a href="register">Register</a><br><br>
            </div>
        </form>
    </div>
</main>
<script src="./js/login.js"></script>
<?php require "footer.php" ?>
</html>

