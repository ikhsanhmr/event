<?php include 'akses_admin.php'; ?>

<?php include 'layouts/header.php'; ?>

<?php include 'layouts/sidebar.php'; ?>

<?php include '../inc/koneksi.php'; ?>

<?php

error_reporting(0);

$tgl_mulai = mysqli_query($koneksi, "SELECT DISTINCT tanggal_mulai FROM events ORDER BY tanggal_mulai DESC");



if (isset($_GET['filter'])) {

    $ev = $_GET['filter'];

    $fil = mysqli_query($koneksi, "SELECT * FROM events WHERE tanggal_mulai='$ev' ORDER BY id DESC");

}

if (!isset($_GET['filter']) || $_GET['filter'] == 'all') {

    $sql = mysqli_query($koneksi, "SELECT * FROM events ORDER BY id DESC");

}



if (isset($_POST['edit'])) {

    $idEvent = $_POST['id'];

    $linkZoom = $_POST['link_zoom'];

    $background_image = $_POST['background_image'];

    $materi = $_POST['materi'];

    $hasil_record = $_POST['hasil_record'];



    if ($linkZoom != '' && $background_image != '' && $materi != '' && $hasil_record != '') {

        $edit = mysqli_query($koneksi, "UPDATE events SET link_zoom='$linkZoom',background_image='$background_image',materi='$materi',hasil_record='$hasil_record' WHERE id=$idEvent ");

    } elseif ($linkZoom != '') {

        $edit = mysqli_query($koneksi, "UPDATE events SET link_zoom='$linkZoom' WHERE id=$idEvent ");

    } elseif ($background_image != '') {

        $edit = mysqli_query($koneksi, "UPDATE events SET background_image='$background_image' WHERE id=$idEvent ");

    } elseif ($materi != '') {

        $edit = mysqli_query($koneksi, "UPDATE events SET materi='$materi' WHERE id=$idEvent ");

    } elseif ($hasil_record != '') {

        $edit = mysqli_query($koneksi, "UPDATE events SET hasil_record='$hasil_record' WHERE id=$idEvent ");

    }



    if ($edit) {

        $url1 = $_SERVER['REQUEST_URI'];

        header("Refresh: 1.6; URL=$url1");

        echo '<div class="alert alert-success alert-dismissable m-2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Berhasil edit event.</div>';

    } else {

        echo '<div class="alert alert-danger alert-dismissable m-2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Gagal edit event, silahkan coba lagi.</div>';

    }

}

?>





<!-- Main content -->

