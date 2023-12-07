<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'Tambah Catatan';
    include '../header.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $deskripsi = $_POST['deskripsi'];
        $tanggal_pembelian = $_POST['tanggal_pembelian'];
        $harga = $_POST['harga'];
        $no_plat= $_POST['no_plat'];

        // Ensure proper validation and sanitization of the input data here


        // Perform database insertion (assuming you have a 'catatan' table)
        $sql = "INSERT INTO catatan (id_mobil, deskripsi, tanggal, total_keluar) VALUES ('$no_plat', '$deskripsi', '$tanggal_pembelian', '$harga')";

        if ($koneksi->query($sql)) {
            // Insertion was successful, redirect to the PLAT page
            echo '<script>alert("sukses");window.location="../plat/plat.php"</script>';
            exit();
        } else {
            // Handle the case where insertion failed
            echo "Error: " . $koneksi->error;
        }
    }
?>

<div class="container">
    <div class="card" style="margin-top:1.5rem">
        <div class="card-header text-white bg-primary">
            <h4 class="card-title">
                Tambah Catatan
                <div class="float-right">
                    <a class="btn btn-warning" href="../plat/plat.php" role="button">Kembali</a>
                </div>
            </h4>
        </div>
        <div class="card-body">
            <div class="container">
                <form method="post" action="" enctype="multipart/form-data">
                    <!-- Other form fields (deskripsi, tanggal_pembelian, harga) go here -->
                    <div class="form-group">
                        <label>Plat Nomor</label>
                        <select class="col-4 form-control" name="no_plat" aria-label="Default select example">
                                <?php
                                    $filter = $koneksi->prepare('SELECT mobil.id_mobil, mobil.no_plat FROM mobil');
                                    $filter->execute();
                                    while($no_plat = $filter->fetch()) {
                                        echo '<option value="'.$no_plat['id_mobil'].'">'.htmlentities($no_plat['no_plat']).'</option>';
                                    }
                                ?>
                                <option selected disabled>PLAT MOBIL</option>
                            </select>
                        <label>Deskripsi</label>
                        <textarea type="text" value="" class="form-control" name="deskripsi" placeholder="Isi Catatan"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">TANGGAL PEMBELIAN</label>
                        <input type="date" class="form-control" name="tanggal_pembelian">
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="text" value="" class="form-control" name="harga" placeholder="Isi Harga">
                    </div>
                    <hr>
                    <div class="float-left">
                        <button class="btn btn-primary" role="button" type="submit">
                            Simpan
                        </button>
                    </div>
                </form>       
            </div>
        </div>
    </div>
</div>
<?php include '../footer.php';?>
