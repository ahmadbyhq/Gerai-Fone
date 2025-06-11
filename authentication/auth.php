<?php
// session_start();

// if (!isset($_SESSION['user_id'])) {
//     header("Location: /dashboard/admin/login.php");
//     exit();
// }

    session_start();

    $timeout_duration = 900;

    if (!isset($_SESSION['user_id'])) {
        header("Location: /dashboard/admin/login.php");
        exit();
    }

    // Cek timeout session
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
        session_unset();   
        session_destroy();
        header("Location: /dashboard/admin/login.php?timeout=1");
        exit();
    }

    $_SESSION['LAST_ACTIVITY'] = time();

?>
