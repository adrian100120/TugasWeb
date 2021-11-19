<?php
session_start();
require_once "db.php";
$pdo = new db();

if(isset($_SESSION['email'])){
    header("Location: index.php");
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
        padding-top: 75px;
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

    <title>e-Nongki</title>
  </head>
  <body>
    <div class="card text-center" style="max-width: 500px;">
        <div class="card-body">
            <div class="text-center">
            <?php
                if(isset($_POST['submit'])){
                    // Cek jika e-mail ditemukan
                    $data = $pdo -> email_check_cafe($_POST['email']);
                
                    // Jika e-mail ditemukan, maka dicocokkan apakah password benar atau salah
                    if (password_verify($_POST['password'], $data['password'])){
                        //Memasukkan data ke session
                        $id = $data['id'];
                        $_SESSION['id'] = $data['id'];
                        $_SESSION['name'] = $data['nama_cafe'];
                        $_SESSION['email'] = $data['email'];
                        header("Location: barista.php");
                    }
                    else{
                        // Jika e-mail dan password salah, maka akan muncul sebuah warning
                        echo("E-mail atau password anda yang diisi salah!<br><br>");
                    }
                }
            ?>
                <img src="gambar/logo_hitam.png" class="rounded" width="250rem"; alt="...">
            </div> <br><br>
        <form method="POST">
        <div class="form-group row">
                <label for="inputEmail3" class="col-sm-1 col-form-label"></label>
            <div class="col-sm-10">
                <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
            </div>
        </div>
        <div class="form-group row">
                <label for="inputPassword3" class="col-sm-1 col-form-label"></label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <button type="submit" name="submit" class="btn btn-primary">Sign in</button><br>
                <br>
                <p>Ingin mendaftar?</p><a href="/index.php#contact">Hubungi Kami</a>
            </div>
        </div>
        </form>
        </div>
    </div>
  </body>
</html>