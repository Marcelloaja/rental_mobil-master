<?php
    include('../../koneksi/koneksi.php');
    $title_web = 'Konfirmasi';
    session_start();
    if(empty($_SESSION['USER']))
    {
        echo '<script>alert("login dulu");window.location="index.php"</script>';
    }
    require_once("dompdf/autoload.inc.php");
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
    $dari = $_GET['dari'];
    $ke =  $_GET['ke'];
    $no_plat = $_GET['no_plat'];
    if(!empty($_GET['id'])){
        $id = strip_tags($_GET['id']);
        $sql = "SELECT mobil.no_plat, catatan.* FROM catatan JOIN mobil ON catatan.id_mobil=mobil.id_mobil WHERE id_login = '$id' AND mobil.id_mobil = '$no_plat'  
        AND tanggal BETWEEN $dari AND $ke ORDER BY mobil.no_plat";
    }else{
        $sql= "SELECT mobil.no_plat, catatan.* FROM catatan JOIN mobil ON catatan.id_mobil=mobil.id_mobil WHERE mobil.id_mobil = '$no_plat' AND catatan.tanggal BETWEEN '$dari' AND '$ke'  
        ORDER BY mobil.no_plat";
    }
    if(empty($no_plat)){
        $sql = "SELECT mobil.no_plat, catatan.* FROM catatan JOIN mobil ON catatan.id_mobil=mobil.id_mobil WHERE catatan.tanggal BETWEEN '$dari' AND '$ke' ORDER BY mobil.no_plat";
    }
    if(empty($dari) && empty($ke)) {
        $sql = "SELECT mobil.no_plat, catatan.* FROM catatan JOIN mobil ON catatan.id_mobil=mobil.id_mobil WHERE mobil.id_mobil = '$no_plat' ORDER BY mobil.no_plat";
    }
    if(empty($dari) && empty($ke) && empty($no_plat)) {
        $sql= "SELECT mobil.no_plat, catatan.* FROM catatan JOIN mobil ON catatan.id_mobil=mobil.id_mobil ORDER BY mobil.no_plat";
    }
        $row = $koneksi->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();



    ob_start(); // Start output buffering
    include('../plat/pdf_template.php');
    $html = ob_get_clean(); 

    $dompdf->loadHtml($html);
    // Setting ukuran dan orientasi kertas
    $dompdf->set_option('isRemoteEnabled', true);
    // tampilkan gambar
    $dompdf->setPaper('a4', 'potrait');
    // Rendering dari HTML Ke PDF
    $dompdf->render();
    // Menampilkan file PDF
    $dompdf->stream('laporan_catatan.pdf');
    ?>
