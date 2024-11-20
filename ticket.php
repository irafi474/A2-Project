<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    rel="stylesheet" />
    <title>A2 Entertainment</title>
</head>
<style>
     .instagram-icon {
      background: linear-gradient(45deg, #feda75, #fa7e1e, #d62976, #962fbf, #4f5bd5);
      width: 50px;
      /* Ukuran default lingkaran */
      height: 50px;
      /* Ukuran default lingkaran */
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }

    .instagram-icon i {
      color: #ffffff;
      font-size: 24px;
      /* Ukuran default ikon */
    }

    .instagram-icon:hover {
      transform: scale(1.1);
    }

    /* Responsif untuk teks dan ikon */
    .instagram-text {
      color: #ffffff;
      margin-left: 10px;
      font-size: 18px;
      /* Ukuran teks default */
    }

    .instagram-icon:hover .instagram-text {
      font-size: 20px;
      /* Ukuran teks saat hover */
    }

    /* Responsif ukuran untuk layar lebih kecil */
    @media (max-width: 768px) {
      .instagram-icon {
        width: 40px;
        height: 40px;
      }

      .instagram-icon i {
        font-size: 20px;
      }

      .instagram-text {
        font-size: 14px;
        /* Ukuran teks untuk tablet dan perangkat kecil */
        margin-left: 8px;
        /* Jarak teks dengan ikon */
      }
    }

    @media (max-width: 576px) {
      .instagram-icon {
        width: 35px;
        height: 35px;
      }

      .instagram-icon i {
        font-size: 18px;
      }

      .instagram-text {
        font-size: 12px;
        /* Ukuran teks untuk smartphone */
        margin-left: 6px;
        /* Jarak teks dengan ikon */
      }
    }
</style>
<body>
    <!-- Navbar -->
    <nav>
        <?php include "navbar.php" ?>
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
                    <p style="color: white;">Ticket not available</p>
                <?php endif; ?>
            </div>
            <div class="d-flex justify-content-center mt-4">
                <div>
                    <a href="https://www.instagram.com/a2entertaintment/" target="_blank">
                        <div class="instagram-icon ms-4">
                            <i class="fab fa-instagram"></i>
                        </div>
                        <p class="instagram-text">Instagram</p>
                    </a>
                </div>
                <div class="ms-1">
                    <a href="https://www.tiktok.com/@antarakreasidigital?_t=8rUiNwxJUKW&_r=1" target="_blank">
                        <div class="instagram-icon ms-2">
                            <i class="fab fa-tiktok"></i>
                        </div>
                        <p class="instagram-text">TikTok</p>
                    </a>
                </div>
            </div>
            <p class="ms-5 me-5 mt-3" style="color: white; text-align: justify;"><?php echo $eventexplan; ?></p>
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