<?php



$koneksi = mysqli_connect('localhost','root','','event');



if (!$koneksi){

    echo 'Failed to connected!';

}