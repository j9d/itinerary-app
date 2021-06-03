<?php
require_once 'tools.php';

function register_user($email, $username, $password) {
    global $lambda_client;

    $body = [
        'email' => $email,
        'username' => $username,
        'password' => $password
    ];

    $result = $lambda_client->invoke([
        'FunctionName' => 'arn:aws:lambda:ap-southeast-2:299197477071:function:register-user',
        'Payload' => json_encode($body)
    ]);

    $result_arr = json_decode($result['Payload']->__toString(), true);
    $statusCode = $result_arr['statusCode'];
    $message = $result_arr['body'];

    if ($statusCode == 409) {
        echo 'Email already exists: ' . $result_arr['conflictingEmail'] . '</br>';
    } else if ($statusCode == 201) {
        redirect('login.php');
    } else if ($statusCode == 400) {
        echo $message . '<br>';
    } else {
        echo 'Uncaught error<br>';
    }

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
        <input type="text" name="username">
        <br/>

        <h3>Password</h3>
        <input type="password" name="password">
        <br/>

        <input type="submit" value="Register" name="submit">
        <p><a href="login.php">Already registered? Log in here.</a></p>
    </form>
    </body>
</html>
