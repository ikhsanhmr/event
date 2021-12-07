<?php

$inc = mysqli_connect('localhost', 'u6533356', 'K@rtini23', 'u6533356_event');



if (!$inc) {

    echo 'Failed to connected!';

}



if (isset($_POST['daftar'])) {

    $nama = $_POST['nama'];

    $email = $_POST['email'];

    $password = md5($_POST['password']);



    if ($nama == '' || $email == '' || $password == '') {

        echo "<script>

                   alert('Gagal Daftar, Silahkan isi semua field');

                    document.location='https://event.lokerprogrammer.com/index.php';

                </script>

                ";

    } else {

        $insert = mysqli_query($inc, "INSERT INTO users(nama, email, password,level) VALUES('$nama','$email','$password','user')");



        if ($insert) {

            echo "<script>

                   alert('Berhasil Daftar');

                    document.location='https://event.lokerprogrammer.com/index.php';

                </script>

                ";

        } else {

            echo "<script>

                   alert('Gagal Daftar');

                    document.location='https://event.lokerprogrammer.com/index.php';

                </script>

                ";

        }

    }

}

