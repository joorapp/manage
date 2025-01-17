<?php
require('db_config.php');

$sql25 = "select * from {$prefix}permissions where role_id = 2";
$res25 = mysqli_query($conn, $sql25);
$row25 = mysqli_fetch_array($res25);

$dashboard = $row25['dashboard'];
$add_enq = $row25['add_enq'];
$edit_enq = $row25['edit_enq'];
$view_enq = $row25['view_enq'];
$del_enq = $row25['del_enq'];
$add_cus = $row25['add_cus'];
$edit_cus = $row25['edit_cus'];
$view_cus = $row25['view_cus'];
$del_cus = $row25['del_cus'];
$add_cus_pay = $row25['add_cus_pay'];
$edit_cus_pay = $row25['edit_cus_pay'];
$view_cus_pay = $row25['view_cus_pay'];
$del_cus_pay = $row25['del_cus_pay'];
$add_misc_inc = $row25['add_misc_inc'];
$edit_misc_inc = $row25['edit_misc_inc'];
$view_misc_inc = $row25['view_misc_inc'];
$del_misc_inc = $row25['del_misc_inc'];
$add_misc_exp = $row25['add_misc_exp'];
$edit_misc_exp = $row25['edit_misc_exp'];
$view_misc_exp = $row25['view_misc_exp'];
$del_misc_exp = $row25['del_misc_exp'];
$send_mar_temp = $row25['send_mar_temp'];
$edit_mar_temp = $row25['edit_mar_temp'];
$view_mar_temp = $row25['view_mar_temp'];
$del_mar_temp = $row25['del_mar_temp'];
$send_sal_temp = $row25['send_sal_temp'];
$view_sal_temp = $row25['view_sal_temp'];
$del_sal_temp = $row25['del_sal_temp'];
$renewals = $row25['renewals'];
$last_logins = $row25['last_logins'];
$add_demo_cust = $row25['add_demo_cust'];
$edit_demo_cust = $row25['edit_demo_cust'];
$del_demo_cust = $row25['del_demo_cust'];
$view_demo_cust = $row25['view_demo_cust'];
$add_pro = $row25['add_pro'];
$edit_pro = $row25['edit_pro'];
$view_pro = $row25['view_pro'];
$del_pro = $row25['del_pro'];
?>