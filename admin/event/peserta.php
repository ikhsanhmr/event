<?php include '../akses_admin.php'; ?>
<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>
<?php include '../../inc/koneksi.php'; ?>

<?php

    $userHasEvent = mysqli_query($koneksi, "SELECT *,users.nama AS nama_peserta FROM user_event 
                                                            INNER JOIN users ON user_event.user_id = users.id
                                                            INNER JOIN events ON user_event.event_id = events.id ORDER BY user_event.id DESC");

?>

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Peserta Event</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Judul Event</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Nama Peserta</th>
                        <!-- <th>Action</th> -->
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($userHasEvent)) : ?>
                        <tr>
                            <td><?= $row['judul'] ?></td>
                            <td><?= date('d F Y', strtotime($row['tanggal_mulai'])) ?></td>
                            <td><?= $row['nama_peserta'] ?></td>
                            <!-- <td>
                                <a href="" title="Hapus" data-toggle="tooltip" class="btn btn-danger btn-sm"><span class="fas fa-trash" aria-hidden="true"></span></a>
                            </td> -->
                        </tr>
                    <?php endwhile; ?>


                </table>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
<?php include '../layouts/footer.php'; ?>