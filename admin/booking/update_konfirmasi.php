<?php
require '../../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $konfirmasi_pembayaran = $_POST['konfirmasi_pembayaran'];

    // Perform the database update here
    $sql = "UPDATE booking SET konfirmasi_pembayaran = :konfirmasi_pembayaran WHERE kode_booking = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':konfirmasi_pembayaran', $konfirmasi_pembayaran, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo 'Success'; // You can return a success message here
    } else {
        echo 'Error'; // You can return an error message here
    }
}
?>
