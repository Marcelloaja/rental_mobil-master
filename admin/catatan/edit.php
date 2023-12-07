<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'Edit Catatan';
    include '../header.php';
    if(empty($_SESSION['USER']))
    {       
        session_start();
    }
    $id = $_GET['id'];

    $sql = "SELECT mobil.no_plat, catatan.* FROM catatan JOIN mobil ON catatan.id_mobil=mobil.id_mobil WHERE id =  ?";
    $row = $koneksi->prepare($sql);
    $row->execute(array($id));

    $hasil = $row->fetch();
?>

<br>
<div class="container">
    <div class="card" style="margin-top:-1.5rem">
        <div class="card-header text-white bg-primary">
            <h4 class="card-title">
                Edit Catatan - <?= $hasil['no_plat'];?>
                <div class="float-right">
                    <a class="btn btn-warning" href="../plat/plat.php" role="button">Kembali</a>
                </div>
            </h4>
        </div>
        <div class="card-body">
            <div class="container">
                <form method="post" action="proses.php?aksi=edit&id=<?= $id;?>" enctype="multipart/form-data">
                <label>Plat Nomor</label>
                        <select class="col-4 form-control" name="no_plat" aria-label="Default select example">
                                <?php
                                    $filter = $koneksi->prepare('SELECT mobil.id_mobil, mobil.no_plat FROM mobil');
                                    $filter->execute();
                                    while($no_plat = $filter->fetch()) {
                                        echo '<option value="'.$no_plat['id_mobil'].'">'.htmlentities($no_plat['no_plat']).'</option>';
                                    }
                                ?>
                            <option selected><?= $hasil['no_plat'];?></option>
                        </select>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea type="text" class="form-control" name="deskripsi" placeholder="Isi Catatan"><?= $hasil['deskripsi'];?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">TANGGAL PEMBELIAN</label>
                        <input type="date" class="form-control" value="<?= $hasil['tanggal'];?>">
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="text" value="<?= $hasil['total_keluar'];?>" class="form-control" name="total_keluar" placeholder="Isi Harga">
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
<?php  include '../footer.php';?>