<!DOCTYPE html>
<html>

<head>
    <title>Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->

</head>

<body>

    <?php
    include 'db.php';
    $sql1 = "SELECT * from event";
    $get = mysqli_query($db, $sql1);
    $accountID = isset($_GET['accountID']) ? $_GET['accountID'] : '';

    ?>
    <div class="container" style="margin-top: 20px">
        <div class="row">
            <div class="col-md-12" class="w3-modal-content w3-card-3">
            <a class="btn btn-primary" href="addevent.php?accountID=<?php echo $accountID; ?>" role="button">Add Event</a>                <!-- <a href='insert.php'>Tambah Karyawan</a> -->
                </class=>
                <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="table1">
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $query = "SELECT * FROM event";
                            $query_run = mysqli_query($db, $sql1);

                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $data) {
                            ?>

                        <tr>
                    <?php
                                    while ($data = mysqli_fetch_array($get)) {
                                        echo "<tr>";
                                        echo "<td>" . $data['eventid'] . "</td>";
                                        echo "<td>" . $data['eventname'] . "</td>";
                                        echo "<td>" . $data['eventdescription'] . "</td>";
                                        echo "<td>" . $data['eventdate'] . "</td>";
                                        echo "<td>" . $data['image'] . "</td>";
                                    }
                                }
                            } else {
                                echo "<h5> No Record Found </h5>";
                            }
                    ?>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_id').DataTable();
        });
    </script>
</body>

</html>