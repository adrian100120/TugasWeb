<?php
session_start();
require_once "db.php";
$pdo = new db();

// Untuk digunakan pada navbar login/logout
$signed = false;
if(isset($_SESSION['email']) == 1){
  $signed = true;
}

// Jika tidak melakukan tidak ada session cafe tidak ada, maka dipindahkan ke index.php
function error_php(){
  header("Location: index.php");
}
set_error_handler('error_php');

// Mengambil data cafe sesuai ID
if (isset($_GET['id'])){
  $info_cafe = $pdo -> get_cafe($_GET['id']);
  $id_cafe = $info_cafe['id'];
  $nama = $info_cafe['nama_cafe'];
  $lokasi = $info_cafe['lokasi_cafe'];
  $gambar = $info_cafe['gambar_website'];
  $gambardua = $info_cafe['gambar_website_dua'];
  $gambartiga = $info_cafe['gambar_website_tiga'];
  $pano = $info_cafe['gambar360'];
  $maps = $info_cafe['linkmaps'];
  $notel = $info_cafe['notel_cafe'];
  $smokingroom = $info_cafe['smoking_room'];
  $jam_buka = $info_cafe['jam_buka'];
  $jam_tutup = $info_cafe['jam_tutup'];
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
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
      <style>
      img {
        max-width: 100%;
        height: auto;
      }
      </style>
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
              <?php
                    if ($signed == false){
                        ?>
                        <a class="nav-link" href="/signas.php">Login</a>
                        <?php
                    }
                    else {
                        ?>
                        <a class="nav-link" href="/logout.php">Logout</a>
                        <?php
                    }
                    ?>
              </li>
              </ul>
          </div>
      </nav>
    </div>
    <!-- Akhir Navbar -->

    <!-- Awal Gambar cafe -->
    <section class="page-section bg-dark text-center text-white">
    <div id="carousel-example-captions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-captions" data-slide-to="0" class=""></li>
          <li data-target="#carousel-example-captions" data-slide-to="1" class=""></li>
          <li data-target="#carousel-example-captions" data-slide-to="2" class="active"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <div class="carousel-item active">
            <center><img class="img-fluid" src="<?= $gambar ?>" width="800rem"; alt="Gambar luar"></center>
          </div>
          <div class="carousel-item">
            <center><img class="img-fluid" src="<?= $gambardua ?>" width="800rem"; alt="Gambar dalam"></center>
          </div>
          <div class="carousel-item">
            <center><img class="img-fluid" src="<?= $gambartiga ?>" width="800rem"; alt="Gambar lain"></center>
          </div>
        </div>
        <br>
        <a class="carousel-control-prev" href="#carousel-example-captions" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-example-captions" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </section>
    <!-- Akhir Gambar cafe -->

    <!-- Awal Informasi cafe -->
    <section class="page-section bg-primary text-black" id="informasicafe">
        <div class="col-md-4 offset-1">
            <h4 class="text-white"><?= $nama ?></h4>
            <p class="text-justify"><?= $lokasi ?></p>
            <p class="letter">No. Telepon : <?= $notel ?></p>
            <p class="letter">Smoking room : <?= $smokingroom ?></p>
            <p class="letter">Jam Cafe : <?= $jam_buka ?> - <?= $jam_tutup ?></p>
            <?php
              // Menggunakan timezone singapore karena jam server tidak sama dengan sekarang
              // Membandingkan waktu buka dan tutup dengan waktu sekarang
              date_default_timezone_set("Singapore");
              if (date("H:i") < $jam_buka || date("H:i") > $jam_tutup){
                echo "<p class='letter font-weight-bold'>Tersedia : Tutup</p>";
              }
              else{
                echo "<p class='letter font-weight-bold'>Tersedia : Buka</p>";
              }
            ?>
            <br>
            <a href="pilihan_booking.php?id=<?= $id_cafe ?>" class="btn btn-light">Booking</a>
            <br><br>
    </section>
    <!-- Akhir informasi cafe -->

    <!-- Panorama -->
    <div class="panorama">
        <img src="<?php echo $pano ?>" alt="Panorama"/>
    </div>

    <!-- Awal Footer-->
    <footer class="bg-light py-5 text-center">
        <div class="container"><div class="small text-center text-muted">Copyright © 2020 - Team e-Nongki</div></div>
    </footer>
    <!-- Akhir Footer -->
    </body>
</html>