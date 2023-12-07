<?php
    include('../../koneksi/koneksi.php');
    $title_web = 'Konfirmasi';
    session_start();
    if(empty($_SESSION['USER']))
    {
        echo '<script>alert("login dulu");window.location="index.php"</script>';
    } 

    $kode_booking = $_GET['id'];
    $hasil = $koneksi->query("SELECT mobil.no_plat, mobil.merk, mobil.harga, booking.* FROM booking JOIN mobil ON 
    booking.id_mobil=mobil.id_mobil WHERE kode_booking = '$kode_booking'")->fetch();
    $isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();

    require_once("dompdf/autoload.inc.php");
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
    $query = mysqli_query($conn,"SELECT booking.ktp, booking.nama, booking.no_tlp, ,booking.alamat, booking.tanggal, booking.lama_sewa, booking.total_harga, 
                mobil.no_plat, mobil.merk, mobil.harga FROM booking JOIN mobil ON 
                booking.id_mobil=mobil.id_mobil");

    ob_start(); // Start output buffering
    include('../booking/pdf_invoice_template.php');
    $html = ob_get_clean(); 

    $dompdf->loadHtml($html);
    // Setting ukuran dan orientasi kertas
    $dompdf->set_option('isRemoteEnabled', true);
    // tampilkan gambar
    $dompdf->setPaper('a5', 'potrait');
    // Rendering dari HTML Ke PDF
    $dompdf->render();
    // Menampilkan file PDF
    $dompdf->stream('laporan_booking.pdf');
?>
