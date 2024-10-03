<!DOCTYPE html>
<html>

<head>
    <title>Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <style>
        /* CSS untuk membuat table fixed width */
        table.dataTable {
            table-layout: fixed; /* Set table-layout menjadi fixed */
            width: 100%; /* Lebar tabel penuh */
        }

        /* Tentukan lebar untuk setiap kolom */
        th, td {
            word-wrap: break-word; /* Memastikan teks dalam sel terbungkus */
            white-space: normal; /* Membuat teks dalam tabel normal (tidak terpotong) */
        }

        /* Set lebar kolom secara spesifik */
        th:nth-child(1), td:nth-child(1) {
            width: 10%; /* Event ID */
        }
        th:nth-child(2), td:nth-child(2) {
            width: 15%; /* Event Name */
        }
        th:nth-child(3), td:nth-child(3) {
            width: 10%; /* Location */
        }
        th:nth-child(4), td:nth-child(4) {
            width: 20%; /* Description */
        }
        th:nth-child(5), td:nth-child(5) {
            width: 10%; /* Date */
        }
        th:nth-child(6), td:nth-child(6) {
            width: 10%; /* Image */
        }
        th:nth-child(7), td:nth-child(7) {
            width: 10%; /* Link */
        }
        th:nth-child(8), td:nth-child(8) {
            width: 10%; /* Status */
        }
        th:nth-child(9), td:nth-child(9) {
            width: 15%; /* Action */
        }
    </style>
</head>

<body>

    <?php
    include 'db.php'; // Including the database connection file
    $accountID = isset($_GET['accountID']) ? $_GET['accountID'] : '';
    
    // Fetching events from the database
    $sql1 = "SELECT * FROM event ORDER BY eventid DESC";
    $get = mysqli_query($db, $sql1);
    ?>

    <div class="container" style="margin-top: 20px">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary" href="addevent.php?accountID=<?php echo $accountID; ?>" role="button">Add Event</a>
                
                <!-- Dropdown untuk filter status -->
                <div class="mb-3">
                    <label for="statusFilter">Filter by Status:</label>
                    <select id="statusFilter" class="form-control" style="width: 200px;">
                        <option value="">All</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Image</th>
                            <th>Link</th>
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
                                    <td><?php echo $data['location']; ?></td>
                                    <td><?php echo $data['eventdescription']; ?></td>
                                    <td><?php echo $data['eventdate']; ?></td>
                                    <td><?php echo $data['image']; ?></td>
                                    <td><?php echo $data['link']; ?></td>
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
    $(document).ready(function () {
    // Initialize DataTable
    var table = $('#table_id').DataTable({
        "searching": true, // Enable searching
        "paging": true,    // Enable pagination
        "info": true,      // Show table info
        "order": [[0, "desc"]], // Order by the first column (Event ID) in descending order
    });

    // Apply status filter
    $('#statusFilter').on('change', function () {
        table.column(7).search(this.value).draw(); // Column status is index 7
    });
});
</script>
</body>

</html>
