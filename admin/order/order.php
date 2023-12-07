<?php
require '../../koneksi/koneksi.php';
$title_web = 'Tambah Order';
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}
?>

<div class="container-fluid">
    <h1 style="color:black;text-align: center;margin-bottom: 35px;">PINJAM MOBIL</h1>
    <form id="formPemesanan" action="../../koneksi/proses.php?id=booking" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-2">
                    <label class="form-label">KTP</label>
                    <input type="text" class="form-control" name="ktp" id="ktp" placeholder="Tidak Wajib Diisi">
                </div>
                <div class="mb-2">
                    <label class="form-label">NAMA PEMESAN</label>
                    <input type="text" name="nama" class="form-control" id="namaPemesan" placeholder="Contoh : Rudi">
                </div>
                <div class="mb-2">
                    <label class="form-label">PILIH MOBIL</label>
                    <input type="hidden" id="selectedMerk">
                    <select class="form-control" id="selectMerk" name="nama_mobil" aria-label="Default select example">
                        <option selected disabled>MERK MOBIL</option>
                        <?php
                        // Koneksi ke database
                        $dbname = "if0_35124824_rental_mobil";
                        $username = "if0_35124824";
                        $password = "XxQZAxDaEVlo";
                        $servername = "sql309.infinityfree.com";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if ($conn->connect_error) {
                            die("Koneksi ke database gagal: " . $conn->connect_error);
                        }

                        // Query untuk mendapatkan data merk mobil dari tabel mobil
                        $sql = "SELECT DISTINCT merk FROM mobil group by merk";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['merk'] . '">' . $row['merk'] . '</option>';
                            }
                        }
                        $conn->close();
                        ?>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">TANGGAL SEWA</label>
                    <input type="date" class="form-control" id="tanggalSewa" name="tanggal">
                </div>
                <div class="mb-2">
                    <label class="form-label">TOTAL HARI</label>
                    <input type="text" class="form-control" id="totalHari" name="totalHari" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-2">
                    <label class="form-label">RUTE</label>
                    <input type="text" class="form-control" id="alamat" name="alamat">
                </div>
                <div class="mb-2">
                    <label class="form-label">TELPON</label>
                    <input type="number" class="form-control" id="telepon" name="telepon">
                </div>
                <div class="mb-2">
                    <label class="form-label">PILIH PLAT</label>
                    <input type='hidden' id="selectedPlat" />
                    <select class="form-control" id="selectPlat" name="no_plat" aria-label="Default select example">
                        <option selected disabled>PLAT MOBIL</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">TANGGAL PENGEMBALIAN</label>
                    <input type="date" class="form-control" id="tanggalPengembalian" name="tanggalPengembalian">
                </div>
                <div class="mb-2">
                    <label class="form-label">TOTAL HARGA</label>
                    <input type="text" class="form-control" id="totalHarga" name="totalHarga">
                </div>
            </div>
        </div>
        <div style="margin-top:15px;">
            <button type="button" class="btn btn-success mr-1" id="hitungButton" name="hitungButton">HITUNG</button>
            <button type="submit" class="btn btn-danger">PESAN</button>
        </div>
    </form>
</div>
<script>
    // Event listener untuk dropdown "PILIH MOBIL"
    function getSelectedText(elementId) {
        var elt = document.getElementById(elementId);
        if (elt.selectedIndex == -1) {
            return null;
        }
        return elt.options[elt.selectedIndex].text
    }
    document.getElementById("selectMerk").addEventListener("change", function(e) {
        var selectedMerk = getSelectedText("selectMerk")

        // Koneksi ke database (sama seperti sebelumnya)
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "getPlat.php?merk=" + selectedMerk, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var platOptions = JSON.parse(xhr.responseText);
                var selectPlat = document.getElementById("selectPlat");

                // Bersihkan pilihan sebelumnya
                selectPlat.innerHTML = '<option selected disabled>PLAT MOBIL</option>';

                // Tambahkan pilihan plat mobil sesuai dengan data yang diambil dari server
                for (var i = 0; i < platOptions.length; i++) {
                    var option = document.createElement("option");
                    option.value = platOptions[i];
                    option.text = platOptions[i];
                    selectPlat.appendChild(option);
                }
            }
        };

        xhr.send();
    });
