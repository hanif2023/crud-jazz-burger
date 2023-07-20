<?php
    include_once __DIR__ . '../../../config/config.php';

    session_start();
    
    if (isset($_GET['menu_code']) && isset($_GET['quantity'])) {

        $menu_code = $_GET['menu_code'];
        $quantity = $_GET['quantity'];

        $sql = "SELECT * FROM menu WHERE menu_code ='$menu_code'";

        $query = $mysqli->query($sql);
        $data = mysqli_fetch_array($query);

        $menu_code = $data['menu_code'];
        $menu_pictures = $data['menu_pictures'];
        $menu_name = $data['menu_name'];
        $menu_price = $data['menu_price'];
        $menu_stock = $data['menu_stock'];

    } else {
        $menu_code = "";
        $quantity = 0;
    }

    if (isset($_GET['aksi'])) {
        $aksi = $_GET['aksi'];
    } else {
        $aksi = "";
    }

    switch($aksi) {
        // menambahkan menu yang akan dibeli ke dalam keranjang belanja
        case "add" :
            $itemArray = array ($menu_code=>array('menu_code'=>$menu_code, 'menu_pictures'=>$menu_pictures, 'menu_name'=>$menu_name, 'menu_price'=>$menu_price, 'quantity'=>$quantity, 'menu_stock'=>$menu_stock));
            if (!empty($_SESSION["cart"])) {
                if (in_array($data['menu_code'], array_keys($_SESSION["cart"]))) {
                    foreach ($_SESSION["cart"] as $k => $c) {
                        if ($data["menu_code"] == $k) {
                            $_SESSION["cart"] = array_merge($_SESSION["cart"], $itemArray);
                        }
                    }
                } else {
                    $_SESSION["cart"] = array_merge($_SESSION["cart"], $itemArray);
                }
            } else {
                $_SESSION["cart"] = $itemArray;
            }
            break;
        
        // menghapus item dalam keranjang belanja
        case "delete" :
            if (!empty($_SESSION["cart"])) {
                foreach ($_SESSION["cart"] as $k => $c) {
                    if ($_GET['menu_code'] == $k) {
                        unset($_SESSION["cart"][$k]);
                    } 

                    if (empty($_SESSION["cart"])) {
                        unset($_SESSION["cart"]);
                    }
                }
            }
            break;

        // melakukan update pesanan
        case "update" :
            $itemArray = array ($menu_code=>array('menu_code'=>$menu_code, 'menu_pictures'=>$menu_pictures, 'menu_name'=>$menu_name, 'menu_price'=>$menu_price, 'quantity'=>$quantity, 'menu_stock'=>$menu_stock));
            if (!empty($_SESSION["cart"])) {
                foreach ($_SESSION["cart"] as $k => $v) {
                    if ($_GET['menu_code'] = $k) {
                        $_SESSION["cart"] = array_merge($_SESSION["cart"], $itemArray);
                    }
                }
            }
            break;
    }


    $custname = $address = $phone = $notes = "";
    $custname_err = $address_err = $phone_err = $notes_err = $k_err = "";

    // jika di klik tombol Checkout Sekarang
    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $custname = trim($_POST['custname']);
        if (empty($custname)) {
            $custname_err = "Silahkan Isi Nama Anda!";
        } elseif (!filter_var($custname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
            $custname_err = "Silahkan Isi Nama yang Valid!";
        }

        $address = trim($_POST['address']);
        if (empty($address)) {
            $address_err = "Silahkan Isi Alamat Anda!";
        }

        $phone = trim($_POST['phone']);
        if (empty($phone)) {
            $phone_err = "Silahkan Isi Nomor Anda!";
        }

        $notes = trim($_POST['notes']);     

        $date = date("Y-m-d");
        if (!isset($_SESSION["cart"])) {
            $k_err = "Keranjang Belanja Kosong";
        }
        
        // jika tidak ada error, maka data siap disimpan
        if (empty($custname_err) && empty($address_err) && empty($phone_err) && empty($notes_err)) {

            $sql = "INSERT INTO orders (custname, address, phone, notes) VALUES (?, ?, ?, ?)";

            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("ssss", $param_custname, $param_address, $param_phone, $param_notes);

                $param_custname = $custname;
                $param_address = $address;
                $param_phone = $phone;
                $param_notes = $notes;

                if ($stmt->execute()) {
                    header("location: greeting.php");
                    exit();
                } else {
                    echo "ada yang salah";
                }
            }
            $stmt->close();

            

        }
        $mysqli->close();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initialscale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
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

        <!--Form Checkout-->
        <div class="grid">
            <div class="container pt-5">
                <form class="text-start" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="row">
                        <div class="col text-center">
                            <h2><b>Konfirmasi Pembelian Anda di <b>Jazz<span style="color: firebrick;">Burger.</span></b></b></h2>
                            <br>
                        </div>
                    </div>

                    <div class="row row-cols-2 row-cols-lg-1 g-2 g-lg-3 text-center ">
                        <div class="col">
                            <div class="p-3 border bg-light hanif-border hanif-product-padding">
                                <table class="table text-center align-items-center">
                                    <div class="w-50 my-auto mx-auto">
                                        <div class="form-login text-center">
                                            <h4>Silahkan Mengisi Form Berikut</h4>
                                            <hr>
                                            
                                                <div class="text-start">
                                                    <div class="mb-3">
                                                        <label for="custname" class="form-label">Nama :</label>
                                                        <input type="text" name="custname" class="form-control <?php echo (!empty($custname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $custname; ?>" id="custname" placeholder="Masukkan custname">
                                                        <span class="invalid-feedback"><?php echo $custname_err; ?></span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="address" class="form-label">Alamat Pengantaran :</label>
                                                        <input type="text" name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>" id="address" placeholder="Masukkan address">
                                                        <span class="invalid-feedback"><?php echo $address_err; ?></span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="phone" class="form-label">Nomor HP :</label>
                                                        <input type="text" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>" id="phone" placeholder="Masukkan phone">
                                                        <span class="invalid-feedback"><?php echo $phone_err; ?></span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="notes" class="form-label">Catatan :</label>
                                                        <input type="text" name="notes" class="form-control <?php echo (!empty($notes_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $notes; ?>" id="notes" placeholder="Masukkan notes">
                                                        <span class="invalid-feedback"><?php echo $notes_err; ?></span>
                                                    </div>
                                                </div>
                                            
                                        </div>
                                    </div>
                                    <hr>
                                    <br>
                                    <br>
                                    <h4><b>Keranjang Pemesanan :</b></h4>
                                    <br>
                                    <thead>
                                        <tr>
                                            <th scope="col">Nomor</th>
                                            <th scope="col">Foto</th>
                                            <th scope="col">Menu</th>
                                            <th scope="col">Harga Satuan</th>
                                            <th scope="col">Kuantitas</th>
                                            <th scope="col">Sub Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $num = 0;
                                            $sub_price = 0;
                                            $total = 0;

                                            if (!empty($_SESSION["cart"])){
                                                foreach ($_SESSION["cart"] as $item) {
                                                    $num++;
                                                    $sub_price = $item["quantity"] * $item['menu_price'];
                                                    $total += $sub_price;
                                        ?>
                                                <input type="hidden" name="menu_code[]" class="menu_code" value="<?php echo $item["menu_code"]; ?>" />

                                                <tr>
                                                    <td><p><?php echo $num ?></p></td>
                                                    <td><img style="width: 100px; border-radius: 8px;" src="../../assets/images/menu/<?php echo $item['menu_pictures']; ?>"></td>
                                                    <td><p><?php echo $item['menu_name']; ?></p></td>
                                                    <td><p><?php echo "Rp" . number_format($item['menu_price'], 2, ",", ".") ?></p></td>
                                                    <td><p><?php echo $item["quantity"]; ?></p></td>
                                                    <td><p><?php echo "Rp" . number_format($sub_price, 2, ",", ".") ?></p></td>
                                                    
                                                </tr>
                                        <?php
                                                }
                                            }
                                        ?>

                                    </tbody>
                                </table>
                                <h4>Total Pembayaran : Rp<?php echo number_format($total, 2, ",", ".");?></h4>
                            </div>
                        </div>
                        <div class="col">
                            
                        </div>
                    </div>
                    <div class="vstack gap-2 col-md-3 mx-auto">
                        <input type="submit" class="btn btn-warning" value="Checkout Sekarang">
                        <a href="keranjang.php" class="btn btn-success" role="button">Ubah Pesanan</a>
                    </div>
                    <div class="row row-cols-2 row-cols-lg-1 g-2 g-lg-3 text-center ">
                        <div class="col">
                            <div class="p-3 hanif-border hanif-product-padding">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>