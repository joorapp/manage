<?php
require('db_config.php');

session_start();

$user_id = $_SESSION['user_id'];
$role_id = $_SESSION['role_id'];

if($role_id == 1){
    require('sa-permission.php');
} else if($role_id == 2){
    require('m-permission.php');
} else if($role_id == 3){
    require('am-permission.php');
} else if($role_id == 4){
    require('cro-permission.php');
} else if($role_id == 5){
    require('mar-permission.php');
}


$roleCondition = "";
if ($role_id == 5) {
    $roleCondition = " AND {$prefix}enquiries.assign_to = '$user_id' ";
}

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($conn, $_POST['search']['value']); // Search value

## Search query for both enquiries and users tables
$searchQuery = " ";
if($searchValue != ''){
    $searchQuery = " AND (enquiry_id LIKE '%".$searchValue."%' 
        OR {$prefix}enquiries.name LIKE '%".$searchValue."%' 
        OR {$prefix}enquiries.mobile LIKE '%".$searchValue."%' 
        OR company LIKE '%".$searchValue."%' 
        OR {$prefix}enquiries.email LIKE '%".$searchValue."%' 
        OR address LIKE '%".$searchValue."%' 
        OR city LIKE '%".$searchValue."%' 
		OR p_name LIKE '%".$searchValue."%' 
		OR s_name LIKE '%".$searchValue."%' 
        OR {$prefix}enquiries.zip_code LIKE '%".$searchValue."%' 
        OR comments LIKE '%".$searchValue."%' 
        -- Search by users table (aby_users and ato_users)
        OR aby_users.name LIKE '%".$searchValue."%' 
        OR ato_users.name LIKE '%".$searchValue."%' )";
}

## Total number of records without filtering
$sel = mysqli_query($conn, "SELECT COUNT(*) AS allcount FROM {$prefix}enquiries
    INNER JOIN {$prefix}products ON {$prefix}products.id = {$prefix}enquiries.product_id 
    INNER JOIN {$prefix}statuses ON {$prefix}statuses.id = {$prefix}enquiries.status_id WHERE {$prefix}enquiries.status_id = 4 AND 1 ".$roleCondition);
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn, "SELECT COUNT(*) AS allcount FROM {$prefix}enquiries 
    INNER JOIN {$prefix}products ON {$prefix}products.id = {$prefix}enquiries.product_id 
    INNER JOIN {$prefix}statuses ON {$prefix}statuses.id = {$prefix}enquiries.status_id 
    LEFT JOIN {$prefix}users AS aby_users ON aby_users.id = {$prefix}enquiries.user_id 
    LEFT JOIN {$prefix}users AS ato_users ON ato_users.id = {$prefix}enquiries.assign_to 
    WHERE {$prefix}enquiries.status_id = 4 AND 1 ".$roleCondition." ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT *, aby_users.name AS aby, ato_users.name AS ato, {$prefix}enquiries.id as ed_no, {$prefix}enquiries.name as enq_name, {$prefix}enquiries.mobile as enq_mobile, {$prefix}products.id as p_id FROM {$prefix}enquiries
    INNER JOIN {$prefix}products ON {$prefix}products.id = {$prefix}enquiries.product_id 
    INNER JOIN {$prefix}statuses ON {$prefix}statuses.id = {$prefix}enquiries.status_id 
    LEFT JOIN {$prefix}users AS aby_users ON aby_users.id = {$prefix}enquiries.user_id 
    LEFT JOIN {$prefix}users AS ato_users ON ato_users.id = {$prefix}enquiries.assign_to 
    WHERE {$prefix}enquiries.status_id = 4 AND 1 ".$roleCondition." ".$searchQuery." 
    ORDER BY ".$columnName." ".$columnSortOrder." 
    LIMIT ".$row.",".$rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

$serial = 0;
while ($row = mysqli_fetch_assoc($empRecords)) {    
    $serial++;

    $p_id = $row['p_id'];
    if($p_id == 1){ $p_name = '<span class="e">E</span><span class="bb">B</span><span class="a">A</span><span class="c">C</span> PRO'; }
    else if ($p_id == 2){ $p_name = '<span class="med">Med Reportr</span>'; }
    else if ($p_id == 3){ $p_name = '<span class="dentos">Dentos</span>'; }    
    
    $data[] = array(    
        "enquiry_id"=>$row['enquiry_id'],
    		"p_name" => $p_name,			
			"name" => $row['enq_name'],
			"company" => $row['company'],
			"mobile" => $row['enq_mobile'],
			"city" => $row['city'],			
			"demo" => '<a href="'.$row["demo"].'" target="_blank">'.substr($row["demo"], 0, 25).'</a>',
			"demo_date" => date('d-m-Y', strtotime($row['demo_date'])),			
			"comments" =>'<div class="toolti">'.ucwords(strtolower(substr($row['comments'], 0, 25))).'
			<span class="tooltiptext">'.ucwords(strtolower(wordwrap($row["comments"], 50,"<br>\n"))).'</span></div>',
        "user_id" => $row['aby'],
        "assign_to" => $row['ato'],
        "last_updated" => date('d-m-Y h:i A', strtotime($row['last_updated'])),
        "actions" =>'',    
    );

 $showEdit = ($edit_enq == 1 ) ? true : false;
			if ($showEdit) {
				$data[count($data) - 1]["actions"] .= '<a href="javascript:edit_id('.$row["ed_no"].')"><i class="mdi mdi-tooltip-edit"></i></a> ';
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