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

$today_date_time = date("Y-m-d H:i:s");

$today_dt = date("Y-m-d H:i");
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">


<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$roleCondition = "";
if ($role_id == 5) {
    $roleCondition = " AND {$prefix}enquiries.assign_to = '$user_id' ";
}

$sqlQuery = "SELECT * FROM {$prefix}enquiries where status_id = 4".$roleCondition;
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords <=1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						  <h4 class="card-title">Using demo list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table">
							  <thead>
								<tr>
								  <th>Enq ID</th>
								  <th>Enquiry For</th>								  
								  <th>Name</th>
								  <th>Company</th>
								  <th>Mobile</th>
								  <th>City / Location</th>
								  <th>Demo Link</th>
								  <th>Demo Date</th>
								  <th>Comments</th>	
								  <th>Assigned By</th>									  
								  <th>Assigned To</th>
								  <th>Added / Updated</th>
								   <?php if($edit_enq == 1){ ?>
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
            $('#dept_table').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'ajax-demo-list.php'
                },
                'columns': [
					{ data: 'enquiry_id' },
					{ data: 'p_name' },			   	
					{ data: 'name' },
					{ data: 'company' },					
					{ data: 'mobile' },	
					{ data: 'city' },
					{ data: 'demo' },
					{ data: 'demo_date' },
					{ data: 'comments' },
					{ data: 'user_id' },	
					{ data: 'assign_to' },
					{ data: 'last_updated' },
					 <?php if($edit_enq == 1){ ?>
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
        window.location.href='sdemo-sheet?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}enquiries` SET `delete_status` = 1 WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Enquiry has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "sdemo-sheet"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='sdemo-sheet?edit_id='+id;
	     
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
		$('#edit_enquiry').modal('show');
		});
		</script>";
	}		
?>

<?php

if(isset($_POST['enquiry_update_submit'])){
	
		
		$sql = "UPDATE `{$prefix}enquiries` SET  `name` = '".ucwords(strtolower($_POST['name']))."',  `mobile` = '".preg_replace('/\s+/', '', $_POST['mobile'])."',  `company` = '".ucwords(strtolower($_POST['company']))."', 
	`email` = '".$_POST['email']."',  `address` = '".$_POST['address']."',  `city` = '".$_POST['city']."', `zip_code` = '".$_POST['zip_code']."',  `product_id` = '".$_POST['product_id']."', `status_id` = '".$_POST['status_id']."',  `meeting_date` = '".$_POST['meeting_date']."',  `demo` = '".$_POST['demo']."', `demo_date` = '".$_POST['demo_date']."', `comments` = '".$_POST['comments']."', `user_id` = '$user_id', `last_updated` = '".$_POST['last_updated']."'   WHERE id = '".$_POST['id']."' ";			
		mysqli_query($conn, $sql);	
		echo '<script> alert("Enquiry details has been updated.")</script>';
		 echo '<script type="text/javascript">
	window.location.href = "sdemo-sheet"
	</script>';
	
}
?>

<!-- Edit enquiry modal starts -->			  
<div class="modal fade" id="edit_enquiry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Demo Details - <?php echo $row['enquiry_id']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="sdemo-sheet" method="post" enctype="multipart/form-data">
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
						$sql32 = "SELECT * FROM {$prefix}products   order by id ";
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
               
                    <button type="submit" name="enquiry_update_submit" class="btn btn-info mr-2">Update</button>
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