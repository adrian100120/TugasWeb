<?php
session_start();
require_once "db.php";
$pdo = new db();
$edit = false;
$edit_photo = false;

// Ambil data dari database
$user_rows = $pdo -> showUser();

// Saat tekan edit
if (isset($_GET['id'])){
    $edit = true;
    $info_user = $pdo -> get_user($_GET['id']);
    $id = $info_user['id'];
    $nama = $info_user['name'];
    $password = $info_user['password'];
    $email = $info_user['email'];
    $notel = $info_user['nomor_telepon'];
}

//Input data
if (isset($_POST['submit'])){
    $pdo -> updateUserInfo($_POST['nama_user'], $_POST['email'], $_POST['password'], $_POST['notel'], $id);
    header('Location: edituser.php');
}

  if(isset($_POST['delete'])){
      $pdo -> deleteUser($_POST['id']);
      header("Location: edituser.php#user");
  }
?>

<!DOCTYPE html>
<html>
<style>
    .nav-item{
        padding:10px;
    }
</style>
    <head>
      <title>Edit User - e-Nongki</title>
      <!-- jQuery and DataTables (Tabel) -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
      <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
      <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
      <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
      <!-- Bootstrap core JS-->
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
      <!-- Third party plugin JS-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
      <!-- Core theme JS-->
      <script src="js/scripts.js"></script>
      <!-- Favicon-->
      <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
      <!-- Font Awesome icons (free version)-->
      <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
      <!-- Google fonts-->
      <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
      <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
      <!-- Third party plugin CSS-->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
      <!-- Core theme CSS (includes Bootstrap)-->
      <link href="https://cdn.jsdelivr.net/gh/e-Nongki/sourcecss@update/styles.min.css" rel="stylesheet" />

      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
      <style>
        body {
          padding-top: 50px;
        }
        #loginForm {
          max-width: 500px;
          margin: 0 auto;
        }
        #loginForm .form-control {
          position: relative;
          text-align: center;
          border-radius: 0;
        }
      </style>
    </head>
    <body>
        
    <!-- Awal Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand offset-1" href="/"><img src="gambar/logo_hitam.png" width="150" height="60" class="d-inline-block align-top" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto my-2 my-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
            </ul>
        </div>
    </nav><br><br>
    <!-- Akhir Navbar -->

    <!-- Awal selamat datang -->
    <section class="page-section bg-primary text-white">
        <div class="container">
            <h1>Edit user</h1><br>
            <h5>Terlogin sebagai : <?= $_SESSION['name'] ?></h5>
        </div>
    </section>
    <!-- Akhir selamat datang -->

    <!-- Awal tabel cafe-->
    <section class="page-section bg-light text-center text-black" id="user">
    <h4>Daftar User</h4><br>
    <div class="container">
        <div class="col-md-4">
            <a href="admin.php" class="btn btn-dark ">Kembali</a>
        </div>
        <br><br>
        <table id="tabel" class="table" style="width:100%">
            <thead>
            <tr>
                <th>ID User</th>
                <th>Nama</th>
                <th>Edit Info</th>
                <th>Hapus</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach($user_rows as $row){
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><a href="edituser.php?id=<?= $row['id'] ?>#edit" class="btn btn-dark">Edit</td>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>" ?>
                <td><button name="delete" class="btn btn-danger">Hapus</button></td>
                </form>
            </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
    </div>
    </section>
    <!-- Akhir tabel cafe -->

    <?php
        if ($edit == false){

        }
        else{
    ?>
    <section class="page-section bg-light text-center text-black" id="edit">
    <h4>Edit User</h4><br>
    <div class="container">
    <form id="loginForm" method="POST">
          <div class="center-block">
          <!-- nama cafe -->
          <div class="form-group">
            <label>Nama User :</label>
            <input type="text" class="form-control" name="nama_user" value="<?= $nama ?>" placeholder="Nama" required>
          </div>
          <!-- lokasi cafe -->
          <div class="form-group">
            <label>E-mail :</label>
            <input type="text" class="form-control" name="email" value="<?= $email ?>" placeholder="E-mail" required>
          </div>
          <!-- link maps cafe -->
          <div class="form-group">
            <label>Password :</label>
            <input type="password" class="form-control" name="password" value="" placeholder="Password" required>
          </div>
          <!-- No. telepon Cafe -->
          <div class="form-group">
            <label>No. Telepon :</label>
            <input type="text" class="form-control" name="notel" value="<?= $notel ?>" placeholder="No. Telepon" required>
          </div>
          </div><br>
          <!-- button "update" -->
          <div class="form-group">
            <button class="btn btn-primary" name="submit" style="margin:25px;">Update</button>
            </form>
            <a href="edituser.php" class="btn btn-primary" style="margin:25px;">Cancel</a>
          </div>
        </div>
    </div>
    </section>
    <?php
        }
    ?>
    <!-- Awal Footer-->
    <footer class="bg-light py-5 text-center">
        <div class="container"><div class="small text-center text-muted">Copyright © 2020 - Team e-Nongki</div></div>
    </footer>
    <!-- Akhir Footer -->
    <!-- DataTables -->
    <script>
        $(document).ready(function () {
            $('#tabel').DataTable({
                    rowReorder:{
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true
                });
        } );
    </script>
    </body>
</html>