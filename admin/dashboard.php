<?php
$sql = mysqli_query($koneksi, "SELECT * FROM events ORDER BY tanggal_mulai DESC");
?>
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Dashboard</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form class="form-inline" method="get">
            <div class="form-group">
                <select name="event" class="form-control" onchange="form.submit()">
                    <option value="0">Filter Event</option>
                    <?php $filter = addslashes(isset($_GET['dashboard']) ? strtolower($_GET['dashboard']) : NULL);  ?>
                    <?php while ($tgl = mysqli_fetch_assoc($sql)) : ?>
                        <option value="<?= $tgl['tanggal_mulai'] ?>" <?php if ($filter == $tgl['tanggal_mulai']) { echo 'selected'; } ?>><?= $tgl['tanggal_mulai'] ?></option>
                    <?php endwhile; ?>

                </select>
            </div>
        </form>
        <div class="table-responsive mt-3">
            <table class="table table-striped table-hover">
                <tr>
                    <th>Judul</th>
                    <th>Nama Pembicara</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam mulai - selesai</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($sql)) : ?>
                    <tr>
                        <td><?= $row['judul'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <?php if ($row['tanggal_mulai']) : ?>
                            <td><?= $row['tanggal_mulai'] ?></td>
                        <?php endif; ?>
                        <td><?= substr($row['jam_mulai'], 0, 5) . ' - ' . substr($row['jam_selesai'], 0, 5) ?></td>
                        <td>
                            <a href="" title="Ubah Data" data-toggle="tooltip" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
                            <a href="" title="Hapus" data-toggle="tooltip" class="btn btn-danger btn-sm"><span class="fas fa-trash" aria-hidden="true"></span></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        Footer
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->