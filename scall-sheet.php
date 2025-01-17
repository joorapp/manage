<?php 
session_start();
$role_id = $_SESSION['role_id'];
$user_id = $_SESSION['user_id'];

if($role_id == 1){
require('sa-permission.php');
require('sheader.php');
require('sadmin-sidebar.php');
}elseif($role_id == 2){
require('m-permission.php');
require('mheader.php');
require('manager-sidebar.php');	
}elseif($role_id == 3){
require('am-permission.php');
require('aheader.php');
require('accountm-sidebar.php');	
}elseif($role_id == 4){
require('cro-permission.php');
require('croheader.php');
require('cro-sidebar.php');	
}elseif($role_id == 5){
require('mar-permission.php');
require('marheader.php');
require('marketer-sidebar.php');	
}



$today_dt = date("Y-m-d H:i");

if(isset($_POST['call_submit'])){
	
	$enquiry_id = $_POST['enquiry_id'];	
	$product_id = $_POST['product_id'];
	$company = ucwords(strtolower($_POST['company']));	
	$mobile =  preg_replace('/\s+/', '', $_POST['mobile']);
	$address = $_POST['address'];
	$city = $_POST['city'];
	$zip_code = $_POST['zip_code'];
	$status_id = $_POST['status_id'];
	$assign_to = $_POST['assign_to'];
	$last_updated = $_POST['last_updated'];
		
	$sql2 = "INSERT INTO `{$prefix}enquiries` (`enquiry_id`, `product_id`, `company`, `mobile`, `address`, `city`, `zip_code`, `status_id`, `user_id`, `assign_to`, `last_updated`) VALUES
	('$enquiry_id', '$product_id',  '$company',  '$mobile',  '$address', '$city', '$zip_code', '$status_id', '$user_id',
	'$assign_to', '$last_updated')";
	
    $result_up = mysqli_query($conn, $sql2);
		  	
	}
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($add_enq == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_calls" class="btn btn-inverse-info">+ Add Details</button>
                </div>            
			</div> <?php } ?>
			  
  <?php 
	$sql23 = "SELECT enquiry_id  FROM {$prefix}enquiries  order by enquiry_id desc";
	$result23 = mysqli_query($conn, $sql23); 
	if(mysqli_num_rows($result23) > 0){
	$row23 = mysqli_fetch_assoc($result23);	
	$enquiry_id = $row23['enquiry_id'];
	$new_enquiry_id = $enquiry_id+1;
	}	
	else{
	$new_enquiry_id = 2001;	
	}
 ?>	
			  		  
			  <!-- Add call sheet modal starts -->			  
<div class="modal fade" id="add_calls" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:900px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Details - <?php echo $new_enquiry_id; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="scall-sheet" method="post" enctype="multipart/form-data">
	<input type="number" class="form-control"  name="enquiry_id" value="<?php echo $new_enquiry_id; ?>" hidden required>
	<input type="datetime-local" class="form-control"  name="last_updated" value="<?php echo $today_dt; ?>" hidden required>
					 <?php 
					 $sql30 = "SELECT * FROM {$prefix}products where status = 1 order by id";
					 $result30 = mysqli_query($conn, $sql30); 													
					?>		
					<div class="form-group row">
					<div class="col-sm-4">
					  Enquiry for : <span class="mand">*</span>
							 <select  required name="product_id"  id="product_id" class="select_dropdown" style="width:100%">
								<option value="">Select  product</option>
								<?php 
									if(mysqli_num_rows($result30) > 0){
									while($row30 = mysqli_fetch_assoc($result30)){ ?>
								<option value="<?php echo $row30['id']; ?>"><?php echo $row30['p_name']; ?></option>
								<?php }} ?>				
							</select>
						</div>
					 <div class="col-sm-4">
					  Company : <span class="mand">*</span>
                        <input type="text"  class="form-control" required  placeholder="Company  name"  name="company" >
					  </div>					  
                      <div class="col-sm-4">
					  Mobile : <span class="mand">*</span>
					     <input type="text" class="form-control"  required placeholder="Mobile" name="mobile" >
					  </div>					
					 </div>	
					 
					 <div class="form-group row">
						<div class="col-sm-5">
					  City / Location : <span class="mand">*</span>
					     <input type="text" class="form-control" required   placeholder="Eg: Cochin, Kalloor" name="city" >
					  </div>

					 <?php 
					 $sql33 = "SELECT *, {$prefix}users.id as uid  FROM {$prefix}users inner join {$prefix}user_roles on  {$prefix}user_roles.id = {$prefix}users.role_id  where {$prefix}users.delete_status = 0 and {$prefix}users.role_id in(2, 5) order by {$prefix}users.id";
					 $result33 = mysqli_query($conn, $sql33); 													
					?>	
					<div class="col-sm-7">
					  Assign to : <span class="mand">*</span>
							 <select  required name="assign_to"  id="assign_to" class="select_dropdown" style="width:100%">
								<option value="">Select one</option>
								<?php 
									if(mysqli_num_rows($result33) > 0){
									while($row33 = mysqli_fetch_assoc($result33)){ ?>
								<option value="<?php echo $row33['uid']; ?>"><?php echo $row33['name'].' - '.$row33['role_name']; ?></option>
								<?php }} ?>				
							</select>
						</div>
					 </div>
					 
					 
					 
					 <div class="form-group row">
					 	 <div class="col-sm-9">
					  Address :
                        <input type="text"  class="form-control"  placeholder="Address"  name="address" >
					    </div>					  
                      <div class="col-sm-3">
					  ZIP Code : 
					     <input type="number" class="form-control"   placeholder="ZIP Code" name="zip_code" >
					  </div>
					 </div>	
					 
					 
					 <input type="number" class="form-control"  value="1" hidden  name="status_id" >
				
					
                    <button type="submit" name="call_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add enquiry modal ends -->



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$roleCondition = "";
if ($role_id == 5) {
    $roleCondition = " AND {$prefix}enquiries.assign_to = '$user_id' ";
}

