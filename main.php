<?php
require_once 'tools.php';

if (!isset($_SESSION['current_email'])) {
    redirect('login.php');
}
?>

<html>
    <head>
        <title>Itinerary App</title>
    </head>
    
    <body>
        <h1>Main Page</h1>
        <p>Welcome, <?= $_SESSION['current_user'] ?>! (<a href='logout.php'>logout</a>)</p>

        <br>
        <p>View your <a href='user.php'>saved itineraries</a>.</p>
        <p>Create a <a href='new_itinerary.php'>new itinerary</a>.</p>
    </body>
</html>
