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
      <div class="collapse navbar-collapse justify-content-end me-3" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link text-white active" aria-current="page" href="main.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="event.php">Event</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link text-white" href="#">Partnership</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link text-white" href="#">Contact Us</a>
          </li>
          <!-- Form pencarian harus dimasukkan dalam <li> -->
          <li class="nav-item">
            <form class="d-flex" action="search.php" method="GET">
              <input class="form-control me-2" type="search" name="search" placeholder="Search events or artists" aria-label="Search">
              <button class="btn btn-outline-warning" type="submit">Search</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>