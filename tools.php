<?php
require_once __DIR__ . '/vendor/autoload.php';

if (!isset($_SESSION)) {
    session_start();
}

use Aws\Sdk;

$sdk = new Sdk([
    'version' => 'latest',
    'region' => 'ap-southeast-2'
]);

$lambda_client = $sdk->createLambda();
$db_client = $sdk->createDynamoDb();
$s3_client = $sdk->createS3();
$email_client = $sdk->createSes();

$s3_base_url = 'https://itinerary-bucket.s3-ap-southeast-2.amazonaws.com/';
$sender_address = 'itinerary.app.cc@gmail.com';

function redirect($page) {
    echo "<script> location.href=\"" . $page . "\" </script>";
}

function query_login_table($email) {
    global $db_client;

    $key = [
        'email' => [
            'S' => $email
        ]
    ];
    $params = [
        'TableName' => 'users',
        'Key' => $key
    ];

    $result = $db_client->getItem($params);
    return $result;
}

function get_all_locations() {
    global $db_client;

    $cities = $db_client->scan([
        'TableName' => 'locations'
    ]);

    return $cities;
}
?>