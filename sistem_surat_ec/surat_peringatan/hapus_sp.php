<?php
require_once '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Perbaikan: Pastikan tabel yang dihapus adalah surat_peringatan
    $query = $koneksi->prepare("DELETE FROM surat_peringatan WHERE id_sp = ?");
    $query->execute([$id]);

    echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
}
?>