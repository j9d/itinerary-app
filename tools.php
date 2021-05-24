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

$REGISTER_URL = 'https://v7w8n4n2ja.execute-api.ap-southeast-2.amazonaws.com/default/register-user';

?>