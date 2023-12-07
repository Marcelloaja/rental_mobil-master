<?php
    session_start();
    require '../../koneksi/koneksi.php';
    $title_web = 'Detail';
    include '../header.php';
    if(empty($_SESSION['USER']))
    {
        echo '<script>alert("Harap login !");window.location="index.php"</script>';
    }
    $kode_booking = $_GET['id'];
    $hasil = $koneksi->query("SELECT * FROM booking WHERE kode_booking = '$kode_booking'")->fetch();

    $id = $hasil['id_mobil'];
    $isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();

    $unik  = random_int(000,000);
    
?>
<br>
<br>
<div class="container">
<div class="row">
    <div class="col-sm-4">

        <div class="card">
            <div class="card-body text-center">
                <h5>Pembayaran Dapat Melalui :</h5>
                <hr/>
                <p> <?= $info_web->no_rek;?> </p>
            </div>
        </div>
        <br/>
        <div class="card">
                <div class="card-body" style="background:#ddd">
                <h5 class="card-title"><?php echo $isi['merk'];?> - <?php echo $isi['no_plat'];?></h5>
                </div>
                <ul class="list-group list-group-flush">

                <?php if($isi['status'] == 'Tersedia'){?>

                    <li class="list-group-item bg-primary text-white">
                        <i class="fa fa-check"></i> Available
                    </li>

                <?php }else{?>

                    <li class="list-group-item bg-danger text-white">
                        <i class="fa fa-close"></i> Not Available
                    </li>

                <?php }?>
            
                        <!--<li class="list-group-item bg-dark text-white">
                    <i class="fa fa-money"></i> Rp. <?php echo number_format($isi['harga']);?>/ day
                </li>-->
                </ul>
            </div>
    </div>
    <div class="col-sm-8">
         <div class="card">
           <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Kode Booking  </td>
                            <td> :</td>
                            <td><?php echo $hasil['kode_booking'];?></td>
                        </tr>
                        <tr>
                            <td>KTP  </td>
                            <td> :</td>
                            <td><?php echo $hasil['ktp'];?></td>
                        </tr>
                        <tr>
                            <td>Nama  </td>
                            <td> :</td>
                            <td><?php echo $hasil['nama'];?></td>
                        </tr>
                        <tr>
                            <td>Rute  </td>
                            <td> :</td>
                            <td><?php echo $hasil['alamat'];?></td>
                        </tr>
                        <tr>
                            <td>telepon  </td>
                            <td> :</td>
                            <td><?php echo $hasil['no_tlp'];?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Sewa </td>
                            <td> :</td>
                            <td><?php echo $hasil['tanggal'];?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Kembali </td>
                            <td> :</td>
                            <td><?php echo $hasil['tgl_kembali'];?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Input Order </td>
                            <td> :</td>
                            <td><?php echo $hasil['tgl_input'];?></td>
                        </tr>
                        <tr>
                            <td>Lama Sewa </td>
                            <td> :</td>
                            <td><?php echo $hasil['lama_sewa'];?> hari</td>
                        </tr>
                        <tr>
                            <td>Total Harga </td>
                            <td> :</td>
                            <td>Rp. <?php echo number_format($hasil['total_harga']);?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>
                                <form id="konfirmasiForm" action="" method="post">
                                    <select class="form-control" name="konfirmasi_pembayaran" id="konfirmasi_pembayaran">
                                        <option value="Lunas" <?php if ($hasil['konfirmasi_pembayaran'] == 'Lunas') echo 'selected'; ?>>Lunas</option>
                                        <option value="DP" <?php if ($hasil['konfirmasi_pembayaran'] == 'DP') echo 'selected'; ?>>DP</option>
                                        <option value="DP" <?php if ($hasil['konfirmasi_pembayaran'] == 'Belum Bayar') echo 'selected'; ?>>Belum Bayar</option>
                                    </select>
                                </form>
                            </td>                            
                        </tr>
                    </table>
                    <td>
                                <button onclick="konfirmasiPembayaran();" class="btn btn-primary float-right">Konfirmasi Pembayaran</button>
                            </td>
                <!-- <?php if($hasil['konfirmasi_pembayaran'] == 'Belum Bayar'){?>
                    <a href="konfirmasi.php?id=<?php echo $kode_booking;?>" 
                    class="btn btn-primary float-right">Konfirmasi Pembayaran</a>
                <?php }?>                -->
                <div class="row-md-auto">
                    <a href="print.php?id=<?= $hasil['kode_booking'];?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                </div>
           </div>
         </div> 
    </div>
</div>
</div>
<br>
<br>
<br>

<?php include '../footer.php';?>

<script>
    function konfirmasiPembayaran() {
        var selectedValue = document.getElementById('konfirmasi_pembayaran').value;
        var kodeBooking = '<?php echo $kode_booking; ?>';

        // Send an AJAX request to update the database
        $.ajax({
            type: 'POST',
            url: 'update_konfirmasi.php', // Replace with the actual path to update_konfirmasi.php
            data: { id: kodeBooking, konfirmasi_pembayaran: selectedValue },
            success: function(response) {
                if (response === 'Success') {
                    alert('Konfirmasi Pembayaran updated successfully.');
                    // You can redirect the user or perform other actions here
                } else {
                    alert('Error updating Konfirmasi Pembayaran.');
                }
            },
            error: function() {
                alert('Error occurred while updating Konfirmasi Pembayaran.');
            }
        });
    }
</script>
