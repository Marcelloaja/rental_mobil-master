<?php
// Database connection details
$host = "sql309.infinityfree.com";
$driver = "mysql";
$username = "if0_35124824";
$password = "XxQZAxDaEVlo";
$database = "if0_35124824_rental_mobil";

try {
    $koneksi = new PDO("$driver:host=$host;dbname=$database", $username, $password);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Determine the protocol (http or https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
// Determine the domain
$domain = $_SERVER['HTTP_HOST'];
// Construct the dynamic base URL
$url = "$protocol://$domain/";

// Fetch data from infoweb table
try {
    $sql_web = "SELECT * FROM infoweb WHERE id = 1";
    $row_web = $koneksi->prepare($sql_web);
    $row_web->execute();
    $info_web = $row_web->fetch(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Error fetching data from infoweb table: " . $e->getMessage());
}

// Turn off error reporting (you already have this in your code)
error_reporting(0);
?>
