<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="style.css" />
    <title>A2 Entertainment</title>
</head>
<body>
    <!-- Navbar -->
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
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
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
                </ul>
            </div>
        </div>
    </nav>

    <section>
        <?php
            include "db.php"; // Koneksi database

            $id = isset($_GET['id']) ? $_GET['id'] : '';

            // Query untuk mengambil event utama
            $queryMainEvent = "SELECT eventname,location ,eventexplan, eventdate, image, link 
                               FROM event 
                               WHERE eventid = '$id'";
            $resultMainEvent = mysqli_query($db, $queryMainEvent);

            // Variabel untuk menyimpan data event utama
            if ($resultMainEvent && mysqli_num_rows($resultMainEvent) > 0) {
                $row = mysqli_fetch_assoc($resultMainEvent);
                $eventName = $row['eventname'];
                $location = $row['location'];
                $eventexplan = $row['eventexplan'];
                $eventDate = date("d-m-Y", strtotime($row['eventdate']));
                $mainImage = "gambar/photos/" . $row['image']; // Gambar utama
                $link = $row['link'];
            } else {
                $eventName = "Event not found"; 
                $eventexplan = "";
                $eventDate = "";
                $mainImage = "";
                $link = "";
            }

            // Query untuk mengambil gambar tambahan dari tabel event_images
            $queryAdditionalImages = "SELECT image_name, artist_name 
                                       FROM event_images 
                                       WHERE eventid = '$id'";
            $resultAdditionalImages = mysqli_query($db, $queryAdditionalImages);

            $additionalImages = []; // Array untuk menyimpan gambar tambahan

            // Ambil data hasil query gambar tambahan
            if ($resultAdditionalImages) {
                while ($row = mysqli_fetch_assoc($resultAdditionalImages)) {
                    // Gabungkan gambar dan artist dalam array asosiatif
                    $additionalImages[] = [
                        'image' => "gambar/photos/" . $row['image_name'],
                        'artist' => $row['artist_name']
                    ];
                }
            } else {
                echo "Error: " . mysqli_error($db); // Debug: Tampilkan error jika ada
            }
        ?>

        <!-- Tampilkan gambar utama jika ada -->
        <?php if (!empty($mainImage)) : ?>
            <img src="<?php echo $mainImage; ?>" style="width: 100%; height: auto;">
        <?php else : ?>
            <p style="color: white;">No image available</p>
        <?php endif; ?>

        <div class="mt-3">
            <div style="text-align: center;">
                <h1 style="color: white;"><?php echo $eventName; ?></h1>
                <h4 style="color: white;"><?php echo $location; ?></h4>
                <h5 style="color: white; font-weight: lighter;"><?php echo date("d F Y", strtotime($eventDate)); ?></h5>
            </div>
            <div style="text-align: center;">
                <?php if (!empty($link)) : ?>
                    <a class="btn btn-warning" href="<?php echo $link; ?>" target="_blank">Get a Ticket</a>
                <?php else : ?>
                    <p style="color: white;">Ticket link not available</p>
                <?php endif; ?>
            </div>
            <p class="ms-5 me-5 mt-5" style="color: white; text-align: justify;"><?php echo $eventexplan; ?></p>
        </div>
    </section>

    <!-- Menampilkan gambar tambahan dari event_images -->
    <section>
    <h3 class="btn btn-danger ms-5 mt-5">Featuring Event</h3>

        <div class="ms-5 mt-3">
            <div class="d-flex flex-wrap">
                <?php foreach ($additionalImages as $imageData) : ?>
                    <div>
                        <div class="me-3 mb-3">
                            <img src="<?php echo $imageData['image']; ?>" style="width: 150px; height: auto;">
                            <!-- Tampilkan artist name di bawah gambar -->
                            <p style="text-align: center; color: white;"><?php echo $imageData['artist']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</body>
</html>
