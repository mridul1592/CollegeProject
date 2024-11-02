<?php

include_once '../../include/settings.php';

$session = $_SESSION;
session_destroy();
session_start();
$_SESSION['project'] = $session['project'];
$_SESSION['userid'] = $session['userid'];
$_SESSION['usertype'] = $session['usertype'];
print_r($_SESSION);
header('location:' . URL . 'candidate/index.php?msg=finishedTest');
?>