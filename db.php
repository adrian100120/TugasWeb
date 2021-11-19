<?php

class db{
    public function __construct()
    {
        try{
            // Hostname, username, password dan db masih dalam bentuk local
            // Ubah ini, jika mau dicocokan sama database online.
            $hostname = 'localhost';
            $username = 'root';
            $password = '';
            $db = 'enongki';
            
            $this-> pdo = new PDO("mysql:host=$hostname;port=3306;dbname=$db",$username, $password);
            $this-> pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            echo $e ->getMessage();
        }
    }

    // Fungsi untuk menambah data ke tabel "akun"
    // Menambah ":" di dalam VALUES, untuk mencegah SQL Injection. Thank you for the video, Tom Scott!
    public function membuat_akun($name, $email, $password, $nomortel){
        $sql = "INSERT INTO akun (name, email, password, nomor_telepon) 
        VALUES (:name, :email, :password, :nomor_telepon)";
        $query = $this -> pdo -> prepare($sql);
        $query-> execute(array(
          ':name' => $name,
          ':email' => $email,
          // Menurut PHP Documentation yang terbaru, sistem password menggunakan algoritma Bcrypt
          ':password' => password_hash($password, PASSWORD_DEFAULT),
          ':nomor_telepon' => $nomortel));
        return $query;
    }

    public function membuat_akun_cafe($name, $email, $password){
        $sql = "INSERT INTO akun_cafe (nama_cafe, email, password) 
        VALUES (:name, :email, :password)";
        $query = $this -> pdo -> prepare($sql);
        $query-> execute(array(
          ':name' => $name,
          ':email' => $email,
          // Menurut PHP Documentation yang terbaru, sistem password menggunakan algoritma Bcrypt
          ':password' => password_hash($password, PASSWORD_DEFAULT)));
        return $query;
    }

    // Fungsi untuk mengecek login benar atau tidak
    public function email_check($email){
        $sql = "SELECT * FROM akun WHERE email = :email";
        $query = $this -> pdo -> prepare($sql);
        $query -> bindParam(':email', $email);
        $query -> execute();
        return $query -> fetch(PDO::FETCH_ASSOC);
    }

