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


if(isset($_POST['product_submit'])){
	
	
	$p_name = $_POST['p_name'];
	$slogan = $_POST['slogan'];
	$p_price = $_POST['p_price'];	
	$status = $_POST['status'];	
		
	$sql2 ="INSERT INTO `{$prefix}products`(`p_name`, `slogan`, `p_price`, `status`) VALUES
	('$p_name', '$slogan', '$p_price', '$status')";
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a Product.")</script>';

}
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($add_pro == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_pro" class="btn btn-inverse-info">+ Add Product</button>
                </div>            
			</div><?php } ?>
			  
		  
			  <!-- Add Product modal starts -->			  
<div class="modal fade" id="add_pro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="smanage-products" method="post" enctype="multipart/form-data">
								
					<div class="form-group row">								  
                      <div class="col-sm-9">
					  Product name : <span class="mand">*</span>
					     <input type="text"  class="form-control"   placeholder="Product name" name="p_name" required>
					  </div>
						<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<option value="">Select status</option>							
							<option value="1">Active</option>
							<option value="0">Inactive</option>										
						</select>
						</div>					  
					 </div>
		
					 <div class="form-group row">                      
                      <div class="col-sm-12">
					  Slogan :
                        <input type="text" class="form-control"  name="slogan" placeholder="Slogan for the product">
					  </div>
					   </div>
					   
					 <div class="form-group row">
					     <div class="col-sm-6">
					  Price : <span class="mand">*</span>
					     <input type="number" min="0" step="any" class="form-control" placeholder="Product price" name="p_price" required>
					  </div>
					  </div>
					 	
										
                    <button type="submit" name="product_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add Product modal ends -->



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$sqlQuery = "SELECT * FROM {$prefix}products";
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						  <h4 class="card-title">Product list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table">
							  <thead>
								<tr>
								  <th>#</th>
								  <th>Product Name</th>								  
								  <th>Slogan</th>	
								  <th>Price</th>								  
								  <th>Status</th>
								 <?php if($edit_pro == 1){ ?>
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
                    'url':'ajax-product-list.php'
                },
                'columns': [
					{ data: 'id' },
					{ data: 'p_name' },
				    { data: 'slogan' },
					{ data: 'p_price' },
					{ data: 'status' },				
					<?php if($edit_pro == 1){ ?>
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
        window.location.href='smanage-products?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}products` set delete_status = 1  WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Product  has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "smanage-products"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='smanage-products?edit_id='+id;
	     
}
</script>			  
			  <?php
if(isset($_GET['edit_id'])){
	
	$sql = "SELECT * FROM {$prefix}products WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_pro').modal('show');
		});
		</script>";
			}		
?>

<?php

if(isset($_POST['product_update_submit'])){
	
	$sql = "UPDATE `{$prefix}products` SET    `p_name` = '".$_POST['p_name']."',  `slogan` = '".$_POST['slogan']."',
	`p_price` = '".$_POST['p_price']."', `status` = '".$_POST['status']."' WHERE id = '".$_POST['id']."'";
	mysqli_query($conn, $sql);	
echo '<script> alert("Product details has been updated.")</script>';

}
?>

<!-- Edit Product modal starts -->			  
<div class="modal fade" id="edit_pro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="smanage-products" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
				<div class="form-group row">								  
                      <div class="col-sm-9">
					  Product name : <span class="mand">*</span>
					     <input type="text"  class="form-control" value="<?php echo $row['p_name']; ?>"  placeholder="Product name" name="p_name" required>
					  </div>
						<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status"  class="select_dropdown" style="width:100%">
							<?php if($row['status']==1){?>
							<option value="1" selected>Active</option>
							<option value="0" >Inactive</option>
							<?php }elseif($row['status']==0){?>
							<option value="1" >Active</option>
							<option value="0" selected>Inactive</option>
							<?php } ?>									
						</select>
						</div>					  
					 </div>
		
					 <div class="form-group row">                      
                      <div class="col-sm-12">
					  Slogan :
                        <input type="text" class="form-control"  name="slogan"  value="<?php echo $row['slogan']; ?>" placeholder="Slogan for the product">
					  </div>
					   </div>
					   
					 <div class="form-group row">
					     <div class="col-sm-6">
					  Price : <span class="mand">*</span>
					     <input type="number" min="0" step="any" class="form-control" value="<?php echo $row['p_price']; ?>" placeholder="Product price" name="p_price" required>
					  </div>
					  </div>			
               
                    <button type="submit" name="product_update_submit" class="btn btn-info mr-2">Update</button>
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