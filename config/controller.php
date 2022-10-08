<?php

function select($query) {
    //Panggil koneksi database
    global $db;

    $result = mysqli_query($db, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    
    return $rows;
}

// Fungsi menambahkan data barang
function create_barang($post)
{
    global $db;

    $nama       = strip_tags($post['nama']);
    $jumlah     = strip_tags($post['jumlah']); 
    $harga      = strip_tags($post['harga']);
    $barcode    = rand(100000, 999999);

    // Query menambahkan data
    $query = "INSERT INTO barang VALUES(null, '$nama', '$jumlah', '$harga', '$barcode', CURRENT_TIMESTAMP())";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}


//Fungsi mengubah data barang
function update_barang($post)
{
    global $db;

    $id_barang  = $post['id_barang'];
    $nama   = strip_tags($post['nama']);
    $jumlah = strip_tags($post['jumlah']); 
    $harga  = strip_tags($post['harga']);

    // Query ubah data
    $query = "UPDATE barang SET nama = '$nama', jumlah = '$jumlah', harga = '$harga' WHERE id_barang = $id_barang";

    mysqli_query($db, $query);
 
    return mysqli_affected_rows($db);
}

// Fungsi menghapus data barang
function delete_barang($id_barang)
{
    global $db;

    //Query hapus data barang
    $query = "DELETE FROM barang WHERE id_barang = $id_barang";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi menambahkan data mahasiswa
function create_mahasiswa($post)
{
    global $db;

    // Filter input dari serangan XSS bisa menggunakan htmlspecialchars() / strip_tags()  
    $nama       = strip_tags($post['nama']);
    $prodi      = strip_tags($post['prodi']);
    $jk         = strip_tags($post['jk']);
    $telepon    = strip_tags($post['telepon']);
    $alamat     = $post['alamat'];
    $email      = strip_tags($post['email']);
    $foto       = upload_file();

    // Check upload foto
    if (!$foto) {
        return false;
    }

    // Query menambahkan data
    $query = "INSERT INTO mahasiswa VALUES(null, '$nama', '$prodi', '$jk', '$telepon', '$alamat', '$email', '$foto')";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi mengubah data mahasiswa
function update_mahasiswa($post)
{
    global $db;

    // Filter input dari serangan XSS bisa menggunakan htmlspecialchars() / strip_tags()  

    $id_mahasiswa = strip_tags($post['id_mahasiswa']);
    $nama       = strip_tags($post['nama']);
    $prodi      = strip_tags($post['prodi']);
    $jk         = strip_tags($post['jk']);
    $telepon    = strip_tags($post['telepon']);
    $alamat     = $post['alamat'];
    $email      = strip_tags($post['email']);
    $fotoLama   = strip_tags($post['fotoLama']);

    // Check upload foto baru atau tidak
    if ($_FILES['foto']['error'] == 4 ) {
        $foto = $fotoLama;
    } else {
        $foto = upload_file();
    }

    // Query menambahkan data
    $query = "UPDATE mahasiswa SET nama = '$nama', prodi = '$prodi', jk = '$jk', telepon = '$telepon', alamat = '$alamat', email = '$email', foto = '$foto' WHERE id_mahasiswa = $id_mahasiswa";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi mengupload file
function upload_file()
{
    $namaFile         = $_FILES['foto']['name'];
    $ukuranFile      = $_FILES['foto']['size'];
    $error            = $_FILES['foto']['error'];
    $tmpName          = $_FILES['foto']['tmp_name'];

    // Check file yang diupload
    $extensifileValid = ['jpg', 'jpeg', 'png'];
    $extensifile      = explode('.', $namaFile);
    $extensifile      = strtolower(end($extensifile));

    // Check format/extensi file
    if (!in_array($extensifile, $extensifileValid)) {
        // Pesan gagal
        echo "<script> 
                    alert('Format File Tidak Valid');
                    document.location.href = 'tambah-mahasiswa.php';
                </script>";
        die();
    }

    // Check ukuran file 2 mb
    if ($ukuranFile > 2048000) {
        // Pesan gagal
        echo "<script> 
                    alert('Ukuran File Max 2 MB');
                    document.location.href = 'tambah-mahasiswa.php';
                </script>";
        die();
    }

    // Generate nama file baru (Ex: malware.exe -> 78as65d76as5)
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensifile;

    // Pindahkan ke folder local 
    move_uploaded_file($tmpName, 'assets/img/'. $namaFileBaru); // assets/img/jafeq789w70q.jpg
    return $namaFileBaru;
}

// Fungsi menghapus data mahasiswa
function delete_mahasiswa($id_mahasiswa)
{
    global $db;

    // ambil foto sesuai data yang dipilih
    $foto = select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0];
    unlink("assets/img/". $foto['foto']);

    //Query hapus data mahasiswa
    $query = "DELETE FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi tambah akun
function create_akun($post) 
{
    global $db;

    $nama       = strip_tags($post['nama']);
    $username   = strip_tags($post['username']); 
    $email      = strip_tags($post['email']);
    $password   = strip_tags($post['password']);
    $level      = strip_tags($post['level']);
    
    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Query menambahkan data
    $query = "INSERT INTO akun VALUES(null, '$nama', '$username', '$email', '$password', '$level')";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi ubah akun
function update_akun($post) 
{
    global $db;

    $id_akun    = strip_tags($post['id_akun']);
    $nama       = strip_tags($post['nama']);
    $username   = strip_tags($post['username']); 
    $email      = strip_tags($post['email']);
    $password   = strip_tags($post['password']);
    $level      = strip_tags($post['level']);
    
    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Query menambahkan data
    $query = "UPDATE akun SET nama = '$nama', username = '$username', email = '$email', password = '$password', level = '$level' WHERE id_akun = $id_akun";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi menghapus data akun
function delete_akun($id_akun)
{
    global $db;

    //Query hapus data akun
    $query = "DELETE FROM akun WHERE id_akun = $id_akun";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

?>