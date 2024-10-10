<?php
include "db.php"; // Koneksi ke database

// Inisialisasi variabel pencarian
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
} elseif (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Query untuk mencari event berdasarkan eventname
$query = "SELECT eventid, eventname, eventdescription,eventdate ,image FROM event WHERE eventname LIKE '%$search%'";
$result = mysqli_query($db, $query);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Search Results</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <img src="asset/a2 logo 1.png" style="height: 2.4375rem" alt="Logo" />
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Partnership</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Contact Us</a>
                    </li>
                    <!-- Form pencarian -->
                    <form action="search.php" method="GET">
                        <input type="text" name="search" placeholder="Search events or artists">
                        <button class="btn btn-outline-warning" type="submit">Search</button>
                    </form>

                </ul>
            </div>
        </div>
    </nav>

    <section>
        <div class="container mt-5">
            <h2 style="color:white">Search Results for "<?php echo htmlspecialchars($search); ?>"</h2>

            <?php if (mysqli_num_rows($result) > 0): ?>
                <div class="row">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="gambar/photos/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['eventname']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['eventname']; ?></h5>
                                    <p class="card-text"><?php echo date("d F Y", strtotime($row['eventdate'])); ?></p>
                                    <p class="card-text"><?php echo $row['eventdescription']; ?></p>
                                    <a href="ticket.php?id=<?php echo $row['eventid']; ?>" class="btn btn-warning">Get Ticket</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No events found.</p>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>