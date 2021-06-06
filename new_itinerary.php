<?php
require_once 'tools.php';

if (!isset($_SESSION['current_email'])) {
    redirect('login.php');
}

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
?><!DOCTYPE html>
<html lang="en">

<head>
    <title>Create New Itinerary</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <script rel="scripts" type="text/javascript">
        // Function for adding destination selection fields to the form
        function addFields() {
                // Number of destinations to create
                let number = document.getElementById('numlocations').value;

                if (number > 20) {
                    alert('Too many destinations. Please choose 20 or less.');

                } else {
                    // Container <div> where the location selections will be displayed
                    let container = document.getElementById('container');

                    // Clear previous contents of the container - allows changing of the number of destinations
                    while (container.hasChildNodes()) {
                        container.removeChild(container.lastChild);
                    }
                    for (let i = 1; i <= number; i++) {
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
                        date.onchange = updateMinDatesWrapper;

                        // Add date selector
                        container.appendChild(document.createTextNode('Date of departure from this destination:'));
                        container.appendChild(document.createElement('br'));
                        container.appendChild(date);
                        
                        container.appendChild(document.createElement('br'));
                    }
                }
            }

            function updateMinDatesWrapper(event) {
                updateMinDates(event.target);
            }

            function updateMinDates(item) {
                id = item.id;
                let num = parseInt(id.replace('date', ''), 10);
                let new_min = document.getElementById('date' + num).value;

                for (let i = num + 1; i <= 20; i++) {
                    let dateselector = document.getElementById('date' + i);
                    dateselector.min = new_min;
                    let current_val = new Date(dateselector.value);
                    let new_min_date = new Date(new_min);
                    if (current_val < new_min_date) {
                        dateselector.value = new_min;
                    }
                }
            }
    </script>
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
                            <p>Welcome, <?= $_SESSION['current_user'] ?>! (<a href='logout.php'>logout</a>)</p>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="row section container-fluid" id="main-body">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <h2 id="page-title">New Itinerary</h2>
            <hr>
            <form name="new_itinerary-form" action="postprocessing.php" method="POST">
                <div class="form-group">
                    <p>Where are you travelling from?</p>
                    <select class="form-select" name="origin" id="origin">
                        <?php 
                        foreach ($cities_unmarshalled as $c) {
                            $cityname = $c['city'];
                            $countryname = $c['country'];
                            $combinedname = $cityname . '^' . $countryname;

                            if ($cityname == 'Melbourne') {
                                echo '<option value="' . $combinedname . '" selected>Melbourne, Australia</option>'; 
                            } else {
                                echo '<option value="' . $combinedname . '">' . $cityname . ', ' . $countryname . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <p>When are you leaving?</p>
                    <input type="date" class="form-control" id="date0" name="date0" value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" onchange="updateMinDates(this)">
                </div>
                <div class="form-group">
                    <p>How many destinations are you travelling to?</p>
                    <input type="text" class="form-control" name="numlocations" id="numlocations">
                    <a href="#" id="addfields" onclick="addFields()">Confirm</a>
                    <div id="container"></div> 
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" class="form-control" value="Save" name="submit">
                </div>
            </form>
        </div>
        <div class="col-lg-3"></div>
    </div>
    <br/><br/><br/><br/>
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