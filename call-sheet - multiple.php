<?php 
require('header.php');
require('admin-sidebar.php');

$today_date_time = date("Y-m-d H:i:s");

if(isset($_POST['call_submit'])){
	
	for($i=0;$i<10;$i++){
	
	if($_POST['product_id'][$i] !=null && $_POST['company'][$i] != null 
	&& $_POST['mobile'][$i] !=null  && $_POST['address'][$i] !=null){
		
	$product_id = $_POST['product_id'][$i];
	$company = ucwords(strtolower($_POST['company'][$i]));	
	$mobile =  preg_replace('/\s+/', '', $_POST['mobile'][$i]);
	$address = $_POST['address'][$i];
	$status_id = $_POST['status_id'][$i];
		
	$sql2 = "INSERT INTO `{$prefix}enquiries`(`product_id`, `company`, `mobile`, `address`, `status_id`) VALUES
	('$product_id',  '$company',  '$mobile',  '$address', '$status_id')";
	
    $result_up = mysqli_query($conn, $sql2);
		}
	  }	
	}
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_calls" class="btn btn-inverse-info">+ Add Details</button>
                </div>            
              </div>
			  		  
			  <!-- Add call sheet modal starts -->			  
<div class="modal fade" id="add_calls" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:900px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="call-sheet" method="post" enctype="multipart/form-data">
				  <?php
				  for($i=0;$i<10;$i++){
					  ?>
					 <?php 
					 $sql30 = "SELECT * FROM {$prefix}products  order by id";
					 $result30 = mysqli_query($conn, $sql30); 													
					?>		
					<div class="form-group row">
					<div class="col-sm-3">
					  Enquiry for : <span class="mand">*</span>
							 <select   name="product_id[]"  id="product_id" class="select_dropdown" style="width:100%">
								<option value="">Select  product</option>
								<?php 
									if(mysqli_num_rows($result30) > 0){
									while($row30 = mysqli_fetch_assoc($result30)){ ?>
								<option value="<?php echo $row30['id']; ?>"><?php echo $row30['p_name']; ?></option>
								<?php }} ?>				
							</select>
						</div>
					 <div class="col-sm-3">
					  Company: <span class="mand">*</span>
                        <input type="text"  class="form-control"  placeholder="Company  name"  name="company[]" >
					  </div>					  
                      <div class="col-sm-3">
					  Mobile: <span class="mand">*</span>
					     <input type="text" class="form-control"   placeholder="Mobile" name="mobile[]" >
					  </div>
					<div class="col-sm-3">
					  Address:
					     <input type="text" class="form-control"   placeholder="Address" name="address[]" >
					  </div>					  
					 </div>	
					 <input type="number" class="form-control"  value="1" hidden  name="status_id[]" >
				  <?php } ?>
					
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
$sqlQuery = "SELECT * FROM {$prefix}enquiries where status_id = 1";
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
								  <th>Address</th>	
								  <th>Comments</th>								  
								  <th>Actions</th>
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
					{ data: 'address' },
					{ data: 'comments' },					
					 <?php if($edit_cus == 1 || $del_cus == 1){ ?>
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
        window.location.href='call-sheet?delete_id='+id;
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
	window.location.href = "call-sheet"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='call-sheet?edit_id='+id;
	     
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
	`email` = '".$_POST['email']."',  `address` = '".$_POST['address']."',   `product_id` = '".$_POST['product_id']."', `status_id` = '".$_POST['status_id']."',  `meeting_date` = '".$_POST['meeting_date']."',  `demo` = '".$_POST['demo']."', `demo_date` = '".$_POST['demo_date']."', `comments` = '".$_POST['comments']."'   WHERE id = '".$_POST['id']."' ";		
	mysqli_query($conn, $sql);	
	echo '<script> alert("Enquiry details has been updated.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "call-sheet"
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
                  <form class="forms-sample" action="call-sheet" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
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