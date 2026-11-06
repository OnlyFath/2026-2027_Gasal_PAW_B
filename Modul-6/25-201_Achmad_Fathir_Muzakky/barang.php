<?php
include "koneksi.php";

$pesan = "";

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    $cek = mysqli_query($koneksi, "SELECT * FROM transaksi_detail WHERE barang_id = $id");

    if (mysqli_num_rows($cek) > 0) {
        $pesan = "Barang tidak bisa dihapus karena masih digunakan pada transaksi";
    } else {
        mysqli_query($koneksi, "DELETE FROM barang WHERE id = $id");
        $pesan = "Barang berhasil dihapus";
    }
}

$barang = mysqli_query($koneksi, "SELECT barang.*, supplier.nama FROM barang JOIN supplier ON supplier.id = barang.supplier_id");
?>
<html>
<body>
<a href="index.php">Transaksi</a> | <a href="barang.php">Barang</a>
<h2>Data Barang</h2>

<?php echo $pesan; ?>

<table border="1" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Kode</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Supplier</th>
        <th>Aksi</th>
    </tr>
    <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
        <tr>
            <td><?php echo $b['id']; ?></td>
            <td><?php echo $b['kode_barang']; ?></td>
            <td><?php echo $b['nama_barang']; ?></td>
            <td><?php echo $b['harga']; ?></td>
            <td><?php echo $b['stok']; ?></td>
            <td><?php echo $b['nama']; ?></td>
            <td><a href="barang.php?hapus=<?php echo $b['id']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>
