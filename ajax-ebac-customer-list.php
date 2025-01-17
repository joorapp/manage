<?php
require('db_config.php');

session_start();


$user_id = $_SESSION['user_id'];
$role_id = $_SESSION['role_id'];
$pid = $_SESSION['pid'];

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
	$searchQuery = " and (cust_id like '%".$searchValue."%'  or ver like '%".$searchValue."%'  or name like '%".$searchValue."%' or  email like '%".$searchValue."%' or mobile like '%".$searchValue."%' or zip_code like '%".$searchValue."%' or company like '%".$searchValue."%' or	status like '%".$searchValue."%' or	amount like '%".$searchValue."%')";
}


## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from {$prefix}customers where pro_id = 1 and delete_status = 0  and 1");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from {$prefix}customers  where pro_id = 1 and delete_status = 0 and  1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select *,  {$prefix}customers.id as ed_no from {$prefix}customers where pro_id = 1 and delete_status = 0  and 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();



$start = $_POST['start'];

$serial = 0;
while ($row = mysqli_fetch_assoc($empRecords)) {	
	$serial++;	
	
		 $ver = $row['ver'];
	 if($ver == 1){$ver = 'V 1.4.7';}else if ($ver == 2){$ver = 'V 2.4.7';} else if ($ver == 3){$ver = 'Enterprise 1.4.7';}
	 else if ($ver == 4){$ver = 'Enterprise 2.4.7';}  else if ($ver == 5){$ver = 'Enterprise 3.4.7';}  else if ($ver == 6){$ver = 'Premium 1.4.7';}  else if ($ver == 7){$ver = 'Premium 2.4.7';}  else if ($ver == 8){$ver = 'Premium 3.4.7';}
		 
		 $status = $row['status'];
		 if($status == 1){$status = '<label class="badge badge-success">Active</label>';}
		 else if ($status == 0){$status = '<label class="badge badge-danger">Inactive</label>';}
	
	$data[] = array(	
			"ed_no"=>$serial + $start,
    		"cust_id"=>$row['cust_id'],
			"ver"=>$ver,
			"hosted_date"=>date('d-m-Y', strtotime($row['hosted_date'])),
			"renewal_date"=>date('d-m-Y', strtotime($row['renewal_date'])),
			"years"=>$row['years'],
			"amount"=>$row['amount'],
			"name"=>$row['name'],
			"mobile"=>$row['mobile'],
			"email"=>$row['email'],			
			"company"=>$row['company'],	
			"login_link"=>'<a href="'.$row["login_link"].'" target="_blank">'.substr($row["login_link"], 0, 30).'</a>',	
			"status"=>$status,				
			"actions"=>'',	
    	);
		
	$showEdit = ($edit_cus == 1 ) ? true : false;
			if ($showEdit) {
				$data[count($data) - 1]["actions"] .= '<a href="javascript:edit_id('.$row["ed_no"].')"><i class="mdi mdi-tooltip-edit"></i></a> ';
			}

	$showDel = ($del_cus == 1 ) ? true : false;
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