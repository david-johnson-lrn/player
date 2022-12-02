<?php

/*

    This is a generic assess template that can be used to display any activity to a client
    Create an activity in the author site and provide the activity_template_id in the query string
    You can also provide a title, description and client logo

    Use this URL format:
        http://docs.vg.learnosity.com/demos/clients/generic/index.php
            ?activity_template_id=2014HolidayQuiz
            &title=Holiday+Quiz
            &desc=Fun+holiday+quiz
            &logo=https://www.learnosity.com/blog/wp-content/themes/learnosity-v2/static/images/logo-colour.svg

*/

require_once './sdk/src/LearnositySdk/autoload.php';
//

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

if (substr($_SERVER["HTTP_HOST"], 0, 9) === "localhost") {
    $domain = "localhost";
} else {
    $domain = $_SERVER["HTTP_HOST"];
}



// Default these parameters if none provided.

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
    $org = '&org=learnosity-demos';
}

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

if (isset($_GET["user_id"])) {

    $user_id = $_GET["user_id"];
} else {
    $user_id = 'demo_student';
}

if (isset($_GET["desc"])) {
    $desc = $_GET["desc"];
} else {
    $desc = 'Learnosity assessment demo';
}

if (isset($_GET["logo"])) {
    $logo = $_GET["logo"];
    if ($logo == "") {
        $logo = 'https://learnosity.com/wp-content/uploads/2018/11/learnosity-logo-1182x245-1024x212.png';
    }
} else {
    $logo = 'https://learnosity.com/wp-content/uploads/2018/11/learnosity-logo-1182x245-1024x212.png';
}

$activity_template_id = $_GET["activity_template_id"];
$okay = true;
if (!isset($activity_template_id)) {
    $okay = false;
}

$timeStamp = gmdate('Ymd-Hi');

$query_string = $_SERVER['QUERY_STRING'];

$session_id = Uuid::generate();
$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);
$per_question = 'incorrect';
$per_response = 'always';

$request = [
    'user_id'        => $user_id,
    'rendering_type' => 'assess',
    'name'           => "Assessment for student " . $user_id,
    'state'          => 'initial',
    'activity_id'    => $activity_id,
    'session_id'     => $session_id,
    'activity_template_id' => $activity_template_id,
    'type'           => 'submit_practice',
    'config'         => array(
        //Redirect to Single Report
        'configuration' => array(
            'onsubmit_redirect_url' => 'report.php?session_id=' . $session_id . '&activity_template_id=' . $activity_template_id . '&title=' . $title . '&desc=' . $desc . '&logo=' . $logo . $org . '&user_id=' . $user_id . '&activity_id=' . $activity_id
        ),
        'questions_api_init_options' => [
            'show_distractor_rationale' => [
                'per_question' => $per_question,
                'per_response' => $per_response
            ]
        ]
        //redirect to Group reports
        // 'configuration' => array(
        //     'onsubmit_redirect_url' => 'report_form.php?session_id=' . $session_id . '&activity_template_id=' . $activity_template_id . '&title=' . $title . '&desc=' . $desc . '&logo=' . $logo . $org . '&user_id=' . $user_id . '&activity_id=' . $activity_id
        // )


    )
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();


?>
<!doctype html>

<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" href="./images/lrn-favicon.png" sizes="32x32" type="image/png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="well" style="padding-left:10%; padding-right:10%;margin-bottom:0px;">
        <div style="float:right; width:9%;">
            <img src="<?php echo $logo; ?>" style="width:100%;" />
        </div>
        <h3 style="margin-top:1px;"><?php echo $title; ?></h3>
        <h6><?php echo "Assessment for student: " . $user_id; ?></h6>
    </div>

    <div class="section" style="margin-left:9%; margin-right:9%;margin-top:10px;">
        <!-- Container for the items api to load into -->
        <div id="learnosity_assess"></div>
    </div>

    <div id="renderError" style=" width: 70rem; margin-top:2vh; display:none" class="card mx-auto">
        <div class="card-body">
            <div class="card-header">
                No Activity Found
            </div>
            <div class="text-center">
                There was an error in finding your activity. Please click the back button below and ensure the Test ID is correctly entered.
                <div>

                    <button class="btn btn-danger" id="backButton"> Back </button>
                </div>


            </div>
        </div>
    </div>

    <script src="//items.learnosity.com?"></script>
    <!-- <script src="//items.learnosity.com?v1.51"></script> -->

    <?php if ($okay) { ?>
        <script>
            document.getElementById('backButton').addEventListener("click", function() {
                window.history.back();
            })
            var itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, {

                readyListener: function() {
                    console.log('ReadyListener fired');


                },
                errorListener: function(e) {
                    console.log('ERROR');
                    console.log(e.code);
                    if (e.code === 20013) {
                        document.getElementById('renderError').style.display = "block"
                    }
                    console.log(e.msg);
                    console.log(e.detail);
                }
            });
        </script>
    <?php } else { ?>
        <div class="alert alert-danger" role="alert" style="margin-left: 20%;margin-right: 20%;margin-top: 60px;">
            No <b>activity_template_id</b> provided.
        </div>
        <div class="alert alert-warning" role="alert" style="margin-left: 20%;margin-right: 20%;margin-top: 60px;">
            Use this URL format:<br /><br />
            http://<?php echo $_SERVER['HTTP_HOST']; ?>/demos/clients/generic/index.php?activity_template_id=2014HolidayQuiz&title=Holiday+Quiz&desc=Fun+holiday+quiz&logo=https://learnosity.com/wp-content/uploads/2018/11/learnosity-logo-1182x245-1024x212.png
        </div>

    <?php } ?>

</body>

</html>