$sqlQuery = "SELECT * FROM {$prefix}enquiries where status_id = 1".$roleCondition;
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords <=1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						  <h4 class="card-title">Call sheet list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table1">
							  <thead>
								<tr>
								  <th>Enq ID</th>
								  <th>Enquiry For</th>  
								  <th>Company</th>								 
								  <th>Mobile</th>
								  <th>City / Location</th>	
								  <th>Comments</th>	
								  <th>Assigned By</th>									  
								  <th>Assigned To</th>
								  <th>Added / Updated</th>
								 <?php if($edit_enq == 1 || $del_enq == 1){ ?>
								  <th>Actions</th>
									<?php } ?>
								</tr>
							  </thead>							 
							</table>							
						  </div>
						</div>
					  </div>
				  </div>
			  </div>			  
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
		
 <script>
        $(document).ready(function(){
            $('#dept_table1').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'ajax-call-list.php'
                },
                'columns': [
					{ data: 'enquiry_id' },
					{ data: 'p_name' },				   	
					{ data: 'company' },			
					{ data: 'mobile' },						
					{ data: 'city' },
					{ data: 'comments' },
					{ data: 'user_id' },	
					{ data: 'assign_to' },
					{ data: 'last_updated' },						
				 <?php if($edit_enq == 1 || $del_enq == 1){ ?>
					{ data: 'actions' },
					 <?php } ?>
					],
				 'columnDefs': [ {
					'targets': [-1], // column index (start from 0)
					'orderable': false, // set orderable false for selected columns
				 }]
            });
        });
  </script>
		
		



<script type="text/javascript">
function delete_id(id)
{
     if(confirm('Are you sure you want to delete this record?'))
     {
        window.location.href='scall-sheet?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "DELETE from `{$prefix}enquiries`  WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Call details has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "scall-sheet"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='scall-sheet?edit_id='+id;
	     
}
</script>			  
			  <?php
if(isset($_GET['edit_id'])){
	
	$sql = "SELECT * FROM {$prefix}enquiries WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_calls').modal('show');
		});
		</script>";
	}		
?>

<?php

if(isset($_POST['call_update_submit'])){
		
	$sql = "UPDATE `{$prefix}enquiries` SET  `name` = '".ucwords(strtolower($_POST['name']))."',  `mobile` = '".preg_replace('/\s+/', '', $_POST['mobile'])."',  `company` = '".ucwords(strtolower($_POST['company']))."', 
	`email` = '".$_POST['email']."',  `address` = '".$_POST['address']."',  `city` = '".$_POST['city']."', `zip_code` = '".$_POST['zip_code']."', `product_id` = '".$_POST['product_id']."', `status_id` = '".$_POST['status_id']."',  `meeting_date` = '".$_POST['meeting_date']."',  `demo` = '".$_POST['demo']."', `demo_date` = '".$_POST['demo_date']."', `comments` = '".$_POST['comments']."', `user_id` = '$user_id', `assign_to` = '".$_POST['assign_to']."',  `last_updated` = '".$_POST['last_updated']."'   WHERE id = '".$_POST['id']."' ";		
	mysqli_query($conn, $sql);	
	echo '<script> alert("Enquiry details has been updated.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "scall-sheet"
	</script>';
	
}
?>

