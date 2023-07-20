<nav class="navbar sticky-top navbar-expand-sm navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#dashboard.php">
            <h4 class="login-title"><b>Jazz<span style="color: firebrick;">Burger.</span></b></h4>
        </a>

        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=beranda">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user/page/menu.php">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user/page/keranjang.php">Keranjang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=profil">Profil</a>
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
                            <a class="nav-link dropdown-toggle" href="#../account/logout.php" role="button" data-bs-toggle="dropdown"><img src="assets/images/person.png" style="width: 20px;"> &nbsp; <?php echo htmlspecialchars($_SESSION["username"]); ?></a>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-lg-end">
                                <li>
                                    <a class="dropdown-item" style="font-size: 12px; " href="user/auth/logout.php">Log Out</a>
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
                            <a class="nav-link text-danger" aria-current="page" href="user/auth/register.php">SignUp</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-success" href="user/auth/login.php">LogIn</a>
                        </li>
                <?php
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>