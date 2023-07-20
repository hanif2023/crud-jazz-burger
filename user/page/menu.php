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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="container">
                <div class="grid pt-5">
                    <?php
                        require_once "../../functions/functions.php";
                        $request_method = strtoupper($_SERVER['REQUEST_METHOD']);
                        $menu_category = '';
                        $menu_name = '';
                        if ($request_method === 'POST') {
                            if (filter_has_var(INPUT_POST, 'menu_category')) {
                                $menu_category = $_POST['menu_category'];
                            } elseif (filter_has_var(INPUT_POST, 'menu_name')) {
                                $menu_name = htmlspecialchars($_POST['menu_name']);
                            }
                        }
                    ?>

                    <div class="row">
                        <div class="col text-center">
                            <h2><b>Menu</b></h2>
                            <br>
                            <br>
                        </div>

                        <div class="text-center">
                                <input class="form-control me-2" type="text" name="menu_name" value="<?php echo $menu_name ?>" placeholder="Cari Menu berdasarkan Nama">
                                <br>
                                <button class="btn btn-danger" type="submit">Cari Menu</button>
                        </div>
                    </div>

                    <br><br>

                    <div class="row row-cols-2 row-cols-lg-1 g-2 g-lg-3 text-center">
                        <div class="col">
                            <button class="btn btn-warning" type="submit" name="menu_category" value="all">All Menu</button>
                            <button class="btn btn-warning" type="submit" name="menu_category" value="special">Special Menu</button>
                            <button class="btn btn-warning" type="submit" name="menu_category" value="breakfast burrito">Breakfast Burrito</button>
                            <button class="btn btn-warning" type="submit" name="menu_category" value="main course">Main Course</button>
                            <button class="btn btn-warning" type="submit" name="menu_category" value="side dishes">Side Dishes</button>
                            <button class="btn btn-warning" type="submit" name="menu_category" value="drinks">Drinks</button>
                        </div>
                    </div>
                    
                    <br><br><br>

                    <div class="row row-cols-2 row-cols-lg-4 g-2 g-lg-3 text-center">
                        <?php      
                            if ($request_method === "POST") {
                                require_once "../../functions/functions.php";
                                $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

                                if (!$mysqli) {
                                    echo "Gagal Melakukan Koneksi";
                                }

                                $sql = "SELECT * FROM menu";
                                if ($menu_category == "special") {
                                    $sql .= " WHERE menu_category LIKE 'special'";
                                } elseif ($menu_category == "breakfast burrito") {
                                    $sql .= " WHERE menu_category LIKE 'breakfast burrito'";
                                } elseif ($menu_category == "main course") {
                                    $sql .= " WHERE menu_category LIKE 'main course'";
                                } elseif ($menu_category == "side dishes") {
                                    $sql .= " WHERE menu_category LIKE 'side dishes'";
                                } elseif ($menu_category == "drinks") {
                                    $sql .= " WHERE menu_category LIKE 'drinks'";
                                } elseif ($menu_name == "$menu_name") {
                                    $sql .= " WHERE menu_name LIKE '%$menu_name%'";
                                }

                                $results = $mysqli->query($sql);
                                $quantity = mysqli_num_rows($results);
                                if ($quantity > 0) {
                                    while($data = mysqli_fetch_array($results)) {
                        ?>
                                        <div class="col">
                                            <div class="p-3 border bg-light hanif-border hanif-product-padding">
                                                <h4><?php echo "{$data['menu_name']}"; ?></h4>
                                                <br>
                                                <img class="hanif-product-img" src="../../assets/images/menu/<?php echo "{$data['menu_pictures']}"; ?>">
                                                <br>
                                                <br>
                                                <p class="hanif-product-desc"><?php echo "{$data['menu_detail']}"; ?></p>
                                                <p class="hanif-product-price"><?php echo "Rp" . number_format($data['menu_price'], 2, ",", ".") ?></p>
                                                <p class="hanif-product-desc"><?php echo "Stok : {$data['menu_stock']}"; ?></p>
                                                <a class="btn btn-success" href="keranjang.php?menu_code=<?php echo "{$data['menu_code']}"?>&aksi=add&quantity=1">Tambahkan ke Keranjang</a>
                                            </div>
                                        </div>
                        <?php
                                    }
                                }
                            } elseif ($request_method === 'GET') {
                                $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

                                if (!$mysqli) {
                                    echo "Gagal Melakukan Koneksi";
                                }

                                $sql = 'SELECT * FROM menu';
                                $result = $mysqli->query($sql);
                                $quantity = mysqli_num_rows($result);
                                if ($quantity > 0) {
                                    while($data = mysqli_fetch_array($result)) {
                        ?>
                                        <div class="col">
                                            <div class="p-3 border bg-light hanif-border hanif-product-padding">
                                                <h4><?php echo "{$data['menu_name']}"; ?></h4>
                                                <br>
                                                <img class="hanif-product-img" src="../../assets/images/menu/<?php echo "{$data['menu_pictures']}"; ?>">
                                                <br>
                                                <br>
                                                <p class="hanif-product-desc"><?php echo "{$data['menu_detail']}"; ?></p>
                                                <p class="hanif-product-price"><?php echo "Rp" . number_format($data['menu_price'], 2, ",", ".") ?></p>
                                                <p class="hanif-product-desc"><?php echo "Stok : {$data['menu_stock']}"; ?></p>
                                                <a class="btn btn-success" href="keranjang.php?menu_code=<?php echo "{$data['menu_code']}"?>&aksi=add&quantity=1">Tambahkan ke Keranjang</a>
                                            </div>
                                        </div>
                        <?php
                                    }
                                } else {
                                    echo "<div class='alert alert-warning'> Tidak ada produk pada kategori ini.</div>";
                                }
                            }

                        ?>
                    </div>
                </div>
            </div>
        </form>

        <!--Footer-->
        <div class="mt-5 hanif-mt-5 p-4 hanif-p-4 bg-dark text-white text-center">
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