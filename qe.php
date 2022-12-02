<?php

/*

    Quick generic demo of the Question Editor
    Based on https://demos.vg.learnosity.com/authoring/questioneditor/editteachermcq.php

*/

require_once './sdk/src/LearnositySdk/autoload.php';


use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

?>
<!doctype html>

<head>
    <title>QE demo</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="well" style="margin-bottom:0px;">
        <div class="container">
            <h3 style="margin-top:1px;">Question Editor</h3>
            <h6>Question Editor Math Demo</h6>
        </div>
    </div>

    <div class="container" style="margin-top:20px;">
        <div class="row">
            <div class="col-sm-8">
                <!-- Buttons -->
                <div>
                    <button class="btn btn-info btn-student">Student</button>
                    <button class="btn btn-info btn-author">Author</button>
                </div>

                <!-- This section contains a Div for each of the two QE modes -->
                <div class="my-question-editor">
                    <div class="view_edit" style="display: none">
                        <span data-lrn-qe-layout-edit-panel></span>
                    </div>
                    <div class="view_preview">
                        <!-- ML - needs to be styled better
                         <span data-lrn-qe-layout-live-score></span> -->
                        <span data-lrn-qe-layout-preview-panel></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                Sample Answers
            </div>
        </div>



    </div>

    <script src="https://questioneditor-va.learnosity.com?v2018.1.LTS"></script>

    <!--  Custom FormulaV2 layout -->
    <script type="text/template" data-lrn-qe-layout="custom_formulaV2_layout">
        <div class="lrn-qe-edit-form">
            <span data-lrn-qe-label="stimulus">Yeah</span>
            <span data-lrn-qe-input="stimulus" class="lrn-qe-ckeditor-lg"></span>

            <div data-lrn-qe-loop="validation.valid_response.value[*]">
                <div class="lrn-qe-row-flex">
                    <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-12 lrn-qe-col-md-9">
                        <span data-lrn-qe-label="validation.valid_response.value[*].value"></span>
                        <span data-lrn-qe-input="validation.valid_response.value[*].value"></span>
                    </div>
                    <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-12 lrn-qe-col-md-3">
                        <span data-lrn-qe-label="validation.valid_response.value[*].options.ignoreOrder"></span>
                        <span data-lrn-qe-input="validation.valid_response.value[*].options.ignoreOrder"></span>
                    </div>
                </div>
            </div>
        </div>
    </script>
    <!--/ Custom Layout -->

    <script>
        var widget_json = {
                "is_math": true,
                "stimulus": "Factor the following: \\(x^2+9+18\\)",
                "type": "formulaV2",
                "validation": {
                    "scoring_type": "exactMatch",
                    "valid_response": {
                        "score": 1,
                        "value": [{
                            "method": "equivSymbolic",
                            "options": {
                                "inverseResult": false,
                                "decimalPlaces": 10
                            },
                            "value": "\\left(x+3\\right)\\left(x+6\\right)"
                        }]
                    }
                },
                "ui_style": {
                    "type": "floating-keyboard"
                },
                "instant_feedback": true
            },

            // var widget_json = {
            //     "is_math": true,
            //     "stimulus": "Expand the following equation:</p><p>\\(3\\left(1+4\\right)\\)",
            //     "type": "formulaV2",
            //     "validation": {
            //         "scoring_type": "exactMatch",
            //         "valid_response": {
            //             "score": 1,
            //             "value": [{
            //                 "method": "equivLiteral",
            //                 "value": "15",
            //                 "options": {
            //                     "allowThousandsSeparator": true,
            //                     "ignoreOrder": false,
            //                     "inverseResult": false,
            //                     "ignoreTrailingZeros": true,
            //                     "setThousandsSeparator": [","],
            //                     "setDecimalSeparator": "."
            //                 }
            //             }]
            //         }
            //     },
            //     "ui_style": {
            //         "type": "block-keyboard"
            //     },
            //     "math_renderer": "mathquill"
            // },



            initOptions = {
                widgetType: 'response',
                configuration: {
                    consumer_key: '<?php echo $consumer_key; ?>'
                },
                widget_json: widget_json,
                rich_text_editor: {
                    type: 'wysihtml'
                },
                ui: {
                    layout: {
                        edit_panel: {
                            formulaV2: [{
                                layout: 'custom_formulaV2_layout'
                            }]
                        },
                        global_template: 'custom'
                    }
                },
                question_types: {
                    mcq: {
                        dependency: ['options', 'metadata.distractor_rationale_response_level']
                    }
                },
                label_bundle: {
                    debug: false,
                    stimulus: "Question:",
                    options: "Options:",
                    'validation.valid_response.value.value': 'Correct answer:'
                },
                dependencies: {
                    questions_api: {
                        init_options: {
                            beta_flags: {
                                reactive_views: true
                            }
                        }
                    }
                }
            },
            qeApp = LearnosityQuestionEditor.init(initOptions, '.my-question-editor');

        qeApp.on('widget:ready', function() {});

        $(function() {
            var $reviewModal = $('.qe-edit-layout-modal'),
                editLayoutContent = $('[data-lrn-qe-layout="custom_formulaV2_layout"]').html();

            var view_edit = $('.view_edit');
            var view_preview = $('.view_preview');
            $('.btn-student').prop("disabled", true);

            $('.btn-student').on('click', function() {
                view_edit.hide();
                view_preview.show();
                $('.btn-student').prop("disabled", true);
                $('.btn-author').prop("disabled", false);
                qeApp.updatePreview();
            })

            $('.btn-author').on('click', function() {
                view_preview.hide();
                view_edit.show();
                $('.btn-author').prop("disabled", true);
                $('.btn-student').prop("disabled", false);
            })

        });
    </script>

</body>

</html>