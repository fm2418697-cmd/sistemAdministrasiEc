<?php 
require_once '../config/koneksi.php';
// Sesuaikan query dengan kolom tabel surat_peringatan Anda
$sql = "SELECT sp.id_sp, a.nama_anggota, tingkat_sp AS jenis_sp
        FROM surat_peringatan sp 
        JOIN anggota a ON sp.id_anggota = a.id_anggota 
        ORDER BY sp.id_sp DESC";
$list_sp = $koneksi->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat SP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <h3 class="mb-4 text-danger">Riwayat Surat Peringatan</h3>
        <form action="cetak_batch_sp.php" method="GET" target="_blank">
            <table id="tabelSP" class="table table-striped table-bordered bg-white">
                <thead class="table-dark">
                    <tr>
                        <th><input type="checkbox" id="checkAllSP"></th>
                        <th>Nama</th>
                        <th>Jenis SP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list_sp as $row): ?>
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="<?= $row['id_sp']; ?>"></td>
                        <td><?= htmlspecialchars($row['nama_anggota']); ?></td>
                        <td><?= htmlspecialchars($row['jenis_sp']); ?></td>
                        <td>
                            <a href="cetak_sp.php?id=<?= $row['id_sp']; ?>" class="btn btn-sm btn-info">Cetak</a>
                            <a href="hapus_sp.php?id=<?= $row['id_sp']; ?>" class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-danger">Cetak SP yang Dipilih</button>
        </form>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabelSP').DataTable();
            $('#checkAllSP').click(function() { $('input[name="ids[]"]').prop('checked', this.checked); });
        });
    </script>
</body>
</html>