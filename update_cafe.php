<?php
session_start();
require_once "db.php";
$pdo = new db();

if (isset($_GET['id'])){
    $info_cafe = $pdo -> get_cafe($_GET['id']);
    $id_cafe = $info_cafe['id'];
    $smoking = $info_cafe['gambar_denah_smoking'];
    $non_smoking = $info_cafe['gambar_denah_non'];
    $nama = $info_cafe['nama_cafe'];
}
$table_rows = $pdo -> get_table_smoking($id_cafe);

if(isset($_POST['terisi'])){
    $pdo -> updateMejaCafe($id_cafe, $_POST['meja']);
    header("Refresh:0");
}

if(isset($_POST['tersedia'])){
    $pdo -> updateMejaTersedia($id_cafe, $_POST['meja_tersedia']);
    header("Refresh:0");
}
?>

<!DOCTYPE html>
<html>
<style>
    .table {
    width:100rem;
    }
    .nav-item{
        padding:10px;
    }
</style>
    <head>
      <title><?= $nama ?> - e-Nongki</title>
      <!-- Panorama menggunakan Paver -->
      <link href="css/pano.css" rel="stylesheet" />
      <!-- Bootstrap core JS-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
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
                  <a class="nav-link" href="logout.php">Logout</a>
              </li>
              </ul>
          </div>
      </nav>
    </div>
    <!-- Akhir Navbar -->

    <!-- Awal Gambar denah -->
    <section class="page-section bg-dark text-center text-white">
        <div class="container">
                <img src="<?= $smoking ?>" alt="Denah Smoking room" width="600rem;" align="center">
                <img src="<?= $smoking ?>" alt="Denah Non-Smoking room" width="600rem;" align="center">
                <br><br><br>
                <!-- Awal tersedia / tidak tersedia -->
                <div class="form-check">
                    <div class="table">
                    <table class="table table-bordered text-white">
                        <thead>
                            <tr>
                                <th>Ruangan</th>
                                <th>Tabel Tersedia</th>		
                            </tr>
                        </thead>
                        <form method="post">
                        <tbody>
                            <?php
                            foreach($table_rows as $table){
                                if ($table['tersedia'] == 'false'){
                            ?>
                            <tr>
                                <td><?= $table['room'] ?></td>
                                <td>
                                <input class="form-check-input" type="radio" id="<?= $table['nomor_meja'] ?>" name="meja" value="<?= $table['nomor_meja'] ?>">
                                <label class="form-check-label" for="exampleCheck1"><?= $table['nomor_meja'] ?></label>
                                </td>
                                </tr>
                            <?php
                                } 
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="container">
                            <button type="submit" name="terisi" class="btn btn-light">Terisi</button>
                    </div>
                        </form>
                    <br>
                    <br>
                    <div class="table">
                    <table class="table table-bordered text-white">
                        <thead>
                            <tr>
                                <th>Ruangan</th>
                                <th>Tabel Terisi</th>		
                            </tr>
                        </thead>
                        <form method="post">
                        <tbody>
                            <?php
                            foreach($table_rows as $table){
                                if ($table['tersedia'] == 'true'){
                            ?>
                            <tr>
                                <td><?= $table['room'] ?></td>
                                <td>
                                <input class="form-check-input" type="radio" id="<?= $table['nomor_meja'] ?>" name="meja_tersedia" value="<?= $table['nomor_meja'] ?>">
                                <label class="form-check-label" for="exampleCheck1"><?= $table['nomor_meja'] ?></label>
                                </td>
                                </tr>
                            <?php
                                } 
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <!-- Awal button  -->
            <div class="container">
                
                <button type="submit" name="tersedia" class="btn btn-light">Tersedia</button>
                </form>
            </div>
                        </form>
            <!-- Akhir button -->
        </div>
    </section>
    <!-- Akhir Gambar denah -->

    <!-- Awal Footer-->
    <footer class="bg-light py-5 text-center">
        <div class="container"><div class="small text-center text-muted">Copyright © 2020 - Team e-Nongki</div></div>
    </footer>
    <!-- Akhir Footer -->
    </body>
</html>