<div class="row">
     <div class="col-lg-12">
        <h1>Catatan Pengeluaran</h1> 
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
                $sql = "SELECT mobil.no_plat, catatan.* FROM catatan JOIN mobil ON catatan.id_mobil=mobil.id_mobil ORDER BY mobil.no_plat";
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
                    <td>Rp.<?= number_format($isi['total_keluar']);?></td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="catatan/edit.php?id=<?php echo $isi['id'];?>" role="button">Edit</a>  
                        <a class="btn btn-danger  btn-sm" href="catatan/proses.php?aksi=hapus&id=<?= $isi['id'];?>" role="button">Hapus</a>  
                    </td>
                </tr>
            <?php $no++; }?>
        </tbody>
     </table>
  </div>
</div>