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
        <script type='text/javascript'>
            function addFields() {
                // Number of destinations to create
                var number = document.getElementById('numlocations').value;
                // Container <div> where the location selections will be displayed
                var container = document.getElementById('container');
                // Clear previous contents of the container
                while (container.hasChildNodes()) {
                    container.removeChild(container.lastChild);
                }
                for (i = 0; i < number; i++) {
                    container.appendChild(document.createElement('hr'));

                    // Clone the selector for the origin location
                    let clone = document.querySelector('#origin').cloneNode(true);
                    clone.id = 'destination' + i;
                    clone.name = 'destination' + i;

                    container.appendChild(document.createTextNode('Destination ' + (i + 1)));
                    // Add the cloned element to the container
                    container.appendChild(clone);
                    
                    container.appendChild(document.createElement('br'));
                }
            }
        </script>
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
                        echo '<option value=' . $cityname . ' selected>Melbourne, Australia</option>'; 
                    } else {
                        echo '<option value=' . $cityname . '>' . $cityname . ', ' . $countryname . '</option>';
                    }
                }
                ?>
            </select>
        
            <p>How many locations are you travelling to?</p>
            <input type='text' id='numlocations' name='numlocations' value=''/>
            <a href='#' id='addfields' onclick='addFields()'>Confirm</a>
            <div id='container'></div>
        </form>
        
    </body>
</html>
