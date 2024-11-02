<?php

if (!isset($_SESSION['userid']) && !isset($_SESSION['usertype'])) {
    echo!isset($_SESSION);
    echo!isset($_SESSION['userid']);
    header('location:guest/index.php');
} elseif (isset($_SESSION['userid'])) {
    header('location:candidate/index.php');
}
?>