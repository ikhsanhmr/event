<?php include 'akses_user.php' ?>
<?php include '../inc/koneksi.php'; ?>
<?php include 'layouts/header.php' ?>
<?php include 'layouts/sidebar.php' ?>

<?php
$email = $_SESSION['user'];
$sql = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email' LIMIT 1");
$user = mysqli_fetch_assoc($sql);
$userId = $user['id'];
$userHasEvent = mysqli_query($koneksi, "SELECT *,events.id AS idEvent FROM user_event 
                                                        INNER JOIN users ON user_event.user_id = users.id
                                                        INNER JOIN events ON user_event.event_id = events.id
                                                        WHERE user_id='$userId' ORDER BY tanggal_mulai DESC");

?>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Event yang <b><?= $user['nama'] ?></b> ikuti</h3>
        </div>
        <div class="card-body">

            <form class="form-inline" method="get">
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Judul Event</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Link Zoom</th>
                            <th>Bukti Transfer</th>
                            <th>Vidio Zoom</th>
                            <th>Materi Slide</th>
                            <th>Sertifikat</th>
                            <th>Action</th>
                        </tr>

                        <?php if (mysqli_num_rows($userHasEvent) < 1) : ?>
                            <tr class="text-center text-secondary">
                                <td colspan="6">Belum mengikuti event. <a href="https://event.lokerprogrammer.com/user/event/">Daftar sekarang</a></td>
                            </tr>
                        <?php endif; ?>
                        <?php while ($row = mysqli_fetch_assoc($userHasEvent)) : ?>

                            <tr>
                                <td><?= $row['judul'] ?></td>
                                <td><?= date('d F Y', strtotime($row['tanggal_mulai'])) ?></td>
                                <td>
                                    <?php if ($row['link_zoom'] !== '') { ?>
                                        <a target="_blank" href="<?= $row['link_zoom'] ?>"><?= $row['link_zoom'] ?></a>
                                    <?php } else { ?>
                                        Belum tersedia
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 'proses') { ?>
                                        <span class="badge badge-warning">Proses</span>
                                    <?php } elseif ($row['status'] == 'acc') { ?>
                                        <span class="badge badge-success">Acc</span>
                                    <?php } elseif ($row['status'] == 'reject') { ?>
                                        <span class="badge badge-danger">Reject</span>
                                    <?php } else { ?>
                                        <span class="badge badge-secondary">Tidak ada</span>
                                    <?php } ?>
                                </td>
                                <?php if ($row['status'] == 'proses') { ?>
                                    <td colspan="3" class="text-center" style="background: rgb(224,224,224)">
                                        Tunggu admin acc bukti transfer
                                    </td>
                                <?php } elseif ($row['status'] == 'acc') { ?>
                                    <?php if (date('Y-m-d') > $row['tanggal_mulai']) { ?>
                                        <td>
                                            <a href="<?= $row['hasil_record'] ?>" target="_blank">
                                                Record Zoom
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?= $row['materi'] ?>" target="_blank">
                                                Materi Slide
                                            </a>
                                        </td>
                                        <td>
                                            <a href="https://event.lokerprogrammer.com/user/sertifikat/index.php?id=<?= $row['idEvent'] ?>" class="btn btn-dark btn-sm" download>
                                                Download
                                            </a>
                                        </td>
                                    <?php } else { ?>
                                        <td colspan="3" class="text-center" style="background: rgb(224,224,224)">
                                            Belum tersedia
                                        </td>
                                    <?php } ?>
                                <?php } elseif ($row['status'] == 'reject') { ?>
                                    <td colspan="3" class="text-center" style="background: rgb(224,224,224)">
                                        Tidak ada
                                    </td>
                                <?php } else { ?>
                                    <td colspan="3" class="text-center" style="background: rgb(224,224,224)">
                                        Tidak ada
                                    </td>
                                <?php } ?>
                                <td>
                                    <a href="#" title="Detail" class="btn btn-success btn-sm" data-toggle="modal" data-target="#deskripsi-<?= $row['id'] ?>"><span class="fas fa-eye" aria-hidden="true"></span></a>
                                    <div class="modal fade" id="deskripsi-<?= $row['id'] ?>" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Detail Event</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="font-size: 13px;">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <tr>
                                                                <th>Judul Event</th>
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
                                                                <th>Link Background Zoom</th>
                                                                <td>
                                                                    <?php if ($row['background_image'] == '') { ?>
                                                                        Belum tersedia
                                                                    <?php } else { ?>
                                                                        <a target="_blank" href="<?= $row['background_image'] ?>"><?= $row['background_image'] ?></a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Link Zoom</th>
                                                                <td>
                                                                    <?php if ($row['link_zoom'] == '') { ?>
                                                                        Belum tersedia
                                                                    <?php } else { ?>
                                                                        <a target="_blank" href="<?= $row['link_zoom'] ?>"><?= $row['link_zoom'] ?></a>
                                                                    <?php } ?>
                                                                </td>
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
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
        </div>
    </div>


</section>

<?php include 'layouts/footer.php' ?>