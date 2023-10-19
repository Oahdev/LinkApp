<?php 
$page_title = "Register";
require "header.php"; 
?>
<nav>
    <div id="logo">
        <a href=""><h1>LinkApp</h1></a>
    </div>
</nav>
<main>
    <div class="main-container">
        <form method="POST" autocomplete="off"  id="register"  enctype="multipart/form-data">
            <div class="input-div">
                <input type="text" id="username" name="username" placeholder='Username' required><br>
                <p id="username-error"></p>
            </div>
            <div class="input-div">
                <input type="email" id="email"  name="email" placeholder="Email" required><br>
                <p id="email-error"></p>
            </div>
            <div class="input-div">
                <input type="password" id="newPassword" name="newPassword" placeholder="Password" title="8 characters minimum" required><br>
                <p id="newPassword-error"></p>
            </div>
            <div class="input-div">
                <input type="password" id="conPassword" name="conPassword" placeholder="Confirm Password" required><br>
                <p id="conPassword-error"></p>
            </div>
            <div class="input-div">
                <button type="submit" id="signupBtn">Create account</button>
            </div>
            <div id="extra_options">
                <a href="./">Login</a>
            </div>
            <div id="register-error-response"></div>

        </form>
    </div>
</main>
<script src="./js/register.js"></script>
<?php require "footer.php"?>