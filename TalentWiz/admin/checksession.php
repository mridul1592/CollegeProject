<?php

//include_once '../include/settings.php';
if (!isset($_SESSION['project'])) {
    header('location:login.php');
} else if (isset($_SESSION['project']) && $_SESSION['project'] != "TalentWiz") {
    header('location:' . URL . 'admin/login.php');
}/**/ else if (isset($_SESSION['project']) && $_SESSION['project'] == "TalentWiz") {


    if (!isset($_SESSION['usertype'])) {
        header('location:' . URL . 'admin/login.php');
    } else if (isset($_SESSION['usertype']) &&
            ($_SESSION['usertype'] != "admin" && $_SESSION['usertype'] != "operator")) {
        header('location:' . URL . 'logout.php');
    }
}
//print_r($_SESSION);
?>