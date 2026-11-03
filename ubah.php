<?php 
session_start();

require 'function.php';

// Cek session login
if(!isset($_SESSION['session_login'])){
    header("Location: login.php");
    exit;
}

// Ambil id dari URL
$id = $_GET['id'];

// Query data alat camping berdasarkan id
$barang = query("SELECT * FROM alat_camping WHERE id_alat = $id")[0];

// Cek apakah tombol submit sudah ditekan
if(isset($_POST['submit'])){

    // Cek apakah data berhasil diubah
    if(ubah($_POST) > 0){
        echo "
            <script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal diubah!');
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
    <title>Ubah Data Alat Camping</title>
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
            
            <br><br><br>
            <a href="logout.php" onclick="return confirm('Yakin ingin logout?');" style="color: #ffcccc;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <!-- BAGIAN KANAN (KONTEN UTAMA) -->
        <div class="col-md-10 p-4">
            
            <h3 style="color: #2C5F2D;"><i class="fas fa-edit"></i> Ubah Data Alat Camping</h3>
            <br>

            <div class="card card-form">
                <div class="card-body p-4">
                    
                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <!-- Input hidden untuk menyimpan id_alat dan gambarLama -->
                        <input type="hidden" name="id_alat" value="<?php echo $barang['id_alat']; ?>">
                        <input type="hidden" name="gambarLama" value="<?php echo $barang['gambar']; ?>">

                        <div class="mb-3">
                            <label for="nama_alat" class="form-label">Nama Alat</label>
                            <input type="text" name="nama_alat" id="nama_alat" class="form-control" required value="<?php echo $barang['nama_alat']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" name="kategori" id="kategori" class="form-control" required value="<?php echo $barang['kategori']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="harga_sewa" class="form-label">Harga Sewa (Per Hari)</label>
                            <input type="number" name="harga_sewa" id="harga_sewa" class="form-control" required value="<?php echo $barang['harga_sewa']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok Barang</label>
                            <input type="number" name="stok" id="stok" class="form-control" required value="<?php echo $barang['stok']; ?>">
                        </div>

                        <div class="mb-4">
                            <label for="gambar" class="form-label">Gambar Alat</label> <br>
                            <img src="img/<?php echo $barang['gambar']; ?>" width="100" class="mb-2 rounded">
                            <input type="file" name="gambar" id="gambar" class="form-control">
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary" style="background-color: #2C5F2D; border: none;">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

</body>
</html>