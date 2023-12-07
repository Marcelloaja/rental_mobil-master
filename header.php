<?php
require 'koneksi/koneksi.php';
if(empty($_SESSION['USER']))
{
    session_destroy();
}

?>
<!doctype html>
<html lang="en">
  <head>
    <title>Rental Mobil</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.css" >
    <link rel="stylesheet" href="assets/css/font-awesome.css" >
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="assets/image/ico.ico">
  </head>
  <body style="background-color: #c9c9c9;">
    <div class="jumbotron jumbotron-fluid pt-4 pb-4" style="background-color: #202124;">
        <div class="row">
            <div class="col-sm-3">
                <p><img src="assets/image/fix1.png" style="height:100px; margin-top:-30px; margin-bottom: -30px;"></p>
            </div>
            <div class="col-sm-6">
                <center><h1 style="color: #ffb400;">TRANS 88</h1></center>
            </div>
            <div class="col-sm-3">
            
            </div>
        </div>
    </div>
    <div style="margin-top:-2pc"></div>
    <nav id="navheader" class="navbar navbar-expand-lg navbar-light" style="background-color: #212529">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="#"></a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php" style="color: #ffb400;">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="blog.php" style="color: #ffb400;">Daftar Mobil</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="kontak.php" style="color: #ffb400;">Tentang Kami</a>
                </li> 
                <li>
                    <a class="nav-link" href="#" data-target="#login" data-toggle="modal" style="color: #ffb400;">LOGIN</a>
                </li>  
                      
                   

                    <div id="login" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        
                        <div class="modal-content">
                        <div class="modal-body">
                        <form method="post" action="koneksi/proses.php?id=login"> 
                            <button data-dismiss="modal" class="close">&times;</button>
                            <h4>Login</h4>
                            <form>
                            <input type="text" name="user" id="" class="form-control" placeholder="" aria-describedby="helpId">
                            <input type="password" name="pass" id="" class="form-control" placeholder="" aria-describedby="helpId">
                            <button class="btn btn-primary">Login</button>
                            </form>
                        </form>
                        </div>
                        </div>
                    </div>  
                    </div>

            
            </ul>
            <?php if(!empty($_SESSION['USER'])){?>
            <ul class="navbar-nav my-2 my-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fa fa-user"> </i> Hallo, <?php echo $_SESSION['USER']['nama_pengguna'];?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="return confirm('Apakah anda ingin logout ?');" href="<?php echo $url;?>admin/logout.php">Logout</a>
                </li>
            </ul>
            <?php }?>
        </div>
    </nav>