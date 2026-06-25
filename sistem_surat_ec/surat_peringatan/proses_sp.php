<?php
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_anggota  = $_POST['id_anggota'];
    $id_pengurus = $_POST['id_pengurus'];
    $tgl_sp      = $_POST['tgl_sp'];
    $tingkat_sp  = $_POST['tingkat_sp'];
    $alasan      = $_POST['alasan'];

    // Query Menggunakan Prepared Statements PDO untuk Keamanan Optimal
    $sql = "INSERT INTO surat_peringatan (id_anggota, id_pengurus, tgl_sp, tingkat_sp, alasan) 
            VALUES (:id_anggota, :id_pengurus, :tgl_sp, :tingkat_sp, :alasan)";
    
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([
        ':id_anggota'  => $id_anggota,
        ':id_pengurus' => $id_pengurus,
        ':tgl_sp'      => $tgl_sp,
        ':tingkat_sp'  => $tingkat_sp,
        ':alasan'      => $alasan
    ]);

    $id_terakhir = $koneksi->lastInsertId();

    // Logika Bisnis: Jika SP yang keluar adalah SP-3, otomatis ubah status keaktifan mahasiswa di sistem
    if ($tingkat_sp == 3) {
        $update = $koneksi->prepare("UPDATE anggota SET status_keaktifan = 'Tidak Aktif' WHERE id_anggota = ?");
        $update->execute([$id_anggota]);
    }

    // Mengalihkan halaman langsung ke template cetak PDF
    header("Location: cetak_sp.php?id=" . $id_terakhir);
    exit;
}
?>