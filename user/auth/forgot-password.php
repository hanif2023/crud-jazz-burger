<?php
    session_start();
    
    include __DIR__ . '/../../config/config.php';

    // memeriksa apakah user telah login, jika sudah maka dialihkan ke halaman beranda
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: /../../index.php");
        exit;
    }

    // mendefinisikan dan menginisialisasi variabel dengan nilai kosong
    $username = "";
    $username_err = "";

    // memproses data ketika form di submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // memeriksa jika username kosong
        if (empty(trim($_POST["username"]))) {
            $username_err = "Silahkan Memasukkan Username";
        } else {
            $username = trim($_POST["username"]);
        }

        // melakukan validasi
        if (empty($username_err)) {

            // mendeklarasikan query SQL
            $sql = "SELECT idcust, username FROM customers WHERE username=?";

            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $param_username);

                // mengatur parameter
                $param_username = $username;

                // mengeksekusi statement
                if ($stmt->execute()) {

                    // menyimpan hasil
                    $stmt->store_result();

                    // jika username ada
                    if($stmt->num_rows == 1)  {
                        $stmt->bind_result($idcust, $username);

                        session_start();

                        $_SESSION["loggedin"] = true;
                        $_SESSION["idcust"] = $idcust;
                        $_SESSION["username"] = $username;

                        header("location: reset-password.php");
                    } else {
                        $login_err = "Username Tidak Ditemukan!";
                    }
                } else {
                    echo "Oops! Ada yang salah. Silahkan diulangi!";
                }
                $stmt->close();
            }
        }
        $mysqli->close();
    }

    include_once __DIR__ . '/auth_template/header.php';
    include_once __DIR__ . '/auth_template/navbar.php';
?>

<div class="container">
    <div class="row align-items-center justify-content-center">
        <div class="col-lg-6">
            <div class="card mt-5 mb-5 shadow rounded border-white">
                <div class="card-body pt-4">
                    <?php
                        if (!empty($login_err)) {
                            echo '<div class="alert alert-danger">' . $login_err . '</div>';
                        }
                    ?>
                    <h4 class="text-center">Daftar akun <b>Jazz<span style="color: firebrick;">Burger.</h4>
                    <hr>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3 mt-3 fw-normal">
                            <label for="email" class="form-label">Username :</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" id="username" placeholder="Masukkan username">
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>

                        <div class="vstack gap-2 col-md-3 mx-auto">
                            <button class="btn btn-success" type="submit">Lupa Password</button>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col text-end fw-normal">
                                <p style="font-size: 12px;">Tidak memiliki akun? <a class="text-decoration-none link-warning" href="register.php">Sign Up</a>.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include_once __DIR__ . '/auth_template/footer.php';
?>