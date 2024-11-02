<?php

//include_once '../include/settings.php';
if (!isset($_SESSION['project'])) {
    header('location:' . URL . 'guest/login.php');
} else if (isset($_SESSION['project']) && $_SESSION['project'] != "TalentWiz") {
    header('location:' . URL . 'guest/login.php');
}/**/ else if (isset($_SESSION['project']) && $_SESSION['project'] == "TalentWiz") {
    
    
    
    if (!isset($_SESSION['usertype'])) {
        header('location:' . URL . 'guest/login.php');
        
        
    } else if ((isset($_SESSION['usertype']) && $_SESSION['usertype'] != "candidate")) {
        header('location:' . URL . 'logout.php');
    }

    
}
//echo $_SESSION['usertype'];
//print_r($_SESSION);
?>