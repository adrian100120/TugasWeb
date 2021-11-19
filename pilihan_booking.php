<?php
session_start();
require_once "db.php";
$pdo = new db();

if (isset($_GET['id'])){
  $info_cafe = $pdo -> get_cafe($_GET['id']);
  $id_cafe = $info_cafe['id'];
}
?>

<!doctype html>
<html lang="en">
    <style>
        body{
          background-image : url("gambar/latar_belakang_html.jpg");
          background-size : cover;
          background-position: center center;
          background-attachment: fixed;
          padding-top : 150px;
        }
        .card{
          margin: 0 auto;
          float: none; 
          margin-bottom: 10px;
        }
    </style>

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/responsive.css" />

    <title>e-Nongki</title>
  </head>
  <body>
    <!-- Awal Button-->
    <center>
    <div class="card text-center" style="max-width: 45%;">
        <div class="card-body">
        <div class="text-center">
                <img src="gambar/logo_hitam.png" class="rounded" width="250rem"; alt="...">
        </div><br><br>
        
        <a href="booking_smoking.php?id=<?= $id_cafe ?>"><button class="btn btn-primary" style="margin:10px;">Smoking Room</button>
        <a href="booking_non-smoking.php?id=<?= $id_cafe ?>"><button class="btn btn-primary" style="margin:10px;">Non-Smoking Room</button></a>
    </div>
    </center>
    <!-- Akhir Button -->

    </body>
</html>