<section class="content">

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">Dashboard Event</h3>

        </div>

        <div class="card-body">



            <form class="form-inline" method="get">

                <div class="form-group">

                    <select name="filter" class="form-control" onchange="form.submit()">

                        <option disabled selected>Filter Event</option>

                        <?php $filter = addslashes(isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>

                        <?php while ($tgl = mysqli_fetch_assoc($tgl_mulai)) : ?>

                            <option value="<?= $tgl['tanggal_mulai'] ?>" <?php if ($filter == $tgl['tanggal_mulai']) {

                                                                                echo 'selected';

                                                                            } ?>><?= date('d F Y', strtotime($tgl['tanggal_mulai'])) ?></option>

                        <?php endwhile; ?>

                        <option value="all" <?php echo $filter == 'all' ? 'selected' : '' ?>>Semua</option>



                    </select>

                </div>

            </form>

            <div class="table-responsive mt-3">

                <table id="event" class="table table-striped table-hover">

                    <thead>

                        <tr>

                            <th>Judul</th>

                            <th>Nama Pembicara</th>

                            <th>Tanggal Mulai</th>

                            <th>Jam mulai - selesai</th>

                            <th>Action</th>

                        </tr>

                    </thead>

                    <?php if (isset($_GET['filter'])) { ?>

                        <?php while ($row = mysqli_fetch_assoc($fil)) : ?>

                            <tbody>

                                <tr>

                                    <td><?= $row['judul'] ?></td>

                                    <td><?= $row['nama'] ?></td>

                                    <td><?= date('d F Y', strtotime($row['tanggal_mulai'])) ?></td>

                                    <td><?= substr($row['jam_mulai'], 0, 5) . ' - ' . substr($row['jam_selesai'], 0, 5) ?></td>

                                    <td>

                                        <a href="https://event.lokerprogrammer.com/admin/event/hapus.php?id=<?= $row['id'] ?>" title="Delete Event" class="btn btn-danger btn-sm" name="test"><span class="fas fa-trash" aria-hidden="true"></span></a>

                                        <a href="#" title="Detail Event" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#deskripsi-<?= $row['id'] ?>"><span class="fas fa-list" aria-hidden="true"></span></a>

                                        <div class="modal fade" id="deskripsi-<?= $row['id'] ?>" style="display: none;" aria-hidden="true">

                                            <form action="" method="post">

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

                                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">

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

                                                                        <th>Link Zoom</th>

                                                                        <td>

                                                                            <?php if ($row['link_zoom'] == '') { ?>

                                                                                <input type="text" class="form-control" id="link_zoom" name="link_zoom" placeholder="Paste link zoom">

                                                                            <?php } else { ?>

                                                                                <a target="_blank" href="<?= $row['link_zoom'] ?>"><?= $row['link_zoom'] ?></a>

                                                                            <?php } ?>

                                                                        </td>

                                                                    </tr>

                                                                    <tr>

                                                                        <th>Link Background Event</th>

                                                                        <td>

                                                                            <?php if ($row['background_image'] == '') { ?>

                                                                                <input type="text" class="form-control" id="background_image" name="background_image" placeholder="Paste link background">

                                                                            <?php } else { ?>

                                                                                <a target="_blank" href="<?= $row['background_image'] ?>"><?= $row['background_image'] ?></a>

                                                                            <?php } ?>

                                                                        </td>

                                                                    </tr>

                                                                    <tr>

                                                                        <th>Link Hasil Record Zoom</th>

                                                                        <td>

                                                                            <?php if ($row['hasil_record'] == '') { ?>

                                                                                <input type="text" class="form-control" id="hasil_record" name="hasil_record" placeholder="Paste link hasil record">

                                                                            <?php } else { ?>

                                                                                <a target="_blank" href="<?= $row['hasil_record'] ?>"><?= $row['hasil_record'] ?></a>

                                                                            <?php } ?>

                                                                        </td>

                                                                    </tr>

                                                                    <tr>

                                                                        <th>Link Materi</th>

                                                                        <td>

                                                                            <?php if ($row['materi'] == '') { ?>

                                                                                <input type="text" class="form-control" id="materi" name="materi" placeholder="Paste link materi">

                                                                            <?php } else { ?>

                                                                                <a target="_blank" href="<?= $row['materi'] ?>"><?= $row['materi'] ?></a>

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

                                                            <?php if ($row['link_zoom'] == '' || $row['background_image'] == '' || $row['materi'] == '' || $row['hasil_record'] == '') { ?>

                                                                <button type="submit" class="btn btn-primary" name="edit">Edit</button>

                                                            <?php } else {

                                                                echo '';

                                                            } ?>

                                                        </div>

                                                    </div>

                                                    <!-- /.modal-content -->

                                                </div>

                                            </form>

                                            <!-- /.modal-dialog -->

                                        </div>

                                    </td>

                                </tr>

                            </tbody>

                        <?php endwhile; ?>

                    <?php } ?>

                    <?php if (!isset($_GET['filter']) || $_GET['filter'] == 'all') { ?>

                        <?php while ($row = mysqli_fetch_assoc($sql)) : ?>

                            <tbody>

                                <tr>

                                    <td><?= $row['judul'] ?></td>

                                    <td><?= $row['nama'] ?></td>

                                    <td><?= date('d F Y', strtotime($row['tanggal_mulai'])) ?></td>

                                    <td><?= substr($row['jam_mulai'], 0, 5) . ' - ' . substr($row['jam_selesai'], 0, 5) ?></td>

                                    <td>

                                        <!-- <form action="" method="post" class="float-left mr-2"> -->

                                        <a href="https://event.lokerprogrammer.com/admin/event/hapus.php?id=<?= $row['id'] ?>" title="Delete Event" class="btn btn-danger btn-sm" name="test"><span class="fas fa-trash" aria-hidden="true"></span></a>

                                        <!-- </form> -->

                                        <a href="#" title="Detail Event" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#deskripsi-<?= $row['id'] ?>"><span class="fas fa-list" aria-hidden="true"></span></a>

                                        <div class="modal fade" id="deskripsi-<?= $row['id'] ?>" style="display: none;" aria-hidden="true">

                                            <form action="" method="post">

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

                                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">

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

                                                                        <th>Link Zoom</th>

                                                                        <td>

                                                                            <?php if ($row['link_zoom'] == '') { ?>

                                                                                <input type="text" class="form-control" id="link_zoom" name="link_zoom" placeholder="Paste link zoom">

                                                                            <?php } else { ?>

                                                                                <a target="_blank" href="<?= $row['link_zoom'] ?>"><?= $row['link_zoom'] ?></a>

                                                                            <?php } ?>

                                                                        </td>

                                                                    </tr>

                                                                    <tr>

                                                                        <th>Link Background Event</th>

                                                                        <td>

                                                                            <?php if ($row['background_image'] == '') { ?>

                                                                                <input type="text" class="form-control" id="background_image" name="background_image" placeholder="Paste link background">

                                                                            <?php } else { ?>

                                                                                <a target="_blank" href="<?= $row['background_image'] ?>"><?= $row['background_image'] ?></a>

                                                                            <?php } ?>

                                                                        </td>

                                                                    </tr>

                                                                    <tr>

                                                                        <th>Link Hasil Record Zoom</th>

                                                                        <td>

                                                                            <?php if ($row['hasil_record'] == '') { ?>

                                                                                <input type="text" class="form-control" id="hasil_record" name="hasil_record" placeholder="Paste link hasil record">

                                                                            <?php } else { ?>

                                                                                <a target="_blank" href="<?= $row['hasil_record'] ?>"><?= $row['hasil_record'] ?></a>

                                                                            <?php } ?>

                                                                        </td>

                                                                    </tr>

                                                                    <tr>

                                                                        <th>Link Materi</th>

                                                                        <td>

                                                                            <?php if ($row['materi'] == '') { ?>

                                                                                <input type="text" class="form-control" id="materi" name="materi" placeholder="Paste link materi">

                                                                            <?php } else { ?>

                                                                                <a target="_blank" href="<?= $row['materi'] ?>"><?= $row['materi'] ?></a>

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

                                                            <?php if ($row['link_zoom'] == '' || $row['background_image'] == '' || $row['materi'] == '' || $row['hasil_record'] == '') { ?>

                                                                <button type="submit" class="btn btn-primary" name="edit">Edit</button>

                                                            <?php } else {

                                                                echo '';

                                                            } ?>

                                                        </div>

                                                    </div>

                                                    <!-- /.modal-content -->

                                                </div>

                                                <!-- /.modal-dialog -->

                                            </form>

                                        </div>
                                    </td>

                                </tr>

                            </tbody>

                        <?php endwhile; ?>

                    <?php } ?>





                </table>

            </div>

        </div>

    </div>

</section>

<!-- /.content -->

<?php include 'layouts/footer.php' ?>