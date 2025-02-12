<link rel="stylesheet" href="./style/style.css">
<style>
    body{
        display: grid;
        flex-direction: column;
    }
    footer{
        margin-top: auto;
    }
</style>
<body class="not-found-main-body">
    <div class="not_found_body">
        <h1><?php echo $username;?> not found</h1>
        <div>
            <a href="./"><button>Login</button></a>
            <a href="./register"><button>Register</button></a>
        </div>
    </div>

