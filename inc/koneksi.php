<?php
// $koneksi = mysqli_connect('localhost','root','','event');
$koneksi = mysqli_connect('localhost','root','','events');

if (!$koneksi){
    echo 'Failed to connected!';
}