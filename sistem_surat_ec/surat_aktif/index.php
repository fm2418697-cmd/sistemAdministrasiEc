<?php 
require_once '../config/koneksi.php';
// Gunakan kolom 'tanggal' atau 'tanggal_terbit' sesuai struktur database Anda
$sql = "SELECT sa.*, a.nama_anggota, a.npm 
        FROM surat_aktif sa 
        JOIN anggota a ON sa.id_anggota = a.id_anggota 
        ORDER BY sa.id_sa DESC"; // Menggunakan ID sebagai pengurut alternatif jika tanggal bermasalah
$list_surat = $koneksi->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat Surat Aktif</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <h3 class="mb-4">Riwayat Surat Keterangan Aktif</h3>
        <form action="cetak_batch.php" method="GET" target="_blank">
            <table id="tabelSurat" class="table table-striped table-bordered bg-white">
                <thead class="table-dark">
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>Nama</th>
                        <th>NPM</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
    <?php foreach ($list_surat as $row): ?>
    <tr>
        <td><input type="checkbox" name="ids[]" value="<?= $row['id_sa']; ?>"></td>
        <td><?= htmlspecialchars($row['nama_anggota']); ?></td>
        <td><?= htmlspecialchars($row['npm']); ?></td>
        <td>
            <a href="cetak_sa.php?id=<?= $row['id_sa']; ?>" class="btn btn-sm btn-info">Cetak</a>
            <a href="hapus_sa.php?id=<?= $row['id_sa']; ?>" class="btn btn-sm btn-danger">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
            </table>
            <button type="submit" class="btn btn-primary">Cetak yang Dipilih</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabelSurat').DataTable();
            $('#checkAll').click(function() { $('input[name="ids[]"]').prop('checked', this.checked); });
        });
    </script>
</body>
</html>