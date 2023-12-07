<?php
require '../../koneksi/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">-->
    <title>download</title>
    
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <p style="font-size:14px; font-weight:bold;"><img src="<?php echo $url;?>assets/image/fix10.png" width="100" height="100"><center>INVOICE</center></p><hr>
    <!--<div class="col-md-1 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">-->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table" style="font-size: 16px;">
                    <tr>
                        <td>JL. Temenggung Suryo No.17 - KOTA MALANG</td>
                        <td>KEPADA : <?= $hasil['nama']; ?></td>
                    </tr>
                    <tr>
                        <td>No. Telp 0812-1754-0007</td>
                        <td>TANGGAL : <?= $hasil['tanggal']; ?></td>
                    </tr>
                </table>

            </div>
        </div>

    </div>
        <br>
        <br>

    <table class="center" method="post" action="../mobil/proses.php?id=konfirmasi">
    <tr >
        <th>KETERANGAN</th>
        <th>HARGA</th>
        <!--<th>No Telp</th>
        <th>Tanggal Sewa</th>-->
        <th>Lama Sewa</th>
        <th>Total</th>
    </tr>
    <tr>
        <td><?= $hasil['merk']; ?> - <?= $hasil['no_plat']; ?> | <?= $hasil['alamat']; ?></td>
        <td>Rp. <?= number_format ($hasil['harga']); ?></td>
        <!--<td><?= $hasil['no_tlp']; ?></td>
        <td><?= $hasil['tanggal']; ?></td>-->
        <td><?= $hasil['lama_sewa']; ?></td>
        <td>Rp. <?= number_format($hasil['total_harga']); ?></td>
    </tr>
    </table>

    <br>
    <br>
    <label>PEMBAYARAN</lebel><br>
    <label>RUDI ARIANTO, BCA : 816 078 6842<label> <br> <br> <br><br>
    <blockquote>TTD</blockquote>
</body>
<style>
    .center {
  margin-left: auto;
  margin-right: auto;
  text-align: center;
  padding: 8px;
}
</style>
</html>