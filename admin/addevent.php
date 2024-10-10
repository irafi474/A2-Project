<?php
include "../db.php"; // Pastikan file koneksi database di sini

$eventname = "";
$location = "";
$eventdescription = "";
$eventdate = "";
$status = "";
$image = "";
$error = "";
$sukses = "";

// Fungsi untuk mendapatkan nama file yang unik
function getUniqueFileName($uploadDir, $fileName)
{
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
    $eventname = isset($_POST['eventname']) ? mysqli_real_escape_string($db, $_POST['eventname']) : "";
    $location = isset($_POST['location']) ? mysqli_real_escape_string($db, $_POST['location']) : "";
    $eventdescription = isset($_POST['eventdescription']) ? mysqli_real_escape_string($db, $_POST['eventdescription']) : "";
    $eventexplan = isset($_POST['eventexplan']) ? mysqli_real_escape_string($db, $_POST['eventexplan']) : "";
    $eventdate = isset($_POST['eventdate']) ? mysqli_real_escape_string($db, $_POST['eventdate']) : "";
    $status = isset($_POST['status']) ? mysqli_real_escape_string($db, $_POST['status']) : "";
    $link = isset($_POST['link']) ? mysqli_real_escape_string($db, $_POST['link']) : "";

    // Direktori untuk menyimpan gambar
    $uploadDir = '../gambar/photos/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Mengunggah gambar utama (image)
    $image_name = getUniqueFileName($uploadDir, basename($_FILES['image']['name']));
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_path = $uploadDir . $image_name;

    // Memvalidasi dimensi gambar utama
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        list($width, $height) = getimagesize($image_tmp_name);
        if ($width == 970 && $height == 425) {
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $image = $image_name;
            } else {
                $error = "Gagal mengunggah gambar utama.";
            }
        } else {
            $error = "Gambar utama harus berukuran 970x425 piksel.";
        }
    } else {
        $error = "Terjadi kesalahan saat mengunggah gambar utama.";
    }

    // Memvalidasi input
    if (empty($eventname) || empty($location) || empty($eventdescription) || empty($eventdate) || empty($status) ||  empty($image)) {
        $error = "Semua field harus diisi.";
    } else {
        // Memasukkan data ke tabel event
        $sql1 = "INSERT INTO event (eventname, location, eventdescription, eventexplan, eventdate, status, link, image) 
                 VALUES ('$eventname', '$location', '$eventdescription', '$eventexplan', '$eventdate', '$status', '$link', '$image')";
        if (mysqli_query($db, $sql1)) {
            $eventid = mysqli_insert_id($db); // Dapatkan ID event yang baru dimasukkan

            // Mengunggah beberapa gambar featuring (imageft[]) dan menyimpan nama artis (artistname[])
            foreach ($_FILES['imageft']['tmp_name'] as $key => $tmp_name) {
                $imageft_name = getUniqueFileName($uploadDir, basename($_FILES['imageft']['name'][$key]));
                $imageft_tmp_name = $_FILES['imageft']['tmp_name'][$key];
                $imageft_path = $uploadDir . $imageft_name;
                $artist_name = mysqli_real_escape_string($db, $_POST['artistname'][$key]); // Ambil nama artis sesuai index gambar

                // Validasi dimensi gambar
                if ($_FILES['imageft']['error'][$key] === UPLOAD_ERR_OK) {
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
                        $error = "Gambar featuring harus berukuran 1080x1080 piksel.";
                    }
                } else {
                    $error = "Terjadi kesalahan saat mengunggah gambar featuring.";
                }
            }

            if (empty($error)) {
                $sukses = "Data berhasil disimpan beserta gambar.";
                header("Location: dashboard.php"); // Redirect ke dashboard setelah berhasil
                exit();
            }
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

                            .remove-btn {
                                cursor: pointer;
                                color: red;
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

                                        <form name="add" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                                            <div class="mb-3">
                                                <label for="eventname" class="form-label">Event Name</label>
                                                <input type="text" class="form-control" id="eventname" name="eventname" required>
                                                <span id="eventname-error" style="color: red;">Event Name harus diisi</span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="location" class="form-label">Location</label>
                                                <input type="text" class="form-control" id="location" name="location" required>
                                                <span id="location-error" style="color: red;">Location Harus Diisi</span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="eventdescription" class="form-label">Event Description</label>
                                                <input type="text" class="form-control" id="eventdescription" name="eventdescription" required>
                                                <span id="eventdescription-error" style="color: red;">Description Harus Diisi</span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="eventexplan" class="form-label">Detail Event</label>
                                                <textarea class="form-control" id="eventexplan" name="eventexplan" rows="4" required></textarea>
                                                <span id="eventexplan-error" style="color: red;">Detail Event Harus Diisi</span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="eventdate" class="form-label">Event Date</label>
                                                <input type="date" class="form-control" id="eventdate" name="eventdate" required>
                                                <span id="eventdate-error" style="color: red;">Date Harus Diisi</span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status Event</label>
                                                <select class="form-control" name="status" id="status" required>
                                                    <option value="" disabled selected>- Choose Status -</option>
                                                    <option value="Upcoming">Upcoming</option>
                                                    <option value="Incoming">Incoming</option>
                                                </select>
                                                <span id="status-error" style="color: red;">Pilih Salah Satu Status</span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="link" class="form-label">Ticket Link</label>
                                                <input type="url" class="form-control" id="link" name="link" >
                                                <span id="link-error" style="color: blue;">Masukan Link, Jika belum Ada Kosongkan</span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="image" class="form-label">Banner Image (970x425)</label>
                                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                                <span id="image-error" style="color: red;">Banner Image Hrus Diisi</span>
                                            </div>

                                            <div id="additional-images-container">
                                                <div class="mb-3 additional-image-row">
                                                    <label for="imageft[]" class="form-label">Artist Images (1080x1080)</label>
                                                    <input type="file" class="form-control" name="imageft[]" accept="image/*" required>
                                                    <span class="imageft-error" style="color: red;">Artist Image Harus Diisi</span>

                                                    <label for="artistname" class="form-label">Artist Name (corresponding to image)</label>
                                                    <input type="text" class="form-control" name="artistname[]" required>
                                                    <span class="artistname-error" style="color: red;">Artist Name Harus Diisi</span>
                                                    <span class="remove-btn" onclick="removeImageRow(this)">Remove</span>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-secondary" onclick="addImageRow()">Add Additional Image</button>
                                            <br><br>
                                            <button type="submit" name="simpan" class="btn btn-primary">Save Event</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Script for dynamically adding and removing input fields for featuring images -->
                        <script>
                            function addImageRow() {
                                const container = document.getElementById('additional-images-container');
                                const newRow = document.createElement('div');
                                newRow.classList.add('mb-3', 'additional-image-row');
                                newRow.innerHTML = `
                <label for="imageft[]" class="form-label">Artist Images (1080x1080)</label>
                <input type="file" class="form-control" name="imageft[]" accept="image/*" required>
                <span class="imageft-error" style="color: red;">Aertist Image Harus Diisi</span>
                
                <label for="artistname" class="form-label">Artist Name (corresponding to image)</label>
                <input type="text" class="form-control" name="artistname[]" required>
                <span class="artistname-error" style="color: red;">Artist Name Harus Diisi</span>
                <span class="remove-btn" onclick="removeImageRow(this)">Remove</span>
            `;
                                container.appendChild(newRow);
                            }

                            function removeImageRow(element) {
                                const row = element.parentElement;
                                row.remove();
                            }

                            function validateForm() {
                                let isValid = true;

                                // Clear previous error messages
                                document.querySelectorAll('span').forEach(span => span.textContent = '');

                                // Event Name Validation
                                let eventname = document.getElementById('eventname').value;
                                if (eventname === "") {
                                    document.getElementById('eventname-error').textContent = "Event name is required";
                                    isValid = false;
                                }

                                // Location Validation
                                let location = document.getElementById('location').value;
                                if (location === "") {
                                    document.getElementById('location-error').textContent = "Location is required";
                                    isValid = false;
                                }

                                // Event Description Validation
                                let eventdescription = document.getElementById('eventdescription').value;
                                if (eventdescription === "") {
                                    document.getElementById('eventdescription-error').textContent = "Event description is required";
                                    isValid = false;
                                }

                                // Event Explanation Validation
                                let eventexplan = document.getElementById('eventexplan').value;
                                if (eventexplan === "") {
                                    document.getElementById('eventexplan-error').textContent = "Event explanation is required";
                                    isValid = false;
                                }

                                // Date Validation
                                let eventdate = document.getElementById('eventdate').value;
                                if (eventdate === "") {
                                    document.getElementById('eventdate-error').textContent = "Event date is required";
                                    isValid = false;
                                }

                                // Status Validation
                                let status = document.getElementById('status').value;
                                if (status === "") {
                                    document.getElementById('status-error').textContent = "Event status is required";
                                    isValid = false;
                                }

                                // Ticket Link Validation
                                // let link = document.getElementById('link').value;
                                // if (link === "") {
                                //     document.getElementById('link-error').textContent = "Ticket link is required";
                                //     isValid = false;
                                // }

                                // Main Image Validation
                                let image = document.getElementById('image').files[0];
                                if (!image) {
                                    document.getElementById('image-error').textContent = "Main image is required";
                                    isValid = false;
                                } else {
                                    let img = new Image();
                                    img.onload = function() {
                                        if (this.width !== 970 || this.height !== 425) {
                                            document.getElementById('image-error').textContent = "Image must be 970x425";
                                            isValid = false;
                                        }
                                    };
                                    img.src = URL.createObjectURL(image);
                                }

                                // Additional Images Validation
                                const imageInputs = document.querySelectorAll('input[name="imageft[]"]');
                                imageInputs.forEach((input, index) => {
                                    if (!input.files[0]) {
                                        input.nextElementSibling.textContent = "Image is required";
                                        isValid = false;
                                    } else {
                                        let img = new Image();
                                        img.onload = function() {
                                            if (this.width !== 1080 || this.height !== 1080) {
                                                input.nextElementSibling.textContent = "Image must be 1080x1080";
                                                isValid = false;
                                            }
                                        };
                                        img.src = URL.createObjectURL(input.files[0]);
                                    }
                                });

                                return isValid;
                            }
                        </script>

                    </body>

                    </html>