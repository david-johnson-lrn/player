<?php

if (isset($_GET["activity_template_id"])) {
    $activity_template_id = $_GET["activity_template_id"];
} else {
    $activity_template_id = '';
}

if (isset($_GET["activity_id"])) {
    $activity_id = $_GET["activity_id"];
} else {
    $activity_id = '';
}

if (isset($_GET["user_id"])) {

    $user_id = $_GET["user_id"];
} else {
    $user_id = '';
}

if (isset($_GET["logo"])) {

    $logo = $_GET["logo"];
} else {
    $logo = 'https://learnosity.com/wp-content/themes/learnosity/assets/img/LearnosityLogo.svg';
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="testForm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="icon" href="./images/lrn-favicon.png" sizes="32x32" type="image/png">
    <title>Select Your Test</title>
</head>

<body class="bg-light">

    <style>
        body {
            font-family: "Verdana";
            /* background-image: url("./images/bnwLearnosity.png");
            background-size: 500px; */
            background: rgba(0, 0, 0, 0.9);
            background-repeat: repeat;
        }

        .test-info input {
            display: inline-flex;
            width: 100%;
        }



        .centerForm {
            margin-bottom: 2vh;


        }

        button {
            margin: 5px;
        }
    </style>
    <!-- If i give the individual the ability to give their user ID and their Activity id, they can manage who is in what class for reporting -->
    <div class="container-fluid">
        <nav class="navbar navbar-light bg-light row" style="border-bottom: 5px solid;">


            <div class="col-sm-5">
                <a class="navbar-brand" href="#">
                    <img src="<?php echo $logo ?>" height="50" alt="" style="padding-left: 10px;">
                </a>
            </div>

        </nav>

    </div>
    <div class="container" style="margin-top:7vh;">
        <!-- Just an image -->


        <!-- <p>please fill out the form </p> -->

        <div class="card mx-auto" style="width: 70rem; margin-top:2vh;">

            <div class="card-body">
                <div class=" card text-black mb-3 mx-auto" style="max-width: 100rem;">
                    <div class="card-header text-center">
                        <h3 style="margin-bottom: 0;">Learnosity Assessment Tool Demonstration </h3>
                    </div>
                    <div class="container-fluid">
                        <!-- <div class="d-flex justify-content-center"> -->
                        <div class="centerForm">
                            <form style="margin:50px 50px 2vh 50px">
                                <div class="form-group row">
                                    <label class="col-3 col-form-label text-end">Test ID :</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control-plaintext" id="activity" placeholder="Activity Template ID" name="activity_template_id" style="border:0px; outline:0px; border-bottom:1px solid;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label text-end">Username :</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control-plaintext" id="username" placeholder="User ID" name="user_id" style="border:0px; outline:0px; border-bottom:1px solid;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label text-end">Group ID :</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control-plaintext" id="class" placeholder="Activity ID" name="activity_id" style="border:0px; outline:0px; border-bottom:1px solid;">
                                    </div>
                                </div>
                            </form>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary" type="button" id="check"> Save Settings </button>
                                <button id="submit" type="button" class="btn btn-success">Submit </button>
                            </div>
                        </div>

                        <!-- 
                            <form action="./assess.php" method="GET" class="test-info">
                                <div>
                                    <p class="formInfo">Test Reference ID</p><input type="text" id="activity" name="activity_template_id" placeholder="Enter Test ID" />
                                </div>

                                <div>
                                    <p class="formInfo">User ID: </p><input type="text" id="username" name="user_id" placeholder="Username">
                                </div>
                                <div>
                                    <p class="formInfo">Enter Test ID</p><input type="text" id="class" name="activity_id" placeholder="Group">
                                </div>

                                <input type="text" id="logo" name="logo" placeholder="Enter Logo" style="display:none">

                            </form> -->
                        <!-- </div> -->
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-center" style="margin-top: 3vh;">
            <button type="button" class="btn btn-outline-dark" id="hint">How does this work?</button>
            <button type="button" class="btn btn-outline-dark" style="display: none;" id="close">Close</button>

        </div>



    </div>

    <div id="instructions" style="display: none; width: 70rem; margin-top:2vh;" class="card mx-auto">
        <div class="card-body">
            <div class="container">

                <strong>
                    Test ID
                </strong>
                - This is the reference of the assessment built using the Learnosity Authoring Tool. (This may be prepopulated for you).

                <hr>

                <strong>
                    Username
                </strong>- This is the anonomized represantion of the individual taking the assessment. This should not be your real first or last name.

                <hr>

                <strong>
                    Group ID
                </strong>
                - If multiple test takers are taking the same test, they should be all part of the same group for a more accurate reporting option. (This may be prepopulated for you).
                <hr>
                <strong>
                    Save Settings
                </strong>
                This will update the URL address with values from the form to easily share to others taking the same test. User ID will not save (to prevent duplicate users)

            </div>
        </div>
    </div>


    <footer class="mx-auto text-center bg-dark" style="width: 100%; position:fixed; left:0; bottom:0; color:white; padding:10px">Sample by <a href="https://learnosity.com/">Learnosity.com </a></footer>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {



        console.log($("#instructions"))

        document.getElementById('activity').value = '<?php echo $activity_template_id; ?>';
        document.getElementById('username').value = '<?php echo $user_id; ?>'
        document.getElementById('class').value = '<?php echo $activity_id; ?>'
        // document.getElementById('logo').value = '<?php echo $logo; ?>'

        var urlParams = new URLSearchParams(window.location.search);
        console.log(urlParams.get('org'))


        if (urlParams.get('org') != '') {
            org = urlParams.get('org')
        } else {
            org = '';
        }

        console.log(org)

        $("#hint").click(function() {
            $("#close").show();

            $("#instructions").fadeIn()
            $("#hint").hide();
        })

        $("#close").click(function() {
            $("#instructions").fadeOut()
            $("#close").hide();
            $("#hint").show();

        })


        document.getElementById('check').addEventListener("click", function(event) {
            event.preventDefault();
            let activity = document.getElementById("activity")
            let username = document.getElementById("username")
            let className = document.getElementById("class")
            // let logo = document.getElementById('logo')

            if (activity.value === "" && username.value === "" && className.value === "") {
                alert("No Settings to Save")
            } else {
                username.value = "";
                var currentURL = new URL(window.location.href)
                // const queryString = window.location.search


                currentURL.search = '';
                var search_params = currentURL.searchParams;
                search_params.append("activity_id", className.value)
                search_params.append("user_id", username.value)
                search_params.append("activity_template_id", activity.value)
                // search_params.append("logo", logo.value)

                if (urlParams.get('org') != '') {
                    search_params.append("org", urlParams.get('org'))
                }
                //control if the activity ID entered is for a teacher survey
                // if (className.value === "teacherSurvey") {
                //     search_params.append("render", "false")
                // }


                currentURL.search = search_params.toString();

                let url = currentURL.toString();
                window.location.href = url

                console.log(url)
            }
        })


        document.getElementById("submit").addEventListener("click", function(event) {
            // event.preventDefault()
            if (urlParams.get('org') != '') {
                org = urlParams.get('org')
            } else {
                org = '';
            }

            console.log(org)

            let activity = document.getElementById("activity")
            let username = document.getElementById("username")
            let className = document.getElementById("class")

            if (username.value == "") {
                let confirmation = confirm("Username is empty would you like to proceed?")
                if (confirmation) {
                    username.value = "demo_student"
                } else {
                    return
                }
            }
            if (className.value == "") {
                let confirmation = confirm("Class ID is empty would you like to proceed?")
                if (confirmation) {
                    className.value = "Learnosity Demo"
                } else {
                    return
                }
            }

            if (activity.value != "") {
                window.location.href = `/assess.php?activity_template_id=${activity.value}&activity_id=${className.value}&user_id=${username.value}&org=${org}`;
            } else {
                event.preventDefault()
                alert("error: Missing Test Name")
                activity.setAttribute('value', 'Learnosity Demo')
            }

        })


    })
</script>

</html>