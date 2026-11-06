<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $pelanggan = mysqli_real_escape_string($koneksi, $_POST['pelanggan_id']);

    mysqli_query($koneksi, "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES ('$tanggal', '$keterangan', 0, '$pelanggan')");
    $id = mysqli_insert_id($koneksi);
    header("Location: detail.php?id=$id");
    exit;
}

$pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
$transaksi = mysqli_query($koneksi, "SELECT transaksi.*, pelanggan.nama 
    FROM transaksi JOIN pelanggan ON pelanggan.id = transaksi.pelanggan_id ORDER BY transaksi.id DESC");
?>
<html>
<body>
<a href="index.php">Transaksi</a> | <a href="barang.php">Barang</a>
<h2>Data Transaksi</h2>

<form method="post">
    Tanggal <input type="date" name="tanggal" value="<?php echo date('Y-m-d'); ?>"><br>
    Pelanggan
    <select name="pelanggan_id">
        <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>
            <option value="<?php echo $p['id']; ?>"><?php echo $p['nama']; ?></option>
        <?php } ?>
    </select><br>
    Keterangan <input type="text" name="keterangan"><br>
    <input type="submit" name="simpan" value="Tambah Transaksi">
</form>

<br>
<table border="1" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Tanggal</th>
        <th>Pelanggan</th>
        <th>Keterangan</th>
        <th>Total</th>
        <th>Aksi</th>
    </tr>
    <?php while ($t = mysqli_fetch_assoc($transaksi)) { ?>
        <tr>
            <td><?php echo $t['id']; ?></td>
            <td><?php echo $t['waktu_transaksi']; ?></td>
            <td><?php echo $t['nama']; ?></td>
            <td><?php echo $t['keterangan']; ?></td>
            <td><?php echo $t['total']; ?></td>
            <td><a href="detail.php?id=<?php echo $t['id']; ?>">Detail</a></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>
