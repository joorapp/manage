<?php
require('db_config.php');

session_start();
$user_id = $_SESSION['user_id'];


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
	$searchQuery = " and (email like '%".$searchValue."%' or   date like '%".$searchValue."%' or ip like '%".$searchValue."%') ";
}

## Total number of records without filtering
$sel = mysqli_query($conn, "select count(*) as allcount from {$prefix}logins where 1");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn, "select count(*) as allcount from {$prefix}logins where 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select *, {$prefix}logins.id as ed_no from {$prefix}logins where 1 ".$searchQuery." order by id desc  limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

$start = $_POST['start'];
$serial = 0;
while ($row = mysqli_fetch_assoc($empRecords)) {	
	$serial++;	

	
    $data[] = array(	
			"ed_no"=>$serial + $start,
			"email"=>$row['email'],
			"date"=>date('d-m-Y h:i A', strtotime($row['date'])),
			"ip"=>$row['ip'],
    	);
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