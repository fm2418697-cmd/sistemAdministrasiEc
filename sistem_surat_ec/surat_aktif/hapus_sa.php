<?php
require_once '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Ganti 'id_sa' dengan nama primary key di tabel surat_aktif Anda
    $query = $koneksi->prepare("DELETE FROM surat_aktif WHERE id_sa = ?");
    $query->execute([$id]);

    // Kembali ke halaman riwayat setelah berhasil
    echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
}
?>