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

$today_date = date("Y-m-d");


if(isset($_POST['payment_submit'])){
	
	$cust_id =  $_POST['cust_id'];
	$date = $_POST['date'];	
	$amount = $_POST['amount'];
	$received = $_POST['received'];
	$remarks = $_POST['remarks'];
		
		
	$sql2 ="INSERT INTO `{$prefix}cust_payments`(`cust_id`, `date`, `amount`, `received`, `remarks`) VALUES
	('$cust_id', '$date', '$amount', '$received', '$remarks')";
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a payment.")</script>';

}
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($add_cus_pay == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_pay" class="btn btn-inverse-info">+ Add Customer Payment</button>
                </div>            
			</div><?php } ?>
			  
		  
			  <!-- Add payment modal starts -->			  
<div class="modal fade" id="add_pay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Customer Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="scustomer-payments" method="post" enctype="multipart/form-data">
						
							
					<div class="form-group row">
						 <?php 
					 $sql30 = "SELECT {$prefix}customers.cust_id, {$prefix}customers.name, {$prefix}customers.company, {$prefix}customers.mobile FROM {$prefix}customers  where delete_status =0  order by cust_id ";
					 $result30 = mysqli_query($conn, $sql30); 													
					?>                 
				  <div class="col-sm-12">	
					Customer : <span class="mand">*</span>
					 <select required  name="cust_id"   class="select_dropdown" style="width:100%">
						<option value="">Select  customer</option>
						<?php 
							if(mysqli_num_rows($result30) > 0){
							while($row30 = mysqli_fetch_assoc($result30)){ ?>
<option value="<?php echo $row30['cust_id']; ?>"><?php echo $row30['cust_id'].' - '.$row30['name'].' - '.$row30['mobile'].' - '.
 $row30['company']; ?></option>
						<?php }} ?>				
					</select>
				  </div>
                    </div>
						
					<div class="form-group row">			
					 <div class="col-sm-6">
					   Date: <span class="mand">*</span> (mm / dd / yy)
                        <input type="date"  class="form-control" id="date"  name="date" value="<?php echo $today_date; ?>"  required>
					  </div>					  
                      <div class="col-sm-6">
					  Amount: <span class="mand">*</span>
					     <input type="number" min="0" step="any" class="form-control"  placeholder="Received amount" name="amount" required>
					  </div>				 
					 </div>
		
					 <div class="form-group row">                      
                      <div class="col-sm-12">
					  Received from / for: <span class="mand">*</span>
                        <input type="text" class="form-control"  name="received" placeholder="Received from / for" required>
					  </div>
					   </div>
					   
					 <div class="form-group row"> 
					   <div class="col-sm-12">
						Remarks : <span class="mand">*</span>
						 <input type="text" class="form-control" id="remarks" placeholder="Remarks if any"  name="remarks" required>
						</div>
					 </div>		
										
                    <button type="submit" name="payment_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add payment modal ends -->



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$sqlQuery = "SELECT * FROM {$prefix}cust_payments where delete_status = 0 ";
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						  <h4 class="card-title">Customer payment list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table">
							  <thead>
								<tr>
								  <th>#</th>
								  <th>Customer ID</th>
								  <th>Payment Date</th>								  
								  <th>Amount</th>								    
								  <th>Received  From / For</th>
								  <th>Remarks</th>
								 <?php if($edit_cus_pay == 1 || $del_cus_pay == 1){ ?>
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
                    'url':'ajax-cust-payment-list.php'
                },
                'columns': [
					{ data: 'ed_no' },
					{ data: 'cust_id' },
					{ data: 'date' },
				    { data: 'amount' },
					{ data: 'received' },
					{ data: 'remarks' },				
					<?php if($edit_cus_pay == 1 || $del_cus_pay == 1){ ?>
					 { data: 'actions' },
					 <?php } ?>
                ],
				 'columnDefs': [ {
					'targets': [4,5,-1], // column index (start from 0)
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
        window.location.href='scustomer-payments?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}cust_payments` set delete_status = 1 WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Customer payment details has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "scustomer-payments"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='scustomer-payments?edit_id='+id;
	     
}
</script>			  
			  <?php
if(isset($_GET['edit_id'])){
	
	$sql = "SELECT * FROM {$prefix}cust_payments WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_pay').modal('show');
		});
		</script>";
			}		
?>

<?php

if(isset($_POST['payment_update_submit'])){
	
	$sql = "UPDATE `{$prefix}cust_payments` SET    `date` = '".$_POST['date']."',  `amount` = '".$_POST['amount']."',
	`received` = '".$_POST['received']."', `remarks` = '".$_POST['remarks']."' WHERE id = '".$_POST['id']."'";
	mysqli_query($conn, $sql);	
echo '<script> alert("Payment details has been updated.")</script>';

}
?>

<!-- Edit customer payment modal starts -->			  
<div class="modal fade" id="edit_pay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Payment Details - <?php echo $row['cust_id']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="scustomer-payments" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
				<div class="form-group row">			
					 <div class="col-sm-6">
					   Date: <span class="mand">*</span> (mm / dd / yy)
                        <input type="date"  class="form-control" id="date"  name="date" value="<?php echo $row['date']; ?>"  required>
					  </div>					  
                      <div class="col-sm-6">
					  Amount: <span class="mand">*</span>
					     <input type="number" min="0" step="any" class="form-control"  value="<?php echo $row['amount']; ?>" placeholder="Received amount" name="amount" required>
					  </div>				 
					 </div>
		
					 <div class="form-group row">                      
                      <div class="col-sm-12">
					  Received from / for: <span class="mand">*</span>
                        <input type="text" class="form-control"  value="<?php echo $row['received']; ?>" name="received" placeholder="Received from / for" required>
					  </div>
					   </div>
					   
					 <div class="form-group row"> 
					   <div class="col-sm-12">
						Remarks : <span class="mand">*</span>
						 <input type="text" class="form-control" id="remarks" value="<?php echo $row['remarks']; ?>" placeholder="Remarks if any"  name="remarks" required>
						</div>
					 </div>	
				
               
                    <button type="submit" name="payment_update_submit" class="btn btn-info mr-2">Update</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     

<!--  Edit payment modal ends -->


 <?php require('footer.php'); ?>