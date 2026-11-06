<?php
include "koneksi.php";

$id = (int)$_GET['id'];
$pesan = "";

if (isset($_POST['simpan'])) {
    $barang_id = (int)$_POST['barang_id'];
    $qty = (int)$_POST['qty'];

    $cek = mysqli_query($koneksi, "SELECT * FROM transaksi_detail WHERE transaksi_id = $id AND barang_id = $barang_id");

    if ($qty < 1) {
        $pesan = "Qty minimal 1";
    } elseif (mysqli_num_rows($cek) > 0) {
        $pesan = "Barang sudah ada di transaksi ini";
    } else {
        $barang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT harga FROM barang WHERE id = $barang_id"));
        $harga = $barang['harga'];

        mysqli_query($koneksi, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES ($id, $barang_id, $harga, $qty)");
        mysqli_query($koneksi, "UPDATE transaksi SET total = (SELECT SUM(harga * qty) FROM transaksi_detail WHERE transaksi_id = $id) WHERE id = $id");
        $pesan = "Detail berhasil disimpan, total diperbarui";
    }
}

$master = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT transaksi.*, pelanggan.nama FROM transaksi JOIN pelanggan ON pelanggan.id = transaksi.pelanggan_id WHERE transaksi.id = $id"));
$detail = mysqli_query($koneksi, "SELECT barang.kode_barang, barang.nama_barang, transaksi_detail.harga, transaksi_detail.qty FROM transaksi_detail JOIN barang ON barang.id = transaksi_detail.barang_id WHERE transaksi_detail.transaksi_id = $id");
$sisa = mysqli_query($koneksi, "SELECT * FROM barang WHERE id NOT IN (SELECT barang_id FROM transaksi_detail WHERE transaksi_id = $id)");
?>
<html>
<body>
<a href="index.php">Transaksi</a> | <a href="barang.php">Barang</a>
<h2>Master Detail Transaksi</h2>

<?php echo $pesan; ?>

<table border="1" cellspacing="0">
    <tr><td>ID</td><td><?php echo $master['id']; ?></td></tr>
    <tr><td>Tanggal</td><td><?php echo $master['waktu_transaksi']; ?></td></tr>
    <tr><td>Pelanggan</td><td><?php echo $master['nama']; ?></td></tr>
    <tr><td>Keterangan</td><td><?php echo $master['keterangan']; ?></td></tr>
    <tr><td>Total</td><td><?php echo $master['total']; ?></td></tr>
</table>

<h3>Detail Barang</h3>
<table border="1">
    <tr>
        <th>Kode</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
    </tr>
    <?php while ($d = mysqli_fetch_assoc($detail)) { ?>
        <tr>
            <td><?php echo $d['kode_barang']; ?></td>
            <td><?php echo $d['nama_barang']; ?></td>
            <td><?php echo $d['harga']; ?></td>
            <td><?php echo $d['qty']; ?></td>
            <td><?php echo $d['harga'] * $d['qty']; ?></td>
        </tr>
    <?php } ?>
</table>

<h3>Tambah Detail</h3>
<form method="post">
    Barang
    <select name="barang_id">
        <?php while ($b = mysqli_fetch_assoc($sisa)) { ?>
            <option value="<?php echo $b['id']; ?>"><?php echo $b['nama_barang']; ?> - <?php echo $b['harga']; ?></option>
        <?php } ?>
    </select><br>
    Qty <input type="number" name="qty" value="1" min="1"><br>
    <input type="submit" name="simpan" value="Simpan">
</form>
</body>
</html>