</script>

<script>
    document.getElementById("hitungButton").addEventListener("click", function() {
        // Mendapatkan tanggal sewa dan tanggal pengembalian
        var tanggalSewa = new Date(document.getElementById("tanggalSewa").value);
        var tanggalPengembalian = new Date(document.getElementById("tanggalPengembalian").value);


        // Menghitung selisih hari
        var selisihHari = 0;
        for (var d = tanggalSewa; d <= tanggalPengembalian; d.setDate(d.getDate() + 1)) {
            selisihHari++
        }

        // Mengisi total hari
        document.getElementById("totalHari").value = selisihHari;

        // Mendapatkan merk mobil yang dipilih
        var merkMobil = document.getElementById("selectMerk").value;
        var platMobil = document.getElementById("selectPlat").value;
        console.log(merkMobil);
        document.getElementById('selectedMerk').value = merkMobil;
        document.getElementById('selectedPlat').value = platMobil;

        var selectedMerk = getSelectedText("selectMerk")

        // Koneksi ke database (gantilah dengan informasi koneksi Anda)
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "getHargaMobil.php?merk=" + selectedMerk, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var hargaMobil = parseFloat(xhr.responseText);

                // Menghitung total harga
                var totalHarga = selisihHari * hargaMobil;
                console.log(hargaMobil);
                document.getElementById("totalHarga").value = totalHarga;
            }
        };

        xhr.send();
    });
</script>

<script>
    document.getElementById("hitungButton").addEventListener("click", function() {
        // Validasi NAMA PEMESAN
        var namaPemesan = document.getElementById("namaPemesan").value;
        if (namaPemesan.trim() === "") {
            alert("Nama pemesan harus diisi.");
            return;
        }



        // Validasi PILIH MOBIL
        var merkMobil = document.getElementById("selectMerk").value;
        if (merkMobil === "MERK MOBIL") {
            alert("Merk mobil harus dipilih.");
            return;
        }

        // Validasi TANGGAL SEWA
        var tanggalSewa = document.getElementById("tanggalSewa").value;
        if (tanggalSewa.trim() === "") {
            alert("Tanggal sewa harus diisi.");
            return;
        }

        // Validasi TANGGAL PENGEMBALIAN
        var tanggalPengembalian = document.getElementById("tanggalPengembalian").value;
        if (tanggalPengembalian.trim() === "") {
            alert("Tanggal pengembalian harus diisi.");
            return;
        }

        // Validasi ALAMAT
        var alamat = document.getElementById("alamat").value;
        if (alamat.trim() === "") {
            alert("Rute harus diisi.");
            return;
        }

        // Validasi TELPON
        var telepon = document.getElementById("telepon").value;
        if (telepon.trim() === "" || isNaN(telepon)) {
            alert("Nomor telepon harus diisi dengan angka.");
            return;
        }

        // Validasi PILIH PLAT
        var platMobil = document.getElementById("selectPlat").value;
        if (platMobil === "PLAT MOBIL") {
            alert("Plat mobil harus dipilih.");
            return;
        }

        // Validasi TOTAL HARI
        var totalHari = document.getElementById("totalHari").value;
        if (totalHari.trim() === "" || isNaN(totalHari) || totalHari <= 0) {
            alert("Total hari harus diisi dengan angka lebih dari 0.");
            return;
        }

        // Validasi TOTAL HARGA
        var totalHarga = document.getElementById("totalHarga").value;
        if (totalHarga.trim() === "" || isNaN(totalHarga) || totalHarga <= 0) {
            alert("Silahkan Konfirmasi Total Harga apakah sudah benar.");
            return;
        }

        // Jika semua validasi berhasil, Anda dapat melanjutkan penghitungan dan pengiriman formulir.

        // Menghitung total hari dan total harga (seperti yang telah Anda lakukan dalam kode sebelumnya).
        // ...

        // Setelah semua validasi berhasil, Anda dapat melanjutkan pengiriman formulir.
        document.getElementById("formPemesanan");
        alert("Data yang telah anda isi sudah benar, Silahkan dicek kembali dan tekan tombol pesan jika sudah benar!!");
        return;
    });
</script>