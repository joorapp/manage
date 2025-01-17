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
	$searchQuery = " and (name like '%".$searchValue."%'  or role_name like '%".$searchValue."%'
	or  email like '%".$searchValue."%' or mobile like '%".$searchValue."%' or zip_code like '%".$searchValue."%') ";
}


## Total number of records without filtering

$sel = mysqli_query($conn,"select count(*) as allcount from {$prefix}users inner join {$prefix}user_roles on  {$prefix}user_roles.id = {$prefix}users.role_id  where {$prefix}users.delete_status = 0 and {$prefix}users.id !=1 and 1");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from {$prefix}users inner join {$prefix}user_roles on {$prefix}user_roles.id = {$prefix}users.role_id  where {$prefix}users.delete_status = 0  and {$prefix}users.id !=1 and  1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select *,  {$prefix}users.id as ed_no from {$prefix}users inner join {$prefix}user_roles on {$prefix}user_roles.id = {$prefix}users.role_id  where {$prefix}users.delete_status = 0  and {$prefix}users.id !=1  and 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();



$start = $_POST['start'];

$serial = 0;
while ($row = mysqli_fetch_assoc($empRecords)) {	
	$serial++;	
	
	$photo = $row['photo'];
	if(!empty($photo)){ $photo = '<img class="hover_big" src="'.$row['photo'].'">';} else
	{$photo = '<img class="hover_big" src="user-photos/1default.jpg">';}
	
	
	$role_id = $row['role_id'];	
	if($role_id == 2) { $role_id = '<label class="badge badge-success">'.$row['role_name'].'</label>'; }
	elseif($role_id == 3) { $role_id = '<label class="badge badge-warning">'.$row['role_name'].'</label>'; }
	elseif($role_id == 4) { $role_id = '<label class="badge badge-info">'.$row['role_name'].'</label>'; }
	elseif($role_id == 5) { $role_id = '<label class="badge badge-primary">'.$row['role_name'].'</label>'; }
	
	
	$status = $row['status'];
	if($status == 1)	 { $status = '<label class="badge badge-success">Active</label>'; }
	elseif($status == 0) { $status = '<label class="badge badge-danger">Inactive</label>'; }

	
	$data[] = array(	
			"ed_no"=>$serial + $start,    		
			"name"=>$row['name'],
			"mobile"=>$row['mobile'],
			"email"=>$row['email'],	
			"role_id"=>$role_id,				
			"status"=>$status,	
			"photo"=>$photo,   	
			"actions"=>'<a href="javascript:edit_id('.$row["ed_no"].')"><i class="mdi mdi-tooltip-edit"></i></a> |
			<a href="javascript:delete_id('.$row["ed_no"].')"><i class="mdi mdi-delete-forever"></i></a>',	
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