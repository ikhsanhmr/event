<?php include '../../base_url.php';?>
<?php include '../akses_admin.php'; ?>
<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>
<?php include '../../inc/koneksi.php'; ?>

<?php
    if(isset($_GET['paginate'])){
        $paginate = $_GET['paginate'];
        $page = 0;
        if(isset($_GET['page'])){
            $page = ($_GET['page']-1) * $paginate;
        }
        $userHasEvent = mysqli_query($koneksi, "SELECT *,users.nama AS nama_peserta FROM user_event 
                                                            INNER JOIN users ON user_event.user_id = users.id
                                                            INNER JOIN events ON user_event.event_id = events.id ORDER BY user_event.id DESC
                                                            LIMIT $page, $paginate");
    } else {
        $userHasEvent = mysqli_query($koneksi, "SELECT *,users.nama AS nama_peserta FROM user_event 
                                                            INNER JOIN users ON user_event.user_id = users.id
                                                            INNER JOIN events ON user_event.event_id = events.id ORDER BY user_event.id DESC");
    }

?>

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Peserta Event</h3>
        </div>
        <div class="card-body">
            <div class="select">
                <form action="" method="" class="d-flex align-items-center">
                    <span style="font-weight : 600;" >Show </span>
                    <select class="form-select" aria-label="Default select example" style="width: fit-content;" name="paginate">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span style="font-weight : 600" > entries</span>
                    <button type="submit" style="width: fit-content" class="badge bg-success">Paginate</button>
                </form>
            </div>
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