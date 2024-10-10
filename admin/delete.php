<?php
include '../db.php'; // Menghubungkan ke database

// Cek apakah eventid ada di URL
if (isset($_GET['eventid'])) {
    $eventid = $_GET['eventid'];

    // Query untuk menghapus event berdasarkan eventid
    $sql = "DELETE FROM event WHERE eventid = $eventid";

    // Eksekusi query
    if (mysqli_query($db, $sql)) {
        // Jika berhasil, kembali ke halaman utama dengan pesan sukses
        header("Location: dashboard.php?delete_success=1");
    } else {
        // Jika gagal, kembali ke halaman utama dengan pesan gagal
        header("Location: dashboard.php?delete_error=1");
    }
} else {
    // Jika tidak ada eventid, kembali ke halaman utama
    header("Location: dashboard.php");
}
?>
