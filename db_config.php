<?php
date_default_timezone_set('Asia/Kolkata');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "company_mgmt";

$conn= mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$fmt = numfmt_create('en_IN', NumberFormatter::CURRENCY);

$prefix = "com_";
?>
