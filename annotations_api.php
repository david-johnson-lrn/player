<?php

/*

    Quick generic demo of the Annotations API

*/

require_once './sdk/src/LearnositySdk/autoload.php';


use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

if (substr($_SERVER["HTTP_HOST"], 0, 9) === "localhost") {
    $domain = "localhost";
} else {
    $domain = $_SERVER["HTTP_HOST"];
}

$timeStamp = gmdate('Ymd-Hi');

$session_id = Uuid::generate();

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'activity_id'    => 'annotations_api_demo',
    'name'           => 'Annotations API demo',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'type'           => 'submit_practice',
    'session_id'     => Uuid::generate(),
    'user_id'        => 'demo_student',
    'items'          => array(
        'Moby',
        'Demo3',
        'Demo4',
        'Demo6',
        'Demo7',
        'Demo8',
        'Demo9',
        'Demo10'
    ),
    'config'         => array(
        'title'               => 'Annotations API',
        'subtitle'            => 'Highlighter and Notepad demo. ',
        'regions'             => 'main',

        // Enable Annotations API =======================
        'annotations' => true,
        // Alternatively specifiy initialization for Annotations
        'annotations_api_init_options' => [
            'modules' => [
                'notepad' => true,
                'texthighlight' => true
            ]
        ]
        // ==============================================

    )
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>
<!doctype html>

<head>
    <title>Annotations API demo</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="well" style="padding-left:10%; padding-right:10%;margin-bottom:0px;">
        <h3 style="margin-top:1px;">Annotations API</h3>
        <h6>Demo of the new Highlighter and Notepad tools</h6>
    </div>

    <div class="alert alert-info" role="alert" style="margin-left: 10%;margin-right: 10%;margin-top: 30px;">
        <h6>The Annotations API currently provides two useful tools which are available to students during the assessment:<br /><br /></h6>
        <h6><b>1> Multi-color Highlighter</b>: Highlight any text in the assessment, select a color for the highlight from the menu that appears over the text.</h6>
        <h6><b>2> Notepad</b>: Click the Notepad icon in the toolbar to access the Notepad. Close and reopen as needed.</h6>
        <h6><br />To use Annotations API see sample request object below</h6>
    </div>

    <div class="section" style="margin-left:9%; margin-right:9%;margin-top:20px;">
        <!-- Container for the items api to load into -->
        <div id="learnosity_assess"></div>
    </div>

    <script src="//items.learnosity.com?"></script>

    <script>
        var itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, {
            readyListener: function() {
                console.log('ReadyListener fired');
            }
        });
    </script>

    <div class="alert alert-warning" role="alert" style="margin-left: 10%;margin-right: 10%;margin-top: 30px;">
        <h6>Annotations API only works with Items API in Assess mode ("rendering_type": "assess")</h6>
        <h6>Requires latest version of Items API</h6>
        <h6>Example request object below</h6>
    </div>


    <pre style="margin-left: 10%;margin-right: 10%;margin-top: 30px;margin-bottom: 60px;">
    "request": {
        "activity_id": "annotations_api_demo",
        "name": "Annotations API demo",
        "rendering_type": "assess",
        "state": "initial",
        "type": "submit_practice",
        "session_id": "b46287e3-879d-403d-8e1e-3d718cde7941",
        "user_id": "demo_student",
        "items": [
            "Moby", "Demo3", "Demo4", "Demo6", "Demo7", "Demo8", "Demo9", "Demo10"
        ],
        "config": {
            "title": "Annotations API",
            "subtitle": "Highlighter and Notepad demo. ",
            "regions": "main",

            // Enable Annotations API =======================
            "annotations": true,
            
            // Specify the modules you need
            "annotations_api_init_options": {
                "modules": {
                    "notepad": true,
                    "texthighlight": true
                }
            }
            // ==============================================
        }
    }
</pre>





</body>

</html>