<?php
include "db.php"; // Pastikan file koneksi database di sini

$eventname = "";
$location = "";
$eventdescription = "";
$eventdate = "";
$status = "";
$image = "";
$error = "";
$sukses = "";

// Fungsi untuk mendapatkan nama file yang unik
function getUniqueFileName($uploadDir, $fileName) {
    $filePath = $uploadDir . $fileName;
    $fileInfo = pathinfo($fileName);
    $baseName = $fileInfo['filename'];
    $extension = $fileInfo['extension'];
    $counter = 1;

    // Cek apakah file sudah ada, jika ada tambahkan angka di belakangnya
    while (file_exists($filePath)) {
        $filePath = $uploadDir . $baseName . '-' . $counter . '.' . $extension;
        $counter++;
    }
    
    return basename($filePath); // Kembalikan nama file yang unik
}

if (isset($_POST['simpan'])) {
    $eventname = mysqli_real_escape_string($db, $_POST['eventname']);
    $location = mysqli_real_escape_string($db, $_POST['location']);
    $eventdescription = mysqli_real_escape_string($db, $_POST['eventdescription']);
    $eventexplan = mysqli_real_escape_string($db, $_POST['eventexplan']);
    $eventdate = mysqli_real_escape_string($db, $_POST['eventdate']);
    $status = mysqli_real_escape_string($db, $_POST['status']);
    $link = mysqli_real_escape_string($db, $_POST['link']);

    // Direktori untuk menyimpan gambar
    $uploadDir = 'gambar/photos/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Mengunggah gambar utama (image)
    $image_name = getUniqueFileName($uploadDir, basename($_FILES['image']['name']));
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_path = $uploadDir . $image_name;

    if (move_uploaded_file($image_tmp_name, $image_path)) {
        $image = $image_name;
    } else {
        $error = "Gagal mengunggah gambar utama.";
    }

    // Memvalidasi input
    if (empty($eventname) || empty($eventdescription) || empty($eventdate) || empty($status) || empty($link) || empty($image)) {
        $error = "Semua field harus diisi.";
    } else {
        // Memasukkan data ke tabel event
        $sql1 = "INSERT INTO event (eventname,location ,eventdescription, eventexplan, eventdate, status, link, image) 
                 VALUES ('$eventname','$location' ,'$eventdescription', '$eventexplan', '$eventdate', '$status', '$link', '$image')";
        if (mysqli_query($db, $sql1)) {
            $eventid = mysqli_insert_id($db); // Dapatkan ID event yang baru dimasukkan
            
            // Mengunggah beberapa gambar featuring (imageft[]) dan menyimpan nama artis (artistname[])
            foreach ($_FILES['imageft']['tmp_name'] as $key => $tmp_name) {
                $imageft_name = getUniqueFileName($uploadDir, basename($_FILES['imageft']['name'][$key]));
                $imageft_tmp_name = $_FILES['imageft']['tmp_name'][$key];
                $imageft_path = $uploadDir . $imageft_name;
                $artist_name = mysqli_real_escape_string($db, $_POST['artistname'][$key]); // Ambil nama artis sesuai index gambar
                
                // Validasi dimensi gambar
                list($width, $height) = getimagesize($imageft_tmp_name);
                if ($width == 1080 && $height == 1080) {
                    if (move_uploaded_file($imageft_tmp_name, $imageft_path)) {
                        // Simpan nama file dan nama artis ke tabel event_images dengan eventid
                        $sql2 = "INSERT INTO event_images (eventid, image_name, artist_name) VALUES ('$eventid', '$imageft_name', '$artist_name')";
                        mysqli_query($db, $sql2);
                    } else {
                        $error = "Gagal mengunggah gambar featuring.";
                    }
                } else {
                    $error = "Gambar harus berukuran 1080x1080 piksel.";
                }
            }

            $sukses = "Data berhasil disimpan beserta gambar.";
            header("Location: dashboard.php"); // Redirect ke dashboard setelah berhasil
            exit();
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($db);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <a href='dashboard.php'>
            <button class="btn btn-secondary">Back to Home</button>
        </a>

        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    Create Event
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($sukses): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $sukses; ?>
                        </div>
                    <?php endif; ?>

                    <form name="add" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="eventname" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="eventname" name="eventname" required>
                        </div>
                        <div class="mb-3">
                            <label for="Loaction" class="form-label">Location</label>
                            <input type="text" class="form-control" id="Location" name="Location" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventdescription" class="form-label">Event Description</label>
                            <input type="text" class="form-control" id="eventdescription" name="eventdescription" required>
                        </div>

                        <div class="mb-3">
                            <label for="eventexplan" class="form-label">Event Explanation</label>
                            <textarea class="form-control" id="eventexplan" name="eventexplan" rows="4" placeholder="Masukkan penjelasan acara..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="eventdate" class="form-label">Event Date</label>
                            <input type="date" class="form-control" id="eventdate" name="eventdate" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status Event</label>
                            <select class="form-control" name="status" id="status" required>
                                <option value="" disabled selected>- Choose Status</option>
                                <option value="Upcoming" <?php if ($status == "Upcoming") echo "selected" ?>>Upcoming</option>
                                <option value="Incoming" <?php if ($status == "Incoming") echo "selected" ?>>Incoming</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label">Ticket Link</label>
                            <input type="text" class="form-control" id="link" name="link" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Main Event Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        </div>

                        <div id="featuring-images">
                            <div class="mb-3">
                                <label for="imageft" class="form-label">Upload Artist & Featuring Images</label>
                                <input type="file" class="form-control" id="imageft" name="imageft[]" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="artistname" class="form-label">Artist Name</label>
                                <input type="text" class="form-control" id="artistname" name="artistname[]" required>
                            </div>
                        </div>

                        <button type="button" id="add-image" class="btn btn-outline-secondary mb-3">Add More Images</button>

                        <div class="col-12">
                            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for dynamically adding input fields for featuring images -->
    <script>
        document.getElementById('add-image').addEventListener('click', function () {
            const featuringImagesDiv = document.getElementById('featuring-images');
            const newImageField = `
                <div class="mb-3">
                    <label for="imageft" class="form-label">Upload Artist & Featuring Images</label>
                    <input type="file" class="form-control" name="imageft[]" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="artistname" class="form-label">Artist Name</label>
                    <input type="text" class="form-control" name="artistname[]" required>
                </div>`;
            featuringImagesDiv.insertAdjacentHTML('beforeend', newImageField);
        });
    </script>
</body>

</html>
