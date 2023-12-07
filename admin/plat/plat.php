<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'PLAT';
    include '../header.php';
    
    if(empty($_SESSION['USER']))
    {
        session_start();
    }
    if(!empty($_GET['id'])){
        $id = strip_tags($_GET['id']);
        $sql = "SELECT mobil.no_plat, mobil.merk, mobil.deskripsi, SUM(booking.total_harga) AS total, booking.* FROM booking JOIN mobil ON 
                booking.id_mobil=mobil.id_mobil WHERE id_login = '$id' AND booking.id_mobil = '".$_GET['no_plat']."' AND tanggal BETWEEN '".$_GET['dari']."' AND '".$_GET['ke']."' GROUP BY mobil.id_mobil ORDER BY id_booking DESC";
    }else{
        $sql = "SELECT mobil.no_plat, mobil.merk, mobil.deskripsi, SUM(booking.total_harga) AS total, booking.* FROM booking JOIN mobil ON 
                booking.id_mobil=mobil.id_mobil WHERE booking.id_mobil = '".$_GET['no_plat']."' AND tanggal BETWEEN '".$_GET['dari']."' AND '".$_GET['ke']."' GROUP BY mobil.id_mobil ORDER BY id_booking DESC";
    }
    if(empty($_GET['no_plat'])){
        $sql = "SELECT mobil.no_plat, mobil.merk, mobil.deskripsi, SUM(booking.total_harga) AS total, booking.* FROM booking JOIN mobil ON 
        booking.id_mobil=mobil.id_mobil WHERE tanggal BETWEEN '".$_GET['dari']."' AND '".$_GET['ke']."' GROUP BY mobil.id_mobil ORDER BY id_booking DESC";
    }
    if(empty($_GET['dari']) && empty($_GET['ke'])) {
        $sql = "SELECT mobil.no_plat, mobil.merk, mobil.deskripsi, SUM(booking.total_harga) AS total, booking.* FROM booking JOIN mobil ON 
        booking.id_mobil=mobil.id_mobil WHERE booking.id_mobil = '".$_GET['no_plat']."' GROUP BY mobil.id_mobil ORDER BY id_booking DESC";
    }
    if(empty($_GET['dari']) && empty($_GET['ke']) && empty($_GET['no_plat'])) {
        $sql = "SELECT mobil.no_plat, mobil.merk, mobil.deskripsi, SUM(booking.total_harga) AS total, booking.* FROM booking JOIN mobil ON 
                booking.id_mobil=mobil.id_mobil GROUP BY mobil.id_mobil ORDER BY id_booking DESC";
    }
    $hasil = $koneksi->query($sql)->fetchAll();
?>

