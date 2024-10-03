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
    <style>
      /* CSS untuk memastikan gambar menyesuaikan dengan kartu */
      .banner-carousel img {
        width: 100%; /* Lebar gambar 100% dari carousel */
        height: 720px; /* Atur tinggi gambar sesuai kebutuhan untuk banner */
        object-fit: cover; /* Memastikan gambar tidak terdistorsi */
      }

      .card-img-top {
        width: 100%; /* Lebar gambar 100% dari kartu */
        height: 200px; /* Atur tinggi gambar sesuai kebutuhan untuk kartu */
        object-fit: cover; /* Memastikan gambar tidak terdistorsi */
      }

      .carousel-item .card {
        width: 300px; /* Lebar tetap untuk card */
        margin: 10px; /* Mengatur jarak antar card */
      }

      @media (max-width: 768px) {
        .carousel-item .card {
          width: 100%; /* Lebar penuh di perangkat mobile */
          margin: 10px 0; /* Margin vertikal lebih kecil di perangkat mobile */
        }
      }

      .carousel-control-prev-icon,
      .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.8); /* Latar belakang lebih gelap */
        border-radius: 50%; /* Tombol bundar */
        width: 50px;
        height: 50px;
      }

      .carousel-control-prev,
      .carousel-control-next {
        width: 70px; /* Tombol lebih lebar */
      }
    </style>
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

    <!-- Carousel Banner Section -->
    <section>
      <?php
        include "db.php"; // Koneksi database

        // Query untuk mendapatkan event dengan status 'Upcoming'
        $query = "SELECT eventname, image FROM event WHERE status = 'Upcoming' AND image IS NOT NULL";
        $result = mysqli_query($db, $query);

        // Jika ada event yang ditemukan
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
    </section>

    <!-- Event Card Section -->
    <section>
    <div class="d-flex justify-content-between align-items-center mt-5 ms-5">
          <button type="button" class="btn btn-danger btn-block">Upcoming Event</button>
          <!-- <img  style="height: 2.4375rem" src="asset/a2 logo 1.png" alt=""> -->
          <a class="text-warning me-5" href="#">See More</a>
        </div>
  <div id="cardCarousel" class="carousel slide mt-5" data-bs-ride="carousel">
    <div class="carousel-inner">
      <?php
      include "db.php";

      $query = "SELECT eventid, eventname,eventexplan ,eventdescription, eventdate, image FROM event WHERE status = 'Upcoming'";
      $result = mysqli_query($db, $query);

      if (mysqli_num_rows($result) > 0) {
        $counter = 0;
        $totalCardsPerSlide = 3; // Pada layar besar

        while ($row = mysqli_fetch_assoc($result)) {
          $eventid = $row['eventid'];
          $eventName = $row['eventname'];
          $eventDescription = $row['eventdescription'];
          $eventexplan = $row['eventexplan'];
          $eventDate = $row['eventdate'];
          $image = $row['image'];
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
                <a href="ticket.php?id='.$eventid.'" class="btn btn-warning">Get Ticket</a>
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
  <!-- CSS to handle responsive layout -->
  <style>
    @media (max-width: 768px) {
      .carousel-item {
        display: block;
        text-align: center;
      }

      .carousel-inner {
        display: flex;
        overflow: hidden;
      }

      .carousel-item .row {
        flex-wrap: nowrap;
        justify-content: center;
      }

      .carousel-item .col-12 {
        flex: 0 0 100%;
        max-width: 100%;
      }

      .carousel-item.active,
      .carousel-item-next,
      .carousel-item-prev {
        transform: translateX(0);
      }
    }
  </style>

</section>


<section>
        <div class="d-flex justify-content-center align-items-center mt-5">
            <h1 style="color:white; font-weight: bold;">Our Partners</h1>
        </div>
        <img class="ms-5 mt-3" width="200" src="asset/tip tip.png" alt="">
</section>

<footer>
  <div class="container-fluid p-5">
</footer>

<!-- Bootstrap JS and custom JS for swipe gesture -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
