<?php
session_start();
require_once "db.php";
$pdo = new db();

// if (isset($_SESSION['email'])) {
//     header("Location: index.php");
// }

//Input data
if (isset($_POST['submit'])) {
    $pdo->membuat_akun_cafe($_POST['name'], $_POST['email'], $_POST['password']);
    $info_cafe = $pdo -> get_data_cafe($_POST['name']);
    $id_cafe = $info_cafe['id'];
    $pdo->buat_cafe($id_cafe);
    header("Location: input_cafe.php");
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
        padding-top: 45px;
        padding-left: 25px;
        padding-right: 25px;
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/responsive.css" />

    <title>Add Cafe (Admin) - e-Nongki</title>
  </head>
  <body>
    <center>
    <div class="card text-center" style="max-width: 500px;">
        <div class="card-body">
            <div class="text-center">
                <img src="gambar/logo_hitam.png" class="rounded" width="250rem"; alt="...">
            </div> <br><br>
        <form method="POST">
        <p class="font-weight-bold">Tambah cafe</p>
        <br>
        <div class="form-group row">
                <label for="inputName3" class="col-sm-1 col-form-label"></label>
            <div class="col-sm-10">
                <input type="name" name="name" class="form-control" id="inputName3" placeholder="Nama Cafe">
            </div>
        </div>
        <div class="form-group row">
                <label for="inputEmail3" class="col-sm-1 col-form-label"></label>
            <div class="col-sm-10">
                <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
            </div>
        </div>
        <div class="form-group row">
                <label for="inputPassword3" class="col-sm-1 col-form-label"></label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" pattern=".{8,}" required title="Password kurang dari 8 karakter.">
            </div>
        </div>
        <br>
        <div class="form-group row">
            <div class="col-sm-12">
                <button name="submit" class="btn btn-primary">Tambah</button><br><br>
            </div>
        </div>
        </form>
        </div>
    </div>
</center>

  </body>
</html>