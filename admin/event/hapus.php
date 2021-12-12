<?php include '../../base_url.php'; ?>
<?php include '../akses_admin.php'; ?>
<?php include '../../inc/koneksi.php'; ?>


<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $cek = mysqli_query($koneksi, "SELECT * FROM events WHERE id='$id'");
    if (mysqli_num_rows($cek) == 0) {
        echo '
            <script>
                alert("Data tidak ditemukan.")
                document.location="https://event.lokerprogrammer.com/admin/index.php";
            </script>
            ';
    } else {
        $delete = mysqli_query($koneksi, "DELETE FROM events WHERE id='$id'");
        if ($delete) {
            echo '
                <script>
                    alert("Berhasil menghapus event.")
                    document.location="https://event.lokerprogrammer.com/admin/index.php";
                </script>
                ';
        } else {
            echo '
                <script>
                    alert("Gagal menghapus event.")
                    document.location="https://event.lokerprogrammer.com/admin/index.php";
                </script>
                ';
        }
    }
}
?>