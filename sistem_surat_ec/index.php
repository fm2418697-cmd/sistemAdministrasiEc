<?php 
require_once 'config/koneksi.php';

// Menghitung statistik data secara dinamis dari database
$total_anggota = $koneksi->query("SELECT COUNT(*) FROM anggota")->fetchColumn() ?: 0;
$total_sp = $koneksi->query("SELECT COUNT(*) FROM surat_peringatan")->fetchColumn() ?: 0;
$total_sa = $koneksi->query("SELECT COUNT(*) FROM surat_aktif")->fetchColumn() ?: 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Administrasi UKM English Club</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { 
            background-color: #f4f7f6; 
            font-family: 'Poppins', sans-serif;
            font-size: 1.05rem; /* Sedikit memperbesar ukuran teks dasar */
        }
        
        /* Navbar Styling */
        .navbar-brand { 
            font-weight: 700; 
            letter-spacing: 1px; 
            font-size: 1.25rem;
        }
        
        /* Statistik Card Styling */
        .stat-card { 
            border-radius: 18px; /* Sudut lebih membulat */
            overflow: hidden;
            transition: all 0.3s ease; 
        }
        .stat-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important; 
        }
        .stat-icon {
            opacity: 0.25;
            transition: all 0.3s ease;
        }
        .stat-card:hover .stat-icon {
            transform: scale(1.15);
            opacity: 0.4;
        }

        /* Module Card Styling */
        .module-card {
            border-radius: 18px;
            transition: all 0.3s ease;
            border-top: 6px solid transparent;
        }
        .module-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
        .module-card.sp { border-top-color: #dc3545; }
        .module-card.sa { border-top-color: #198754; }
        .module-card.undangan { border-top-color: #0d6efd; }
        .module-card.pinjam { border-top-color: #ffc107; }
        .module-card.medpart { border-top-color: #0dcaf0; }

        .icon-box {
            width: 75px; /* Diperbesar dari 60px */
            height: 75px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-bottom: 20px;
            font-size: 1.5rem; /* Ikon di dalam box lebih besar */
        }
        
        .btn {
            border-radius: 10px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
            <i class="fas fa-graduation-cap text-primary fa-lg"></i>
            <span>UKM ENGLISH CLUB</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fs-6">
                <li class="nav-item"><a class="nav-link active fw-semibold" href="index.php"><i class="fas fa-home me-1"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="surat_peringatan/tambah_sp.php">Buat SP</a></li>
                <li class="nav-item"><a class="nav-link" href="surat_aktif/tambah_sa.php">Buat Surat Aktif</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row mb-5 text-center text-md-start">
        <div class="col-12">
            <h1 class="fw-bold text-dark mb-2">Pusat Administrasi UKM</h1>
            <p class="text-muted fs-5">Manajemen persuratan, anggota, dan fasilitas UKM English Club.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6">
            <div class="card stat-card bg-primary text-white border-0 shadow py-2">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="text-uppercase text-white-50 fw-semibold mb-2">Total Anggota</h5>
                            <h1 class="fw-bold m-0 display-6"><?= $total_anggota; ?> <span class="fs-5 fw-normal">Orang</span></h1>
                        </div>
                        <i class="fas fa-users fa-4x stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
            <div class="card stat-card bg-danger text-white border-0 shadow py-2">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="text-uppercase text-white-50 fw-semibold mb-2">Surat Peringatan</h5>
                            <h1 class="fw-bold m-0 display-6"><?= $total_sp; ?> <span class="fs-5 fw-normal">Arsip</span></h1>
                        </div>
                        <i class="fas fa-triangle-exclamation fa-4x stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card stat-card bg-success text-white border-0 shadow py-2">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="text-uppercase text-white-50 fw-semibold mb-2">Surat Aktif</h5>
                            <h1 class="fw-bold m-0 display-6"><?= $total_sa; ?> <span class="fs-5 fw-normal">Terbit</span></h1>
                        </div>
                        <i class="fas fa-file-signature fa-4x stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="mb-5 text-muted">

    <h3 class="fw-bold text-dark mb-4 text-center">Modul Layanan Administrasi</h3>
    
    <div class="row g-4 justify-content-center">
        
        <div class="col-lg-4 col-md-6">
            <div class="card module-card sp shadow-sm h-100">
                <div class="card-body p-4 p-xl-5 d-flex flex-column">
                    <div class="icon-box bg-danger bg-opacity-10 text-danger mx-auto mx-md-0">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <h4 class="card-title fw-bold text-dark">Surat Peringatan</h4>
                    <p class="card-text text-muted flex-grow-1">Mencetak berkas fisik SP 1, 2, atau 3 untuk penegakan kedisiplinan organisasi.</p>
                    <div class="mt-4">
                        <a href="surat_peringatan/tambah_sp.php" class="btn btn-danger btn-lg w-100 mb-2 shadow-sm"><i class="fas fa-plus-circle me-1"></i> Buat SP</a>
                        <a href="surat_peringatan/index.php" class="btn btn-light btn-lg border w-100"><i class="fas fa-history me-1"></i> Riwayat</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card module-card sa shadow-sm h-100">
                <div class="card-body p-4 p-xl-5 d-flex flex-column">
                    <div class="icon-box bg-success bg-opacity-10 text-success mx-auto mx-md-0">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h4 class="card-title fw-bold text-dark">Surat Aktif</h4>
                    <p class="card-text text-muted flex-grow-1">Penerbitan surat keterangan aktif untuk keperluan beasiswa atau akademik mahasiswa.</p>
                    <div class="mt-4">
                        <a href="surat_aktif/tambah_sa.php" class="btn btn-success btn-lg w-100 mb-2 shadow-sm"><i class="fas fa-plus-circle me-1"></i> Buat SKA</a>
                        <a href="surat_aktif/index.php" class="btn btn-light btn-lg border w-100"><i class="fas fa-history me-1"></i> Riwayat</a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>