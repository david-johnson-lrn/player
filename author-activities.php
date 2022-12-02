<?php

require_once './sdk/src/LearnositySdk/autoload.php';


use LearnositySdk\Request\Init;


if (substr($_SERVER["HTTP_HOST"], 0, 9) === "localhost") {
    $domain = "localhost";
} else {
    $domain = $_SERVER["HTTP_HOST"];
}

//consumer key for Tech Sales Itembank
$consumer_key = 'Kbtat26gytHSxh0S';
$consumer_secret = 'q9O8Pwikp1WBzeNq4SuSl1jTf2hj32smmbYvqV7f';

//  Demos
// $consumer_key = 'yis0TYCu7U9V4o7M';
// $consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';

if (isset($_GET["client"])) {
    $tag = $_GET["client"];
} else {
    $tag = "Test";
}

if (isset($_GET["hex"])) {
    $hex = $_GET["hex"];
} else {
    $hex = "#C0C0C0";
}


$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];
//adding comments
//more comments
$request = [
    'mode'      => 'activity_list',
    'config'    => [
        'global' => [       //This is where we modify config to hide said tag (by organization, client etc.) https://reference.learnosity.com/author-api/initialization#config_global
            'hide_tags' => array(

                ["type" => "Prospect"]



            )
        ],
        'item_list' => [
            'item' => [
                'status' => true
            ],
            'filter' => [
                'restricted' => [ // Filters the view to show only provided tag type and name 
                    //https://reference.learnosity.com/author-api/initialization#config_item_list_filter_restricted_tags
                    'tags' => [
                        'all' => [
                            [
                                'type' => 'Prospect',
                                'name' => [
                                    $tag
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ],
        'activity_list' => [
            'status' => true,
            'filter' => [
                'restricted' => [ // Filters the view to show only provided tag type and name 
                    //https://reference.learnosity.com/author-api/initialization#config_item_list_filter_restricted_tags
                    'tags' => [
                        'all' => [
                            [
                                'type' => 'Prospect',
                                'name' => [
                                    $tag
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ],
        'activity_edit' => [
            'tags_on_create' => [
                [
                    "type" => 'Prospect',
                    "name" => $tag
                ]
            ],
            "player" => [
                'administration' => [
                    'show' => true
                ],
                'playback' => [
                    'scroll_to_top' => [
                        'show' => true,
                        'edit' => true
                    ],
                    'show_acknowledgements' => [
                        'show' => true,
                        'edit' => true

                    ],
                    'distractor_rationale' => [
                        'show' => true,
                        'edit' => true
                    ]

                ]
            ]
        ],
        'item_edit' => [
            //for some reason this is not working proplery
            // 'tags_on_create' => [
            //     [
            //         "type" => 'Propsect',
            //         'tags' => [
            //             "name" => $tag
            //         ]
            //     ]
            // ],
            'item' => [ //https://reference.learnosity.com/author-api/initialization#config_item_edit_item
                "back" => true,
                'reference' => [
                    'show' => true,
                    'edit' => true
                ],
                'dynamic_content' => true,
                'shared_passage' => true,
                "enable_audio_recording" => true
            ]


        ],
        "dependencies" => [
            "question_editor_api" => [
                "init_options" => [
                    "ui" => [
                        "distractor_rationale_button" => [
                            "enabled" => true,
                            "options" => ["perQuestion", "perResponse"]
                        ]
                    ]
                ]
            ],
            // "questions_api" => [
            //     'init_options' => [
            //         'show_distractor_rationale' => true
            //     ]
            // ]

        ],
        'questions_api_init_options' => [
            'show_distractor_rationale' => [
                'per_question' => 'always',
                'per_response' => 'always'
            ]
        ]

    ],
    'user' => [
        'id'        => " user"
    ]
];

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Author Activities</title>
</head>

<body style="height: 100vh;">

    <div class="" style="display: flex; height: 80px; background-color:<?php echo $hex; ?>; padding: 5px; justify-content:space-between; align-items:baseline">
        <div style="width:200px"></div>

        <div>
            <h3 style="background:white; border-radius:5px; padding:5px 10px 5px 10px;"><?php echo $tag; ?> Sample Author Enviornment</h3>
        </div>



        <div style="width:10%; height:10%;">
            <img src="https://co.udpglobal.com/sites/default/files/logo_udp_6.png" style="width: 100%;">
        </div>

    </div>
    <div class="container-fluid">

        <div class="card" style="margin:5%; border:solid red 1px">
            <div class="card-body">
                <div id="learnosity-author"></div>
            </div>
        </div>



    </div>


    <footer style="position:sticky; top:100%;  width:100%; background-color: <?php echo $hex; ?>; height:60px;">


        <div style="display: flex; justify-content:center" class="footer-copyright">
            <p style="margin-top:.8rem; background:white; border-radius:5px; padding:5px 10px 5px 10px; width:50%" class="text-center justify-content-center">© <?php echo date("Y"); ?> Copyright: Learnosity and <?php echo $tag; ?></p>

        </div>


    </footer>



    <script src="//authorapi.learnosity.com?v2022.2.LTS"></script>
    <script>
        var initOptions = <?php echo $signedRequest; ?>;

        var authorApp = LearnosityAuthor.init(initOptions, {

            readyListener: function() {
                console.log('Ready..');

                authorApp.on("activityedit:item:create", function() {
                    console.log('created Item')
                    authorApp.setActivityStatus('unpublished')
                })

                authorApp.on("activityedit:items:added", function() {
                    console.log('added Item')
                    authorApp.setActivityStatus('unpublished')
                })
                //using this as back up as the tags_on_create is not adding tags before save. 
                // authorApp.on('save', function(event) {

                //     try {

                //         let currentTags = authorApp.getItemTags();
                //         console.log(currentTags)

                //         if (currentTags.some(key => key.type === 'Prospect')) {
                //             console.log("Key found")
                //         } else {
                //             currentTags.push({
                //                 'type': "Prospect",
                // 'name': ''
                //             })

                //         }

                //         authorApp.setItemTags(currentTags);


                //     } catch (err) {
                //         console.log(err.message);
                //     }
                // });

                // Prior to saving a newly created item we need to apply the same tag used in this filtered list view so it will appear in the filtered view however allow for new tags also to be saved

            }
        });
    </script>

</body>

</html>