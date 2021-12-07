
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Loker Programmer</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <link rel="stylesheet" href="https://event.lokerprogrammer.com/assets/css/adminlte.min.css">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="hold-transition login-page vh-100">

    <div class="col-md-4">
        <h3 class="text-center text-bold">Event</h3>
        <h4 class="text-center">Loker Programmer</h4>
        <div class="card m-4">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#masuk" data-toggle="tab">Masuk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#daftar" data-toggle="tab">Daftar</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div class="tab-pane active" id="masuk">
                        <form action="masuk.php" method="post">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Email" name="email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Password" name="password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block" name="masuk">Masuk</button>
                                    <a href="https://event.lokerprogrammer.com/index.php" class="btn btn-default btn-block">Cancel</a>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="daftar">
                        <form action="daftar.php" method="post">
                            <div class="input-group mb-3">
                                <input type="nama" class="form-control" placeholder="Nama Lengkap" name="nama">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Email" name="email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Password" name="password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block" name="daftar">Daftar</button>
                                    <a href="https://event.lokerprogrammer.com/index.php" class="btn btn-default btn-block">Cancel</a>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>

                        <!-- /.social-auth-links -->

                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>



    <!-- jQuery -->
    <script src="https://event.lokerprogrammer.com/assets/plugins/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://event.lokerprogrammer.com/assets/plugins/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://event.lokerprogrammer.com/assets/js/adminlte.min.js"></script>

</body>

</html>
