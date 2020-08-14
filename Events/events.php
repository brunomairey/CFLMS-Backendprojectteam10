<?php require_once '../db_connect.php'; ?>



<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../style_MANUELA.css">
    <title>Events</title>

</head>

<body>
<?php require_once '../header.php'; ?>
    <!-- bootstrap version -->
    <nav class="navbar sticky-top navbar-light bg-light">

        <div class="mx-auto">

            <a class="btn btn-outline-info" href="../Login/login.php" role="button">Admin</a>

        </div>
    </nav>



    <nav class="navbar navbar-dark bg-white">



<div>
            <form>
                <p class="text-success">SEARCH</p>
                <input type="text" name="search" id="search">
            </form>

            <p id="result"></p>
        </div>
</nav>

    <!-- <div class="container autos row row-cols-1 row-cols-md-2 row-cols-lg-3 mx-auto"> -->
    <div class="container row row-cols-1 row-cols-md-2 row-cols-lg-2 mx-auto">

        <?php
        $sql = "SELECT * FROM events";


        //nicer version
        $result = mysqli_query($conn, $sql);
        // fetch the next row (as long as there are any) into $row
        while ($row = mysqli_fetch_assoc($result)) {
            $eventID = $row['eventID'];
            $eventName = $row['eventName'];
            $eventDate = $row['eventDate'];
            $location = $row['eventLocation'];
            $description = $row['eventDescription'];
            $image = $row['image'];


        ?>

<div class="col mb-3 ">
                <div class="card card_event px-1 py-1 bg-light">
                <img class="card-img-top pt-2" src="<?= $row['image'] ?>" alt="" width="100%" height="250vw" class="rounded">
                    <!-- <h5 class="card-title text-secondary"><?= $eventID ?></h5> -->

                    <div class="card-body">
                        <h3 class="card-text text-info font-weight-bold"><?= $eventName ?> <span></span> </h3>

                        <h6 class='card-text'><span class='font-weight-bold'>WHEN: </span> <?= $eventDate ?><span class="font-weight-bold">     WHERE:</span> <?= $location ?>
                        </h6>
                        <h6 class='card-text'><span class='font-weight-bold'>WHAT: </span> <?= $description ?>
                        </h6>

                    </div>
                    

                </div>
            </div>


        <?php
        }

        // Free result set
        mysqli_free_result($result);
        // Close connection
        mysqli_close($conn);
        ?>


<script>
        //Search function AJAX
        var request;

        //PART SEARCH
        // Bind to the submit event of our form
        $("#search").keyup(function(event) {

            // Prevent default posting of form - put here to work in case of errors
            event.preventDefault();

            // Abort any pending request
            if (request) {
                request.abort();
            }
            // setup some local variables
            var $form = $(this);

            // Let's select and cache all the fields
            var $inputs = $form.find("input, select, button, textarea");

            // Serialize the data in the form
            var serializedData = $form.serialize();

            // console.log(serializedData);
            var search = document.getElementById("search").value;
            if (search.length > 0) {
                $inputs.prop("disabled", true);

                // Fire off the request to /form.php
                request = $.ajax({
                    url: "search.php",
                    type: "post",
                    data: serializedData
                });

                // Callback handler that will be called on success
                request.done(function(response, textStatus, jqXHR) {
                    // Log a message to the console
                    document.getElementById("result").innerHTML = response;
                    // console.log(response);
                });

                // Callback handler that will be called on failure
                request.fail(function(jqXHR, textStatus, errorThrown) {
                    // Log the error to the console
                    console.error(
                        "The following error occurred: " +
                        textStatus, errorThrown
                    );
                });

                // Callback handler that will be called regardless
                // if the request failed or succeeded
                request.always(function() {
                    // Reenable the inputs
                    $inputs.prop("disabled", false);
                });
            } else {
                document.getElementById("result").innerHTML = "";
            }
            // search => 
            // Let's disable the inputs for the duration of the Ajax request.
            // Note: we disable elements AFTER the form data has been serialized.
            // Disabled form elements will not be serialized.

        });
    </script>

    </div>

</body>

</html>