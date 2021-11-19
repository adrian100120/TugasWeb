<?php
session_start();
require_once "db.php";
$pdo = new db();
$signed = false;

if(isset($_SESSION['email']) == 1){
    if ($pdo -> email_check_cafe($_SESSION['email'])){
        header("Location: barista.php");
    }
    else {
        $signed = true;
    }
}

//Jika user belum login dan membuka ini, maka langsung diarahkan ke halaman login
if(isset($_SESSION['email']) == 0){
    header('Location: login.php');
}

//Jika admin login, maka langsung diarahkan ke halaman dashboard admin
//Ubah e-mailnya jika ingin mengganti akun admin
if($_SESSION['email'] == 'admin@enongki.com'){
    header('Location: admin.php');
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

$book_rows = $pdo -> order_user($_SESSION['name']);
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
        .th{
            color:white;
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
        <link href="https://cdn.jsdelivr.net/gh/e-Nongki/sourcecss@update/styles.min.css" rel="stylesheet" type="text/css" />
        <link href="css/responsive.css" rel="stylesheet" />

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    </head>
    <body id="page-top">

        <!-- Awal Navbar -->
        <nav class="navbar navbar-expand-lg navbar fixed-top py-3" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="gambar/logo_hitam.png" width="150" height="60" class="d-inline-block align-top" alt="" loading="lazy">
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"><i class="fas fa-bars" style="color:#000; font-size:28px;"></i></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#mitra">Mitra</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#order">Order</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#contact">Contact</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="user_edit.php?id=<?= $_SESSION['id'] ?>">Edit Profile</a></li>
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
                        <input class="form-control my-0 py-1 lime-border" id="box" type="text" name="input_search" placeholder="Cari nama cafe" aria-label="Search" required>
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
                                <h4 class="link_cafe"><img src="<?= $row['gambar_website'] ?>" style="float:left; padding-right: 20px;" width="300px" height="215px"/><a href="info_cafe.php?id=<?= $row['id'] ?>" style="color:white"><?= $row['nama_cafe'] ?></a></h4>
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
                                <h4><img src="<?=$row['gambar_website']?>" style="float:left; padding-right: 20px;" width="300px" height="215px"/><a href="info_cafe.php?id=<?= $row['id'] ?>" style="color:white"><?= $row['nama_cafe'] ?></a></h4>
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
        
        <!-- Awal Order -->
        <section class="page-section bg-white text-center text-dark" id="order">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 mx-auto">
                      <h2 class="section-heading text-center">Order</h2>
                      <hr class="divider dark my-4" />
                      <table id="tabel" class="table" style="width:100%">
                        <thead>
                        <tr><br>
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
                </div>
            </div>
          </section>
        <!-- Akhir Order -->

        <!-- Awal Contact-->
        <section class="page-section bg-dark text-white" id="contact">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="mt-0">Contact</h2>
                        <hr class="divider my-4" />
                        <p class="mb-5" style="color:white;">Jika ada kendala pada website , silahkan mengirim feedback ke email dibawah ini atau menelpon pada nomor dibawah ini, kami akan berusaha membalasnya secepat mungkin</p>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
                        <i class="fas fa-phone fa-3x mb-3 text-muted"></i>
                        <div>+62 819 1737 8488</div>
                    </div>
                    <div class="col-lg-4 mr-auto text-center">
                        <i class="fas fa-envelope fa-3x mb-3 text-muted"></i>
                        <a class="d-block" href="mailto:admin@enongki.com" style="color:white;">admin@enongki.com</a>
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
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
