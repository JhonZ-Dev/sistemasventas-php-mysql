<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de ventas</title>
    <style>


@font-face {
    font-family: hiper;
    src: url(../distint.otf);
}
@font-face {
    font-family: family_text;
    src: url(../KGCorneroftheSky.ttf);
}
@font-face {
    font-family: vector_line;
    src: url(VectorLine.otf);
}
#w{
    color: #0179B4;
    font-family: family_text;
    font-size: 40px;


}
#e{
    color: #03588C;
    font-family: family_text;
    font-size: 40px;


}

#m{
    color:#E17909;
    font-family: family_text;
    font-size: 40px;

}
#a{
    color:#E17909;
    font-family: family_text;
    font-size: 40px;

}
#k{
    color:#F2B807;
    font-family: family_text;
    font-size: 40px;

}
#e1,#r,#s{
    color:#E17909;
    font-family: family_text;
    font-size: 40px;

}
#academia{
    color:#524C4D;
    font-family: hiper;
    font-size: 15px;
}
</style>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/templeates/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../public/templeates/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/templeates/AdminLTE-3.2.0/dist/css/adminlte.min.css">

    <!-- Libreria Sweetallert2-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->


    <?php
    session_start();
    if(isset($_SESSION['mensaje'])){
        $respuesta = $_SESSION['mensaje']; ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: '<?php echo $respuesta;?>',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php
    }
    ?>

    <center>
        <img src="../public/images/logo2.png"
             alt="" width="250px">
    </center>
    <br>
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
        <h1 class="m-0"><span id="w">W</span ><span id="e">e</span> <span id="m">M</span ><span id="a" >a</span><span id="k" >k</span><span id="e1" >e</span><span id="r" >r</span><span id="s" >s</span></h1>
        <span id="academia">ACADEMIA STEAM</span>
    </div>
        <div class="card-body">
            <p class="login-box-msg" style="font-family:family_text;">Ingrese sus datos</p>

            <form action="../app/controllers/login/ingreso.php" method="post">
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_user" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../public/templeates/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/templeates/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/templeates/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>
</body>
</html>
