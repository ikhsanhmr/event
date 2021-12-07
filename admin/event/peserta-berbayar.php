<?php include '../akses_admin.php'; ?>
<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>
<?php include '../../inc/koneksi.php'; ?>

<?php
$userWithCertificate = mysqli_query($koneksi, "SELECT *,user_event.id AS UserEventId, users.nama AS nama_peserta FROM user_event 
                                                            INNER JOIN users ON user_event.user_id = users.id
                                                            INNER JOIN events ON user_event.event_id = events.id 
                                                            WHERE status != ''
                                                            ORDER BY user_event.id DESC");
?>

<?php
if (isset($_POST['acc']) || isset($_POST['reject'])) {
    $id = $_POST['UserEventId'];
    if (isset($_POST['reject'])) {
        $status = 'reject';
    } else {
        $status = 'acc';
    }

    $updateStatusCertificate = mysqli_query($koneksi, "UPDATE user_event SET status='$status'
                                                            WHERE id = $id AND status != ''");

    if ($updateStatusCertificate) {
        $url1 = $_SERVER['REQUEST_URI'];
        header("Refresh: 1.6; URL=$url1");
        echo '<div class="alert alert-success alert-dismissable m-2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Berhasil Acc bukti transfer.</div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissable m-2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Gagal Acc bukti transfer.</div>';
    }
}
?>



<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Peserta Event Berbayar</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Judul Event</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Nama Peserta</th>
                        <th>Status</th>
                        <th>Bukti Transfer</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($user = mysqli_fetch_assoc($userWithCertificate)) : ?>

                        <tr>
                            <td><?= $user['judul'] ?></td>
                            <td><?= date('d F Y', strtotime($user['tanggal_mulai'])) ?></td>
                            <td><?= $user['nama_peserta'] ?></td>
                            <td>
                                <?php if ($user['status'] == 'proses') { ?>
                                    <span class="badge badge-warning"><?= $user['status'] ?></span>
                                <?php } elseif ($user['status'] == 'acc') { ?>
                                    <span class="badge badge-success"><?= $user['status'] ?></span>
                                <?php } else { ?>
                                    <span class="badge badge-danger"><?= $user['status'] ?></span>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="../../user/event/<?= $user['bukti_transfer'] ?>" target="_blank">Lihat</a>
                            </td>
                            <td>
                                <?php if ($user['status'] == 'acc') { ?>
                                    <span class="badge badge-success">Pembayaran selesai</span>
                                <?php } else { ?>
                                    <div class="row">
                                        <div class="col-3-md">
                                            <form method="POST" class="float-left">
                                                <input type="hidden" name="UserEventId" value="<?= $user['UserEventId'] ?>">
                                                <button type="submit" name="acc" title="Acc" class="btn btn-primary btn-sm"><span class="fas fa-check" aria-hidden="true"></span></button>
                                            </form>
                                        </div>
                                        <div class="col-5">
                                            <form method="POST">
                                                <input type="hidden" name="UserEventId" value="<?= $user['UserEventId'] ?>">
                                                <button type="submit" name="reject" title="Reject" class="btn btn-danger btn-sm"><span class="fas fa-times" aria-hidden="true"></span></button>
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
<?php include '../layouts/footer.php'; ?>