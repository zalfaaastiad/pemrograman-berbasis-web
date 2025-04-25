<?php
$conn = mysqli_connect("localhost", "root", "" , "kuliah");

if (!$conn){
    die("koneksi gagal: " . mysqli_connect_error());
}
?>