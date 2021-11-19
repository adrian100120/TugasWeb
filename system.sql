CREATE DATABASE enongki;
USE enongki;

CREATE TABLE `akun` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nomor_telepon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=UTF8;

CREATE TABLE `akun_cafe` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nama_cafe` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=UTF8;

CREATE TABLE `cafe` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `nama_cafe` varchar(50) DEFAULT NULL,
  `lokasi_cafe` varchar(255) DEFAULT NULL,
  `gambar_website` varchar(255) DEFAULT NULL,
  `gambar_website_dua` varchar(255) DEFAULT NULL,
  `gambar_website_tiga` varchar(255) DEFAULT NULL,
  `gambar_denah_smoking` varchar(255) DEFAULT NULL,
  `gambar_denah_non` varchar(255) DEFAULT NULL,
  `gambar360` varchar(255) DEFAULT NULL,
  `linkmaps` varchar(255) DEFAULT NULL,
  `notel_cafe` varchar(50) DEFAULT NULL,
  `smoking_room` varchar(20) DEFAULT NULL,
  `jam_buka` varchar(20) DEFAULT NULL,
  `jam_tutup` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=UTF8;

CREATE TABLE `booking`(
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `id_cafe` int(50) DEFAULT NULL,
  `nama_user` varchar(50) DEFAULT NULL,
  `tanggal_waktu` varchar(255) DEFAULT NULL,
  `nomor_meja` varchar(255) DEFAULT NULL,
  `smokingroom` varchar(255) DEFAULT NULL,
  `confirm` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=UTF8;