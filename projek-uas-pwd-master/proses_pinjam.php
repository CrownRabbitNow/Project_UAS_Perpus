<?php
include('koneksi.php');

$id_pinjam = $_POST['id_pinjam'];
$tgl_pinjam = $_POST['tgl_pinjam'];
$tgl_kembali = date('mm/dd/yyyy');
$anggota = $_POST['anggota'];
$buku = $_POST['buku'];


$query = mysqli_query($koneksi, "insert into meminjam values ('$id_pinjam','$tgl_pinjam','$tgl_kembali','$anggota','$buku',1)");

header("location:pinjam_buku.php");
