<?php
// Koneksi ke database (gantilah dengan informasi koneksi Anda)
$dbname = "if0_35124824_rental_mobil";
$username = "if0_35124824";
$password = "XxQZAxDaEVlo";
$servername = "sql309.infinityfree.com";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Ambil merk mobil yang dipilih dari parameter GET
$merkMobil = $_GET["merk"];

// Query untuk mendapatkan harga mobil berdasarkan merk
$sql = "SELECT harga FROM mobil WHERE merk = '$merkMobil' LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil harga dari hasil query
    $row = $result->fetch_assoc();
    $hargaMobil = $row["harga"];

    // Kembalikan harga sebagai respons
    echo $hargaMobil;
} else {
    // Jika tidak ada hasil, kembalikan nilai kosong atau sesuai kebutuhan
    echo "0";
}

$conn->close();
?>