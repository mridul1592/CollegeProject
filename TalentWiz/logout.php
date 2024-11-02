<?php

include_once 'include/settings.php';
$userType = $_SESSION['usertype'];
session_destroy();
//die ($userType == 'candidate');
if (strcmp($userType,'candidate')==0) {
    header('location:guest/login.php');
} else {
    header('location:admin/login.php');
}
?>