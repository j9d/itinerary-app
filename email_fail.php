<?php
require 'tools.php';

echo '<!DOCTYPE html>
<html lang="en">

<head>
    <title>Email Success</title>
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
        <img src="' . $s3_base_url . "logo.png" . '" height="85px">
    </div>
    <div class="col-lg-3"></div>
</div>

<div class="row section container-fluid" id="navigation-bar">
    <div class="col-lg-1"></div>
    <div class="col-lg-8">
        <nav class="collapse navbar-collapse">
            <div class="navbar-nav">
                <ul class="nav navbar-nav mr-auto justify-content-end">
                    <li class="nav-item">
                        <a href="new_itinerary.php" id="nav-links">New itinerary</a>
                    </li>
                    <li class="nav-item">
                        <a href="user.php" id="nav-links">Past itineraries</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="col-lg-3">
        <nav class="collapse navbar-collapse">
            <div class="navbar-nav">
                <ul class="nav navbar-nav mr-auto justify-content-end">
                    <li class="nav-item">
                        <p>Welcome, ' . $_SESSION["current_user"] . ' ?>! (<a href="logout.php">logout</a>)</p>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<div class="row section container-fluid" id="main-body">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <p>Looks like your email address isn\'t verified, so we can\'t send you your itinerary. Try using a verified email.</p>
        <p>(<a href="main.php">back to the main page</a>)</p>
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

</html>';
?>