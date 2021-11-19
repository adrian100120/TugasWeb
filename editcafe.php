<?php
session_start();
require_once "db.php";
$pdo = new db();
$edit = false;
$edit_photo = false;

// Ambil data dari database
$cafe_rows = $pdo -> showCafe();

// Saat tekan edit
if (isset($_GET['id'])){
    $edit = true;
    $info_cafe = $pdo -> get_cafe($_GET['id']);
    $id = $info_cafe['id'];
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

if (isset($_GET['photo'])){
    $edit_photo = true;
    $info_cafe = $pdo -> get_cafe($_GET['photo']);
    $id = $info_cafe['id'];
}

//Input data
if (isset($_POST['submit'])){
    $pdo -> updateCafeInfo($_POST['nama_cafe'], $_POST['lokasi'], $_POST['link_maps'], $_POST['notel'], $_POST['waktu_buka'], $_POST['waktu_tutup'], $_POST['smoking'], $id);
    header('Location: editcafe.php');
}

if(isset($_POST['submit_photo'])){ 
    $upload = 1; 
    // Target gambar disimpan
    $target = "photo-cafe/" . basename($_FILES["image_upload"]["name"]);
    $targetdua = "photo-cafe/" . basename($_FILES["image_upload_dua"]["name"]);
    $targettiga = "photo-cafe/" . basename($_FILES["image_upload_tiga"]["name"]);
    // Mengambil informasi extension
    $image_type = strtolower(pathinfo($target,PATHINFO_EXTENSION));
    $image_type_dua = strtolower(pathinfo($targetdua,PATHINFO_EXTENSION));
    $image_type_tiga = strtolower(pathinfo($targettiga,PATHINFO_EXTENSION));
  
    // Mengecek gambar apakah sesuai aturan
    if($image_type != "jpg" && $image_type != "png" && $image_type != "jpeg") {
      echo "Format gambar yang diperbolehkan adalah JPG, PNG dan JPEG!";
      $upload = 0;
    }
    else if($image_type_dua != "jpg" && $image_type_dua != "png" && $image_type_dua != "jpeg") {
      echo "Format gambar yang diperbolehkan adalah JPG, PNG dan JPEG!";
      $upload = 0;
    }
    else if($image_type_tiga != "jpg" && $image_type_tiga != "png" && $image_type_tiga != "jpeg") {
      echo "Format gambar yang diperbolehkan adalah JPG, PNG dan JPEG!";
      $upload = 0;
    }
    
  
    // Jika ada kesalahan
    if ($upload == 0) {
      echo "<p>Gambar tidak terupload!</p>";
    } 
    // Upload jika tidak ada kesalahan lagi
    else{
      if (move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target)) {
        if (move_uploaded_file($_FILES["image_upload_dua"]["tmp_name"], $targetdua)) {
          if (move_uploaded_file($_FILES["image_upload_tiga"]["tmp_name"], $targettiga)) {
            $pdo -> updateCafePhoto($_FILES["image_upload"]["name"], $_FILES["image_upload_dua"]["name"], $_FILES["image_upload_tiga"]["name"], $id);
            header("Location: editcafe.php");
          }
        }
  
        // Masukkan gambar ke dalam database dan redirect kembali ke admin
      } 
      else {
        echo "Terjadi kesalahan dalam mengupload gambar";
      }
    } 
  }

  if(isset($_POST['delete'])){
      $pdo -> deleteCafe($_POST['id']);
      header("Location: editcafe.php#cafe");
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
      <title>Edit Cafe - e-Nongki</title>
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
    <section class="page-section bg-primary text-white text-center">
        <div class="container">
            <h1>Edit cafe</h1><br>
            <h5>Terlogin sebagai : <?= $_SESSION['name'] ?></h5>
        </div>
    </section>
    <!-- Akhir selamat datang -->

    <!-- Awal tabel cafe-->
    <section class="page-section bg-light text-center text-black" id="cafe">
    <h4>Daftar Cafe</h4><br>
    <div class="container">
        <div class="col-md-4">
            <a href="admin.php" class="btn btn-dark ">Kembali</a>
        </div>
        <br><br>
        <table id="tabel" class="table" style="width:100%">
            <thead>
            <tr>
                <th>ID Cafe</th>
                <th>Nama Cafe</th>
                <th>Edit Info</th>
                <th>Edit Foto</th>
                <th>Hapus</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach($cafe_rows as $row){
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><a href="info_cafe.php?id=<?= $row['id'] ?>" target="_blank"><?= $row['nama_cafe'] ?></a></td>
                <td><a href="editcafe.php?id=<?= $row['id'] ?>#edit" class="btn btn-dark">Edit</td>
                <td><a href="editcafe.php?photo=<?= $row['id'] ?>#photo" class="btn btn-dark">Edit</td>
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
    <h4>Edit Cafe</h4><br>
    <div class="container">
    <form id="loginForm" method="POST">
          <div class="center-block">
          <!-- nama cafe -->
          <div class="form-group">
            <label>Nama Cafe :</label>
            <input type="text" class="form-control" name="nama_cafe" value="<?= $nama ?>" placeholder="Nama Cafe" required>
            <br>
          </div>
          <!-- lokasi cafe -->
          <div class="form-group">
            <label>Lokasi Cafe :</label>
            <input type="text" class="form-control" name="lokasi" value="<?= $lokasi ?>" placeholder="Lokasi Cafe" required>
            <br>
          </div>
          <!-- link maps cafe -->
          <div class="form-group">
            <label>Link Maps Cafe :</label>
            <input type="text" class="form-control" name="link_maps" value="<?= $maps ?>" placeholder="Link Maps Cafe" required>
            <br>
          </div>
          <!-- No. telepon Cafe -->
          <div class="form-group">
            <label>No. Telepon Cafe :</label>
            <input type="text" class="form-control" name="notel" value="<?= $notel ?>" placeholder="No. Telepon Cafe" required>
            <br>
          </div>
          <!-- Jam buka -->
          <div class="form-group">
            <label>Jam buka :</label>
            <input type="time" class="form-control" name="waktu_buka" value="<?= $jam_buka ?>" required>
            <br>
          </div>
          <!-- Jam tutup -->
          <div class="form-group">
            <label>Jam tutup :</label>
            <input type="time" class="form-control" name="waktu_tutup" value="<?= $jam_tutup ?>" required>
            <br>
          </div>
          <!-- Ketersediaan smoking room -->
          <div class="form-group">
            <label>Tersedia smoking room :</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="smoking" id="ya" value="Ya" <?php if($smokingroom == 'Ya') echo 'checked' ?> required>
              <label class="form-check-label" for="ya">
                Ya
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="smoking" id="tidak" value="Tidak" <?php if($smokingroom == 'Tidak') echo 'checked' ?> required>
              <label class="form-check-label" for="tidak">
                Tidak
              </label>
            </div>
          </div>
          <!-- button "update" -->
          <div class="form-group">
            <button class="btn btn-primary" name="submit" style="margin:25px;">Update</button>
            <a href="editcafe.php" class="btn btn-primary" style="margin:25px;">Cancel</a>
          </div>
          </form>
        </div>
    </div>
    </section>
    <?php
        }
    ?>
<?php
    if ($edit_photo == false){

    }
    else{
?>
<section class="page-section bg-light text-center text-black" id="photo">
    <h4>Edit photo</h4><br>
    <div class="container">
        <form id="loginForm" method="POST" enctype="multipart/form-data">
        <div class="form-group center-block">
            <label>Upload photo</label>
            <input type="file" class="form-control" name="image_upload" id="image_upload" required>
            <input type="file" class="form-control" name="image_upload_dua" id="image_upload_dua" required>
            <input type="file" class="form-control" name="image_upload_tiga" id="image_upload_tiga" required>
            <p class="text-secondary">Foto harus 1280x720 dengan ukuran kecil</p>
            <p class="text-secondary">3 foto yang diupload harus berisi : Luar cafe, Dalam cafe dan Kasir cafe.</p>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" name="submit_photo" style="margin:25px;">Update</button>
            <a href="editcafe.php" class="btn btn-primary" style="margin:25px;">Cancel</a>
        </div>
        </form>
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