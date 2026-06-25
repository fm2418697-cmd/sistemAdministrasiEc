<?php
require_once '../config/koneksi.php';

$id = $_GET['id'] ?? 0;

$sql = "SELECT sp.*, a.nama_anggota, a.npm, p.nama_pengurus, p.jabatan 
        FROM surat_peringatan sp
        JOIN anggota a ON sp.id_anggota = a.id_anggota
        JOIN pengurus p ON sp.id_pengurus = p.id_pengurus
        WHERE sp.id_sp = ?";
$stmt = $koneksi->prepare($sql);
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    die("Data arsip surat peringatan tidak valid.");
}

$romawi = ["", "Pertama (SP-1)", "Kedua (SP-2)", "Ketiga (SP-3) / Pemutusan Hubungan Keanggotaan"];
$sp_teks = $romawi[$data['tingkat_sp']];

// Menyesuaikan sapaan (Saudara/Saudari) - Default Saudari sesuai template
$sapaan = "Saudari"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat_Peringatan_<?= str_replace(' ', '_', $data['nama_anggota']); ?></title>
    <style>
/* Pengaturan Kertas untuk menghilangkan tulisan browser otomatis */
        @page { size: A4; margin: 0; } 
        
        body { 
            font-family: "Times New Roman", Times, serif; 
            font-size: 12pt; 
            line-height: 1.5; 
            color: #000; 
            margin: 0; 
            padding: 15mm 20mm 20mm 20mm; 
            box-sizing: border-box;
            /* KUNCI POSISI: Memaksa tinggi halaman sama dengan kertas A4 */
            position: relative; 
            min-height: 297mm; 
        }
        
        /* Kop Surat */
        .kop-surat { width: 100%; border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 15px; }
        .kop-surat.double-line { border-bottom-style: double; border-bottom-width: 4px; } 
        .kop-surat td { vertical-align: middle; }
        .kop-teks { text-align: center; line-height: 1.1; }
        .kop-teks .kementerian { font-size: 13pt; color: #000; } 
        .kop-teks .polinela { font-size: 13pt; color: #000;}
        .kop-teks .ukm { font-size: 14pt; font-weight: bold; margin-top: 2px;}
        .kop-teks .alamat { font-size: 10pt; margin-top: 5px; color: #000;}
        .kop-teks .kontak { font-size: 10pt; font-style: italic; color: blue; }

        /* Detail Surat */
        .detail-surat { width: 100%; margin-bottom: 15px; }
        .detail-surat td { vertical-align: top; }

        .judul-surat { text-align: center; margin-bottom: 20px; }
        .judul-surat span { font-weight: bold; text-decoration: underline; font-size: 12pt; }
        .judul-surat h4 { font-size: 14pt; text-decoration: underline; margin: 0; text-transform: uppercase; font-weight: bold; }
        .judul-surat p { margin: 5px 0 0 0; font-size: 11pt; }

        /* Konten */
        .content-body { text-align: justify; margin-bottom: 10px; }
        .table-data { margin: 10px 0 10px 0; width: 100%; }
        .table-data td { padding: 2px 0; vertical-align: top; }
        .table-data td:nth-child(1) { width: 70px; }
        .table-data td:nth-child(2) { width: 15px; }

        /* Tanda Tangan */
        .container-ttd { margin-top: 20px; float: right; text-align: left; width: 250px; }
        .space-ttd { height: auto; text-align: left; padding-left: 0px; } 
        
        /* FOOTER CUSTOM - DIPAKSA MENEMPEL KE BAWAH */
        .footer-garis { 
            text-align: center; 
            border-top: 1px solid #000; 
            line-height: 0.1em; 
            position: absolute; /* Mengunci posisi elemen */
            bottom: 25mm; /* Jarak pasti dari ujung paling bawah kertas */
            left: 20mm; 
            right: 20mm; 
        }
        .footer-garis span { background: #fff; padding: 0 15px; font-weight: bold; font-size: 10pt; color: #000; }

        /* Tombol Navigasi */
        .panel-kontrol { background: #f0f2f5; padding: 12px; margin-bottom: 25px; border-radius: 6px; display: flex; gap: 10px; border: 1px solid #ddd; }
        .btn { padding: 6px 14px; font-family: sans-serif; cursor: pointer; text-decoration: none; border-radius: 4px; font-size: 13px; font-weight: bold; }
        .btn-print { background-color: #198754; color: white; border: none; }
        .btn-back { background-color: #6c757d; color: white; border: none; }

        @media print {
            .panel-kontrol { display: none !important; }
            body { padding-top: 15mm; } 
        }
    </style>
</head>
<body>

<div class="panel-kontrol">
    <button onclick="window.print();" class="btn btn-print">🖨️ Simpan Sebagai PDF</button>
    <a href="tambah_sp.php" class="btn btn-back">← Kembali</a>
</div>

<table class="kop-surat">
    <tr>
        <td width="15%" align="left">
            <img src="../assets/img/logo_ec.png" alt="Logo EC" width="90" onerror="this.style.display='none'">
        </td>
        <td width="85%" class="kop-teks">
            <div class="kementerian">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,</div>
            <div class="kementerian">RISET, DAN TEKNOLOGI</div>
            <div class="polinela">POLITEKNIK NEGERI LAMPUNG</div>
            <div class="ukm">UKM ENGLISH CLUB</div>
            <div class="alamat">Jalan Soekarno – Hatta No 10 Rajabasa Bandar Lampung 35144</div>
            <div class="kontak">Email : englishclub@polinela.ac.id <span style="color:#000;">Website : englishclub.kemahasiswaan.polinela.ac.id</span></div>
        </td>
        <td width="15%" align="right">
            <img src="../assets/img/logo_ec.png" alt="Logo EC" width="90" onerror="this.style.display='none'">
        </td>
    </tr>
</table>

<table class="detail-surat">
    <tr>
        <td width="60%">
            Nomor &nbsp;: 0<?= $data['id_sp']; ?>/EC-POLINELA/A/<?= date('Y', strtotime($data['tgl_sp'])); ?><br>
            Hal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Surat Peringatan
        </td>
        <td width="40%" align="right">
            <?= date('d F Y', strtotime($data['tgl_sp'])); ?>
        </td>
    </tr>
</table>

<div class="content-body" style="margin-bottom: 30px;">
    Yth. <?= htmlspecialchars($data['nama_anggota']); ?><br>
    Di-Tempat
</div>

<div class="content-body">
    Surat Peringatan <?= $sp_teks; ?> UKM English Club Politeknik Negeri Lampung ditujukan kepada :
    
    <table class="table-data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?= htmlspecialchars($data['nama_anggota']); ?></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>Member of UKM English Club</td>
        </tr>
    </table>
</div>

<div class="content-body">
    <p>Dengan ini UKM English Club POLINELA memberikan SP-<?= $data['tingkat_sp']; ?> <?= $data['tingkat_sp'] == 3 ? 'sekaligus disampaikan sebagai Surat Pemutusan Hubungan Keanggotaan' : '' ?>. Kami mengeluarkan surat ini atas dasar ketidak disiplinan dan ketidakaktifan yang telah dilakukan oleh <?= $sapaan ?> <?= htmlspecialchars($data['nama_anggota']); ?>.</p>

    <?php if($data['tingkat_sp'] == 3): ?>
    <p>Kami memohon maaf karena terpaksa menjatuhkan Pemutusan Hubungan Keanggotaan kepada <?= $sapaan ?>. Keputusan ini dibuat agar kegiatan UKM English Club POLINELA dapat berjalan dengan semestinya.</p>
    <p>Sehubungan dengan ini pula, <?= $sapaan ?> <?= htmlspecialchars($data['nama_anggota']); ?> diwajibkan untuk melepas dan tidak menggunakan segala atribut UKM English Club POLINELA.</p>
    <?php else: ?>
    <p>Kami sangat berharap <?= $sapaan ?> dapat segera memperbaiki tingkat kehadiran dan kedisiplinan. Keputusan ini dibuat agar kegiatan UKM English Club POLINELA dapat berjalan dengan semestinya dan sesuai dengan komitmen awal kepengurusan.</p>
    <?php endif; ?>

    <p>Demikian Surat Peringatan <?= $sp_teks; ?> dibuat supaya diperhatikan dengan seksama dan ditaati oleh <?= $sapaan ?> <?= htmlspecialchars($data['nama_anggota']); ?>.</p>
</div>

<div class="container-ttd">
    <p style="margin-bottom: 0;">Ketua Umum UKM English Club,</p>
    
    <div class="space-ttd" style="height: auto; text-align: left; padding-left: 10px;">
        <img src="../assets/img/ttd_ketua.png" alt="Tanda Tangan Ketua" style="width: 220px; margin-top: -15px; margin-bottom: -20px; margin-left: -30px; mix-blend-mode: multiply;">
    </div>
    
    <p style="margin-top: 0; line-height: 1.2;">
        <?= htmlspecialchars($data['nama_pengurus']); ?><br>
        NPM 24781106 </p>
</div>

<div class="footer-garis">
    <span>UKM ENGLISH CLUB</span>
</div>

<script>
    // Menambahkan jeda 0.5 detik agar browser sempat membaca <title> untuk nama file
    window.onload = function() { 
        setTimeout(function() {
            window.print();
        }, 500);
    }
</script>
</body>
</html>