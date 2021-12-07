<?php include '../akses_admin.php'; ?>
<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>
<?php include '../../inc/koneksi.php'; ?>

<?php

if (isset($_POST['create'])) {
    $judul = $_POST['judul'];
    $nama = $_POST['nama'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $link_zoom = $_POST['link_zoom'];
    $background_image = $_POST['background_image'];
    $singkatan = $_POST['singkatan'];
    $deskripsi = $_POST['deskripsi'];


    $insert = mysqli_query($koneksi, "INSERT INTO events(judul,nama,tanggal_mulai,jam_mulai,jam_selesai,deskripsi,link_zoom,singkatan,background_image) 
                                                                VALUES('$judul','$nama','$tanggal_mulai','$jam_mulai','$jam_selesai','$deskripsi','$link_zoom','$singkatan','$background_image') ");

    if ($insert) {
        echo '<div class="alert alert-success alert-dismissable m-2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Berhasil membuat event.</div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissable m-2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Data gagal disimpan, silahkan coba lagi.</div>';
    }
}
?>
<section class="content">
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Create Event</h3>
    </div>
    <form method="post" action="">
        <div class="card-body">
            <!-- <div class="form-group">
                <label for="gambar">Gambar</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="gambar" name="gambar">
                        <label class="custom-file-label" for="gambar">Choose file</label>
                    </div>
                </div>
            </div> -->
            <div class="form-group mt-4">
                <label for="judul">Judul Event <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="form-group mt-4">
                <label for="singkatan">Singkatan <span class="text-danger">*</span> <code><small>Cth: FE, BE, UI</small></code></label>
                <input type="text" class="form-control" id="singkatan" name="singkatan" placeholder="FE" required>
            </div>
            <div class="form-group mt-4">
                <label for="nama">Nama Pembicara <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="jam_berakhir">Jam Berakhir <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                    </div>
                </div>
            </div>
            <div class="form-group mt-4">
                <label for="background_image">Link Background Event <code><small>Dikosongkan jika belum ada</small></code></label>
                <input type="text" class="form-control" id="background_image" name="background_image">
            </div>
            <div class="form-group mt-4">
                <label for="link_zoom">Link Zoom <code><small>Dikosongkan jika belum ada</small></code></label>
                <input type="text" class="form-control" id="link_zoom" name="link_zoom">
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control" required></textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" name="create">Create</button>
        </div>
    </form>
</div>
</section>
<?php include '../layouts/footer.php' ?>
