<?php
 include '../db.php'; // Including the database connection file
 $eventid = isset($_GET['eventid']) ? $_GET['eventid'] : '';


if (!$db) {
    die("tidak bisa connect");
}


if (isset($_POST['simpan'])) {
    // $ID = $_POST['ID'];
    $eventname = $_POST['eventname'];
    $location = $_POST['location'];
    $explan = $_POST['eventexplan'];
    $description = $_POST['eventdescription'];
    $eventdate = $_POST['eventdate'];
    $birthdate = $_POST['birthdate'];
    $status = $_POST['status'];
    $link = $_POST['link'];

    // update

    // $QUERY = "UPDATE data_employee SET NIK = '$NIK', first_name = '$first_name', middle_name = '$middle_name',
    // last_name ='$last_name', full_name = '$full_name', birthplace = '$birthplace', birthdate = '$birthdate', gender = '$gender',
    // grade_name = '$grade_name' WHERE ID = '$ID'";



    $result = mysqli_query($db, "UPDATE event SET eventname = '$eventname', location = '$location', eventexplan = '$explan',
    eventdescription = '$description', eventdate = '$eventdate', status = '$status', link = '$link' WHERE eventid = '$eventid'");


    header("Location:dashboard.php");
}

?>

<?php

$result = mysqli_query($db, "SELECT * FROM event WHERE eventid='$eventid'");


while ($data = mysqli_fetch_array($result)) {
    $eventname = $data['eventname'];
    $location = $data['location'];
    $eventexplan = $data['eventexplan'];
    $description = $data['eventdescription'];
    $eventdate = date('Y-m-d', strtotime($data['eventdate']));
    $status = $data['status'];
    $link = $data['link'];
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mt-4">
        <a href='dashboard.php'><button>back to home</button></a>
    </div>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Edit Event
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <input type="hidden" name="eventid" value="<?php echo $eventid ?>">
                        <label for="eventname" class="form-label">Event name</label>
                        <input type="text" class="form-control" id="eventname" name="eventname" value="<?php echo $eventname; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" name="location" id="location" value="<?php echo $location; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="eventdescription" value="<?php echo $description; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="eventexplan" class="form-label">Event Explanation</label>
                        <!-- Textarea doesn't use the "value" attribute, the text should be between the tags -->
                        <textarea class="form-control" id="eventexplan" name="eventexplan"><?php echo $eventexplan; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="eventdate" class="form-label">Date</label>
                        <input type="date" class="form-control" name="eventdate" id="eventdate" value="<?php echo $eventdate; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="" disabled selected>- Choose Status</option>
                            <option value="Upcoming" <?php if ($status == "Upcoming") echo "selected"; ?>>Upcoming</option>
                            <option value="Incoming" <?php if ($status == "Incoming") echo "selected"; ?>>Incoming</option>
                            <option value="Done" <?php if ($status == "Done") echo "selected"; ?>>Done</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" class="form-control" name="link" id="link" value="<?php echo $link; ?>">
                    </div>

                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>
