<?php
    // menginisialisasi SESSION
    session_start();
    
    // mengatur ulang variabel SESSION
    $_SESSION = array();
    
    // menyelesaikan SESSION
    session_destroy();
    
    // mengalihkan ke halaman login
    header("location: ../../index.php");
    exit;
?>