<!-- Edit call details modal starts -->			  
<div class="modal fade" id="edit_calls" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Call Details - <?php echo $row['enquiry_id']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="scall-sheet" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  	<input type="datetime-local" class="form-control"  name="last_updated" value="<?php echo $today_dt; ?>" hidden required>
				  
					  <div class="form-group row">				
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                  <input type="text"  class="form-control" value="<?php echo $row['name']; ?>"  placeholder="Name"  name="name" required>
					  </div>
					<div class="col-sm-6">
					   Company: <span class="mand">*</span>
                  <input type="text"  class="form-control" value="<?php echo $row['company']; ?>"  placeholder="Company name"  name="company" required>
					  </div>                     				 
					 </div>					 
					   
					<div class="form-group row">
					 <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
	<input type="text"  class="form-control" value="<?php echo $row['mobile']; ?>"  placeholder="Mobile" name="mobile" required>
					  </div>
					<div class="col-sm-6">
					  Email: 
                        <input type="email" class="form-control" value="<?php echo $row['email']; ?>"  name="email" placeholder="Email" >
					  </div>									  
					 </div>	

					<div class="form-group row">
					<?php 
						$sql32 = "SELECT * FROM {$prefix}products   where status = 1 order by id ";
						$result32 = mysqli_query($conn, $sql32);										
						?>	
					               
						  <div class="col-sm-6">	
							Enquiry for : <span class="mand">*</span>
							 <select required  name="product_id"  id="product_id" class="select_dropdown" style="width:100%">
								<option value="">Select  product</option>
								<?php if (mysqli_num_rows($result32) > 0) {
								while($row32 = mysqli_fetch_assoc($result32)) {
								$selected = "";
							if ($row32['id'] == $row['product_id'])
							$selected = "selected";										
									?>
							<option class="" value="<?php echo $row32['id']; ?>" <?php echo $selected; ?>><?php echo $row32['p_name']; }} ?></option>						
							</select>
						  </div>
						<?php 
						$sql33 = "SELECT * FROM {$prefix}statuses    order by id ";
						$result33 = mysqli_query($conn, $sql33);										
						?>	
					               
						  <div class="col-sm-6">	
							Status  : <span class="mand">*</span>
							 <select required  name="status_id"  id="status_id" class="select_dropdown" style="width:100%">
								<option value="">Select  status</option>
								<?php if (mysqli_num_rows($result33) > 0) {
								while($row33 = mysqli_fetch_assoc($result33)) {
								$selected = "";
							if ($row33['id'] == $row['status_id'])
							$selected = "selected";										
									?>
							<option class="" value="<?php echo $row33['id']; ?>" <?php echo $selected; ?>><?php echo $row33['s_name']; }} ?></option>						
							</select>
						  </div>
					</div>
					
					 <div class="form-group row">
						 <div class="col-sm-12">
						Address  : <span class="mand">*</span>
						 <input type="text" class="form-control" value="<?php echo $row['address']; ?>" placeholder="Address"  name="address" required>
						</div>
						</div>
						
					 <div class="form-group row">
					 <div class="col-sm-6">
						City / Location  : <span class="mand">*</span>
						 <input type="text" class="form-control" value="<?php echo $row['city']; ?>" placeholder="City / Location"  name="city" required>
						</div>
						 <div class="col-sm-6">
						ZIP Code : 
					     <input type="number" class="form-control"  value="<?php echo $row['zip_code']; ?>"  placeholder="ZIP Code" name="zip_code" >
					  </div>
					    </div>
					   <div class="form-group row">
					 <div class="col-sm-6">
					   Meeting date: (mm / dd / yy)
			<input type="datetime-local" step="any" class="form-control" value="<?php echo $row['meeting_date']; ?>"  
			name="meeting_date" >
					  </div>
					   <?php 
					 $sql33 = "SELECT *, {$prefix}users.id as uid  FROM {$prefix}users inner join {$prefix}user_roles on  {$prefix}user_roles.id = {$prefix}users.role_id  where {$prefix}users.delete_status = 0 and {$prefix}users.role_id in(2, 5) order by {$prefix}users.id";
					 $result33 = mysqli_query($conn, $sql33); 													
					?>	
					<div class="col-sm-6">
					  Assign to : <span class="mand">*</span>
							 <select  required name="assign_to" class="select_dropdown" style="width:100%">
								<option value="">Select one</option>
								<?php 
									if(mysqli_num_rows($result33) > 0){
									while($row33 = mysqli_fetch_assoc($result33)) {
								$selected = "";
							if ($row33['uid'] == $row['assign_to'])
							$selected = "selected";										
									?>
							<option class="" value="<?php echo $row33['uid']; ?>" <?php echo $selected; ?>><?php echo $row33['name'].' - '.$row33['role_name']; }} ?></option>								
							</select>
						</div>
					  </div>
					
					 <div class="form-group row">
						<div class="col-sm-6">
						Demo link  :
		<input type="text" class="form-control" value="<?php echo $row['demo']; ?>" placeholder="Demo link"  name="demo">
						</div>
						<div class="col-sm-6">
						Demo date  : (mm / dd / yy)
		 <input type="date" class="form-control" value="<?php echo $row['demo_date']; ?>"  name="demo_date">
						</div>
					</div>

					  <div class="form-group row">
					   <div class="col-sm-12">
						Comments: 
 <textarea class="form-control"  name="comments" rows="4"><?php echo $row['comments']; ?></textarea>
					  </div>
						</div>
               
               
                    <button type="submit" name="call_update_submit" class="btn btn-info mr-2">Update</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     

<!--  Edit enquiry modal ends -->


 <?php require('footer.php'); ?>