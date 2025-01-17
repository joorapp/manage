<?php
require('db_config.php');

session_start();


$user_id = $_SESSION['user_id'];
$role_id = $_SESSION['role_id'];

if($role_id == 1){
require('sa-permission.php');
}else if($role_id == 2){
require('m-permission.php');
}else if($role_id == 3){
require('am-permission.php');
}else if($role_id == 4){
require('cro-permission.php');
}else if($role_id == 5){
require('mar-permission.php');
}


## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($conn,$_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " and (date like '%".$searchValue."%'  or cust_id like '%".$searchValue."%'	or  received like '%".$searchValue."%' or amount like '%".$searchValue."%')";
}


## Total number of records without filtering
$sel = mysqli_query($conn,"select  count(*) as allcount from {$prefix}cust_payments where delete_status = 0  ");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from {$prefix}cust_payments WHERE delete_status = 0 and 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select *, {$prefix}cust_payments.id as ed_no from {$prefix}cust_payments WHERE delete_status = 0 and 1".$searchQuery." order by
 ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

$start = $_POST['start'];
$serial = 0;

while ($row = mysqli_fetch_assoc($empRecords)) {	
	$serial++;		
	
	$data[] = array(	
			"ed_no"=>$serial + $start,
			"cust_id"=>$row['cust_id'],
    		"date"=>date('d-m-Y', strtotime($row['date'])),			
			"amount"=>$row['amount'],
			"received" =>$row['received'],	
			"remarks" =>$row['remarks'],
			"actions"=>'',	
    	);	
		
		$showEdit = ($edit_cus_pay == 1 ) ? true : false;
			if ($showEdit) {
				$data[count($data) - 1]["actions"] .= '<a href="javascript:edit_id('.$row["ed_no"].')"><i class="mdi mdi-tooltip-edit"></i></a> ';
			}

	$showDel = ($del_cus_pay == 1 ) ? true : false;
		if ($showDel) {
			$data[count($data) - 1]["actions"] .= ' | <a  href="javascript:delete_id('.$row["ed_no"].')"><i class="mdi mdi-delete-forever"></i></a>';
		}
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);

?>