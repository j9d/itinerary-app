<?php
require_once 'tools.php';

function register_user($email, $username, $password) {
    global $REGISTER_URL;

    $body = [
        'email' => $email,
        'username' => $username,
        'password' => $password
    ];

    $request = [
        'http' => [
            'header' => 'Content-type: application/json',
            'method' => 'POST',
            'body' => http_build_query($body)
        ]
    ];
    
    $context = stream_context_create($request);
    $result = file_get_contents($REGISTER_URL, false, $context);
    if ($result === false) {
        echo 'Error making request';
    }
    var_dump($result);
}

?>

<html>
    <head>
        <title>Register</title>
    </head>
    <body>
    <?php
        if (isset($_POST['submit'])) {
            register_user($_POST['email'], $_POST['username'], $_POST['password']);
        }
    ?>
    <form name="register-form" method="post" action="register.php">
        <h3>Email</h3>
        <input type="email" name="email">
        <br/>

        <h3>Username</h3>
        <input type="text" name="username" required>
        <br/>

        <h3>Password</h3>
        <input type="password" name="password" required>
        <br/>

        <input type="submit" value="Register" name="submit">
        <p><a href="login.php">Already registered? Log in here.</a></p>
    </form>
    </body>
</html>
