<!DOCTYPE html>
<html>

<head>
    <title>Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>

    <?php
    include 'db.php'; // Including the database connection file
    $accountID = isset($_GET['accountID']) ? $_GET['accountID'] : '';
    
    // Fetching events from the database
    $sql1 = "SELECT * FROM event";
    $get = mysqli_query($db, $sql1);
    ?>

    <div class="container" style="margin-top: 20px">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary" href="addevent.php?accountID=<?php echo $accountID; ?>" role="button">Add Event</a>
                
                <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($get) > 0) {
                            while ($data = mysqli_fetch_array($get)) {
                        ?>
                                <tr>
                                    <td><?php echo $data['eventid']; ?></td>
                                    <td><?php echo $data['eventname']; ?></td>
                                    <td><?php echo $data['eventdescription']; ?></td>
                                    <td><?php echo $data['eventdate']; ?></td>
                                    <td><?php echo $data['image']; ?></td>
                                    <td><?php echo $data['status']; ?></td>
                                    <td>
                                        <a class="btn btn-warning" href="update.php?eventid=<?php echo $data['eventid']; ?>">Update</a>
                                        <a class="btn btn-danger" href="delete.php?eventid=<?php echo $data['eventid']; ?>">Delete</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6'><h5>No Record Found</h5></td></tr>";
                        }
                        ?>
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
    </script
