<?php include '../akses_user.php' ?>
<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>
<?php include '../../inc/koneksi.php'; ?>

<?php
$email = $_SESSION['user'];

$sql = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($sql);
$userId = $user['id'];

$sql = mysqli_query($koneksi, "SELECT * FROM events ORDER BY id DESC");

?>

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Event</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="event" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Judul Event</th>
                            <th>Nama Pembicara</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php while ($row = mysqli_fetch_assoc($sql)) : ?>
                        <tbody>
                            <tr>
                                <td><?= $row['judul'] ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= date('d F Y', strtotime($row['tanggal_mulai'])) ?></td>
                                <td>
                                    <a href="#" title="Detail" class="btn btn-success btn-sm" data-toggle="modal" data-target="#deskripsi-<?= $row['id'] ?>"><span class="fas fa-eye" aria-hidden="true"></span></a>
                                    <div class="modal fade" id="deskripsi-<?= $row['id'] ?>" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Event</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="font-size: 13px;">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <tr>
                                                                <th>Judul</th>
                                                                <td><?= $row['judul'] ?></td>
                                                            </tr>   
                                                            <tr>
                                                                <th>Nama</th>
                                                                <td><?= $row['nama'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tanggal Pelaksanaan</th>
                                                                <td><?= date('d F Y', strtotime($row['tanggal_mulai'])) ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Mulai - Selesai</th>
                                                                <td><?= substr($row['jam_mulai'], 0, 5) . ' - ' . substr($row['jam_selesai'], 0, 5) ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Deskripsi</th>
                                                                <td><?= $row['deskripsi'] ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <?php
                                                    $idEvent = $row['id'];
                                                    $userEvent = mysqli_query($koneksi, "SELECT * FROM user_event WHERE user_id='$userId' AND event_id='$idEvent' LIMIT 1");
                                                    $userRegistered = mysqli_fetch_assoc($userEvent);
                                                    ?>
                                                    <?php if ($userId == isset($userRegistered['user_id'])) { ?>
                                                        <span class="badge badge-primary m-2">Anda sudah mendaftar</span>
                                                    <?php } else { ?>
                                                        <a href="daftar.php?id=<?= $row['id'] ?>" type="button" class="btn btn-primary">Daftar</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>


</section>
<!-- /.content -->
<?php include '../layouts/footer.php'; ?>