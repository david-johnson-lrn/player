<?php
require_once './sdk/src/LearnositySdk/autoload.php';


use LearnositySdk\Request\DataApi;

if (isset($_GET["org"]) && $_GET["org"] == 'learnosity-internal') {
    //  Internal
    $consumer_key = 'ARV3wIzUPWnC5l18';
    $consumer_secret = 'oCsuobS0ZBSEw6zG8yepifKSQ3tqgmaBzbPYp1zl';
    $org = '&org=learnosity-internal';
} elseif (isset($_GET["org"]) && $_GET["org"] == 'learnosity-acme-demos') {
    //  ACME Demos
    $consumer_key = 'GXieCdYBljuT5EwS';
    $consumer_secret = 'W1taPhHr8r0eZxFxB1qs5l3wHUfDe3xVLrXIjTcq';
    $org = '&org=learnosity-acme-demos';
} elseif (isset($_GET["org"]) && $_GET["org"] == 'tech-sales') {
    //  Tech Sales
    $consumer_key = 'Kbtat26gytHSxh0S';
    $consumer_secret = 'q9O8Pwikp1WBzeNq4SuSl1jTf2hj32smmbYvqV7f';
    $org = '&org=tech-sales';
} else {
    //  Demos
    $consumer_key = 'yis0TYCu7U9V4o7M';
    $consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';
}


if (substr($_SERVER["HTTP_HOST"], 0, 9) === "localhost") {
    $domain = "localhost";
} else {
    $domain = $_SERVER["HTTP_HOST"];
}

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];


$endpoint = "https://data.learnosity.com/v2022.1.LTS/sessions/responses/scores";
$action = 'get'; // get or set. 

$activity_id = $_POST['activity_id'];



$request = [ // We set the parameters/filters for the request here. IN this simple case we are just requesting a specific Item
    "activity_id" => [
        $activity_id
    ],
    "limit" => 100
];

$lrnData = new DataApi();  // Call the Data API and send the Security & Request objects with your secret and action
$dataRequest = $lrnData->request($endpoint, $security, $consumer_secret, json_encode($request), $action);

$body = $dataRequest->getBody(); // We are only interested in the body part of the returned object

//echo $body;

$body = json_decode($body); // Decode the body to JSON


$json_string = json_encode($body); // Set up the output to print

header('Content-Type: application/json'); // Need a header for our browser to render the JSON in a readable format

echo $json_string; // Output the JSON
