<?php 
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "web_camping");

// Fungsi untuk mengambil data (Read)
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

// Fungsi Tambah Data (Create)
function tambah($data) {
    global $conn;

    // Ambil data dari form 
    $nama_alat  = $data["nama_alat"];
    $kategori   = $data["kategori"];
    $harga_sewa = $data["harga_sewa"];
    $stok       = $data["stok"];

    // Upload gambar
    $gambar = upload();
    if( !$gambar ) {
        return false;
    }

    $query = "INSERT INTO alat_camping 
                VALUES ('', '$nama_alat', '$kategori', '$harga_sewa', '$stok', '$gambar')";
    
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// Fungsi Upload Gambar
function upload() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // Cek apakah tidak ada gambar yang diupload
    if( $error === 4 ) {
        echo "<script>
                alert('Pilih gambar terlebih dahulu!');
              </script>";
        return false;
    }

    // Cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
        echo "<script>
                alert('Yang anda upload bukan gambar!');
              </script>";
        return false;
    }

    // Lolos pengecekan, gambar siap diupload
    move_uploaded_file($tmpName, 'img/' . $namaFile);

    return $namaFile;
}

// Fungsi Hapus Data (Delete)
function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM alat_camping WHERE id_alat = $id");
    return mysqli_affected_rows($conn);
}

// Fungsi Ubah Data (Update)
function ubah($data) {
    global $conn;

    $id         = $data["id_alat"];
    $nama_alat  = $data["nama_alat"];
    $kategori   = $data["kategori"];
    $harga_sewa = $data["harga_sewa"];
    $stok       = $data["stok"];
    $gambarLama = $data["gambarLama"];

    // Cek apakah user pilih gambar baru atau tidak
    if( $_FILES['gambar']['error'] === 4 ) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE alat_camping SET
                nama_alat = '$nama_alat',
                kategori = '$kategori',
                harga_sewa = '$harga_sewa',
                stok = '$stok',
                gambar = '$gambar'
              WHERE id_alat = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// Fungsi Registrasi User
function registrasi($data) {
    global $conn;

    $username  = strtolower($data["username"]);
    $password  = mysqli_real_escape_string($conn, $data["password"]);
    $konfirmasi = mysqli_real_escape_string($conn, $data["konfirmasi"]);

    // Cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

    if( mysqli_fetch_assoc($result) ) {
        echo "<script>
                alert('Username sudah terdaftar!');
              </script>";
        return false;
    }

    // Cek konfirmasi password
    if( $password !== $konfirmasi ) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai!');
              </script>";
        return false;
    }

    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);
}
?>