<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../koneksi/koneksi.php';
$title_web = 'Dashboard';
include 'header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}
// if(!empty($_POST['nama_rental']))
// {
//     $data[] =  htmlspecialchars($_POST["nama_rental"]);
//     $data[] =  htmlspecialchars($_POST["telp"]);
//     $data[] =  htmlspecialchars($_POST["alamat"]);
//     $data[] =  htmlspecialchars($_POST["email"]);
//     $data[] =  htmlspecialchars($_POST["no_rek"]);
//     $data[] =  1;
//     $sql = "UPDATE infoweb SET nama_rental = ?, telp = ?, alamat = ?, email = ?, no_rek = ?  WHERE id = ? ";
//     $row = $koneksi->prepare($sql);
//     $row->execute($data);
//     echo '<script>alert("Update Data Info Website Berhasil !");window.location="index.php"</script>';
//     exit;
// }

// if(!empty($_POST['nama_pengguna']))
// {
//     $data[] =  htmlspecialchars($_POST["nama_pengguna"]);
//     $data[] =  htmlspecialchars($_POST["username"]);
//     $data[] =  md5($_POST["password"]);
//     $data[] =  $_SESSION['USER']['id_login'];
//     $sql = "UPDATE login SET nama_pengguna = ?, username = ?, password = ? WHERE id_login = ? ";
//     $row = $koneksi->prepare($sql);
//     $row->execute($data);
//     echo '<script>alert("Update Data Profil Berhasil !");window.location="index.php"</script>';
//     exit;
// }
?>

<div class="container" style="height:100% !important;">
    <div class="row" style="margin-top:1.5rem;">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pendapatan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                // Koneksi ke database (ganti dengan informasi koneksi Anda)
                                $dbname = "if0_35124824_rental_mobil";
                                $username = "if0_35124824";
                                $password = "XxQZAxDaEVlo";
                                $servername = "sql309.infinityfree.com";

                                // Membuat koneksi
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                // Memeriksa koneksi
                                if ($conn->connect_error) {
                                    die("Koneksi ke database gagal: " . $conn->connect_error);
                                }

                                // Query SQL untuk menjumlahkan total_harga
                                $sql = "SELECT SUM(total_harga) AS total_harga FROM booking JOIN mobil ON 
                                booking.id_mobil=mobil.id_mobil WHERE konfirmasi_pembayaran= 'lunas'";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Output hasil query
                                    while ($row = $result->fetch_assoc()) {;
                                        $totalHarga = (float)$row["total_harga"];
                                        echo "Rp " . number_format($totalHarga, 0);
                                    }
                                } else {
                                    echo "Tidak ada data booking.";
                                }

                                // Menutup koneksi
                                $conn->close();
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pengeluaran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                $dbname = "if0_35124824_rental_mobil";
                                $username = "if0_35124824";
                                $password = "XxQZAxDaEVlo";
                                $servername = "sql309.infinityfree.com";

                                $conn = new mysqli($servername, $username, $password, $dbname);
                                if ($conn->connect_error) {
                                    die("Koneksi ke database gagal: " . $conn->connect_error);
                                }
                                $sql = "SELECT SUM(total_keluar) AS total_keluar FROM catatan JOIN mobil ON 
                                    catatan.id_mobil=mobil.id_mobil";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {;
                                        $totalKeluarC = (float)$row["total_keluar"];
                                        echo "Rp " . number_format($totalKeluarC, 0);
                                    }
                                } else {
                                    echo "Tidak ada data booking.";
                                }
                                $conn->close();
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Keseluruhan
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        <?php
                                        $dbname = "if0_35124824_rental_mobil";
                                        $username = "if0_35124824";
                                        $password = "XxQZAxDaEVlo";
                                        $servername = "sql309.infinityfree.com";

                                        $conn = new mysqli($servername, $username, $password, $dbname);
                                        if ($conn->connect_error) {
                                            die("Koneksi ke database gagal: " . $conn->connect_error);
                                        }
                                        echo "Rp " . number_format($totalHarga - $totalKeluarC);
                                        $conn->close();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Catatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                $dbname = "if0_35124824_rental_mobil";
                                $username = "if0_35124824";
                                $password = "XxQZAxDaEVlo";
                                $servername = "sql309.infinityfree.com";

                                $conn = new mysqli($servername, $username, $password, $dbname);
                                if ($conn->connect_error) {
                                    die("Koneksi ke database gagal: " . $conn->connect_error);
                                }
                                $sql = "SELECT COUNT(id) AS TOTAL FROM catatan JOIN mobil ON 
                                    catatan.id_mobil=mobil.id_mobil";
                                $result = $conn->query($sql);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    echo $row['TOTAL'];
                                } else {
                                    echo "Query failed: " . $conn->error;
                                }
                                $conn->close();
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'catatan/index.php'; ?>

</div>

<?php include 'footer.php'; ?>