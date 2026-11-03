<?php 
session_start();

    require 'function.php';

    if(isset($_SESSION['session_login'])){
        header("Location: index.php");
        exit;
    }

    if(isset($_POST['login'])){

        // var_dump($_POST);
        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' ");

        // cek username
        if(mysqli_num_rows($result) === 1){

        // cek password
         $row = mysqli_fetch_assoc($result);
         if(password_verify($password, $row['password'])){

                // set session
                $_SESSION['session_login'] = true;
                $_SESSION['username'] = $username;

                header('Location: index.php');
                exit;
            }else{
                echo "<script>
                    alert('Password yang kamu masukkan salah!');
                    </script>
                ";  
            }
        }else{
            echo "<script>
                alert('Username yang kamu masukkan salah atau tidak ditemukan!');
                </script>
            ";
        }

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .page-register {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }
        .container-custom {
            width: 100%;
            max-width: 520px;
            margin: 0;
        }
        .form-card {
            padding: 40px 45px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1); 
        }
    </style>
</head>

<body class="page-register">

    <div class="container-custom">
        <div class="form-card">
            
            <div style="text-align: center; margin-bottom: 15px;">
                <img src="img/logo.png" width="80" alt="Logo">
            </div>
            
             
            <h3 class="text-center" style="color: #2C5F2D;">Login</h3>

            <form action="" method="post">
                
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label"> Password </label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>

                <!-- Button dipadukan dengan tombol bootstrap -->
                <div class="d-flex justify-content-between">
                    <button type="submit" name="login" class="btn btn-primary px-4"> Login </button>
                    <a href="registrasi.php" class="btn btn-secondary px-4"> Registrasi </a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>