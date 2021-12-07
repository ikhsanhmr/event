<?php
session_start();

include 'inc/koneksi.php';

if (isset($_POST['masuk'])) {
   // $email = $_POST['email'];
	$email = mysqli_real_escape_string($koneksi, $_POST['email']);
	$password =mysqli_real_escape_string($koneksi, md5($_POST['password']));
    //$password = md5($_POST['password']);

    $login = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email' AND password='$password' ");
  //echo  $login; exit;
    if(mysqli_num_rows($login) == 0){
        echo "<script>
                alert('Login gagal, silahkan coba lagi');
                document.location='https://event.lokerprogrammer.com/index.php';
            </script>";
    }else{
        $row = mysqli_fetch_assoc($login);
        if($row['level'] == 'admin'){
            $_SESSION['admin'] = $email;
            $_SESSION['level'] = 'admin';
            echo '<script language="javascript">document.location="https://event.lokerprogrammer.com/admin/index.php";</script>';
        }
        elseif($row['level'] == 'user'){
            $_SESSION['user'] = $email;
            $_SESSION['level'] = 'user';
            echo '<script language="javascript">document.location="https://event.lokerprogrammer.com/user/index.php";</script>';
        }else{
            echo '<center><div class="alert alert-danger">Upss...!!! Login gagal.</div></center>';
        }
    }
}
