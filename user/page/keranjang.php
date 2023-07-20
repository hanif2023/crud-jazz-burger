<?php
session_start();

if (isset($_GET['menu_code']) && isset($_GET['quantity'])) {

    include __DIR__ . "../../../config/config.php";

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

switch ($aksi) {
    // menambahkan menu yang akan dibeli ke dalam keranjang belanja
    case "add":
        $itemArray = array(
            'menu_code' => $menu_code,
            'menu_pictures' => $menu_pictures,
            'menu_name' => $menu_name,
            'menu_price' => $menu_price,
            'quantity' => $quantity,
            'menu_stock' => $menu_stock
        );
        if (!empty($_SESSION["cart"])) {
            $menuCodeExists = false;
            foreach ($_SESSION["cart"] as $k => $item) {
                if ($item["menu_code"] == $menu_code) {
                    // Update the quantity of the existing item in the cart
                    $_SESSION["cart"][$k]["quantity"] = $quantity;
                    $menuCodeExists = true;
                    break;
                }
            }
            if (!$menuCodeExists) {
                // Add the new item to the cart if the menu code does not already exist
                $_SESSION["cart"][] = $itemArray;
            }
        } else {
            // If the cart is empty, add the new item to the cart
            $_SESSION["cart"][] = $itemArray;
        }
        break;

    // menghapus item dalam keranjang belanja
    case "delete":
        if (!empty($_SESSION["cart"]) && isset($_GET['menu_code'])) {
            $menu_code_to_delete = $_GET['menu_code'];

            // Find the item index with the given menu code in the cart array
            $itemIndex = array_search($menu_code_to_delete, array_column($_SESSION["cart"], 'menu_code'));

            if ($itemIndex !== false) {
                // Remove the item from the cart using its index
                unset($_SESSION["cart"][$itemIndex]);

                // Re-index the array after deletion
                $_SESSION["cart"] = array_values($_SESSION["cart"]);
            }

            // Check if the cart is empty after deletion and unset the cart session if necessary
            if (empty($_SESSION["cart"])) {
                unset($_SESSION["cart"]);
            }
        }
        break;

    // Update the quantity of the item in the cart
    case "update":
        if (!empty($_SESSION["cart"])) {
            foreach ($_SESSION["cart"] as $k => $item) {
                if ($item["menu_code"] === $_GET["menu_code"]) {
                    // Update the quantity of the existing item
                    $_SESSION["cart"][$k]["quantity"] = $_GET["quantity"];
                    break;
                }
            }
        }
        break;
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

        <!-- Keranjang Belanja -->
        <div class="container">
            <div class="grid pt-5">
                <div class="row">
                    <div class="col text-center">
                        <h2><b>Keranjang Belanja</b></h2>
                        <br>
                    </div>
                </div>

                <div class="row row-cols-2 row-cols-lg-1 g-2 g-lg-3 text-center ">
                    <div class="col">
                        <div class="p-3 border bg-light hanif-border hanif-product-padding">
                            <table class="table text-center align-items-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nomor</th>
                                        <th scope="col">Foto</th>
                                        <th scope="col">Menu</th>
                                        <th scope="col">Harga Satuan</th>
                                        <th scope="col">Kuantitas</th>
                                        <th scope="col">Sub Total Harga</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $num = 0;
                                    $sub_price = 0;
                                    $total = 0;

                                    if (!empty($_SESSION["cart"])) {
                                        foreach ($_SESSION["cart"] as $item) {
                                            $num++;
                                            $sub_price = $item["quantity"] * $item['menu_price'];
                                            $total += $sub_price;
                                    ?>
                                            <input type="hidden" name="menu_code[]" class="menu_code" value="<?php echo $item["menu_code"]; ?>" />

                                            <tr>
                                                <td>
                                                    <p><?php echo $num ?></p>
                                                </td>
                                                <td><img style="width: 100px; border-radius: 8px;" src="../../assets/images/menu/<?php echo $item['menu_pictures']; ?>"></td>
                                                <td>
                                                    <p><?php echo $item['menu_name']; ?></p>
                                                </td>
                                                <td>
                                                    <p><?php echo "Rp" . number_format($item['menu_price'], 2, ",", ".") ?></p>
                                                </td>
                                                <td>
                                                    <input type="number" min="1" max="<?php echo $item['menu_stock'] ?>" value="<?php echo $item["quantity"]; ?>" class="form-control text-center" id="quantity<?php echo $num; ?>" name="quantity[]">
                                                    <script>
                                                        $("#quantity<?php echo $num; ?>").bind('change', function() {
                                                            var quantity<?php echo $num; ?> = $("#quantity<?php echo $num; ?>").val();
                                                            $("#quantitys<?php echo $num; ?>").val(quantity<?php echo $num; ?>);
                                                        });
                                                        $("#quantity<?php echo $num; ?>").keydown(function(event) {
                                                            return false;
                                                        });
                                                    </script>
                                                </td>
                                                <td>
                                                    <p><?php echo "Rp" . number_format($sub_price, 2, ",", ".") ?></p>
                                                </td>
                                                <td>
                                                    <form method="GET">
                                                        <input type="hidden" class="form-control" name="menu_code" value="<?php echo $item['menu_code']; ?>">
                                                        <input type="hidden" class="form-control" name="aksi" value="update">
                                                        <input type="hidden" class="form-control" name="quantity" value="<?php echo $item["quantity"]; ?>" id="quantitys<?php echo $num; ?>">
                                                        <input type="submit" class="btn btn-dark" value="Update">
                                                        <a href="keranjang.php?menu_code=<?php echo "{$item['menu_code']}" ?>&aksi=delete" class="btn btn-danger" role="button">Delete</a>
                                                    </form>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                            <h4>Total Pembayaran : Rp<?php echo number_format($total, 2, ",", "."); ?></h4>
                        </div>
                    </div>
                    <div class="col">

                    </div>
                </div>
                <div class="vstack gap-2 col-md-2 mx-auto">
                    <a href="checkout.php" class="btn btn-warning" role="button">Checkout</a>
                    <a href="menu.php" class="btn btn-success" role="button">Tambah Pesanan</a>
                </div>
                <div class="row row-cols-2 row-cols-lg-1 g-2 g-lg-3 text-center ">
                    <div class="col">
                        <div class="p-3 hanif-border hanif-product-padding">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>