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
    <style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 16px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>
    
</head>
<body>
            <center><h4>CATATAN PENGELUARAN</h4></center>
            <center><p style="font-size: 14px;">Tanggal : <?= $dari;?> - <?= $ke;?></p></center>
                <table class="table" style="margin-top: 10px">
                    <thead>
                        <tr class="success">
                            <th>No</th>
                            <th>No Plat</th>
                            <th >Deskripsi Pengeluaran</th>
                            <th>Tanggal Pembelian</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php $no = 1;
                                        foreach($hasil as $isi)
                                    {
                            ?>
                            <tr>
                                <td><?php echo $no;?></td>
                                <td><?php echo $isi['no_plat'];?></td>
                                <td><?php echo $isi['deskripsi'];?></td>
                                <td><?php echo $isi['tanggal'];?></td>
                                <td>Rp. <?= number_format($isi['total_keluar']);?></td>
                            </tr>
                        <?php $no++; }?>
                    </tbody>
                </table>
</body>
</html>