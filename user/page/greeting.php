<?php
    include "../../config/config.php";

    session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initialscale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">

    <title>Jazz Burger</title>
</head>

<body>
    <main>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
            <div class="container">
                <a class="navbar-brand" href="#dashboard.php">
                    <h4 class="login-title"><b>Jazz<span style="color: firebrick;">Burger.</span></b></h4>
                </a>

                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../../index.php?page=beranda">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu.php">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="keranjang.php">Keranjang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../index.php?page=profil">Profil</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav justify-content-end">
                        <?php
                            if ($_SESSION['loggedin'] == true) {
                        ?>
                            <li class="nav-item">
                                &nbsp;&nbsp;&nbsp;
                            </li>
                            <li class="nav-item dropdown-center">
                                <a class="nav-link dropdown-toggle" href="#../account/logout.php" role="button" data-bs-toggle="dropdown"><img src="../../assets/images/person.png" style="width: 20px;"> &nbsp; <?php echo htmlspecialchars($_SESSION["username"]); ?></a>
                                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-lg-end">
                                    <li>
                                        <a class="dropdown-item" href="../auth/logout.php">Log Out</a>
                                    </li>
                                </ul>
                            </li>
                        <?php
                            } else {
                        ?>
                                <li class="nav-item">
                                    &nbsp;&nbsp;&nbsp;
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-danger" aria-current="page" href="../auth/register.php">SignUp</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-success" href="../auth/login.php">LogIn</a>
                                </li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!--MENU-->
        <div class="grid">
            <div class="container pt-5">
                <div class="row">
                    <div class="col text-center">
                        <h2>Terimakasih <span class="text-success"><?php echo htmlspecialchars($_SESSION["username"]); ?>!</span></h2>
                        <br>
                        <h5>Selamat menikmati!</h5>
                        <h5>Silahkan menuju <a href="menu.php" class="link-warning text-danger">link berikut</a> untuk melakukan pembelian!</h5>
                    </div>
                </div>
            </div>
        </div>

        <!--Footer-->
        <div class="mt-5 hanif-mt-5 p-4 hanif-p-4 bg-dark text-white text-center fixed-bottom">
            <a class="hanif-brand" href="#">
                <h4>Jazz<span style="color: firebrick;">Burger.</h4>
            </a>
            <h5>- The Best Burger in Town -</h5>
            <p class="hanif-footer-text">
                Kami Hadir dengan Kenikmatan yang Tak Tertandingi. Burger Bun Lembut Dipadukan dengan Patty yang Juicy.
                <br>
                Segera <span><a class="hanif-link-contact link-primary" href="">Hubungi Kami</a></span>.
                <br><br>
                &copy · <a class="hanif-copyright" href="#">Hanif Abdillah</a>
            </p>
        </div>
    </main>
</body>

</html>