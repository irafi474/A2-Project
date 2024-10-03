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
$query = "SELECT eventname, eventdescription, image FROM event WHERE eventname LIKE '%$search%'";
$result = mysqli_query($db, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Search Results</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Search Results for "<?php echo htmlspecialchars($search); ?>"</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="gambar/photos/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['eventname']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['eventname']; ?></h5>
                                <p class="card-text"><?php echo $row['eventdescription']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No events found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
