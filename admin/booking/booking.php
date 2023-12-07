<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'Daftar Booking';
    include '../header.php';
    if(empty($_SESSION['USER']))
    {
        session_start();
    }
    if(!empty($_GET['id'])){
        $id = strip_tags($_GET['id']);
        $sql = "SELECT mobil.no_plat, mobil.merk, booking.* FROM booking JOIN mobil ON 
                booking.id_mobil=mobil.id_mobil WHERE id_login = '$id' AND booking.id_mobil = '".$_GET['no_plat']."' AND tanggal BETWEEN '".$_GET['dari']."' AND '".$_GET['ke']."' ORDER BY id_booking DESC";
    }else{
        $sql = "SELECT mobil.no_plat, mobil.merk, booking.* FROM booking JOIN mobil ON 
                booking.id_mobil=mobil.id_mobil WHERE booking.id_mobil = '".$_GET['no_plat']."' AND tanggal BETWEEN '".$_GET['dari']."' AND '".$_GET['ke']."' ORDER BY id_booking DESC";
    }
    if(empty($_GET['no_plat'])){
        $sql = "SELECT mobil.no_plat, mobil.merk, booking.* FROM booking JOIN mobil ON 
        booking.id_mobil=mobil.id_mobil WHERE tanggal BETWEEN '".$_GET['dari']."' AND '".$_GET['ke']."' ORDER BY id_booking DESC";
    }
    if(empty($_GET['dari']) && empty($_GET['ke'])) {
        $sql = "SELECT mobil.no_plat, mobil.merk, booking.* FROM booking JOIN mobil ON 
        booking.id_mobil=mobil.id_mobil WHERE booking.id_mobil = '".$_GET['no_plat']."' ORDER BY id_booking DESC";
    }
    if(empty($_GET['dari']) && empty($_GET['ke']) && empty($_GET['no_plat'])) {
        $sql = "SELECT mobil.no_plat, mobil.merk, booking.* FROM booking JOIN mobil ON 
                booking.id_mobil=mobil.id_mobil ORDER BY id_booking DESC";
    }
    $hasil = $koneksi->query($sql)->fetchAll();

?>

<br>
<div class="container" style="height:100% !important;">
    <div class="card" style="margin-top:-1.5rem;">
        <div class="card-header text-white bg-primary" style="padding-bottom:-1rem;">
            <h5 class="card-title">
                Daftar Booking
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-10">
                    <!-- form filter data berdasarkan range tanggal  -->
                    <form action="booking.php" method="get">
                        <div class="row g-3 align-items-center pb-3">
                            <div class="col-auto">
                                <label class="col-form-label">Periode</label>
                            </div>
                            <div class="col-auto">
                                <input type="date" pattern="\d{4}-\d{2}-\d{2}" class="form-control" name="dari">
                            </div>
                            <div class="col-auto">
                                -
                            </div>
                            <div class="col-auto">
                                <input type="date" class="form-control" name="ke">
                            </div>
                            <select class="col form-control" name="no_plat" aria-label="Default select example">
                                <?php
                                    $filter = $koneksi->prepare('SELECT mobil.id_mobil, mobil.no_plat FROM mobil');
                                    $filter->execute();
                                    while($no_plat = $filter->fetch()) {
                                        echo '<option value="'.$no_plat['id_mobil'].'">'.htmlentities($no_plat['no_plat']).'</option>';
                                    }
                                ?>
                                <option selected disabled>PLAT MOBIL</option>
                            </select>
                            <div class="col-auto">
                                <button class="btn btn-primary" type="submit">Cari</button>
                                <a class="btn btn-primary" href="<?php echo $url;?>admin/booking/booking.php">Refresh</a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- <div class="row-md-auto">
                    <a href="generate_report.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                </div> -->
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Kode Booking</th>
                            <th>NO PLAT</th>
                            <th>Merk Mobil</th>
                            <th>Nama </th>
                            <th>Tanggal Sewa </th>
                            <th>Tanggal kembali </th>
                            <th>Lama Sewa </th>
                            <th>Total Harga</th>
                            <th>Konfirmasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>                    
                    <tbody>
                        <?php  $no=1; foreach($hasil as $isi){?>
                        <tr>
                            <td><?php echo $no;?></td>
                            <td><?= $isi['kode_booking'];?></td>
                            <td><?= $isi['no_plat'];?></td>
                            <td><?= $isi['merk'];?></td>
                            <td><?= $isi['nama'];?></td>
                            <td><?= $isi['tanggal'];?></td>
                            <td><?= $isi['tgl_kembali'];?></td>
                            <td><?= $isi['lama_sewa'];?> hari</td>
                            <td>Rp. <?= number_format($isi['total_harga']);?></td>
                            <td><?= $isi['konfirmasi_pembayaran'];?></td> 
                            <td>
                                <a class="btn btn-primary" href="bayar.php?id=<?= $isi['kode_booking'];?>" 
                                role="button">Detail</a>   
                            </td>
                        </tr>
                        <?php $no++;}?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php  include '../footer.php';?>