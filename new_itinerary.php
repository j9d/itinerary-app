<?php
require_once 'tools.php';

$cities = get_all_locations();

print_r($cities);
?>

<html>
    <head>
        <title>Create New Itinerary</title>
    </head>
    <body>
        <h1>New Itinerary</h1>
        <hr/>
        <p>Where are you travelling from?</p>
    </body>
</html>
