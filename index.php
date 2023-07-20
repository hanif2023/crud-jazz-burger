<?php
    session_start();

    include __DIR__ . '/config/config.php';

    include_once __DIR__ . '/template/header.php';
    include_once __DIR__ . '/template/navbar.php';

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if ($page === 'beranda') {
            include_once __DIR__ . "/user/page/beranda.php";
        } elseif ($page === 'profil') {
            include_once __DIR__ . "/user/page/profile.php";
        }
    } else {
        include_once __DIR__ . "/user/page/beranda.php";
    }

    include_once __DIR__ . '/template/footer.php';
?>