<?php
require_once 'tools.php';

// Retrieve all cities from DynamoDB
$cities = get_all_locations();

// Unmarshall into a normal array from that godforsaken DynamoDB format
$cities_unmarshalled = [];
foreach ($cities['Items'] as $i) {
    $cities_unmarshalled[$i['city']['S']] = [
        'city' => $i['city']['S'],
        'country' => $i['country']['S'],
        'continent' => $i['continent']['S'],
        'acceptsGround' => $i['acceptsGround']['BOOL']
    ];
}

// Sort by city name
$city_col = array_column($cities_unmarshalled, 'city');
array_multisort(
    $city_col, SORT_ASC,
    $cities_unmarshalled
);
?>

<html>
    <head>
        <title>Create New Itinerary</title>
        <script type='text/javascript'>
            // Function for adding destination selection fields to the form
            function addFields() {
                // Number of destinations to create
                var number = document.getElementById('numlocations').value;

                if (number > 20) {
                    alert('Too many destinations. Please choose 20 or less.');

                } else {
                    // Container <div> where the location selections will be displayed
                    var container = document.getElementById('container');

                    // Clear previous contents of the container - allows changing of the number of destinations
                    while (container.hasChildNodes()) {
                        container.removeChild(container.lastChild);
                    }
                    for (i = 1; i < number + 1; ++i) {
                        container.appendChild(document.createElement('hr'));

                        // Clone the selector for the origin location
                        let clone = document.querySelector('#origin').cloneNode(true);
                        clone.id = 'destination' + i;
                        clone.name = 'destination' + i;

                        container.appendChild(document.createTextNode('Destination ' + i));
                        container.appendChild(document.createElement('br'));
                        // Add the cloned element to the container
                        container.appendChild(clone);
                        container.appendChild(document.createElement('br'));

                        // Create a date selector for each destination
                        let date = document.createElement('input');
                        date.type = 'date';
                        date.id = 'date' + i;
                        date.name = 'date' + i;
                        date.value = '<?= date('Y-m-d') ?>';
                        date.min = '<?= date('Y-m-d') ?>';
                        date.onchange = updateMinDates;

                        // Add date selector
                        container.appendChild(document.createTextNode('Date of departure from this destination:'));
                        container.appendChild(document.createElement('br'));
                        container.appendChild(date);
                        
                        container.appendChild(document.createElement('br'));
                    }
                }
            }

            function updateMinDates(event) {
                id = event.target.id;
                console.log(id);
                num = parseInt(id.trim('date'), 10);
                new_min = document.getElementById('date' + num).value;

                for (i = num + 1; i <= 20; ++i) {
                    dateselector = document.getElementById('date' + i);
                    dateselector.min = new_min;
                }
            }
        </script>
    </head>
    <body>
        <h1>New Itinerary</h1>
        <hr/>
        <form action='postprocessing.php' method='post'>
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

            <p>When are you leaving?</p>
            <input type='date' id='origin-date' name='origin-date' value='<?= date('Y-m-d') ?>' min=<?= date('Y-m-d') ?>>
        
            <p>How many locations are you travelling to?</p>
            <input type='text' id='numlocations' name='numlocations' value=''/>
            <a href='#' id='addfields' onclick='addFields()'>Confirm</a>
            <div id='container'></div>

            <br/>
            <input type='submit' value='Save' name='submit'>
        </form>
        
    </body>
</html>
