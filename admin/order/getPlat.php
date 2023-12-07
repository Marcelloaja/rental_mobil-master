<?php
$dbname = "if0_35124824_rental_mobil";
$username = "if0_35124824";
$password = "XxQZAxDaEVlo";
$servername = "sql309.infinityfree.com";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Ambil parameter 'merk' dari URL
$selectedMerk = $_GET['merk'];

// Query untuk mendapatkan daftar plat nomor mobil sesuai dengan merk yang dipilih
$sql = "SELECT no_plat FROM mobil WHERE merk = '$selectedMerk'";
$result = $conn->query($sql);

$platOptions = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $platOptions[] = $row['no_plat'];
  }
}

// Mengembalikan daftar plat nomor dalam format JSON
echo json_encode($platOptions);

$conn->close();
?>
