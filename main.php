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

  <link rel="stylesheet" href="style.css">
  <!-- Font Awesome -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    rel="stylesheet" />

  <title>A2 Entertainment</title>
  <style>
    /* CSS untuk memastikan gambar menyesuaikan dengan kartu */
    .banner-carousel img {
      width: 100%;
      height: auto;
      object-fit: cover;
    }

    .card-img-top {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .carousel-item .card {
      width: 300px;
      margin: 10px;
    }

    @media (max-width: 768px) {
      .carousel-item .card {
        width: 100%;
        margin: 10px 0;
      }
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      background-color: rgba(0, 0, 0, 0.8);
      border-radius: 50%;
      width: 50px;
      height: 50px;
    }

    .carousel-control-prev,
    .carousel-control-next {
      width: 70px;
    }

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
</head>

<body>
  <!-- Navbar -->
  <nav>
    <?php include "navbar.php" ?>
  </nav>

  <!-- Carousel Banner Section -->
  <section>
    <?php
    include "db.php"; // Koneksi database

    // Query untuk mendapatkan event dengan status 'Upcoming'
    $query = "SELECT eventname, image FROM event WHERE status = 'Upcoming' AND image IS NOT NULL";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
      echo '
          <div id="bannerCarousel" class="carousel slide mb-3 banner-carousel" data-bs-ride="carousel" data-bs-interval="2000">
            <div class="carousel-inner">';

      $isActive = true;
      while ($row = mysqli_fetch_assoc($result)) {
        $imagePath = 'gambar/photos/' . $row['image'];
        $eventName = $row['eventname'];
        $activeClass = $isActive ? 'active' : '';

        echo '
            <div class="carousel-item ' . $activeClass . '">
              <img class="d-block" src="' . $imagePath . '" alt="' . $eventName . '">
            </div>';

        $isActive = false;
      }

      echo '
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>';
    } else {
      echo "No upcoming events with images found.";
    }
    ?>
    <div class="d-flex justify-content-center">
      <div>
        <a href="https://www.instagram.com/a2entertaintment/" target="_blank">
          <div class="instagram-icon ms-4">
            <i class="fab fa-instagram"></i>
          </div>
          <p class="instagram-text">Instagram</p>
        </a>
      </div>
      <div class="ms-4">
        <a href="https://www.tiktok.com/@antarakreasidigital?_t=8rUiNwxJUKW&_r=1" target="_blank">
          <div class="instagram-icon ms-2">
            <i class="fab fa-tiktok"></i>
          </div>
          <p class="instagram-text">TikTok</p>
        </a>
      </div>
    </div>


  </section>

  <!-- Event Card Section -->
  <section>
    <div class="d-flex justify-content-between align-items-center mt-5 ms-5">
      <button type="button" class="btn btn-danger btn-block">Upcoming Event</button>
      <a class="text-warning me-5" href="event.php">See More</a>
    </div>
    <div id="cardCarousel" class="carousel slide mt-5" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php
        $query = "SELECT eventid, eventname,eventexplan ,eventdescription, eventdate, image FROM event WHERE status = 'Upcoming'";
        $result = mysqli_query($db, $query);

        if (mysqli_num_rows($result) > 0) {
          $counter = 0;
          $totalCardsPerSlide = 3;

          while ($row = mysqli_fetch_assoc($result)) {
            $eventid = $row['eventid'];
            $eventName = $row['eventname'];
            $eventDescription = $row['eventdescription'];
            $eventDate = $row['eventdate'];
            $imagePath = 'gambar/photos/' . $row['image'];

            if ($counter % $totalCardsPerSlide == 0) {
              if ($counter > 0) {
                echo '</div>';
                echo '</div>';
              }
              $activeClass = ($counter == 0) ? 'active' : '';
              echo '<div class="carousel-item ' . $activeClass . '">';
              echo '<div class="row justify-content-center">';
            }

            echo '
          <div class="col-12 col-md-4 d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
              <img class="card-img-top img-fluid" src="' . $imagePath . '" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">' . $eventName . '</h5>
                <p class="card-text" style="font-weight: lighter">' . date("d F Y", strtotime($eventDate)) . '</p>
                <p class="card-text">' . $eventDescription . '</p>
                <a href="ticket.php?id=' . $eventid . '" class="btn btn-warning">Get Ticket</a>
              </div>
            </div>
          </div>';

            $counter++;
          }

          if ($counter > 0) {
            echo '</div>';
            echo '</div>';
          }
        } else {
          echo "No upcoming events found.";
        }
        ?>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>

  <section>
    <div class="d-flex justify-content-center align-items-center mt-5">
      <h1 style="color:white; font-weight: bold;">Our Partners</h1>
    </div>
    <div class="d-flex justify-content-center">
      <img class="mt-3" width="200" src="asset/tiket.com" alt="">
    </div>
  </section>

  <footer>
    <div class="container-fluid p-5">
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const cardCarousel = document.querySelector('#cardCarousel');
      const carouselInstance = new bootstrap.Carousel(cardCarousel);

      let touchStartX = 0;
      let touchEndX = 0;

      cardCarousel.addEventListener('touchstart', function(event) {
        touchStartX = event.changedTouches[0].screenX;
      });

      cardCarousel.addEventListener('touchend', function(event) {
        touchEndX = event.changedTouches[0].screenX;
        handleSwipeGesture();
      });

      function handleSwipeGesture() {
        if (touchEndX < touchStartX - 40) {
          carouselInstance.next();
        }
        if (touchEndX > touchStartX + 40) {
          carouselInstance.prev();
        }
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>