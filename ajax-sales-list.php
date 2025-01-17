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
	$searchQuery = " and (cust_id like '%".$searchValue."%'  or date_time like '%".$searchValue."%'  or email like '%".$searchValue."%' or business_name like '%".$searchValue."%') ";
}


## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from {$prefix}sales_templates where delete_status = 0 and  1");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from {$prefix}sales_templates  where delete_status = 0 and 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select *, {$prefix}sales_templates.id as ed_no from {$prefix}sales_templates  where  delete_status = 0 and  1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();


$start = $_POST['start'];
$serial = 0;
while ($row = mysqli_fetch_assoc($empRecords)) {	
	$serial++;	

	
	$data[] = array(	
			"id"=>$serial + $start,
			"cust_id"=>$row['cust_id'],
    		"date_time"=> date('d-m-Y g:i:s A', strtotime($row['date_time'])),
			"email"=>$row['email'],			
			"business_name"=>$row['business_name'],
			"login_link"=>'<a href="'.$row["login_link"].'" target="_blank">'.$row["login_link"].'</a>' ,
			"sent"=>$row['sent'],
			"actions"=>'',	
    	);
		$showDel = ($del_sal_temp == 1 ) ? true : false;
		if ($showDel) {
			$data[count($data) - 1]["actions"] .= '<a  href="javascript:delete_id('.$row["ed_no"].')"><i class="mdi mdi-delete-forever"></i></a>';
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