<?php

require_once './sdk/src/LearnositySdk/autoload.php';



use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

if (substr($_SERVER["HTTP_HOST"], 0, 9) === "localhost") {
    $domain = "localhost";
} else {
    $domain = $_SERVER["HTTP_HOST"];
}

// For this first one we default to the Demos Org but it is useful to be able to optionally switch to Internal
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

// Default these parameters if none provided.
if (isset($_GET["title"])) {
    $title = $_GET["title"];
} else {
    $title = 'Learnosity Demo';
}
if (isset($_GET["activity_id"])) {
    $activity_id = $_GET["activity_id"];
} else {
    $activity_id = 'Learnosity Demo';
}


if (isset($_GET["users"])) {
    $users = json_decode($_GET["users"]);
    $sessions = [];



    for ($i = 0; $i < count($users); $i++) {
        $each_user[$i] = [
            "id" => $users[$i]->user_id,
            "name" => $users[$i]->user_id
        ];
    };
    for ($i = 0; $i < count($users); $i++) {
        array_push($sessions, $users[$i]->session);
    };

    // echo '<pre>' . var_export($sessions, true) . '</pre>';

} else {
    $users = [
        [
            "id" => "mce_student",
            "name" => "Jesse Pinkman"
        ],
        [
            "id" => "mce_student_1",
            "name" => "Skylar White"
        ],
        [
            "id" => "mce_student_2",
            "name" => "Walter White"
        ],
        [
            "id" => "mce_student_3",
            "name" => "Saul Goodman"
        ]
    ];

    //need to add dummy sessions here for else
}

if (isset($_GET["logo"])) {
    $logo = $_GET["logo"];
} else {
    $logo = 'https://www.learnosity.com/blog/wp-content/themes/learnosity-v2/static/images/logo-colour.svg';
}

$timeStamp = gmdate('Ymd-Hi');

$query_string = $_SERVER['QUERY_STRING'];


$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$activity = array(
    "reports" => [

        [
            "id" => "report-1",
            "type" => "response-analysis-by-item",
            //check why i need partial
            'question_source' => 'original',
            "session_ids" => $sessions,
            "users" => $each_user,
            "item_reference_map" => [
                [
                    'reference' => "Question 1",
                    'name' => "item 1"
                ],
                [
                    'reference' => "Question 2",
                    'name' => "item 2"
                ],
                [
                    'reference' => "Question 3",
                    'name' => 'item 3'
                ],
                [
                    'reference' => "Question 4",
                    'name' => 'item 4'
                ],
                [
                    'reference' => "Question 5",
                    'name' => 'item 5'
                ],
            ],
            'render' => true

        ],



    ],

);

$init = new Init('reports', $security, $consumer_secret, $activity);

?>

<!doctype html>

<head>
    <title><?php echo $title;
            ?></title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//reports.learnosity.com"></script>
</head>

<body>
    <div class="well" style="padding-left:9%; padding-right:9%;margin-bottom:0px;">
        <img src="<?php echo $logo; ?>" style="float:right; width:11%;margin-bottom:0px;" />
        <h3 style="margin-top:1px;"><?php echo $title;
                                    ?></h3>
        <h6><?php //echo $desc; 
            ?></h6>
    </div>


    <div class="section" style="margin-left:9%; margin-right:9%;margin-top:10px;">
        <h3>General Reports</h3>
        <h5>Here we see a small selection of general reports on the completed assessment</h5>
        <span>Learn more about Learnosity report types <a href='https://demos.learnosity.com/analytics/reports/report_types.php' target='_blank'>here</a></span>
    </div>

    <hr />

    <div class="section" style="margin-left:9%; margin-right:9%;margin-top:10px;">
        <h3>Summary Report</h3>
        <span class="learnosity-report" id="report-1"></span>
    </div>

    <hr />


    <div class="section">
        <div class="row">
            <div class="text-center">
                <button class="btn btn-danger" id="backButton"> Back </button>
                <br /><br />

            </div>
        </div>
    </div>



    <script>
        var activity = <?php echo $init->generate(); ?>;
        var reportsApp = LearnosityReports.init(window.activity);

        document.getElementById('backButton').addEventListener("click", function() {
            window.history.back();
        })
    </script>

</body>

</html>