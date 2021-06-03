<?php
require_once 'tools.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Itinerary App - Home</title>
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
                        <li class="nav-item">
                            <a class="nav-link" id="lr-btn" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="lr-btn" href="register.php">Register</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
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