    public function email_check_cafe($email){
        $sql = "SELECT * FROM akun_cafe WHERE email = :email";
        $query = $this -> pdo -> prepare($sql);
        $query -> bindParam(':email', $email);
        $query -> execute();
        return $query -> fetch(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk menambah data ke tabel cafe
    public function membuat_cafe($nama_cafe, $lokasi_cafe, $gambar, $gambardua, $gambartiga, $denahsmoking, $denahnon, $gambarpano, $link_maps, $notel_cafe, $smoking_room, $jam_buka, $jam_tutup){
        $sql = "INSERT INTO cafe (nama_cafe, lokasi_cafe, gambar_website, gambar_website_dua, gambar_website_tiga, gambar_denah_smoking, gambar_denah_non, gambar360, linkmaps, notel_cafe, smoking_room, jam_buka, jam_tutup)
        VALUES (:nama_cafe, :lokasi_cafe, :gambar_website, :gambar_website_dua, :gambar_website_tiga, :denah_smoking, :denah_non, :gambar_pano, :linkmaps, :notel_cafe, :smoking_room, :jam_buka, :jam_tutup)";
        $query = $this -> pdo -> prepare($sql);
        $query -> execute(array(
            ':nama_cafe' => $nama_cafe,
            ':lokasi_cafe' => $lokasi_cafe,
            ':gambar_website' => $gambar,
            ':gambar_website_dua' => $gambardua,
            ':gambar_website_tiga' => $gambartiga,
            ':denah_smoking' => $denahsmoking,
            ':denah_non' => $denahnon,
            ':gambar_pano' => $gambarpano,
            ':linkmaps' => $link_maps,
            ':notel_cafe' => $notel_cafe,
            ':smoking_room' => $smoking_room,
            ':jam_buka' => $jam_buka,
            ':jam_tutup' => $jam_tutup));
        return $query;
    }

    //Fungsi mengambil data random untuk index
    public function random_cafe_left(){
        $sql = "SELECT * FROM cafe WHERE id <= 2 ORDER BY RAND() LIMIT 2";
        $query = $this -> pdo -> query($sql);
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }
    public function random_cafe_right(){
        $sql = "SELECT * FROM cafe WHERE id >= 3 ORDER BY RAND() LIMIT 2";
        $query = $this -> pdo -> query($sql);
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }

    //Fungsi untuk search.php
    public function search_cafe($search){
        $sql = "SELECT * FROM cafe WHERE nama_cafe LIKE :search";
        $query = $this -> pdo -> prepare($sql);
        $query -> execute(array(
            ':search' => '%'.$search.'%'));
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_cafe($cafe){
        $sql = "SELECT * FROM cafe WHERE id = :zip";
        $stmt = $this -> pdo ->prepare($sql);
        $stmt->execute(array(':zip' => $cafe));
        return $stmt -> fetch();
    }

    public function get_user($user){
        $sql = "SELECT * FROM akun WHERE id = :zip";
        $stmt = $this -> pdo ->prepare($sql);
        $stmt->execute(array(':zip' => $user));
        return $stmt -> fetch();
    }

    public function showUser(){
        $sql = "SELECT * FROM akun";
        $query = $this -> pdo -> query($sql);
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function showCafe(){
        $sql = "SELECT * FROM cafe";
        $query = $this -> pdo -> query($sql);
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCafeInfo($nama, $lokasi, $maps, $notel, $buka, $tutup, $smoking, $id){
        $sql = "UPDATE cafe SET nama_cafe=:nama_cafe, lokasi_cafe=:lokasi_cafe, linkmaps=:linkmaps, notel_cafe=:notel_cafe, smoking_room=:smoking_room, jam_buka=:jam_buka, jam_tutup=:jam_tutup WHERE id=:id";
        $stmt = $this -> pdo -> prepare($sql);
        $stmt->execute(array(
            ':nama_cafe' => $nama,
            ':lokasi_cafe' => $lokasi,
            ':linkmaps' => $maps,
            ':notel_cafe' => $notel,
            ':smoking_room' => $smoking,
            ':jam_buka' => $buka,
            ':jam_tutup' => $tutup,
            ':id' => $id));
        return $stmt;
    }

    public function updateUserInfo($nama, $email, $password, $notel, $id){
        $sql = "UPDATE akun SET name=:nama_user, email=:email, password=:password, nomor_telepon=:notel WHERE id=:id";
        $stmt = $this -> pdo -> prepare($sql);
        $stmt->execute(array(
            ':nama_user' => $nama,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':notel' => $notel,
            ':id' => $id));
        return $stmt;
    }

    public function updateCafePhoto($photo, $photodua, $phototiga, $id){
        $sql = "UPDATE cafe SET gambar_website=:gambar, gambar_website_dua=:gambarr, gambar_website_tiga=:gambarrr WHERE id=:id";
        $stmt = $this -> pdo -> prepare($sql);
        $stmt->execute(array(
            ':gambar' => $photo,
            ':gambarr' => $photodua,
            ':gambarrr' => $phototiga,
            ':id' => $id));
        return $stmt;
    }

    public function updateMejaCafe($meja, $id){
        $sql = "UPDATE `$meja` SET tersedia='true' WHERE nomor_meja=$id";
        $query = $this -> pdo -> query($sql);
        return $query;
    }

    public function updateMejaTersedia($meja, $id){
        $sql = "UPDATE `$meja` SET tersedia='false' WHERE nomor_meja=$id";
        $query = $this -> pdo -> query($sql);
        return $query;
    }

    public function deleteCafe($id){
        $sql = "DELETE FROM cafe WHERE id = :zip";
        $stmt = $this-> pdo ->prepare($sql);
        $stmt->execute(array(':zip' => $id));
        return $stmt;
    }

    public function deleteUser($id){
        $sql = "DELETE FROM akun WHERE id = :zip";
        $stmt = $this-> pdo ->prepare($sql);
        $stmt->execute(array(':zip' => $id));
        return $stmt;
    }

    public function booking_cafe($id){
        $sql = "SELECT * FROM `$id`";
        $query = $this -> pdo -> query($sql);
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function order_admin(){
        $sql = "SELECT * FROM booking";
        $query = $this -> pdo -> query($sql);
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function order_cafe($cafe){
        $sql = "SELECT * FROM booking WHERE id_cafe = :zip";
        $stmt = $this -> pdo ->prepare($sql);
        $stmt->execute(array(':zip' => $cafe));
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function order_user($cafe){
        $sql = "SELECT * FROM booking WHERE nama_user = :zip";
        $stmt = $this -> pdo ->prepare($sql);
        $stmt->execute(array(':zip' => $cafe));
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function order_check($cafe){
        $sql = "SELECT nama_cafe FROM cafe WHERE id = :zip";
        $stmt = $this -> pdo ->prepare($sql);
        $stmt->execute(array(':zip' => $cafe));
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function buat_cafe($cafe){
        $sql ="CREATE TABLE `$cafe` (
            `id` int(30) NOT NULL AUTO_INCREMENT,
            `room` varchar(50) DEFAULT NULL,
            `nomor_meja` varchar(255) DEFAULT NULL,
            `tersedia` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=UTF8";
        $query = $this -> pdo -> query($sql);
        return $query;
    }

    public function get_data_cafe($cafe){
        $sql = "SELECT * FROM akun_cafe WHERE nama_cafe = :zip";
        $stmt = $this -> pdo ->prepare($sql);
        $stmt->execute(array(':zip' => $cafe));
        return $stmt -> fetch();
    }

    public function get_table_non_smoking($table){
        $sql = "SELECT * FROM `$table` WHERE room = 'Non-smoking'";
        $query = $this -> pdo -> query($sql);
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_table_smoking($table){
        $sql = "SELECT * FROM `$table` WHERE room = 'Smoking'";
        $query = $this -> pdo -> query($sql);
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function hasil_booking($idcafe, $nama_user, $tanggal, $nomor_meja, $smoking, $confirm){
        $sql = "INSERT INTO booking (id_cafe, nama_user, tanggal_waktu, nomor_meja, smokingroom, confirm)
        VALUES (:id, :nama, :tanggal, :nomor, :smokingroom, :confirm)";
        $query = $this -> pdo -> prepare($sql);
        $query -> execute(array(
            ':id' => $idcafe,
            ':nama' => $nama_user,
            ':tanggal' => $tanggal,
            ':nomor' => $nomor_meja,
            ':smokingroom' => $smoking,
            ':confirm' => $confirm));
        return $query;
    }

    public function confirm($id, $idcafe){
        $sql = "UPDATE booking SET confirm='true' WHERE id=:zip AND id_cafe=:cafe";
        $stmt = $this -> pdo -> prepare($sql);
        $stmt->execute(array(
            ':zip' => $id,
            ':cafe' => $idcafe));
        return $stmt;
    }
    public function deleteOrder($id, $id_cafe){
        $sql = "DELETE FROM booking WHERE id = :zip AND id_cafe=:cafe";
        $stmt = $this-> pdo ->prepare($sql);
        $stmt->execute(array(
            ':zip' => $id,
            ':cafe' => $id_cafe
        ));
        return $stmt;
    }
}