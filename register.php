<?php
require_once 'tools.php';

if (isset($_POST['submit'])) {
    register_user($_POST['email'], $_POST['username'], $_POST['password']);
}

function register_user($email, $username, $password)
{
    // global $lambda_client;

    $body = [
        'email' => $email,
        'username' => $username,
        'password' => $password
    ];
    $body_json = json_encode($body);

    $url = 'https://v7w8n4n2ja.execute-api.ap-southeast-2.amazonaws.com/default/register-user';

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    // curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($body));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body_json);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    $message = $result['message'];
    echo 'Code: ' . $statusCode . '<br>';
    echo 'Message: ' . $message . '<br>';

    if ($statusCode == 409) {
        echo 'Email already exists.</br>';
    } else if ($statusCode == 201) {
        echo 'Success';
        // redirect('login.php');
    } else {
        echo 'Uncaught error: ' . $message . '<br>';
    }
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
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
            <img src="<?= $s3_base_url . 'logo.png' ?>" height="85px">
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
            <form name="register-form" method="POST" action="register.php">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <input class="btn btn-primary" type="submit" name="submit" value="Register">
                <p><a href="login.php">Already registered? Log in here</a></p>
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