<?php
require_once 'tools.php';

if (!isset($_SESSION['current_email'])) {
    redirect('login.php');
}

$user = query_login_table($_SESSION['current_email']);
if ($user['Item']['itineraries'] != null) {
    $itineraries = $user['Item']['itineraries']['L'];
} else {
    $itineraries = null;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Page</title>
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
        <div class="col-lg-1"></div>
        <div class="col-lg-8">
            <nav class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <ul class="nav navbar-nav mr-auto justify-content-end">
                        <li class="nav-item">
                            <a href='new_itinerary.php' id="nav-links">New itinerary</a>
                        </li>
                        <li class="nav-item">
                            <a href='user.php' id="nav-links">Past itineraries</a>
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
                            <p>username and logout go here</p>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="row section container-fluid" id="main-body">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <h2 id="page-title">Your Saved itineraries</h2>
            <hr>
            <?php
            if ($itineraries) {
                echo '<table>
                <tr>
                    <th>Date</th>
                    <th>Origin</th>
                    <th>Number of Destinations</th>
                    <th>View</th>
                </tr>
                ';
                foreach ($itineraries as $index => $itin) {
                    echo '<tr>
                        <td>' . $itin['L'][0]['M']['date']['S'] . '</td>
                        <td>' . $itin['L'][0]['M']['city']['S'] . '</td>
                        <td>' . (count($itin['L']) - 1) . '</td>
                        <td><form method="post" action="itinerary.php">
                            <input type="hidden" name="index" value="' . $index . '">
                            <input type="submit" name="submit" value="View">
                        </form></td>
                    </tr>';
                }
                echo '</table>';
            } else {
                echo '<p>No itineraries to show.</p>';
            }
            ?>
            <hr>
            <p><a href="main.php">Back to the main page</a></p>
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