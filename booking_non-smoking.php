<?php
session_start();
require_once "db.php";
$pdo = new db();

if (isset($_GET['id'])){
    $info_cafe = $pdo -> get_cafe($_GET['id']);
    $id_cafe = $info_cafe['id'];
    $nonsmoking = $info_cafe['gambar_denah_non'];
}

date_default_timezone_set("Singapore");
$date = date("Y-m-d h:i:sa");

if (isset($_POST['update'])){
    $pdo -> hasil_booking($id_cafe, $_SESSION['name'], $date, $_POST['meja'], 'false', 'false');
    $pdo -> updateMejaCafe($id_cafe, $_POST['meja']);
    header("Location: users.php");
}

$table_rows = $pdo -> get_table_non_smoking($id_cafe);

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
      <title>Booking (Non-smoking) - e-Nongki</title>
      <!-- Panorama menggunakan Paver -->
      <link href="css/pano.css" rel="stylesheet" />
      <!-- Bootstrap core JS-->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
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
                    <a class="nav-link" href="signas.php">Logout</a>
                </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- Akhir Navbar -->

    <!-- Awal gambar table cafe -->
    <section class="page-section bg-dark text-center text-white">
    <h4>Meja yang tersedia</h4><br>
    <div class="container">
        <!-- Memasukkan gambar meja secara real-time  -->
        <img src="<?= $nonsmoking ?>" alt="" width="900rem;"><br><br><br>
        <h5>Pilih meja yang diinginkan :</h5><br>
        <!-- Awal checklist -->
        <form method="POST">
        <div class="row">
            <div class="col-md-1 offset-1">
            <?php
            foreach($table_rows as $row){
            ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input pilihanmeja" type="radio" required id="<?= $row['nomor_meja'] ?>" name="meja" value="<?= $row['nomor_meja'] ?>">
                    <label class="form-check-label" for="inlineCheckbox1"><?= $row['nomor_meja'] ?></label>
                </div>
                <script>
                    // $row['tersedia'] mengeluarkan true atau false
                    document.getElementById("<?= $row['nomor_meja'] ?>").disabled = <?= $row['tersedia'] ?>;
                </script>
            <?php
            }
            ?>
            </div>
        </div><br><br>
        <!-- Awal Tombol Next ( data hasil checklist akan tersubmit dan dibawa ke bagian checkout.php) -->
        <!-- Akhir tombol Next -->
    </div>
    <!-- Akhir checklist -->
    </section>

    <!-- Awal Checkout -->
    <section class="page-section bg-primary text-white text-center">
        <div class="container">
            <h3 class="tengah text-center">Checkout</h3><br>
            <p><b>Nama User :</b><br>  <?php echo $_SESSION['name']; ?></p>
            <p><b>Ruangan :</b><br> Ruang tanpa asap rokok (Non-Smoking room)</p>
            <p><b>Tanggal Pesan :</b><br> <span id="date"></p>
            <br>
            <p class="font-weight-bold">Meja nomor :<br> <input type="text" id="hasil" disabled></p><br>
            <button type="submit" name="update" class="btn btn-light">Submit</button>
                </form>
        </div>
    </section>
                   
    </body>
    <script>
        // Digunakan untuk memunculkan pilihan di checkout
        var radio = document.querySelectorAll(".pilihanmeja");
        var muncul = document.getElementById("hasil");
        
        function checks(e){
            muncul.value = e.target.value;
        }

        radio.forEach(check => {
            check.addEventListener("click", checks);
        });
    </script>
    <script src="js/booking.js"></script>
</html>