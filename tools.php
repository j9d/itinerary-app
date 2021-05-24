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

?>
