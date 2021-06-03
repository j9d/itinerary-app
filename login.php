<?php
require_once 'tools.php';

if (isset($_POST['submit'])) {
    login($_POST['email'], $_POST['password']);
}

function login($email, $password)
{
    $result = query_login_table($email);

    if ($result['Item'] != null) {
        $result_email = $result['Item']['email']['S'];
        $result_user = $result['Item']['username']['S'];
        $result_pass = $result['Item']['password']['S'];

        if ($result_pass == hash('sha256', $password)) {
            $_SESSION['current_email'] = $result_email;
            $_SESSION['current_user'] = $result_user;
            redirect('main.php');
        } else {
            echo '<p>Email or password is invalid</p></br>';
        }
    } else {
        echo '<p>Email or password is invalid</p></br>';
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container-fluid" id="main-title">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 text-center">
            <h1 id="title">Itinerary App</h1>
        </div>
        <div class="col-lg-3"></div>
    </div>

    <div class="row section container-fluid" id="navigation-bar">
        <div class="col-lg-9"></div>
        <div class="col-lg-3">
            <nav class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <ul class="nav navbar-nav mr-auto justify-content-end">
                        <li class="nav-item active">
                            <a class="nav-link" id="lr-btn" href="login.php">Login<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="lr-btn" href="register.php">Register</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="row section container-fluid" id="main-body">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <form name="login-form" method="POST" action="login.php">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <input class="btn btn-primary" type="submit" value="Login">
                <p><a href="register.php">Register here!</a></p>
            </form>
        </div>
        <div class="col-lg-3"></div>
    </div>
</body>

<footer class="container-fluid" id="footer">
    <div>
        <p>COSC2626 Cloud Computing - Assessment 3</p>
        <p><span>&#169;</span>James Dimos (s3722398)<br>
            <span>&#169;</span>Louis Manabat (s3719633)
        </p>
    </div>
</footer>

</html>