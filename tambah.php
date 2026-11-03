<?php 
session_start();

require 'function.php';

if(!isset($_SESSION['session_login'])){
    header("Location: login.php");
    exit;
}


if(isset($_POST['submit'])){

    // Cek apakah data berhasil ditambahkan atau tidak
    if(tambah($_POST) > 0){
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    }

}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Alat Camping</title>
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
        .card-form {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: none;
            max-width: 700px;
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
            
            <a href="index.php">
                <i class="fas fa-campground"></i> Daftar Alat
            </a>
            
            <br>
            <br>
            <br>

            <a href="logout.php" onclick="return confirm('Yakin ingin logout?');" style="color: #ffcccc;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <!-- BAGIAN KANAN (KONTEN UTAMA) -->
        <div class="col-md-10 p-4">
            
            <h3 style="color: #2C5F2D;"><i class="fas fa-plus-circle"></i> Tambah Data Alat Camping</h3>
            <br>

            <div class="card card-form">
                <div class="card-body p-4">
                    
                    <!-- Form -->
                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label for="nama_alat" class="form-label">Nama Alat</label>
                            <input type="text" name="nama_alat" id="nama_alat" class="form-control" placeholder="Masukkan nama alat..." required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" name="kategori" id="kategori" class="form-control" placeholder="Contoh: Tenda, Cooking Set, Dll..." required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label for="harga_sewa" class="form-label">Harga Sewa (Per Hari)</label>
                            <input type="number" name="harga_sewa" id="harga_sewa" class="form-control" placeholder="Masukkan harga sewa (angka saja)..." required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok Barang</label>
                            <input type="number" name="stok" id="stok" class="form-control" placeholder="Masukkan jumlah stok..." required autocomplete="off">
                        </div>

                        <div class="mb-4">
                            <label for="gambar" class="form-label">Pilih Gambar</label>
                            <input type="file" name="gambar" id="gambar" class="form-control" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary" style="background-color: #2C5F2D; border: none;">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> Kembali
                        </a>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

</body>
</html>