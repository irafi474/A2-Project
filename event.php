<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event</title>
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
  <style>
    .card-img-top {
      width: 100%;
      /* Lebar gambar 100% dari kartu */
      height: 200px;
      /* Atur tinggi gambar sesuai kebutuhan untuk kartu */
      object-fit: cover;
      /* Memastikan gambar tidak terdistorsi */
    }
    .card-body {
        flex-grow: 1; /* Allow card body to fill available space */
    }
    .btn-block {
        width: 100%; /* Full width for buttons */
    }
  </style>
</head>

<body>
  <nav><?php include "navbar.php"; ?></nav>

  <section>
    <div class="mt-5 ms-5">
      <button type="button" class="btn btn-danger">Upcoming Event</button>
    </div>
    <div class="row mt-4">
      <?php
      include 'db.php'; // Include database connection file

      // Fetch upcoming events
      $sql = "SELECT eventid, eventname, eventdescription, eventdate, image FROM event WHERE status = 'Upcoming'";
      $result = $db->query($sql);

      if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()): ?>
          <div class="col-3 mt-2 ms-5">
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
      <?php else: ?>
        <p class="text-center">No cards found.</p>
      <?php endif; ?>
    </div>
  </section>
</body>

</html>
