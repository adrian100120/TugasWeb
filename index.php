<?php
session_start();
require_once "db.php";
$pdo = new db();
$signed = false;

if(isset($_SESSION['email']) == 1){
    $signed = true;
    header("Location: users.php");
}

// Memunculkan cafe-cafe random untuk tab mitra
$rows_left = $pdo -> random_cafe_left();
$rows_right = $pdo -> random_cafe_right();

// Cookie digunakan untuk mengirim input searchbox ke search.php
if (isset($_GET['search'])){
    $cookie_name = "search-box";
    // Ambil input dari search box kirim ke $cookie_value
    $cookie_value = htmlentities($_GET['input_search']);
    setcookie($cookie_name, $cookie_value, strtotime('+1 day'), '/');
    
    // Jika cookie sudah dikirim, maka akan langsung dibawa ke search.php
    header("Location: search.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <style>
        .vertical { 
            border-left: 4px solid white; 
            height: 500px; 
            position:absolute; 
            left: 50%; 
            margin: 5px;
        }
        .letter{
            line-height: 12px;
        }
    </style>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content=""/>
        <title>e-Nongki</title>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
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
    </head>
    <body id="page-top">

        <!-- Awal Navbar -->
        <nav class="navbar navbar-expand-lg navbar fixed-top py-3" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="gambar/logo_hitam.png" width="150" height="60" class="d-inline-block align-top" alt="" loading="lazy">
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon icon-bar"><i class="fas fa-bars" style="color:#000; font-size:28px;"></i></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#mitra">Mitra</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#download">Download</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#contact">Contact</a></li>
                        <?php
                        if ($signed == false){
                        ?>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="signas.php">Sign in</a></li>
                        <?php
                        }
                        else {
                        ?>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="logout.php">Sign out</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Akhir Navbar -->

        <!-- Awal Search-->
        <form method="get">
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center" style="padding-left: 15px">
                    <div class="input-group md-form form-sm form-2 pl-0 col-md-6">
                        <input class="form-control my-0 py-1 lime-border" type="text" name="input_search" placeholder="Cari nama cafe" aria-label="Search" required>
                        <div class="input-group-append">
                          <button class="input-group-text lime lighten-2" name="search" id="basic-text1"><i class="fas fa-search text-grey" name="search" aria-hidden="true"></i></button>
                        </div>
                      </div>
                </div>
            </div>
        </header>
        </form>
        <!-- Akhir Search -->

        <!-- Awal Mitra -->
        <section class="page-section bg-primary" id="mitra">
            <div class="container">
                <div class="row justify-content-center">
                    <center>
                        <div class="col-lg-15">
                        <h2 class="text-white mt-0">Mitra Cafe e-Nongki</h2>
                        <hr class="divider light my-4" />
                    </center>
                        <div class="container">
                            <div class="row">
                              <div class="col">
                                <?php
                                    foreach ($rows_left as $row){
                                ?>
                                <h4 class="text-white"><img src="<?= $row['gambar_website'] ?>" style="float:left; padding-right: 20px;" width="300px" height="215px"/><a href="info_cafe.php?id=<?= $row['id'] ?>" style="color:white"><?= $row['nama_cafe'] ?></a></h4>
                                <p class="text-justify"><?= $row['lokasi_cafe'] ?></p>
                                <p class="letter"><?= $row['notel_cafe'] ?></p>
                                <?php
                                    // Menggunakan timezone singapore karena jam server tidak sama dengan sekarang
                                    // Membandingkan waktu buka dan tutup dengan waktu sekarang
                                    date_default_timezone_set("Singapore");
                                    if (date("H:i") < $row['jam_buka'] || date("H:i") > $row['jam_tutup']){
                                        echo "<p class='letter font-weight-bold'>Tersedia : Tutup</p>";
                                    }
                                    else{
                                        echo "<p class='letter font-weight-bold'>Tersedia : Buka</p>";
                                    }
                                ?>

                                <br><br>
                                <?php
                                    }
                                ?>
                                </div>
                                <!-- <div class="vertical"></div> -->
                                <div class="col">
                                <?php
                                    foreach ($rows_right as $row){
                                ?>
                                <h4 class="text-white"><img src="<?= $row['gambar_website'] ?>" style="float:left; padding-right: 20px;" width="300px" height="215px"/><a href="info_cafe.php?id=<?= $row['id'] ?>" style="color:white"><?= $row['nama_cafe'] ?></a></h4>
                                <p class="text-justify"><?= $row['lokasi_cafe'] ?></p>
                                <p class="letter"><?= $row['notel_cafe'] ?></p>
                                <?php
                                    // Menggunakan timezone singapore karena jam server tidak sama dengan sekarang
                                    // Membandingkan waktu buka dan tutup dengan waktu sekarang
                                    date_default_timezone_set("Singapore");
                                    if (date("H:i") < $row['jam_buka'] || date("H:i") > $row['jam_tutup']){
                                        echo "<p class='letter font-weight-bold'>Tersedia : Tutup</p>";
                                    }
                                    else{
                                        echo "<p class='letter font-weight-bold'>Tersedia : Buka</p>";
                                    }
                                ?>
                                <br><br>
                                <?php
                                    }
                                ?>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Akhir Mitra -->
        
        <!-- Awal Download -->
        <section class="page-section bg-dark text-center text-white" id="download">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 mx-auto">
                      <h2 class="section-heading text-center">Coming Soon</h2>
                      <hr class="divider light my-4" />
                      <div class="badges">
                        <a class="badge-link" ><img src="gambar/playstore.png" alt="" width="300rem";></a>
                        <a class="badge-link" ><img src="gambar/apple.png" alt="" width="240rem";></a>
                      </div>
                    </div>
                  </div>
            </div>
          </section>
        <!-- Akhir Download -->

        <!-- Awal Contact-->
        <section class="page-section bg-light" id="contact">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="mt-0">Contact</h2>
                        <hr class="divider my-4" />
                        <p class="text-muted mb-5">Jika ada kendala pada website , silahkan mengirim feedback ke email dibawah ini atau menelpon pada nomor dibawah ini, kami akan berusaha membalasnya secepat mungkin</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
                        <i class="fas fa-phone fa-3x mb-3 text-muted"></i>
                        <div>+62 819 1737 8488</div>
                    </div>
                    <div class="col-lg-4 mr-auto text-center">
                        <i class="fas fa-envelope fa-3x mb-3 text-muted"></i>
                        <a class="d-block" href="mailto:admin@enongki.com">admin@enongki.com</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Akhir Contact -->

        <!-- Awal Footer-->
        <footer class="bg-light py-5">
            <div class="container"><div class="small text-center text-muted">Copyright © 2020 - Team e-Nongki</div></div>
        </footer>
        <!-- Akhir Footer -->

        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
