<?php
require_once 'tools.php';

function login($email, $password) {
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
?>

<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <?php
            if (isset($_POST['submit'])) {
                login($_POST['email'], $_POST['password']);
            }
        ?>
        <form name="login-form" method="post" action="login.php">
            <h3>Email</h3>
            <input type="text" name="email" required>

            <h3>Password</h3>
            <input type="password" name="password" required>
            <br/>

            <input type="submit" value="Login" name="submit">
            <p><a href="register.php">Register here!</a></p>
        </form>
    </body>
</html>