<br>
<div class="container" style="height:100% !important;">
    <div class="card" style="margin-top:-1.5rem;">
        <div class="card-header text-white bg-primary" style="padding-bottom:-1rem;">
            <h5 class="card-title">
                Cari Plat
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-10">
                    <!-- form filter data berdasarkan range tanggal  -->
                    <form action="plat.php" method="get">
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
                            
                            <select class="col-3 form-control" name="no_plat" aria-label="Default select example">
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
                                <a class="btn btn-primary" href="<?php echo $url;?>admin/plat/plat.php">Refresh</a> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>PLAT</th>
                            <th>Merk Mobil</th>
                            <th>TOTAL PEMASUKAN</th>
                            <th>TOTAL PENGELUARAN</th>
                            <th>CATATAN TAMBAHAN</th>
                        </tr>
                    </thead>                    
                    <tbody>
                    <?php
                    // SQL PENGELUARAN
                    $sqlPengeluaran = "SELECT mobil.no_plat, mobil.merk, SUM(catatan.total_keluar) AS total_pengeluaran FROM mobil LEFT JOIN catatan ON mobil.id_mobil = catatan.id_mobil GROUP BY mobil.no_plat, mobil.merk ORDER BY mobil.no_plat DESC";
                    $rowPengeluaran = $koneksi->prepare($sqlPengeluaran);
                    $rowPengeluaran->execute();
                    $hasilPengeluaran = $rowPengeluaran->fetchAll();

                    // SQL PEMASUKAN
                    $sqlPemasukan = "SELECT mobil.no_plat, mobil.merk, SUM(booking.total_harga) AS total_pemasukan, booking.konfirmasi_pembayaran FROM mobil LEFT JOIN booking ON mobil.id_mobil = booking.id_mobil WHERE booking.konfirmasi_pembayaran = 'lunas' GROUP BY mobil.no_plat, mobil.merk ORDER BY mobil.no_plat DESC";
                    $rowPemasukan = $koneksi->prepare($sqlPemasukan);
                    $rowPemasukan->execute();
                    $hasilPemasukan = $rowPemasukan->fetchAll();

                    $no = 1;
                    foreach ($hasilPengeluaran as $isiPengeluaran) {
                        $isiPemasukan = $hasilPemasukan[$no - 1];
                    ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?= $isiPengeluaran['no_plat'];?></td>
                        <td><?= $isiPengeluaran['merk'];?></td>
                        <td>Rp. <?= number_format($isiPemasukan['total_pemasukan']);?></td>
                        <td>Rp. <?= number_format($isiPengeluaran['total_pengeluaran']);?></td>
                        <td><a class="btn btn-primary" href="<?php echo $url;?>admin/catatan/tambah.php">TAMBAH</a></td>
                    </tr>
                    <?php $no++;}
                    ?>
                    </tbody>
                </table>
            </div>
            <center><h6>--NOTES : TOTAL PEMASUKAN HANYA AKAN UPDATE JIKA STATUS PEMBAYARAN "LUNAS" !!</h6></center>
            <div class="col-lg-12">
        <h4>Catatan Pengeluaran Mobil</h4> 
                <table class="table table-hover table-bordered" style="margin-top: 10px">
                    <thead>
                        <tr class="success">
                            <th>No</th>
                            <th>No Plat</th>
                            <th width="400px">Deskripsi Pengeluaran</th>
                            <th>Tanggal Pembelian</th>
                            <th>Harga</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($_GET['id'])){
                                $id = strip_tags($_GET['id']);
                                $sql = "SELECT mobil.no_plat, catatan.* FROM catatan JOIN mobil ON catatan.id_mobil=mobil.id_mobil WHERE id_login = '$id' AND mobil.id_mobil = '".$_GET['no_plat']."' 
                                AND tanggal BETWEEN '".$_GET['dari']."' AND '".$_GET['ke']."' ORDER BY mobil.no_plat";
                            }else{
                                $sql= "SELECT mobil.no_plat, catatan.* FROM catatan JOIN mobil ON catatan.id_mobil=mobil.id_mobil WHERE mobil.id_mobil = '".$_GET['no_plat']."' AND catatan.tanggal BETWEEN '".$_GET['dari']."' AND '".$_GET['ke']."' 
                                ORDER BY mobil.no_plat";
                            }
                            if(empty($_GET['no_plat'])){
                                $sql = "SELECT mobil.no_plat, catatan.* FROM catatan JOIN mobil ON catatan.id_mobil=mobil.id_mobil WHERE catatan.tanggal BETWEEN '".$_GET['dari']."' AND '".$_GET['ke']."' ORDER BY mobil.no_plat";
                            }
                            if(empty($_GET['dari']) && empty($_GET['ke'])) {
                                $sql = "SELECT mobil.no_plat, catatan.* FROM catatan JOIN mobil ON catatan.id_mobil=mobil.id_mobil WHERE mobil.id_mobil = '".$_GET['no_plat']."' ORDER BY mobil.no_plat";
                            }
                            if(empty($_GET['dari']) && empty($_GET['ke']) && empty($_GET['no_plat'])) {
                                $sql= "SELECT mobil.no_plat, catatan.* FROM catatan JOIN mobil ON catatan.id_mobil=mobil.id_mobil ORDER BY mobil.no_plat";
                            }
                                $row = $koneksi->prepare($sql);
                                $row->execute();
                                $hasil = $row->fetchAll();
                                $no = 1;
                                        foreach($hasil as $isi)
                                    {
                            ?>
                            <tr>
                                <td><?php echo $no;?></td>
                                <td><?php echo $isi['no_plat'];?></td>
                                <td><?php echo $isi['deskripsi'];?></td>
                                <td><?php echo $isi['tanggal'];?></td>
                                <td>Rp. <?= number_format($isi['total_keluar']);?></td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="../catatan/edit.php?id=<?php echo $isi['id'];?>" role="button">Edit</a>  
                                    <a class="btn btn-danger  btn-sm" href="../catatan/proses.php?aksi=hapus&id=<?= $isi['id'];?>" role="button">Hapus</a>  
                                </td>
                            </tr>
                        <?php $no++; }?>
                    </tbody>
                </table>
                <?php
                $dari = $_GET['dari'];
                $ke =  $_GET['ke'];
                $no_plat = $_GET['no_plat'];?>
                <div class="row-md-auto">
                    <a href="print.php?dari=<?= $dari;?>&ke=<?= $ke;?>&no_plat=<?= $no_plat;?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i> Cetak Catatan</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php  include '../footer.php';?>