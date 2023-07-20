<?php
    session_start();

    include __DIR__ . '/../../config/config.php';

    // mendeklarasikan dan menginisialisasi password dengan nilai kosong
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";

    // memproses data form jika di klik submit
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // validasi username
        if(empty(trim($_POST["username"]))){
            $username_err = "Silahkan Memasukkan Username";
        } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
            $username_err = "Username Hanya Bisa Berupa Huruf, Angka, dan Underscores";
        } else {
            // deklarasi statement
            $sql = "SELECT idcust FROM customers WHERE username = ?";

            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param("s", $param_username);

                // mengatur parameter
                $param_username = trim($_POST["username"]);

                // mengeksekusi statement
                if($stmt->execute()){
                    // menyimpan data
                    $stmt->store_result();

                    if($stmt->num_rows == 1){
                        $username_err = "Username Telah Dipakai";
                    } else{
                        $username = trim($_POST["username"]);
                    }
                } else{
                    echo "Oops! Ada yang Salah. Silahkan Diulangi!";
                }

                $stmt->close();
            }
        }

        // validasi password
        if (empty(trim($_POST["password"]))) {
            $password_err = "Silahkan Memasukkan Password";
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Password Harus Memiliki Minimal 6 Karakter";
        } else {
            $password = trim($_POST["password"]);
        }

        // validasi confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Silahkan Konfirmasi Password";
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password Tidak Sesuai";
            }
        }

        // memeriksa error pada input sebelum data dimasukkan ke database
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

            // deklarasi statement
            $sql = "INSERT INTO customers (username, password) VALUES (?, ?)";

            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param("ss", $param_username, $param_password);

                // mengatur parameters
                $param_username = $username;

                //membuat password hash
                $param_password = password_hash($password, PASSWORD_DEFAULT);

                // mengeksekusi statement
                if($stmt->execute()){
                    // mengalihkan ke halaman login
                    header("location: login.php");
                } else{
                    echo "Oops! Ada yang Salah. Silahkan Diulangi!";
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
                            <label for="username" class="form-label">Username :</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" id="username" placeholder="Masukkan username">
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>

                        <div class="mb-3 fw-normal">
                            <label for="pwd" class="form-label">Password :</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" id="password" placeholder="Masukkan password">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>

                        <div class="mb-3 fw-normal">
                            <label for="pwd" class="form-label">Konfirmasi Password :</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'isinvalid' : ''; ?>" value="<?php echo $confirm_password; ?>" id="confirm_password" placeholder="Ulangi password">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>

                        <div class="vstack gap-2 col-md-2 mx-auto">
                            <button class="btn btn-success" type="submit">Sign Up</button>
                            <button class="btn btn-dark" type="reset">Reset</button>
                        </div>

                        <div class="row">
                            <div class="col">
                                <p class="text-end fw-normal" style="font-size: 12px;">Sudah memiliki akun? <a class="text-decoration-none link-warning" href="login.php">Log In</a>.</p>
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