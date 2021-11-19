<?php
session_start();
require_once "db.php";
$pdo = new db();

// Untuk digunakan pada navbar login/logout
$signed = false;

$cookie_name = "search-box"; 

if(isset($_SESSION['email']) == 1){
    $signed = true;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content=""/>
        <title>Search Cafe</title>
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
         <link href="css/responsive.css" rel="stylesheet" />

         <!-- Optional JavaScript -->
         <!-- jQuery first, then Popper.js, then Bootstrap JS -->
         <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <style>
        .nav-item{
            padding:10px;
        }
        img-kiri{
            float: right;
            margin: 5px;
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

    <!-- Awal tampilan setiap cafe -->
   
    <section class="page-section bg-primary text-black" id="informasicafe">
    <?php
    echo "<center><h4><u> Ini hasil pencarian cafe: " . $_COOKIE[$cookie_name] . "</u></h4></center>";
    echo "<br><br>";
    ?>    
    <div class="container">
    <?php
                //Memasukkan cookie yang terdaftar ke query search
                if(!isset($_COOKIE[$cookie_name])){
                    echo "Error saat terjadi search";
                }
                else{ 
                    $search_row = $pdo -> search_cafe($_COOKIE[$cookie_name]);
                }

                foreach ($search_row as $row){
                ?>
            <div class="row">
                <!-- Awal menampilkan gambar cafe sekilas -->
                <div class="col-md-4 offset-1">
                        <img src="<?= $row['gambar_website'] ?>" width="350px" height="215px">
                    </div>
                    
                    <!-- Akhir tampilan gambar cafe sekilas -->
                <div class="col-md-4 offset-1">
                    <br>
                    <h4 class="text-white"><?= $row['nama_cafe'] ?></h4>
                    <p class="text-justify"><?= $row['lokasi_cafe'] ?></p>
                    <p class="letter">No Tel : <?= $row['notel_cafe'] ?></p>
                    <?php
                        // Timezone Singapore
                        // Membandingkan waktu buka dan tutup dengan waktu sekarang
                        date_default_timezone_set("Singapore");
                        if (date("H:i") < $row['jam_buka'] || date("H:i") > $row['jam_tutup']){
                            echo "<p class='letter font-weight-bold'>Tersedia : Tutup</p>";
                        }
                        else{
                            echo "<p class='letter font-weight-bold'>Tersedia : Buka</p>";
                        }
                    ?>
                    <br>
                    <!-- Awal menuju info_cafe.php -->
                        <input type="hidden" name="cafe" value="<?php echo $row["id"]; ?>"/>
                        <a href="info_cafe.php?id=<?php echo $row["id"]; ?>" class="btn btn-light">See about cafe</a>
                </div>
                    <!-- Akhir info_cafe.php -->
            </div>
            <br>
            <br>
            <?php
                    }
                ?>
        </div>
    </section>
    <!-- Akhir informasi cafe -->

    <!-- Awal Footer-->
    <footer class="bg-light py-5 text-center">
        <div class="container"><div class="small text-center text-muted">Copyright © 2020 - Team e-Nongki</div></div>
    </footer>
    <!-- Akhir Footer -->
    </body>
</html>