<?php
session_start();
require_once "db.php";
$pdo = new db();

// Ambil data dari database
$user_rows = $pdo -> showUser();
$cafe_rows = $pdo -> showCafe();

$book_rows = $pdo -> order_admin();

//Jika user belum login dan membuka ini, maka langsung diarahkan ke halaman login
if(isset($_SESSION['email']) == 0){
    exit("<h1>Access Denied</h1>");
}

//Akses selain e-mail admin akan ditolak
//Ubah e-mailnya jika ingin mengganti akun admin
if($_SESSION['email'] != 'admin@enongki.com'){
    exit("<h1>Access Denied</h1>");
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
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="" />
      <meta name="author" content=""/>
      <title>Admin - e-Nongki</title>
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
    </head>
    <body>
        
    <!-- Awal Navbar -->
    <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand" href="/"><img src="gambar/logo_hitam.png" width="150" height="60" class="d-inline-block align-top" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto my-2 my-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#cafe">Daftar Cafe</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#users">Daftar User</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#order">Daftar Order</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
            </ul>
        </div>
    </nav>
    </div>
    <!-- Akhir Navbar -->

    <!-- Awal selamat datang -->
    <section class="page-section bg-primary text-white text-center">
        <div class="container">
            <h1>Selamat datang!</h1><br>
            <h5>Terlogin sebagai : <?= $_SESSION['name'] ?></h5>
        </div>
    </section>
    <!-- Akhir selamat datang -->

    <!-- Awal tabel cafe-->
    <section class="page-section bg-light text-center text-black" id="cafe">
    <h4>Daftar Cafe</h4><br>
    <div class="container">
        <div class="col-md-4">
            <a href="addcafe.php" class="btn btn-dark" style="margin-right:20px;">Tambah Cafe</a>
            <a href="editcafe.php" class="btn btn-dark">Edit cafe</a>
        </div>
        <br><br>
        <table id="tabel" class="table" style="width:100%">
            <thead>
            <tr>
                <th>ID Cafe</th>
                <th>Nama Cafe</th>
                <th>Lokasi</th>
                <th>Link Google Maps</th>
                <th>No. Telepon</th>
                <th>Smoking room</th>
                <th>Jam Buka</th>
                <th>Jam Tutup</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach($cafe_rows as $row){
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><a href="info_cafe.php?id=<?= $row['id'] ?>" target="_blank"><?= $row['nama_cafe'] ?></a></td>
                <td><?= $row['lokasi_cafe'] ?></td>
                <td><a href="<?= $row['linkmaps'] ?>" target="_blank"><?= $row['linkmaps'] ?></td>
                <td><?= $row['notel_cafe'] ?></td>
                <td><?= $row['smoking_room'] ?></td>
                <td><?= $row['jam_buka'] ?></td>
                <td><?= $row['jam_tutup'] ?></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
    </div>
    </section>
    <!-- Akhir tabel cafe -->

    <!-- Awal tabel user -->
    <section class="page-section bg-primary text-center text-white" id="users">
    <h4>Daftar User</h4><br>
    <div class="container">
        <div class="col-md-4">
            <a href="adduser.php" class="btn btn-light" style="margin-right:20px;">Tambah User</a>
            <a href="edituser.php" class="btn btn-light">Edit User</a>
        </div>
        <br><br>
        <table id="tabel2" class="table table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>ID User</th>
                <th>Nama</th>
                <th>E-mail</th>
                <th>Nomor Telepon</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach($user_rows as $row){
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['nomor_telepon'] ?></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
    </div>
    </section>
    <!-- Akhir tabel user -->

    <!-- CHANGE THIS BACKGROUND COLOR -->
    <!-- Awal tabel order -->
    <section class="page-section bg-light text-center text-black" id="order">
    <h4>Daftar Order</h4><br>
    <div class="container">
        <table id="tabel3" class="table" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID Order</th>
                            <th>ID Cafe</th>
                            <th>Nama Cafe</th>
                            <th>Tanggal & Waktu</th>
                            <th>Nomor Meja</th>
                            <th>Ruangan</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($book_rows as $row){
                                $check_row = $pdo -> order_check($row['id_cafe']);
                                foreach($check_row as $check){
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['id_cafe'] ?></td>
                            <td><?= $check['nama_cafe'] ?></td>
                            <?php
                                }
                            ?>
                            <td><?= $row['tanggal_waktu'] ?></td>
                            <td><?= $row['nomor_meja'] ?></td>
                            <?php
                                if ($row['smokingroom'] == 'true'){
                                    echo "<td>Smoking room</td>";
                                }
                                else{
                                    echo "<td>Non-Smoking room</td>";
                                }
                            ?>
                            <?php
                                if ($row['confirm'] == 'true'){
                                    echo "<td class='font-italic'>Diterima</td>";
                                }
                                else{
                                    echo "<td class='font-italic'>Menunggu konfirmasi</td>";
                                }
                            ?>
                        </tr>
                        <?php
                            }
                        ?>
                        </tbody>
                    </table>
    </div>
    </section>
    <!-- Akhir tabel order -->

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

        $(document).ready(function () {
            $('#tabel2').DataTable({
                    rowReorder:{
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true
                });
        } );

        $(document).ready(function () {
            $('#tabel3').DataTable({
                    rowReorder:{
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true
                });
        } );
    </script>
    </body>
</html>