<?php
    session_start();

    $timeout_duration = 900;

    if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'pelanggan') {
        header("Location: login-user.php");
        exit();
    }

    // Cek timeout session
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
        session_unset();   
        session_destroy();
        header("Location: login-user.php?timeout=1");
        exit();
    }

    $_SESSION['LAST_ACTIVITY'] = time();

?>
