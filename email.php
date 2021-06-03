<?php

use Aws\Exception\AwsException;

require_once 'tools.php';

if (!isset($_SESSION['current_email']) || !isset($_POST['submit'])) {
    redirect('main.php');
}

$index = intval($_POST['index']);
$user = query_login_table($_SESSION['current_email']);
$itinerary = $user['Item']['itineraries']['L'][$index]['L'];

$subject = 'Here\'s your itinerary from ItineraryApp.';

$html_body = '
<h1>Saved Itinerary</h1>
<hr/>
<div>
    <p><strong>Origin</strong></p>
    <p>' . $itinerary[0]['M']['city']['S'] . ', ' . $itinerary[0]['M']['country']['S'] . '</p>
    <p><strong>Depart on </strong>' . (new DateTime($itinerary[0]['M']['date']['S']))->format('jS F Y') . '</p>
    <hr/>
</div>';

foreach ($itinerary as $index => $location) {
    if ($index > 0) {
        $combinedname = $itinerary[$index]['M']['city']['S'] . ', ' . $itinerary[$index]['M']['country']['S'];
        $arrdate = (new DateTime($itinerary[$index - 1]['M']['date']['S']))->format('jS F Y');
        $depdate = (new DateTime($itinerary[$index]['M']['date']['S']))->format('jS F Y');
        $html_body .= '
        <div>
            <p><strong>Destination ' . $index . '</strong></p>
            <p>' . $combinedname . '</p>
            <p><strong>Arrive on </strong>' . $arrdate . '</p>
            <p><strong>Depart on </strong>' . $depdate . '</p>
        </div>
        <hr/>';
    }
}

$html_body .= '
<p><strong>Return Destination</strong></p>
<p>' . $itinerary[0]['M']['city']['S'] . ', ' . $itinerary[0]['M']['country']['S'] . '</p>
<p><strong>Arrive on </strong>' . (new DateTime($itinerary[count($itinerary) - 1]['M']['date']['S']))->format('jS F Y') . '</p>
<hr/><hr/>

View the rest of your itineraries at http://itinerary-app.ap-southeast-2.elasticbeanstalk.com/
';
$charset = 'UTF-8';

try {
    $result = $email_client->sendEmail([
        'Destination' => [
            'ToAddresses' => [$_SESSION['current_email']]
        ],
        'ReplyToAddresses' => [$sender_address],
        'Source' => $sender_address,
        'Message' => [
            'Body' => [
                'Html' => [
                    'Charset' => $charset,
                    'Data' => $html_body
                ]
            ],
            'Subject' => [
                'Charset' => $charset,
                'Data' => $subject
            ]
        ]
    ]);
    $messageId = $result['MessageId'];
    echo 'Email sent! Message ID: ' . $messageId . "\n";
    
} catch (AwsException $e) {
    echo $e->getMessage();
    echo 'The email was not sent. Error message: ' . $e->getAwsErrorMessage() . "\n";
    echo "\n";
}

?>
