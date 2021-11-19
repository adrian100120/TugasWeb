<?php
session_start();
require_once "db.php";
$pdo = new db();

if(isset($_POST['submit'])){ 
  /* Gambar Pertama */
  $upload = 1; 
  // Target gambar disimpan
  $target = "gambar/" . time() . '_' . uniqid() . '.' . basename($_FILES["image_upload"]["name"]);
  $targetdua = "gambar/" . time() . '_' . uniqid() . '.' . basename($_FILES["image_upload_dua"]["name"]);
  $targettiga = "gambar/" . time() . '_' . uniqid() . '.' . basename($_FILES["image_upload_tiga"]["name"]);
  $targetpano = "gambar/" . time() . '_' . uniqid() . '.' . basename($_FILES["image_pano"]["name"]);
  $targetdenah = "gambar/" . time() . '_denah_' . uniqid() . '.' . basename($_FILES["image_denah"]["name"]);
  $targetdenahnon = "gambar/" . time() . '_denah_' . uniqid() . '.' . basename($_FILES["image_denah_non"]["name"]);
  // Mengambil informasi extension
  $image_type = strtolower(pathinfo($target,PATHINFO_EXTENSION));
  $image_type_dua = strtolower(pathinfo($targetdua,PATHINFO_EXTENSION));
  $image_type_tiga = strtolower(pathinfo($targettiga,PATHINFO_EXTENSION));
  $image_type_pano = strtolower(pathinfo($targetpano,PATHINFO_EXTENSION));
  $image_type_denah = strtolower(pathinfo($targetdenah,PATHINFO_EXTENSION));
  $image_type_denah_non = strtolower(pathinfo($targetdenahnon,PATHINFO_EXTENSION));

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
  else if($image_type_pano != "jpg" && $image_type_pano != "png" && $image_type_pano != "jpeg") {
    echo "Format gambar yang diperbolehkan adalah JPG, PNG dan JPEG!";
    $upload = 0;
  }
  else if($image_type_denah != "jpg" && $image_type_denah != "png" && $image_type_denah != "jpeg") {
    echo "Format gambar yang diperbolehkan adalah JPG, PNG dan JPEG!";
    $upload = 0;
  }
  else if($image_type_denah_non != "jpg" && $image_type_denah_non != "png" && $image_type_denah_non != "jpeg") {
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
          if (move_uploaded_file($_FILES["image_pano"]["tmp_name"], $targetpano)) {
            if (move_uploaded_file($_FILES["image_denah"]["tmp_name"], $targetdenah)) {
              if (move_uploaded_file($_FILES["image_denah_non"]["tmp_name"], $targetdenahnon)) {
                $pdo -> membuat_cafe($_POST['nama_cafe'], $_POST['lokasi'], $target, $targetdua, $targettiga, $targetdenah, $targetdenahnon, $targetpano, $_POST['link_maps'], $_POST['notel'], $_POST['smoking'], $_POST['waktu_buka'], $_POST['waktu_tutup']);
                header("Location: admin.php");
              }
            }
          }
        }
      }
      
      // Masukkan gambar ke dalam database dan redirect kembali ke admin
    } 
    else {
      echo "Terjadi kesalahan dalam mengupload gambar";
    }
  } 
}
?>

<!DOCTYPE HTML>
<html>
<style>
  body{
        background-image : url("gambar/latar_input_cafe.jpg");
        background-size : cover;
        padding:100px;
      }
</style>
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>Input Cafe</title>
    </head>
    <body>
        <center>
        <div class="card text-center" style="width: 35rem;">
        <div class="card-body">
        <div class="text-center">
                <img src="gambar/logo_hitam.png" class="rounded" width="250rem"; alt="...">
        </div><br><br>

        <form method="POST" enctype="multipart/form-data">
          <div class="form-row">
          <!-- nama cafe -->
          <div class="form-group col-md-8 offset-2">
            <label>Nama Cafe :</label>
            <input type="text" class="form-control" name="nama_cafe" placeholder="Nama Cafe" required>
          </div>
          <!-- lokasi cafe -->
          <div class="form-group col-md-8 offset-2">
            <label>Lokasi Cafe :</label>
            <input type="text" class="form-control" name="lokasi" placeholder="Lokasi Cafe" required>
          </div>
          <!-- link maps cafe -->
          <div class="form-group col-md-8 offset-2">
            <label>Link Maps Cafe :</label>
            <input type="text" class="form-control" name="link_maps" placeholder="Link Maps Cafe" required>
          </div>
          <!-- No. telepon Cafe -->
          <div class="form-group col-md-8 offset-2">
            <label>No. Telepon Cafe :</label>
            <input type="text" class="form-control" name="notel" placeholder="No. Telepon Cafe" required>
          </div>
          <!-- Jam buka -->
          <div class="form-group col-md-8 offset-2">
            <label>Jam buka :</label>
            <input type="time" class="form-control" name="waktu_buka" required>
          </div>
          <!-- Jam tutup -->
          <div class="form-group col-md-8 offset-2">
            <label>Jam tutup :</label>
            <input type="time" class="form-control" name="waktu_tutup" required>
          </div>
          <!-- Ketersediaan smoking room -->
          <div class="form-group col-md-8 offset-2">
            <label>Tersedia smoking room :</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="smoking" id="ya" value="Ya" required>
              <label class="form-check-label" for="ya">
                Ya
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="smoking" id="tidak" value="Tidak" required>
              <label class="form-check-label" for="tidak">
                Tidak
              </label>
            </div>
          </div><br>
          <!-- upload photo cafe -->
          <div class="form-group col-md-8 offset-2">
            <label>Upload photo</label>
            <input type="file" class="form-control" name="image_upload" id="image_upload" required>
            <input type="file" class="form-control" name="image_upload_dua" id="image_upload_dua" required>
            <input type="file" class="form-control" name="image_upload_tiga" id="image_upload_tiga" required>
            <br>
            <label>Upload panorama</label>
            <input type="file" class="form-control" name="image_pano" id="image_upload_empat" required>
            <br>
            <label>Upload Denah Cafe (Smoking/Non-smoking room)</label>
            <input type="file" class="form-control" name="image_denah" id="image_upload_enam" required>
            <input type="file" class="form-control" name="image_denah_non" id="image_upload_lima" required>
            </div>
          <!-- button "buat" -->
          <div class="form-group col-md-8 offset-2">
            <button class="btn btn-primary" name="submit" style="margin:25px;">Buat</button>
          </div>
          </form>
        </div>
    </center>
    </body>
</html>