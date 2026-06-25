<?php 
require_once '../config/koneksi.php';
// Mengambil list mahasiswa yang statusnya masih Aktif saja
$list_anggota = $koneksi->query("SELECT id_anggota, npm, nama_anggota FROM anggota WHERE status_keaktifan = 'Aktif'")->fetchAll();
$list_pengurus = $koneksi->query("SELECT id_pengurus, nama_pengurus, jabatan FROM pengurus")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Penerbitan Surat Peringatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body class="bg-light">
<div class="container my-5" style="max-width: 700px;">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-danger text-white p-3">
            <h5 class="card-title mb-0 fw-bold">Form Input Surat Peringatan (SP)</h5>
        </div>
        <div class="card-body p-4">
            <form action="proses_sp.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Anggota (Penerima Sanksi)</label>
                    <select name="id_anggota" class="form-select select2" required>
                        <option value="">-- Pilih Anggota --</option>
                        <?php foreach($list_anggota as $row): ?>
                            <option value="<?= $row['id_anggota']; ?>"><?= $row['npm']; ?> - <?= $row['nama_anggota']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <script>
                        $(document).ready(function() {
                            $('.select2').select2({
                                placeholder: "Cari nama atau NPM anggota...",
                                allowClear: true,
                                width: '100%' // Agar lebar dropdown mengikuti form
                            });
                        });
                    </script>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Penandatangan Surat (Pengurus Inti)</label>
                    <select name="id_pengurus" class="form-select" required>
                        <option value="">-- Pilih Pengurus --</option>
                        <?php foreach($list_pengurus as $row): ?>
                            <option value="<?= $row['id_pengurus']; ?>"><?= $row['nama_pengurus']; ?> (<?= $row['jabatan']; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Dokumen</label>
                        <input type="date" name="tgl_sp" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tingkat Surat Peringatan</label>
                        <select name="tingkat_sp" class="form-select" required>
                            <option value="1">Surat Peringatan I (SP 1)</option>
                            <option value="2">Surat Peringatan II (SP 2)</option>
                            <option value="3">Surat Peringatan III (SP 3)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Alasan Tindakan Indispliner</label>
                    <textarea name="alasan" class="form-control" rows="4" placeholder="Tuliskan detail pelanggaran komitmen anggota di sini..." required></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="../index.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-danger px-4">Simpan Data & Cetak Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>