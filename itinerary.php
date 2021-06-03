<?php
require_once 'tools.php';

if (!isset($_POST['submit'])) {
    redirect('main.php');
}

$index = intval($_POST['index']);
$user = query_login_table($_SESSION['current_email']);
$itinerary = $user['Item']['itineraries']['L'][$index]['L'];
?>

<html>
    <head>
        <title>Saved Itinerary</title>
    </head>
    
    <body>
        <h1>Saved Itinerary</h1>
        <hr/>
        <div>
            <p><strong>Origin</strong></p>
            <p><?= $itinerary[0]['M']['city']['S'] . ', ' . $itinerary[0]['M']['country']['S'] ?></p>
            <p><strong>Depart on </strong><?= (new DateTime($itinerary[0]['M']['date']))->format('jS F Y') ?></p>
            <hr/>
        </div>

        <?php
        foreach ($itinerary as $index => $location) {
            if ($index > 0) {
                $combinedname = $itinerary[$index]['M']['city']['S'] . ', ' . $itinerary[$index]['M']['country']['S'];
                $arrdate = (new DateTime($itinerary[$index - 1]['M']['date']))->format('jS F Y');
                $depdate = (new DateTime($itinerary[$index]['M']['date']))->format('jS F Y');
                echo '<div>
                    <p><strong>Destination ' . $index . '</strong></p>
                    <p>' . $combinedname . '</p>
                    <p><strong>Arrive on </strong>' . $arrdate . '</p>
                    <p><strong>Depart on </strong>' . $depdate . '</p>
                </div>
                <hr/>';
            }
        }
        ?>

        <p><strong>Return Destination</strong></p>
        <p><?= $itinerary[0]['M']['city']['S'] . ', ' . $itinerary[0]['M']['country']['S'] ?></p>
        <p><strong>Arrive on </strong><?= (new DateTime($itinerary[count($itinerary) - 1]['M']['date']))->format('jS F Y') ?></p>
        <hr/>

        <form action='user.php'><input type='submit' value='Back'></form>
        <form action='email.php'><input type='submit' value='Email to me'></form>
    </body>
</html>
