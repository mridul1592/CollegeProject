<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "talentwiz";


$con = mysql_connect($host, $username, $password);
if (!$con) {
    echo '<font color=red>' . mysql_error() . '</font>';
}
$db = mysql_select_db($db);
if (!$db) {
    echo '<font color=red>' . mysql_error() . '</font>';
}

session_start();
ob_start();
$_SESSION["project"] = "TalentWiz";
//@date_default_timezone_set(@date_default_timezone_get());

define("URL", "http://localhost/mridul/_TalentWiz/TalentWiz/");
define("PATH", "D:/wamp/www/mridul/_TalentWiz/TalentWiz/");
?>