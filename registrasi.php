<?php
require 'function.php'; 

if( isset($_POST["register"]) ) {
    if( registrasi($_POST) > 0 ) {
        echo "<script>
                alert('User baru berhasil ditambahkan! Silakan login.');
                document.location.href = 'login.php';
              </script>";
    } else {
        echo mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - CAMPRENT</title>
    <!-- Link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #F9F8F6; 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .card-register { 
            border: none; 
            border-radius: 15px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            padding: 30px; 
            width: 100%; 
            max-width: 400px; 
        }
        .btn-custom { 
            background-color: #2C5F2D; 
            color: white; 
            border: none; 
            font-weight: 600; 
        }
        .btn-custom:hover { 
            background-color: #1F4220; 
            color: white; 
        }
        .logo-img { 
            max-width: 100px; 
            margin-bottom: 15px; 
        }
    </style>
</head>
<body>

<div class="card card-register bg-white">
    <div class="text-center">

        <img src="img/logo.png" alt="CAMPRENT Logo" class="logo-img">
        <h4 class="fw-bold" style="color: #2C5F2D;">Daftar Akun Baru</h4>
    </div>
    
    <form action="" method="post" class="mt-4">
        <div class="mb-3">
            <label for="username" class="form-label fw-semibold small">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold small">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-4">
            <label for="konfirmasi" class="form-label fw-semibold small">Konfirmasi Password</label>
            <input type="password" name="konfirmasi" id="konfirmasi" class="form-control" required>
        </div>
        
        <div class="d-grid gap-2">
            <button type="submit" name="register" class="btn btn-custom">Registrasi</button>
            <a href="login.php" class="text-center text-muted small mt-2 text-decoration-none">Sudah punya akun? Login di sini</a>
        </div>
    </form>
</div>

</body>
</html>