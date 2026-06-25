<?php 
require_once '../config/koneksi.php';
$list_anggota = $koneksi->query("SELECT id_anggota, npm, nama_anggota, program_studi, jurusan FROM anggota WHERE status_keaktifan = 'Aktif'")->fetchAll();
$list_pengurus = $koneksi->query("SELECT id_pengurus, nama_pengurus, jabatan FROM pengurus")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input SKA - UKM English Club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body { background-color: #f4f6f9; }
        .card { border-radius: 12px; }
        .card-header { background-color: #fff !important; border-bottom: 1px solid #eee; padding: 1.5rem !important; }
        .form-label { font-weight: 600; color: #495057; }
        .select2-container .select2-selection--single { height: 38px; padding-top: 4px; border: 1px solid #ced4da; border-radius: 6px; }
        .btn-success { background-color: #198754; border: none; padding: 0.6rem 1.5rem; }
    </style>
</head>
<body>

<div class="container my-5" style="max-width: 800px;">
    <div class="mb-4">
        <h2 class="fw-bold text-dark">Formulir Penerbitan SKA</h2>
        <p class="text-muted">Lengkapi data berikut untuk menerbitkan Surat Keterangan Aktif anggota.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="proses_sa.php" method="POST">
                <div class="mb-4">
                    <label class="form-label">Nama Anggota Pemohon</label>
                    <select name="id_anggota" class="form-select select2" required>
                        <option value="">-- Cari nama atau NPM anggota --</option>
                        <?php foreach($list_anggota as $row): ?>
                            <option value="<?= $row['id_anggota']; ?>">
                                <?= $row['npm']; ?> | <?= $row['nama_anggota']; ?> - <?= $row['program_studi']; ?> - <?= $row['jurusan']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Penandatangan Surat</label>
                        <select name="id_pengurus" class="form-select" required>
                            <option value="">-- Pilih Pengurus --</option>
                            <?php foreach($list_pengurus as $row): ?>
                                <option value="<?= $row['id_pengurus']; ?>"><?= $row['nama_pengurus']; ?> (<?= $row['jabatan']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Tanggal Terbit</label>
                        <input type="date" name="tgl_terbit" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Peruntukan / Keperluan Surat</label>
                    <textarea name="keperluan" class="form-control" rows="3" placeholder="Contoh: Kelengkapan berkas administrasi beasiswa PPA 2026." required></textarea>
                </div>

                <div class="d-flex gap-2">
                    <a href="../index.php" class="btn btn-outline-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success ms-auto">Simpan & Cetak Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({ width: '100%' });
    });
</script>
</body>
</html>