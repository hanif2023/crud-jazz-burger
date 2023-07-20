<?php
    session_start();

    include __DIR__ . '/../../config/config.php';

    // Define variables and initialize with empty values
    $new_password = $confirm_password = "";
    $new_password_err = $confirm_password_err = "";
    
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        // Validate new password
        if(empty(trim($_POST["new_password"]))){
            $new_password_err = "Please enter the new password.";     
        } elseif(strlen(trim($_POST["new_password"])) < 6){
            $new_password_err = "Password must have atleast 6 characters.";
        } else{
            $new_password = trim($_POST["new_password"]);
        }
        
        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Please confirm the password.";
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($new_password_err) && ($new_password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }
        
        // Check input errors before updating the database
        if(empty($new_password_err) && empty($confirm_password_err)){

            // Prepare an update statement
            $sql = "UPDATE customers SET password=? WHERE username=?";
            
            if($stmt = $mysqli->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("ss", $param_password, $param_username);
                
                // Set parameters
                $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                $param_username = $_SESSION["username"];
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Password updated successfully. Destroy the session, and redirect to login page
                    session_destroy();
                    header("location: login.php");
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                $stmt->close();
            }
        }
        // Close connection
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
                        <div class="mb-3 fw-normal">
                            <label for="pwd" class="form-label">Password Baru :</label>
                            <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>" placeholder="Masukkan password baru">
                            <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                        </div>

                        <div class="mb-3 fw-normal">
                            <label for="pwd" class="form-label">Konfirmasi Password baru :</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" placeholder="Ulangi password baru">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>

                        <div class="vstack gap-2 col-md-2 mx-auto">
                            <button class="btn btn-success" type="submit">Save</button>
                            <button class="btn btn-dark" type="reset">Reset</button>
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