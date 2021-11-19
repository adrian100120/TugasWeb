<?php
session_start();
require_once "db.php";
$pdo = new db();

// if (isset($_SESSION['email'])) {
//     header("Location: index.php");
// }

//Input data
if (isset($_POST['submit'])) {
    header('Location: success.php');
    $pdo->membuat_akun($_POST['name'], $_POST['email'], $_POST['password'], $_POST['notel']);
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

    <title>Add User (Admin) - e-Nongki</title>
  </head>
  <body>
    <center>
    <div class="card text-center" style="max-width: 500px;">
        <div class="card-body">
            <div class="text-center">
                <img src="gambar/logo_hitam.png" class="rounded" width="250rem"; alt="...">
            </div> <br><br>
        <form method="POST">
        <p>Tambah user</p>
        <div class="form-group row">
                <label for="inputName3" class="col-sm-1 col-form-label"></label>
            <div class="col-sm-10">
                <input type="name" name="name" class="form-control" id="inputName3" placeholder="Name">
            </div>
        </div>
        <div class="form-group row">
                <label for="inputEmail3" class="col-sm-1 col-form-label"></label>
            <div class="col-sm-10">
                <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
            </div>
        </div>
        <div class="form-group row">
                <label for="inputNomor_Telepon3" class="col-sm-1 col-form-label"></label>
            <div class="col-sm-10">
                <input type="nomor_telepon" name="notel" class="form-control" id="inputNomor_Telepon3" placeholder="No. Telepon" pattern=".{10,14}" required>
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