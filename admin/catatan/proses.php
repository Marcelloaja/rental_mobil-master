<?php
require '../../koneksi/koneksi.php';
$title_web = 'Tambah Catatan';
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}

if ($_GET['aksi'] == 'tambah') {    
    $data[] = $_POST['deskripsi'];
    $data[] = $_POST['total_keluar'];

    $sql = "INSERT INTO `catatan`(`deskripsi`, `total_keluar`) VALUES (?,?)";
    $row = $koneksi->prepare($sql);
    $row->execute($data);
    echo '<script>window.location="../../admin"</script>';
}

if ($_GET['aksi'] == 'edit') {
    $id = $_GET['id'];
    $data[] = $_POST['deskripsi'];
    $data[] = $_POST['total_keluar'];

    $data[] = $id;
    $sql = "UPDATE catatan SET deskripsi= ?, total_keluar=? WHERE id = ?";
    $row = $koneksi->prepare($sql);
    $row->execute($data);

    echo '<script>window.location="../plat/plat.php"</script>';
}


if (!empty($_GET['aksi'] == 'hapus')) {
    $id = $_GET['id'];

    $sql = "DELETE FROM catatan WHERE id = ?";
    $row = $koneksi->prepare($sql);
    $row->execute(array($id));

    echo '<script>window.location="../../admin"</script>';
}
