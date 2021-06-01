<?php
require_once 'tools.php';

$cities = get_all_locations();

$cities_unmarshalled = [];
foreach ($cities['Items'] as $i) {
    $cities_unmarshalled[$i['city']['S']] = [
        'city' => $i['city']['S'],
        'country' => $i['country']['S'],
        'continent' => $i['continent']['S'],
        'acceptsGround' => $i['acceptsGround']['BOOL']
    ];
}

$city_col = array_column($cities_unmarshalled, 'city');
array_multisort(
    $city_col, SORT_ASC,
    $cities_unmarshalled
);

print('<pre>' . print_r($cities_unmarshalled) . '</pre>');
?>

<html>
    <head>
        <title>Create New Itinerary</title>
    </head>
    <body>
        <h1>New Itinerary</h1>
        <hr/>
        <form>
            <p>Where are you travelling from?</p>
            <select name='origin' id='origin'>
                <?php 
                foreach ($cities_unmarshalled as $c) {
                    $cityname = $c['city'];
                    $countryname = $c['country'];

                    if ($cityname == 'Melbourne') {
                        echo '<option value=' . $cityname . ' selected>Melbourne, Australia</option>\n'; 
                    } else {
                        echo '<option value=' . $cityname . '>' . $cityname . ', ' . $countryname . '</option>\n';
                    }
                }
                
                ?>
            </select>
        
        </form>
        
    </body>
</html>
