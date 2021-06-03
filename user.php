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

<html>
    <head>
        <title>User Page</title>
    </head>
    
    <body>
        <h1>Your Saved Itineraries</h1>
        <hr/>

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
                    <td>' . count($itin['L']) . '</td>
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
    </body>
</html>
