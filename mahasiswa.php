<?php

session_start();

// Membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
  echo "<script>
            alert('Login Dahulu');
            document.location.href = 'login.php';
        </script>";
  exit;
}

// Membatasi halaman sesuai user login
if ($_SESSION['level'] != 1 and $_SESSION['level'] != 3) {
  echo "<script>
            alert('Perhatian anda tidak punya hak akses');
            document.location.href = 'akun.php';
        </script>";
  exit;
}

$title = 'Daftar Mahasiswa';

include 'layout/header.php';

// Menampilkan data mahasiswa
$data_mahasiswa = select("SELECT * FROM mahasiswa ORDER BY id_mahasiswa DESC");

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="fas fa-users"></i> Data Mahasiswa</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="index.php">Data Mahasiswa</a></li> -->
            <li class="breadcrumb-item active">Data Mahasiswa</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Table Data Mahasiswa</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <a href="tambah-mahasiswa.php" class="btn btn-primary btn-sm mb-2"><i class="fas fa-plus"></i> Tambah</a>

              <a href="download-pdf-mahasiswa.php" class="btn btn-success btn-sm mb-1"><i class="fas fa-file-pdf"></i> PDF</a>

              <a href="download-excel-mahasiswa.php" class="btn btn-success btn-sm mb-1"><i class="fas fa-file-excel"></i> Download Excel</a>

              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Prodi</th>
                    <th>Jenis Kelamin</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                  </tr>
                </thead>

                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($data_mahasiswa as $mahasiswa) : ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $mahasiswa['nama']; ?></td>
                      <td><?= $mahasiswa['prodi']; ?></td>
                      <td><?= $mahasiswa['jk']; ?></td>
                      <td><?= $mahasiswa['telepon']; ?></td>
                      <td class="text-center" width="25%%">
                        <a href="detail-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i> Detail</a>
                        <a href="ubah-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Ubah</a>
                        <a href="hapus-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Data Mahasiswa Akan Dihapus');"><i class="fas fa-trash-alt"></i> Hapus</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>

<?php include 'layout/footer.php'; ?>