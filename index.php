<?php 
session_start();
require 'function.php';

// Cek session login
if(!isset($_SESSION['session_login'])){
    header("Location: login.php");
    exit;
}

// ==========================================
//               PAGINATION
// ==========================================

// Jumlah data yang ditampilkan per halaman
$jumlahDataPerHalaman = 5;

// Hitung jumlah seluruh data
$jumlahData = count(query("SELECT * FROM alat_camping"));

// Hitung jumlah halaman
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

// Halaman aktif
$halamanAktif = (isset($_GET["halaman"])) ? (int)$_GET["halaman"] : 1;

// Menentukan awal data
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

// Ambil data alat camping berdasarkan pagination
$alat = query("SELECT * FROM alat_camping LIMIT $awalData, $jumlahDataPerHalaman");

// Untuk mencari data melalui input cari
if(isset($_POST['cari'])){
    $keyword = $_POST['keyword'];
    $alat = query("SELECT * FROM alat_camping WHERE nama_alat LIKE '%$keyword%' OR kategori LIKE '%$keyword%' ");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard CAMPRENT</title>
    <!-- Link Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link FontAwesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background-color: #2C5F2D; 
            min-height: 100vh; 
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #1F4220; 
        }
        .card-tabel {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: none;
        }
        /* Style untuk tombol pagination agar sesuai Bootstrap tapi simpel */
        .pagination-disabled {
            color: #6c757d;
            padding: 6px 12px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <!-- BAGIAN KIRI (SIDEBAR) -->
        <div class="col-md-2 sidebar">
            <div class="text-center mb-4">
                <img src="img/logo.png" width="80" alt="Logo CAMPRENT" class="mb-2">
                <h5>CAMPRENT</h5>
                <hr>
            </div>
            
            <a href="index.php" style="background-color: #1F4220;">
                <i class="fas fa-campground"></i> Daftar Alat
            </a>
            
            <br><br><br>
            <a href="logout.php" onclick="return confirm('Yakin ingin logout?');" style="color: #ffcccc;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <!-- BAGIAN KANAN (KONTEN UTAMA) -->
        <div class="col-md-10 p-4">
            
            <h3 style="color: #2C5F2D;"><i class="fas fa-boxes"></i> Inventaris Alat Camping</h3>
            <br>

            <div class="card card-tabel">
                <div class="card-body">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <a href="tambah.php" class="btn btn-primary" style="background-color: #2C5F2D; border: none;">
                                <i class="fas fa-plus"></i> Tambah Data
                            </a>
                        </div>
                        <div class="col-md-6">
                            <form action="" method="post" class="d-flex">
                                <input type="text" name="keyword" class="form-control me-2" placeholder="Cari alat camping..." autocomplete="off" autofocus>
                                <button type="submit" name="cari" class="btn btn-secondary"><i class="fas fa-search"></i> Cari</button>
                            </form>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No.</th>
                                <th>Gambar</th>
                                <th>Nama Alat</th>
                                <th>Kategori</th>
                                <th>Harga Sewa</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = $awalData + 1; ?>
                            <?php foreach($alat as $barang) : ?>
                            <tr>
                                <td class="text-center"><?php echo $i; ?></td>
                                <td class="text-center">
                                    <img src="img/<?php echo $barang['gambar']; ?>" width="60" style="border-radius: 5px;">
                                </td>
                                <td><?php echo $barang['nama_alat']; ?></td>
                                <td class="text-center"><?php echo $barang['kategori']; ?></td>
                                <td>Rp <?php echo number_format($barang['harga_sewa'], 0, ',', '.'); ?></td>
                                <td class="text-center"><?php echo $barang['stok']; ?></td>
                                <td class="text-center">
                                    <a href="ubah.php?id=<?php echo $barang['id_alat']; ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a> 
                                    <a href="hapus.php?id=<?php echo $barang['id_alat']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus <?php echo $barang['nama_alat']; ?>?');">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- NAVIGASI PAGINATION -->
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">

                                <!-- PREVIOUS -->
                                <?php if($halamanAktif > 1) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?halaman=<?php echo $halamanAktif - 1; ?>">&larr; Prev</a>
                                    </li>
                                <?php else : ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">&larr; Prev</span>
                                    </li>
                                <?php endif; ?>

                                <!-- NOMOR HALAMAN -->
                                <?php for($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                                    <?php if($i == $halamanAktif) : ?>
                                        <li class="page-item active">
                                            <a class="page-link" href="?halaman=<?php echo $i; ?>" style="background-color: #2C5F2D; border-color: #2C5F2D;"><?php echo $i; ?></a>
                                        </li>
                                    <?php else : ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <!-- NEXT -->
                                <?php if($halamanAktif < $jumlahHalaman) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?halaman=<?php echo $halamanAktif + 1; ?>">Next &rarr;</a>
                                    </li>
                                <?php else : ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">Next &rarr;</span>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </nav>
                    </div>
                    <!-- END PAGINATION -->

                </div>
            </div>

        </div>

    </div>
</div>

</body>
</html>