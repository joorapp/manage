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


if(isset($_POST['income_submit'])){
	
	$date = $_POST['date'];
	$i_amount = $_POST['i_amount'];
	$received_from = $_POST['received_from'];
	$remarks = $_POST['remarks'];	
		
	$sql2 ="INSERT INTO `{$prefix}incomes`(`date`, `i_amount`, `received_from`, `remarks`, `user_id`) VALUES
	('$date', '$i_amount', '$received_from', '$remarks', '$user_id')";
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added an Income.")</script>';

}
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($add_misc_inc == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_income" class="btn btn-inverse-info">+ Add Income</button>
                </div>            
			</div><?php } ?>
			  
		  
			  <!-- Add Income modal starts -->			  
<div class="modal fade" id="add_income" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Income</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="smanage-incomes" method="post" enctype="multipart/form-data">
								
					<div class="form-group row">			
					 <div class="col-sm-6">
					   Date: <span class="mand">*</span> (mm / dd / yy)
                        <input type="date"  class="form-control" id="date"  name="date" value="<?php echo $today_date; ?>"  required>
					  </div>					  
                      <div class="col-sm-6">
					  Amount: <span class="mand">*</span>
					     <input type="number" min="0" step="any" class="form-control" id="i_amount"  placeholder="Received amount" name="i_amount" required>
					  </div>				 
					 </div>
		
					 <div class="form-group row">                      
                      <div class="col-sm-12">
					  Received from / for: <span class="mand">*</span>
                        <input type="text" class="form-control" id="received_from"  name="received_from" placeholder="Received from / for" required>
					  </div>
					   </div>
					   
					 <div class="form-group row"> 
					   <div class="col-sm-12">
						Remarks :
						 <input type="text" class="form-control" id="remarks" placeholder="Remarks if any"  name="remarks" >
						</div>
					 </div>		
										
                    <button type="submit" name="income_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add Income modal ends -->



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$sqlQuery = "SELECT * FROM {$prefix}incomes where delete_status = 0";
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						  <h4 class="card-title">Income list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table">
							  <thead>
								<tr>
								  <th>#</th>
								  <th>Date</th>								  
								  <th>Amount</th>								    
								  <th>Received  From / For</th>
								  <th>Remarks</th>
								  <?php if($edit_misc_inc == 1 || $del_misc_inc == 1){ ?>
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
                    'url':'ajax-income-list.php'
                },
                'columns': [
					{ data: 'id' },
					{ data: 'date' },
				    { data: 'i_amount' },
					{ data: 'received_from' },
					{ data: 'remarks' },				
				<?php if($edit_misc_inc == 1 || $del_misc_inc == 1){ ?>
					  { data: 'actions' },
					 <?php } ?>
                ],
				 'columnDefs': [ {
					'targets': [4,-1], // column index (start from 0)
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
        window.location.href='smanage-incomes?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}incomes` set delete_status = 1  WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Income details has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "smanage-incomes"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='smanage-incomes?edit_id='+id;
	     
}
</script>			  
			  <?php
if(isset($_GET['edit_id'])){
	
	$sql = "SELECT * FROM {$prefix}incomes WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_income').modal('show');
		});
		</script>";
			}		
?>

<?php

if(isset($_POST['income_update_submit'])){
	
	$sql = "UPDATE `{$prefix}incomes` SET    `date` = '".$_POST['date']."',  `i_amount` = '".$_POST['i_amount']."',
	`received_from` = '".$_POST['received_from']."', `remarks` = '".$_POST['remarks']."', `user_id` = '$user_id' WHERE id = '".$_POST['id']."'";
	mysqli_query($conn, $sql);	
echo '<script> alert("Income details has been updated.")</script>';

}
?>

<!-- Edit Income modal starts -->			  
<div class="modal fade" id="edit_income" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Income Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="smanage-incomes" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
				<div class="form-group row">			
					 <div class="col-sm-6">
					   Date: <span class="mand">*</span> (mm / dd / yy)
                        <input type="date"  class="form-control" id="date"  name="date" value="<?php echo $row['date']; ?>"  required>
					  </div>					  
                      <div class="col-sm-6">
					  Amount: <span class="mand">*</span>
					     <input type="number" min="0" step="any" class="form-control" id="i_amount" value="<?php echo $row['i_amount']; ?>" placeholder="Received amount" name="i_amount" required>
					  </div>				 
					 </div>
		
					 <div class="form-group row">                      
                      <div class="col-sm-12">
					  Received from / for: <span class="mand">*</span>
                        <input type="text" class="form-control" id="received_from" value="<?php echo $row['received_from']; ?>" name="received_from" placeholder="Received from / for" required>
					  </div>
					   </div>
					   
					 <div class="form-group row"> 
					   <div class="col-sm-12">
						Remarks :
						 <input type="text" class="form-control" id="remarks" value="<?php echo $row['remarks']; ?>" placeholder="Remarks if any"  name="remarks" >
						</div>
					 </div>	
				
               
                    <button type="submit" name="income_update_submit" class="btn btn-info mr-2">Update</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     

<!--  Edit Income modal ends -->


 <?php require('footer.php'); ?>