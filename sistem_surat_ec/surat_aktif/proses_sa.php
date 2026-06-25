<?php
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_anggota  = $_POST['id_anggota'];
    $id_pengurus = $_POST['id_pengurus'];
    $tgl_terbit  = $_POST['tgl_terbit'];
    $keperluan   = $_POST['keperluan'];

    $sql = "INSERT INTO surat_aktif (id_anggota, id_pengurus, tgl_terbit, keperluan) 
            VALUES (:id_anggota, :id_pengurus, :tgl_terbit, :keperluan)";
    
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([
        ':id_anggota'  => $id_anggota,
        ':id_pengurus' => $id_pengurus,
        ':tgl_terbit'  => $tgl_terbit,
        ':keperluan'   => $keperluan
    ]);

    $id_terakhir = $koneksi->lastInsertId();

    header("Location: cetak_sa.php?id=" . $id_terakhir);
    exit;
}
?>