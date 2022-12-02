<?php

if (isset($_GET["user_id"])) {

    $user_id = $_GET["user_id"];
}

if (isset($_GET["title"])) {

    $title = $_GET["title"];
} else {
    $title = "Learnosity";
}

if (isset($_GET['session_id'])) {

    $session_id = $_GET['session_id'];
};
if (isset($_GET['activity_id'])) {

    $activity_id = $_GET['activity_id'];
};
if (isset($_GET['activity_template_id'])) {

    $activity_template_id = $_GET['activity_template_id'];
};

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
    $org = '&org=learnosity-demos';
    $consumer_key = 'yis0TYCu7U9V4o7M';
    $consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';
};
if (isset($_GET["logo"])) {
    $logo = $_GET["logo"];
} else {
    $logo = 'https://learnosity.com/wp-content/uploads/2018/11/learnosity-logo-1182x245-1024x212.png';
}


//Can create a form that asks the user what acitivity ID and User ID they want to pull a report from.  Can prepopulate those fields using URL string from completed test.  If empty, throw error.

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/lrn-favicon.png" sizes="32x32" type="image/png">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <title>Report Parameters</title>
</head>

<body>
    <div class='container-fluid'>
        <nav class="navbar navbar-dark bg-light">
            <a class="navbar-brand" href="#">
                <img src="<?php echo $logo; ?>" width="250" height="50" alt="" style="padding-left: 10px;">
            </a>
        </nav>

    </div>

    <div class="container">

        <!-- <h1 class="fs-1 text-center" style="margin-top: 5vh; background-color:#f2f2f2; padding:10px; border-radius:15px">Learnosity Analytics Demonstration Environment</h1> -->

        <div class=" card text-black bg-light mb-3 mx-auto" style="max-width: 100rem;">
            <div class="card-header text-center">
                <h1> Learnosity Analytics Demonstration Environment</h1>

            </div>
            <div class="card-body">
                <h4 class="card-title text-center">Instructions </h4>
                <h5 class="card-title text-center" style="border: solid black 2px; padding:8px; border-radius:5px"> Enter the Group ID below, to generate a list of all test takers who took the same test</h5>

                <div class="d-flex justify-content-center">

                    <input id="activity_search" style="display: block;width: 300px; height:35px; text-align:center; margin-bottom:10px" />
                </div>
                <div class="text-center">
                    <button id="getUsers" class="btn btn-dark text-center">
                        Get Users From Activity
                    </button>
                </div>

            </div>
        </div>




        <footer class="mx-auto text-center bg-light" style="width: 100%; position:fixed; left:0; bottom:0; color:black; padding:10px"><?php echo $title; ?>. &copy; 2022</footer>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {



            document.getElementById('getUsers').addEventListener("click", function() {


                let activity = document.getElementById("activity_search");
                if (activity.value === "") {
                    alert("please enter activity_id")

                    // need to get request to get_activity.php  Need to have org in URL string
                } else {
                    console.log(activity.value)

                    $.post(`/get_activity.php?<?php echo $org ?>`, {
                        activity_id: activity.value
                    }, function(response) {
                        console.log(response)
                        console.log(response.data)


                        console.log(response.data.length)
                        if (response.data.length === 0) {
                            alert("No data found")
                        } else {
                            let selection = [];


                            response.data.map(x => {
                                let users = {};
                                users.user_id = x.user_id;
                                users.session = x.session_id;
                                selection.push(users)



                                console.log(selection)
                            })

                            window.location.href = `/response_analysis.php?<?php echo $org ?>&users=${JSON.stringify(selection)}&activity_id=${activity.value}&logo=<?php echo $logo ?>&title=Response Analysis Results`

                        }



                    })
                }
            })
        })
    </script>

</body>

</html>