<?php
require_once '../config/koneksi.php';

$id = $_GET['id'] ?? 0;

// GANTI QUERY LAMA ANDA DENGAN KODE BARU INI:
$sql = "SELECT sa.*, 
               a.nama_anggota, a.npm, a.program_studi AS ps_anggota, 
               p.nama_pengurus, p.program_studi AS ps_pengurus, p.jabatan 
        FROM surat_aktif sa
        JOIN anggota a ON sa.id_anggota = a.id_anggota
        JOIN pengurus p ON sa.id_pengurus = p.id_pengurus
        WHERE sa.id_sa = ?";
$stmt = $koneksi->prepare($sql);
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    die("Arsip surat keterangan aktif tidak valid.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat_Aktif_<?= str_replace(' ', '_', $data['nama_anggota']); ?></title>
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
    <a href="tambah_sa.php" class="btn btn-back">← Kembali</a>
</div>

<table class="kop-surat">
    <tr>
        <td width="15%" align="left">
            <img src="../assets/img/logo_polinela.png" alt="Logo Polinela" width="90" onerror="this.style.display='none'">
        </td>
        <td width="70%" class="kop-teks">
            <div class="kementerian">KEMENTERIAN PENDIDIKAN TINGGI, SAINS,</div>
            <div class="kementerian">DAN TEKNOLOGI</div>
            <div class="polinela">POLITEKNIK NEGERI LAMPUNG</div>
            <div class="ukm">UKM ENGLISH CLUB</div>
            <div class="alamat">Jalan Soekarno – Hatta No 10 Rajabasa Bandar Lampung 35144</div>
            <div class="kontak">Email : englishclub@polinela.ac.id <span style="color:#666;">Website : www.ecpolinela.com</span></div>
        </td>
        <td width="15%" align="right">
            <img src="../assets/img/logo_ec.png" alt="Logo EC" width="90" onerror="this.style.display='none'">
        </td>
    </tr>
</table>

<table class="detail-surat">
    <tr>
        <td width="60%">
            Nomor &nbsp;: <?= $data['id_sa']; ?>/EC-POLINELA/A/<?= date('Y', strtotime($data['tgl_terbit'])); ?><br>
            Hal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Surat Aktif
        </td>
        <td width="40%" align="right">
            <?= date('d F Y', strtotime($data['tgl_terbit'])); ?>
        </td>
    </tr>
</table>

<div class="judul-surat">
    <span>SURAT AKTIF</span>
</div>

<div class="content-body">
    Yang bertanda tangan dibawah ini :
    <table class="table-data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?= htmlspecialchars($data['nama_pengurus']); ?></td>
        </tr>
        <tr>
            <td>NPM</td>
            <td>:</td>
            <td>24781106</td>
        </tr>
        <tr>
            <td>PS</td>
            <td>:</td>
            <td><?= htmlspecialchars($data['ps_pengurus']); ?></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td><?= htmlspecialchars($data['jabatan']); ?></td>
        </tr>
    </table>
</div>

<div class="content-body">
    Dengan ini menyatakan dengan sesungguhnya bahwa :
    <table class="table-data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?= htmlspecialchars($data['nama_anggota']); ?></td>
        </tr>
        <tr>
            <td>NPM</td>
            <td>:</td>
            <td><?= htmlspecialchars($data['npm']); ?></td>
        </tr>
        <tr>
            <td>PS</td>
            <td>:</td>
            <td><?= htmlspecialchars($data['ps_anggota']); ?></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>Member Of UKM English Club 2026</td>
        </tr>
    </table>
</div>

<div class="content-body">
    <p>Bahwa nama tersebut di atas benar-benar masih aktif dalam keorganisasian UKM English Club Politeknik Negeri Lampung Pada Tahun Akademik <?= date('Y'); ?>/<?= date('Y')+1; ?>.</p>
    <p>Demikian surat aktif organisasi ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
</div>

<div class="container-ttd">
    <p style="margin-bottom: 0;">Chairman of UKM English Club 2026,</p>
    
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