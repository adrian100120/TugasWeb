<?php
session_start();
require_once "db.php";
$pdo = new db();

//Jika user belum login dan membuka ini, maka langsung diarahkan ke halaman login
if(isset($_SESSION['email']) == 0){
    header('Location: login_cafe.php');
}

//Jika admin login, maka langsung diarahkan ke halaman dashboard admin
//Ubah e-mailnya jika ingin mengganti akun admin
if($_SESSION['email'] == 'admin@enongki.com'){
    header('Location: admin.php');
}

$book_rows = $pdo -> order_cafe($_SESSION['id']);

// Mencegah error karena header
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
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
        <title>e-Nongki</title>
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
    <body id="page-top">

    <!-- Awal Navbar -->
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
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
            </ul>
        </div>
    </nav>
    <!-- Akhir Navbar -->

    <!-- Awal selamat datang -->
    <section class="page-section bg-primary text-center text-white">
        <div class="container">
            <h1>Welcome!</h4><br>
            <h4 class="font-weight-bold"><?php echo $_SESSION['name'] ?></h4>
        </div>
    </section>
    <!-- Akhir selamat datang -->

    <!-- Awal tabel order -->
    <!-- Pada bagian ini adanya button (centang dan silang) centeng = menerima dan silang = menolak -->
    <section class="page-section bg-light text-center text-dark">
    <h4>Konfirmasi Order</h4><br>
    <div class="container">
        <div class="col-md-3">
        </div>
        <table id="tabel" class="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama User</th>
                <th>Tanggal & Waktu</th>
                <th>Nomor Meja</th>
                <th>Ruangan</th>
                <th>Terima</th>
                <th>Tolak</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach($book_rows as $row){
                    if ($row['confirm'] == 'true'){

                    }
                    else{

                    if (isset($_POST[$row['id']])){
    
                        $pdo -> confirm($row['id'], $_SESSION['id']);
                        header("Location: barista.php");
                    }
                    if (isset($_POST['tolak_'.$row['id']])){
                        $pdo -> deleteOrder($row['id'], $_SESSION['id']);
                        header("Location: barista.php");
                    }
            ?>
            <tr>
                <td><?= $row['nama_user'] ?></a></td>
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
                <form method="post">
                    <input type="hidden" value="<?= $row['id'] ?>">
                    <td><button name="<?= $row['id'] ?>" class="btn btn-dark">Terima</button></td>
                    <td><input type="submit" value="Tolak" name="tolak_<?= $row['id'] ?>" class="btn btn-dark"></td>
                </form>
            </tr>
            <?php
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
    </section>
    <!-- Akhir tabel order -->

    <!-- Awal histori pesanan -->
    <section class="page-section bg-light text-center text-dark">
    <h4>Histori Order</h4><br>
    <div class="container">
        <table id="tabel2" class="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama User</th>
                <th>Tanggal & Waktu</th>
                <th>Nomor Meja</th>
                <th>Ruangan</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach($book_rows as $row){
                    if ($row['confirm'] == 'true'){
            ?>
            <tr>
                <td><?= $row['nama_user'] ?></a></td>
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
            </tr>
            <?php
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
    </section>

    <!-- Akhir histori pesanan -->

    <!-- Awal Footer-->
    <footer class="bg-light py-5">
        <div class="container"><div class="small text-center text-muted">Copyright © 2020 - Team e-Nongki</div></div>
    </footer>
    <!-- Akhir Footer -->
        
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
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
    </script>
    </body>
</html>
<?php
ob_flush();
?>