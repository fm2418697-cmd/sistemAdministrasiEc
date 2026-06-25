<?php
require_once '../config/koneksi.php';

// Mendapatkan daftar ID dari form (contoh: ?id=1,2,3)
$ids = isset($_GET['ids']) ? explode(',', $_GET['ids']) : [];

if (empty($ids)) {
    die("Tidak ada surat yang dipilih untuk dicetak.");
}

// Mengambil data berdasarkan daftar ID
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$sql = "SELECT sa.*, a.nama_anggota, a.npm, a.program_studi AS ps_anggota, 
               p.nama_pengurus, p.program_studi AS ps_pengurus, p.jabatan 
        FROM surat_aktif sa
        JOIN anggota a ON sa.id_anggota = a.id_anggota
        JOIN pengurus p ON sa.id_pengurus = p.id_pengurus
        WHERE sa.id_sa IN ($placeholders)";

$stmt = $koneksi->prepare($sql);
$stmt->execute($ids);
$list_surat = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cetak Massal Surat Aktif</title>
    <style>
        /* CSS yang sudah kita perbaiki sebelumnya */
        @page { size: A4; margin: 0; }
        body { font-family: "Times New Roman", Times, serif; font-size: 12pt; margin: 0; padding: 15mm 20mm 20mm 20mm; }
        
        /* CLASS PENGATUR HALAMAN */
        .page-break { page-break-after: always; position: relative; min-height: 297mm; }

        /* Masukkan CSS Surat Anda (Kop, Tanda Tangan, dll) di sini... */
        /* Pastikan elemen .footer-garis tetap menggunakan position: absolute; bottom: 25mm; */
    </style>
</head>
<body>

<?php foreach ($list_surat as $data): ?>
    <div class="page-break">
        <div class="kop-surat">...</div>
        <div class="content-body">...</div>
        <div class="container-ttd">Chairman of UKM English Club 2026,</div>
        <div class="footer-garis"><span>UKM ENGLISH CLUB</span></div>
    </div>
<?php endforeach; ?>

<script>
    window.print(); // Otomatis memicu dialog print saat halaman dibuka
</script>
</body>
</html>