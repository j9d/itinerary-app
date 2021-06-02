<?php
require_once 'tools.php';

use Aws\DynamoDb\Exception\DynamoDbException;

if (!isset($_SESSION['current_email']) || !isset($_POST['submit'])) {
    redirect('login.php');
}

// Postprocessing for saving an itinerary to the database
$user = query_login_table($_SESSION['current_email']);
$itineraries = $user['Item']['itineraries']['L'];
if (!$itineraries) {
    $itineraries = array();
}
$numlocations = $_POST['numlocations'];

print_r($_POST);
$origin = explode('^', $_POST['origin']);
$itinerary = ['L' => [
    ['M' => [
        'city' => ['S' => $origin[0]],
        'country' => ['S' => $origin[1]],
        'date' => ['S' => $_POST['date0']]
    ]]
]];

for ($i = 1; $i <= $numlocations; $i++) {
    $locationname = explode('^', $_POST['destination' . $i]);
    $itinerary_destination = ['M' => [
        'city' => ['S' => $locationname[0]],
        'country' => ['S' => $locationname[1]],
        'date' => ['S' => $_POST['date' . $i]]
    ]];
    $itinerary['L'][] = $itinerary_destination;
}
$itineraries[] = $itinerary;

$key = [
    'email' => ['S' => $user['Item']['email']['S']]
];
$eav = [':itineraries' => ['L' => $itineraries]];
$params = [
    'TableName' => 'users',
    'Key' => $key,
    'UpdateExpression' =>
        'set itineraries = :itineraries',
    'ExpressionAttributeValues' => $eav
];

try {
    $result = $db_client->updateItem($params);
    // redirect('main.php');
    echo 'Success!';

} catch (DynamoDbException $e) {
    echo 'Error: ' . $e->getMessage() . '<br/>';
}

?>
