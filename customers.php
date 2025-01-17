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

if(isset($_GET['pid'])){
$_SESSION['pid'] = $_GET['pid'];
}

if($_SESSION['pid']== 1){
	
	
	
// Function to create folder structure
function createCustomerFolders($cust_id) {
    $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/test'; // Update path as needed
    $customerDir = $baseDir . '/' . $cust_id;
    $subfolders = ['clients', 'estimations', 'logos', 'projects', 'staffs', 'sub', 'sup'];

    if (!file_exists($baseDir)) {
        mkdir($baseDir, 0777, true);
    }

    if (!file_exists($customerDir)) {
        mkdir($customerDir, 0777, true);
    }

    foreach ($subfolders as $subfolder) {
        $subfolderPath = $customerDir . '/' . $subfolder;
        if (!file_exists($subfolderPath)) {
            mkdir($subfolderPath, 0777, true);
        }
    }
}

if(isset($_POST['ebac_submit'])){
	
	$cust_id = $_POST['cust_id'];
	$pro_id = $_POST['pro_id'];
	$ver = $_POST['ver'];
	$website = $_POST['website'];
	$name = ucwords(strtolower($_POST['name']));
	$company = $_POST['company'];
	$mobile = $_POST['mobile'];
	$email = strtolower($_POST['email']);
	$address_1 = $_POST['address_1'];
	$address_2 = $_POST['address_2'];
	$zip_code = $_POST['zip_code'];	
	$status = $_POST['status'];
	$login_link = 'https://ebacpro.com';	
	$hosted_date = $_POST['hosted_date'];
	$renewal_date = $_POST['renewal_date'];
	$years = $_POST['years'];
	$amount = $_POST['amount'];	
	$remarks = $_POST['remarks'];
		 
	if(!empty($_FILES['photo']['name'])) //new image uploaded
	{	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`, `pro_id`, `ver`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`, `photo`) VALUES
	('$cust_id', '$pro_id', '$ver', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks', '$target_file')";
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added an EBAC PRO customer.")</script>';
	}
	else{		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`, `pro_id`, `ver`,  `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`) VALUES
	('$cust_id', '$pro_id', '$ver',  '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks')";
	
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added an EBAC PRO customer.")</script>';
		}
	
if($ver == 3 || $ver == 4 || $ver == 5){	
	 createCustomerFolders($cust_id);
}
}
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($add_cus == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_customer" class="btn btn-inverse-info">+ Add EBAC Customer</button>
                </div>            
			</div><?php } ?>
			  
   <?php 
	$sql23 = "SELECT cust_id  FROM {$prefix}customers  where pro_id = 1 order by cust_id desc";
	$result23 = mysqli_query($conn, $sql23); 
	if(mysqli_num_rows($result23) > 0){
	$row23 = mysqli_fetch_assoc($result23);	
	$cust_id = $row23['cust_id'];
	$new_cust_id = $cust_id+1;
	}	
	else{
	$new_cust_id = 16082022;	
	}
 ?>			  
			  <!-- Add customer modal starts -->			  
<div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New EBAC Customer - <?php echo $new_cust_id; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
                  						 
		<input type="text" class="form-control" id="cust_id"  name="cust_id" value="<?php echo $new_cust_id; ?>" hidden required>
	<input type="number" name="pro_id" value="1" hidden required>
							
					<div class="form-group row">
					<div class="col-sm-3">
					   Ver: <span class="mand">*</span>
                        <select required  name="ver"  id="ver" class="select_dropdown" style="width:100%">
							<option value="">Select ver</option>							
							<option value="1">V 1.4.7</option>
							<option value="2">V 2.4.7</option>
							<option value="3">Enterprise Basic V 1.4.7</option>
							<option value="4">Enterprise Starter V 2.4.7</option>
							<option value="5">Enterprise Advanced V 3.4.7</option>							
							<option value="6">Premium Basic V 1.4.7</option>
							<option value="7">Premium Starter V 2.4.7</option>
							<option value="8">Premium Advanced V 3.4.7</option>
						</select>
					  </div>
					 <div class="col-sm-5">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" id="name" placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-4">
					  Mobile: <span class="mand">*</span>
					     <input type="number" min="0" class="form-control" id="mobile"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
		
					 <div class="form-group row"> 
					<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<option value="">Select status</option>							
							<option value="1">Active</option>
							<option value="0">Inactive</option>										
						</select>
						</div>
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					 <div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" id="email"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" id="company" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>		
					 					 
					   <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" id="address_1" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" id="address_2" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" id="zip_code"  placeholder="ZIP code" name="zip_code" >
						</div>
						
						<div class="col-sm-9">
						   
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span>
							 <input type="date" class="form-control" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span>
							 <input type="date" class="form-control" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
					    <input type="number" min="0" class="form-control"  placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
							 <input type="text" class="form-control"  name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>
						<div class="form-group row">
						<div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control"  placeholder="Years" name="years">
							</div>
							<div class="col-sm-9">
						   Company logo: (200px X 200px)
							<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">  
							</div>
							
						 </div>
						
                    <button type="submit" name="ebac_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add customer modal ends -->



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$sqlQuery = "SELECT * FROM {$prefix}customers where delete_status = 0 and pro_id = 1";
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						  <h4 class="card-title">EBAC PRO customer list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table">
							  <thead>
								<tr>
								  <th>#</th>
								  <th>Customer ID</th>	
								  <th>Version</th>
								  <th>Hosted On</th>
								  <th>Renewal</th>
								  <th>Years</th>
								  <th>Amount</th>
								  <th>Name</th>								    
								  <th>Mobile</th>
								  <th>Email</th>
								  <th>Company</th>
								  <th>Login Link</th>
								  <th>Status</th>
								  <?php if($edit_cus == 1 || $del_cus == 1){ ?>
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
                    'url':'ajax-ebac-customer-list.php'
                },
                'columns': [
					{ data: 'ed_no' },
					{ data: 'cust_id' },
				    { data: 'ver' },
					{ data: 'hosted_date' },
					{ data: 'renewal_date' },
					{ data: 'years' },						
					{ data: 'amount' },	
					{ data: 'name' },
				    { data: 'mobile' },
					{ data: 'email' },
					{ data: 'company' },		 
					{ data: 'login_link' },	
					{ data: 'status' },	
					 <?php if($edit_cus == 1 || $del_cus == 1){ ?>
					{ data: 'actions' },
					 <?php } ?>
                ],
				 'columnDefs': [ {
					'targets': [], // column index (start from 0)
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
        window.location.href='customers?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}customers` SET `delete_status` = 1 WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Customer has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "customers"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='customers?edit_id='+id;
	     
}
</script>			  

<?php
if(isset($_GET['edit_id'])){
	
	$sql = "SELECT * FROM {$prefix}customers WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_customer').modal('show');
		});
		</script>";
	}		
?>

<?php

if(isset($_POST['ebac_update_submit'])){
	
	$chk_id = $_POST['id'];

	
	  if(!empty($_FILES['photo']['name'])) //new image uploaded
	{
	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
	$sql = "UPDATE `{$prefix}customers` SET  `ver` = '".$_POST['ver']."', 
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	 `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',   `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."', `photo` = '$target_file' WHERE id = '".$_POST['id']."' ";
	mysqli_query($conn, $sql);	
	echo '<script> alert("EBAC PRO customer details has been updated.")</script>';
	}
	else{
		$sql = "UPDATE `{$prefix}customers` SET  `ver` = '".$_POST['ver']."', 
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	`hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',  `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."' WHERE id = '".$_POST['id']."' ";	
		mysqli_query($conn, $sql);	
echo '<script> alert("EBAC PRO customer details has been updated.")</script>';
		
	}
 
}

$versions = [
    1 => 'V 1.4.7',
    2 => 'V 2.4.7',
    3 => 'Enterprise  Basic V 1.4.7',
    4 => 'Enterprise Starter V 2.4.7',
    5 => 'Enterprise Advanced V 3.4.7',
    6 => 'Premium Basic V 1.4.7',
    7 => 'Premium Starter V 2.4.7',
    8 => 'Premium Advanced V 3.4.7'
];
?>

<!-- Edit customer modal starts -->			  
<div class="modal fade" id="edit_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Customer - <?php echo $row['cust_id']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
				  <div class="form-group row">
					<div class="col-sm-3">
					   Ver : <span class="mand">*</span>
                        <select required  name="ver"  id="ver" class="select_dropdown" style="width:100%">
							<?php foreach ($versions as $key => $version): ?>
				<option value="<?php echo $key; ?>" <?php echo ($row['ver'] == $key) ? 'selected' : ''; ?>>
				<?php echo $version; ?>
				</option>
				<?php endforeach; ?>											
						</select>
					  </div>
					 <div class="col-sm-5">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" value="<?php echo $row['name']; ?>"  placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-4">
					  Mobile: <span class="mand">*</span>
	<input type="number" min="0" class="form-control" value="<?php echo $row['mobile']; ?>"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
					 
					  <div class="form-group row"> 
					  	<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<?php if($row['status']==1){?>
							<option value="1" selected>Active</option>
							<option value="0" >Inactive</option>
							<?php }elseif($row['status']==0){?>
							<option value="1" >Active</option>
							<option value="0" selected>Inactive</option>
							<?php } ?>										
						</select>
						</div>				              
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  value="<?php echo $row['website']; ?>" name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					<div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" value="<?php echo $row['email']; ?>"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" value="<?php echo $row['company']; ?>" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>	
					 
					 
					    <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_1']; ?>" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_2']; ?>" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" value="<?php echo $row['zip_code']; ?>"  placeholder="ZIP code" name="zip_code" >
						</div>
					
						<div class="col-sm-9">
						   Login link: <span class="mand">*</span>
	<input type="text"  class="form-control" value="<?php echo $row['login_link']; ?>" placeholder="Eg: https://name.ebacpro.com"   readonly>
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span> (m-d-y)
		<input type="date" class="form-control" value="<?php echo $row['hosted_date']; ?>" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span> (m-d-y)
	 <input type="date" class="form-control" value="<?php echo $row['renewal_date']; ?>" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
 <input type="number" min="0" class="form-control" value="<?php echo $row['amount']; ?>" placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
	 <input type="text" class="form-control" value="<?php echo $row['remarks']; ?>" name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>				  
								 
					 
					   <div class="form-group row">
					   <div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control" value="<?php echo $row['years']; ?>" placeholder="Years" name="years">
							</div>
					    <div class="col-sm-9">
					   Company logo: (200px X 200px)
		<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">				
			             </div>	
						

						<div class="col-sm-6">
						<br>&nbsp;
						<?php if(!$row["photo"]){?>
				<img class="img-xs rounded-circle" src="customer-logos/1default.jpg" alt="" />
				<?php } else { ?>
				<img class="img-xs rounded-circle hover_big" src="<?php echo $row['photo']; ?>" alt="" /> <?php } ?>	
						</div>
					 </div>
				
               
                    <button type="submit" name="ebac_update_submit" class="btn btn-info mr-2">Update</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     

<!-- EBAC PRO ends  --  MR starts -->

<?php } elseif($_SESSION['pid'] == 2){ 


if(isset($_POST['mr_submit'])){
	
	$cust_id = $_POST['cust_id'];
	$pro_id = $_POST['pro_id'];
	$website = $_POST['website'];
	$name = ucwords(strtolower($_POST['name']));
	$company = $_POST['company'];
	$mobile = $_POST['mobile'];
	$email = strtolower($_POST['email']);
	$address_1 = $_POST['address_1'];
	$address_2 = $_POST['address_2'];
	$zip_code = $_POST['zip_code'];	
	$status = $_POST['status'];
	$login_link = $_POST['login_link'];	
	$hosted_date = $_POST['hosted_date'];
	$renewal_date = $_POST['renewal_date'];
	$years = $_POST['years'];
	$amount = $_POST['amount'];	
	$remarks = $_POST['remarks'];

			 
	if(!empty($_FILES['photo']['name'])) //new image uploaded
	{	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`, `pro_id`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`, `photo`) VALUES
	('$cust_id', '$pro_id', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks', '$target_file')";
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a Med Reportr customer.")</script>';
	}
	else{		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`,  `pro_id`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`) VALUES
	('$cust_id', '$pro_id', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks')";
	
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a Med Reportr customer.")</script>';
		}
}
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($add_cus == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_customer" class="btn btn-inverse-info">+ Add MR Customer</button>
                </div>            
              </div><?php } ?>
			  
   <?php 
	$sql23 = "SELECT cust_id  FROM {$prefix}customers where pro_id = 2 order by cust_id desc";
	$result23 = mysqli_query($conn, $sql23); 
	if(mysqli_num_rows($result23) > 0){
	$row23 = mysqli_fetch_assoc($result23);	
	$cust_id = $row23['cust_id'];
	$new_cust_id = $cust_id+1;
	}	
	else{
	$new_cust_id = 2021;	
	}
 ?>			  
			  <!-- Add customer modal starts -->			  
<div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New MR Customer - <?php echo $new_cust_id; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
                  						 
		<input type="text" class="form-control" id="cust_id"  name="cust_id" value="<?php echo $new_cust_id; ?>" hidden required>
		<input type="number" name="pro_id" value="2" hidden required>
							
					<div class="form-group row">
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" id="name" placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
					     <input type="number" min="0" class="form-control" id="mobile"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
		
					 <div class="form-group row"> 
					<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<option value="">Select status</option>							
							<option value="1">Active</option>
							<option value="0">Inactive</option>										
						</select>
						</div>
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					 <div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" id="email"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" id="company" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>		
					 					 
					   <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" id="address_1" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" id="address_2" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" id="zip_code"  placeholder="ZIP code" name="zip_code" >
						</div>
						
						<div class="col-sm-9">
						  Login link: <span class="mand">*</span>
						<input type="text"  class="form-control" placeholder="Eg: https://name.domainname.com"  name="login_link" required>
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span>
							 <input type="date" class="form-control" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span>
							 <input type="date" class="form-control" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
					    <input type="number" min="0" class="form-control"  placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
							 <input type="text" class="form-control"  name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>
						<div class="form-group row">
						<div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control"  placeholder="Years" name="years">
							</div>
							<div class="col-sm-9">
						   Company logo: (200px X 200px)
							<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">  
							</div>
							
						 </div>
						
                    <button type="submit" name="mr_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add customer modal ends -->



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$sqlQuery = "SELECT * FROM {$prefix}customers where  pro_id = 2 and delete_status = 0";
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						  <h4 class="card-title">Med Reportr customer list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table">
							  <thead>
								<tr>
								  <th>#</th>
								  <th>Customer ID</th>
								  <th>Hosted On</th>
								  <th>Renewal</th>
								  <th>Years</th>
								  <th>Amount</th>
								  <th>Name</th>								    
								  <th>Mobile</th>
								  <th>Email</th>
								  <th>Company</th>
								  <th>Login Link</th>
								  <th>Status</th>
								 <?php if($edit_cus == 1 || $del_cus == 1){ ?>
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
                    'url':'ajax-mr-customer-list.php'
                },
                'columns': [
					{ data: 'ed_no' },
					{ data: 'cust_id' },
					{ data: 'hosted_date' },
					{ data: 'renewal_date' },
					{ data: 'years' },						
					{ data: 'amount' },	
					{ data: 'name' },
				    { data: 'mobile' },
					{ data: 'email' },
					{ data: 'company' },		 
					{ data: 'login_link' },	
					{ data: 'status' },					
					 <?php if($edit_cus == 1 || $del_cus == 1){ ?>
					{ data: 'actions' },
					 <?php } ?>
                ],
				 'columnDefs': [ {
					'targets': [], // column index (start from 0)
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
        window.location.href='customers?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}customers` SET `delete_status` = 1 WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Customer has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "customers"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='customers?edit_id='+id;
	     
}
</script>			  
			  <?php
if(isset($_GET['edit_id'])){
	
	$sql = "SELECT * FROM {$prefix}customers WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_customer').modal('show');
		});
		</script>";
	}		
?>

<?php

if(isset($_POST['mr_update_submit'])){

	
	  if(!empty($_FILES['photo']['name'])) //new image uploaded
	{
	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
	$sql = "UPDATE `{$prefix}customers` SET   
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	`login_link` = '".$_POST['login_link']."', `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',   `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."', `photo` = '$target_file' WHERE id = '".$_POST['id']."' ";
	mysqli_query($conn, $sql);	
	echo '<script> alert("Med Reportr customer details has been updated.")</script>';
	}
	else{
		$sql = "UPDATE `{$prefix}customers` SET  
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	`login_link` = '".$_POST['login_link']."', `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',  `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."' WHERE id = '".$_POST['id']."' ";	
		mysqli_query($conn, $sql);	
echo '<script> alert("Med Reportr customer details has been updated.")</script>';
		
	}
}
?>

<!-- Edit customer modal starts -->			  
<div class="modal fade" id="edit_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Med Reportr Customer - <?php echo $row['cust_id']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
				  <div class="form-group row">
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" value="<?php echo $row['name']; ?>"  placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
	<input type="number" min="0" class="form-control" value="<?php echo $row['mobile']; ?>"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
					 
					  <div class="form-group row"> 
					  	<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<?php if($row['status']==1){?>
							<option value="1" selected>Active</option>
							<option value="0" >Inactive</option>
							<?php }elseif($row['status']==0){?>
							<option value="1" >Active</option>
							<option value="0" selected>Inactive</option>
							<?php } ?>										
						</select>
						</div>				              
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  value="<?php echo $row['website']; ?>" name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					<div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" value="<?php echo $row['email']; ?>"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" value="<?php echo $row['company']; ?>" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>	
					 
					 
					    <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_1']; ?>" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_2']; ?>" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" value="<?php echo $row['zip_code']; ?>"  placeholder="ZIP code" name="zip_code" >
						</div>
					
						<div class="col-sm-9">
						   Login link: <span class="mand">*</span>
	<input type="text"  class="form-control" value="<?php echo $row['login_link']; ?>"  placeholder="Eg: https://name.domainname.com" name="login_link" required>
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span> (m-d-y)
		<input type="date" class="form-control" value="<?php echo $row['hosted_date']; ?>" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span> (m-d-y)
	 <input type="date" class="form-control" value="<?php echo $row['renewal_date']; ?>" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
 <input type="number" min="0" class="form-control" value="<?php echo $row['amount']; ?>" placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
	 <input type="text" class="form-control" value="<?php echo $row['remarks']; ?>" name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>				  
								 
					 
					   <div class="form-group row">
					   <div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control" value="<?php echo $row['years']; ?>" placeholder="Years" name="years">
							</div>
					    <div class="col-sm-9">
					   Company logo: (200px X 200px)
		<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">				
			             </div>	
						

						<div class="col-sm-6">
						<br>&nbsp;
						<?php if(!$row["photo"]){?>
				<img class="img-xs rounded-circle" src="customer-logos/1default.jpg" alt="" />
				<?php } else { ?>
				<img class="img-xs rounded-circle hover_big" src="<?php echo $row['photo']; ?>" alt="" /> <?php } ?>	
						</div>
					 </div>
				
               
                    <button type="submit" name="mr_update_submit" class="btn btn-info mr-2">Update</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     

<!--  MR ends  | Dentos starts -->

<?php }  elseif($_SESSION['pid'] == 3){ 


if(isset($_POST['dentos_submit'])){
	
	$cust_id = $_POST['cust_id'];
	$pro_id = $_POST['pro_id'];
	$website = $_POST['website'];
	$name = ucwords(strtolower($_POST['name']));
	$company = $_POST['company'];
	$mobile = $_POST['mobile'];
	$email = strtolower($_POST['email']);
	$address_1 = $_POST['address_1'];
	$address_2 = $_POST['address_2'];
	$zip_code = $_POST['zip_code'];	
	$status = $_POST['status'];
	$login_link = $_POST['login_link'];	
	$hosted_date = $_POST['hosted_date'];
	$renewal_date = $_POST['renewal_date'];
	$years = $_POST['years'];
	$amount = $_POST['amount'];	
	$remarks = $_POST['remarks'];

		 
	if(!empty($_FILES['photo']['name'])) //new image uploaded
	{	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`, `pro_id`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`, `photo`) VALUES
	('$cust_id', '$pro_id', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks', '$target_file')";
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a Dentos customer.")</script>';
	}
	else{		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`,  `pro_id`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`) VALUES
	('$cust_id', '$pro_id', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks')";
	
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a Dentos customer.")</script>';
		}
}
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($add_cus == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_customer" class="btn btn-inverse-info">+ Add Dentos Customer</button>
                </div>            
              </div><?php } ?>
			  
   <?php 
	$sql23 = "SELECT cust_id  FROM {$prefix}customers where pro_id = 3 order by cust_id desc";
	$result23 = mysqli_query($conn, $sql23); 
	if(mysqli_num_rows($result23) > 0){
	$row23 = mysqli_fetch_assoc($result23);	
	$cust_id = $row23['cust_id'];
	$new_cust_id = $cust_id+1;
	}	
	else{
	$new_cust_id = 13032024;	
	}
 ?>			  
			  <!-- Add customer modal starts -->			  
<div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Dentos Customer - <?php echo $new_cust_id; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
                  						 
		<input type="text" class="form-control" id="cust_id"  name="cust_id" value="<?php echo $new_cust_id; ?>" hidden required>
		<input type="number" name="pro_id" value="3" hidden required>
							
					<div class="form-group row">
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" id="name" placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
					     <input type="number" min="0" class="form-control" id="mobile"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
		
					 <div class="form-group row"> 
					<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<option value="">Select status</option>							
							<option value="1">Active</option>
							<option value="0">Inactive</option>										
						</select>
						</div>
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					 <div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" id="email"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" id="company" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>		
					 					 
					   <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" id="address_1" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" id="address_2" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" id="zip_code"  placeholder="ZIP code" name="zip_code" >
						</div>
						
						<div class="col-sm-9">
						  Login link: <span class="mand">*</span>
						<input type="text"  class="form-control"  placeholder="Eg: https://name.domainname.com"  name="login_link" required>
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span>
							 <input type="date" class="form-control" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span>
							 <input type="date" class="form-control" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
					    <input type="number" min="0" class="form-control"  placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
							 <input type="text" class="form-control"  name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>
						<div class="form-group row">
						<div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control"  placeholder="Years" name="years">
							</div>
							<div class="col-sm-9">
						   Company logo: (200px X 200px)
							<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">  
							</div>
							
						 </div>
						
                    <button type="submit" name="dentos_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add customer modal ends -->



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$sqlQuery = "SELECT * FROM {$prefix}customers where  pro_id = 3 and delete_status = 0";
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						  <h4 class="card-title">Dentos customer list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table">
							  <thead>
								<tr>
								  <th>#</th>
								  <th>Customer ID</th>
								  <th>Hosted On</th>
								  <th>Renewal</th>
								  <th>Years</th>
								  <th>Amount</th>
								  <th>Name</th>								    
								  <th>Mobile</th>
								  <th>Email</th>
								  <th>Company</th>
								  <th>Login Link</th>
								  <th>Status</th>
								  <?php if($edit_cus == 1 || $del_cus == 1){ ?>
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
                    'url':'ajax-dentos-customer-list.php'
                },
                'columns': [
					{ data: 'ed_no' },
					{ data: 'cust_id' },
					{ data: 'hosted_date' },
					{ data: 'renewal_date' },
					{ data: 'years' },						
					{ data: 'amount' },	
					{ data: 'name' },
				    { data: 'mobile' },
					{ data: 'email' },
					{ data: 'company' },		 
					{ data: 'login_link' },	
					{ data: 'status' },					
					 <?php if($edit_cus == 1 || $del_cus == 1){ ?>
					{ data: 'actions' },
					 <?php } ?>
                ],
				 'columnDefs': [ {
					'targets': [], // column index (start from 0)
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
        window.location.href='customers?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}customers` SET `delete_status` = 1 WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Customer has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "customers"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='customers?edit_id='+id;
	     
}
</script>			  
			  <?php
if(isset($_GET['edit_id'])){
	
	$sql = "SELECT * FROM {$prefix}customers WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_customer').modal('show');
		});
		</script>";
	}		
?>

<?php

if(isset($_POST['dentos_update_submit'])){
	
	  if(!empty($_FILES['photo']['name'])) //new image uploaded
	{
	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
	$sql = "UPDATE `{$prefix}customers` SET   
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	`login_link` = '".$_POST['login_link']."', `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',   `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."', `photo` = '$target_file' WHERE id = '".$_POST['id']."' ";
	mysqli_query($conn, $sql);	
	echo '<script> alert("Dentos customer details has been updated.")</script>';
	}
	else{
		$sql = "UPDATE `{$prefix}customers` SET  
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	`login_link` = '".$_POST['login_link']."', `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',  `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."' WHERE id = '".$_POST['id']."' ";	
		mysqli_query($conn, $sql);	
echo '<script> alert("Dentos customer details has been updated.")</script>';
		
	}
}
?>

<!-- Edit customer modal starts -->			  
<div class="modal fade" id="edit_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Dentos Customer - <?php echo $row['cust_id']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
				  <div class="form-group row">
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" value="<?php echo $row['name']; ?>"  placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
	<input type="number" min="0" class="form-control" value="<?php echo $row['mobile']; ?>"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
					 
					  <div class="form-group row"> 
					  	<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<?php if($row['status']==1){?>
							<option value="1" selected>Active</option>
							<option value="0" >Inactive</option>
							<?php }elseif($row['status']==0){?>
							<option value="1" >Active</option>
							<option value="0" selected>Inactive</option>
							<?php } ?>										
						</select>
						</div>				              
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  value="<?php echo $row['website']; ?>" name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					<div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" value="<?php echo $row['email']; ?>"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" value="<?php echo $row['company']; ?>" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>	
					 
					 
					    <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_1']; ?>" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_2']; ?>" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" value="<?php echo $row['zip_code']; ?>"  placeholder="ZIP code" name="zip_code" >
						</div>
					
						<div class="col-sm-9">
						   Login link: <span class="mand">*</span>
	<input type="text"  class="form-control" value="<?php echo $row['login_link']; ?>"  placeholder="Eg: https://name.domainname.com" name="login_link" required>
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span> (m-d-y)
		<input type="date" class="form-control" value="<?php echo $row['hosted_date']; ?>" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span> (m-d-y)
	 <input type="date" class="form-control" value="<?php echo $row['renewal_date']; ?>" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
 <input type="number" min="0" class="form-control" value="<?php echo $row['amount']; ?>" placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
	 <input type="text" class="form-control" value="<?php echo $row['remarks']; ?>" name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>				  
								 
					 
					   <div class="form-group row">
					   <div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control" value="<?php echo $row['years']; ?>" placeholder="Years" name="years">
							</div>
					    <div class="col-sm-9">
					   Company logo: (200px X 200px)
		<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">				
			             </div>	
						

						<div class="col-sm-6">
						<br>&nbsp;
						<?php if(!$row["photo"]){?>
				<img class="img-xs rounded-circle" src="customer-logos/1default.jpg" alt="" />
				<?php } else { ?>
				<img class="img-xs rounded-circle hover_big" src="<?php echo $row['photo']; ?>" alt="" /> <?php } ?>	
						</div>
					 </div>
				
               
                    <button type="submit" name="dentos_update_submit" class="btn btn-info mr-2">Update</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     

<!--  Dentos ends |  Bizzat starts -->

<?php }  elseif($_SESSION['pid'] == 4){ 


if(isset($_POST['bizzat_submit'])){
	
	$cust_id = $_POST['cust_id'];
	$pro_id = $_POST['pro_id'];
	$website = $_POST['website'];
	$name = ucwords(strtolower($_POST['name']));
	$company = $_POST['company'];
	$mobile = $_POST['mobile'];
	$email = strtolower($_POST['email']);
	$address_1 = $_POST['address_1'];
	$address_2 = $_POST['address_2'];
	$zip_code = $_POST['zip_code'];	
	$status = $_POST['status'];
	$login_link = $_POST['login_link'];	
	$hosted_date = $_POST['hosted_date'];
	$renewal_date = $_POST['renewal_date'];
	$years = $_POST['years'];
	$amount = $_POST['amount'];	
	$remarks = $_POST['remarks'];
		 
	if(!empty($_FILES['photo']['name'])) //new image uploaded
	{	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`, `pro_id`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`, `photo`) VALUES
	('$cust_id', '$pro_id', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks', '$target_file')";
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a Bizzat customer.")</script>';
	}
	else{		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`,  `pro_id`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`) VALUES
	('$cust_id', '$pro_id', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks')";
	
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a Bizzat customer.")</script>';
		}
}
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($add_cus == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_customer" class="btn btn-inverse-info">+ Add Bizzat Customer</button>
                </div>            
              </div><?php } ?>
			  
   <?php 
	$sql23 = "SELECT cust_id  FROM {$prefix}customers where pro_id = 4 order by cust_id desc";
	$result23 = mysqli_query($conn, $sql23); 
	if(mysqli_num_rows($result23) > 0){
	$row23 = mysqli_fetch_assoc($result23);	
	$cust_id = $row23['cust_id'];
	$new_cust_id = $cust_id+1;
	}	
	else{
	$new_cust_id = 15122023;	
	}
 ?>			  
			  <!-- Add customer modal starts -->			  
<div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Bizzat Customer - <?php echo $new_cust_id; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
                  						 
		<input type="text" class="form-control" id="cust_id"  name="cust_id" value="<?php echo $new_cust_id; ?>" hidden required>
		<input type="number" name="pro_id" value="4" hidden required>
							
					<div class="form-group row">
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" id="name" placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
					     <input type="number" min="0" class="form-control" id="mobile"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
		
					 <div class="form-group row"> 
					<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<option value="">Select status</option>							
							<option value="1">Active</option>
							<option value="0">Inactive</option>										
						</select>
						</div>
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					 <div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" id="email"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" id="company" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>		
					 					 
					   <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" id="address_1" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" id="address_2" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" id="zip_code"  placeholder="ZIP code" name="zip_code" >
						</div>
						
						<div class="col-sm-9">
						  Login link: <span class="mand">*</span>
						<input type="text"  class="form-control"   placeholder="Eg: https://name.domainname.com"  name="login_link" required>
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span>
							 <input type="date" class="form-control" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span>
							 <input type="date" class="form-control" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
					    <input type="number" min="0" class="form-control"  placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
							 <input type="text" class="form-control"  name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>
						<div class="form-group row">
						<div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control"  placeholder="Years" name="years">
							</div>
							<div class="col-sm-9">
						   Company logo: (200px X 200px)
							<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">  
							</div>
							
						 </div>
						
                    <button type="submit" name="bizzat_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add customer modal ends -->



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$sqlQuery = "SELECT * FROM {$prefix}customers where  pro_id = 4 and delete_status = 0";
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						  <h4 class="card-title">Bizzat customer list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table">
							  <thead>
								<tr>
								  <th>#</th>
								  <th>Customer ID</th>
								  <th>Hosted On</th>
								  <th>Renewal</th>
								  <th>Years</th>
								  <th>Amount</th>
								  <th>Name</th>								    
								  <th>Mobile</th>
								  <th>Email</th>
								  <th>Company</th>
								  <th>Login Link</th>
								  <th>Status</th>
								 <?php if($edit_cus == 1 || $del_cus == 1){ ?>
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
                    'url':'ajax-bizzat-customer-list.php'
                },
                'columns': [
					{ data: 'ed_no' },
					{ data: 'cust_id' },
					{ data: 'hosted_date' },
					{ data: 'renewal_date' },
					{ data: 'years' },						
					{ data: 'amount' },	
					{ data: 'name' },
				    { data: 'mobile' },
					{ data: 'email' },
					{ data: 'company' },		 
					{ data: 'login_link' },	
					{ data: 'status' },					
					 <?php if($edit_cus == 1 || $del_cus == 1){ ?>
					{ data: 'actions' },
					 <?php } ?>
                ],
				 'columnDefs': [ {
					'targets': [], // column index (start from 0)
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
        window.location.href='customers?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}customers` SET `delete_status` = 1 WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Customer has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "customers"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='customers?edit_id='+id;
	     
}
</script>			  
			  <?php
if(isset($_GET['edit_id'])){
	
	$sql = "SELECT * FROM {$prefix}customers WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_customer').modal('show');
		});
		</script>";
	}		
?>

<?php

if(isset($_POST['bizzat_update_submit'])){
	
	
	  if(!empty($_FILES['photo']['name'])) //new image uploaded
	{
	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
	$sql = "UPDATE `{$prefix}customers` SET   
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	`login_link` = '".$_POST['login_link']."', `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',   `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."', `photo` = '$target_file' WHERE id = '".$_POST['id']."' ";
	mysqli_query($conn, $sql);	
	echo '<script> alert("Bizzat customer details has been updated.")</script>';
	}
	else{
		$sql = "UPDATE `{$prefix}customers` SET  
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	`login_link` = '".$_POST['login_link']."', `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',  `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."' WHERE id = '".$_POST['id']."' ";	
		mysqli_query($conn, $sql);	
echo '<script> alert("Bizzat customer details has been updated.")</script>';
		
	}
}
?>

<!-- Edit customer modal starts -->			  
<div class="modal fade" id="edit_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Bizzat Customer - <?php echo $row['cust_id']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
				  <div class="form-group row">
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" value="<?php echo $row['name']; ?>"  placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
	<input type="number" min="0" class="form-control" value="<?php echo $row['mobile']; ?>"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
					 
					  <div class="form-group row"> 
					  	<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<?php if($row['status']==1){?>
							<option value="1" selected>Active</option>
							<option value="0" >Inactive</option>
							<?php }elseif($row['status']==0){?>
							<option value="1" >Active</option>
							<option value="0" selected>Inactive</option>
							<?php } ?>										
						</select>
						</div>				              
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  value="<?php echo $row['website']; ?>" name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					<div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" value="<?php echo $row['email']; ?>"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" value="<?php echo $row['company']; ?>" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>	
					 
					 
					    <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_1']; ?>" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_2']; ?>" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" value="<?php echo $row['zip_code']; ?>"  placeholder="ZIP code" name="zip_code" >
						</div>
					
						<div class="col-sm-9">
						   Login link: <span class="mand">*</span>
	<input type="text"  class="form-control" value="<?php echo $row['login_link']; ?>"  placeholder="Eg: https://name.domainname.com" name="login_link" required>
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span> (m-d-y)
		<input type="date" class="form-control" value="<?php echo $row['hosted_date']; ?>" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span> (m-d-y)
	 <input type="date" class="form-control" value="<?php echo $row['renewal_date']; ?>" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
 <input type="number" min="0" class="form-control" value="<?php echo $row['amount']; ?>" placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
	 <input type="text" class="form-control" value="<?php echo $row['remarks']; ?>" name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>				  
								 
					 
					   <div class="form-group row">
					   <div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control" value="<?php echo $row['years']; ?>" placeholder="Years" name="years">
							</div>
					    <div class="col-sm-9">
					   Company logo: (200px X 200px)
		<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">				
			             </div>	
						

						<div class="col-sm-6">
						<br>&nbsp;
						<?php if(!$row["photo"]){?>
				<img class="img-xs rounded-circle" src="customer-logos/1default.jpg" alt="" />
				<?php } else { ?>
				<img class="img-xs rounded-circle hover_big" src="<?php echo $row['photo']; ?>" alt="" /> <?php } ?>	
						</div>
					 </div>
				
               
                    <button type="submit" name="bizzat_update_submit" class="btn btn-info mr-2">Update</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     

<!-- Bizzat ends | Learn Sphere starts -->

<?php } elseif($_SESSION['pid'] == 5){ 


if(isset($_POST['learn_submit'])){
	
	$cust_id = $_POST['cust_id'];
	$pro_id = $_POST['pro_id'];
	$website = $_POST['website'];
	$name = ucwords(strtolower($_POST['name']));
	$company = $_POST['company'];
	$mobile = $_POST['mobile'];
	$email = strtolower($_POST['email']);
	$address_1 = $_POST['address_1'];
	$address_2 = $_POST['address_2'];
	$zip_code = $_POST['zip_code'];	
	$status = $_POST['status'];
	$login_link = $_POST['login_link'];	
	$hosted_date = $_POST['hosted_date'];
	$renewal_date = $_POST['renewal_date'];
	$years = $_POST['years'];
	$amount = $_POST['amount'];	
	$remarks = $_POST['remarks'];
		 
	if(!empty($_FILES['photo']['name'])) //new image uploaded
	{	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`, `pro_id`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`, `photo`) VALUES
	('$cust_id', '$pro_id', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks', '$target_file')";
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a Learn Sphere customer.")</script>';
	}
	else{		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`,  `pro_id`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`) VALUES
	('$cust_id', '$pro_id', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks')";
	
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a Learn Sphere customer.")</script>';
		}
}
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($add_cus == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_customer" class="btn btn-inverse-info">+ Add Learn Sphere Customer</button>
                </div>            
              </div><?php } ?>
			  
   <?php 
	$sql23 = "SELECT cust_id  FROM {$prefix}customers where pro_id = 5 order by cust_id desc";
	$result23 = mysqli_query($conn, $sql23); 
	if(mysqli_num_rows($result23) > 0){
	$row23 = mysqli_fetch_assoc($result23);	
	$cust_id = $row23['cust_id'];
	$new_cust_id = $cust_id+1;
	}	
	else{
	$new_cust_id = 17052023;	
	}
 ?>			  
			  <!-- Add customer modal starts -->			  
<div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Learn Sphere Customer - <?php echo $new_cust_id; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
                  						 
		<input type="text" class="form-control" id="cust_id"  name="cust_id" value="<?php echo $new_cust_id; ?>" hidden required>
		<input type="number" name="pro_id" value="5" hidden required>
							
					<div class="form-group row">
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" id="name" placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
					     <input type="number" min="0" class="form-control" id="mobile"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
		
					 <div class="form-group row"> 
					<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<option value="">Select status</option>							
							<option value="1">Active</option>
							<option value="0">Inactive</option>										
						</select>
						</div>
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					 <div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" id="email"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" id="company" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>		
					 					 
					   <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" id="address_1" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" id="address_2" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" id="zip_code"  placeholder="ZIP code" name="zip_code" >
						</div>
						
						<div class="col-sm-9">
						  Login link: <span class="mand">*</span>
						<input type="text"  class="form-control"   placeholder="Eg: https://name.domainname.com"  name="login_link" required>
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span>
							 <input type="date" class="form-control" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span>
							 <input type="date" class="form-control" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
					    <input type="number" min="0" class="form-control"  placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
							 <input type="text" class="form-control"  name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>
						<div class="form-group row">
						<div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control"  placeholder="Years" name="years">
							</div>
							<div class="col-sm-9">
						   Company logo: (200px X 200px)
							<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">  
							</div>
							
						 </div>
						
                    <button type="submit" name="learn_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add customer modal ends -->



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$sqlQuery = "SELECT * FROM {$prefix}customers where  pro_id = 5 and delete_status = 0";
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						<h4 class="card-title">Learn Sphere customer list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table">
							  <thead>
								<tr>
								  <th>#</th>
								  <th>Customer ID</th>
								  <th>Hosted On</th>
								  <th>Renewal</th>
								  <th>Years</th>
								  <th>Amount</th>
								  <th>Name</th>								    
								  <th>Mobile</th>
								  <th>Email</th>
								  <th>Company</th>
								  <th>Login Link</th>
								  <th>Status</th>
								  <?php if($edit_cus == 1 || $del_cus == 1){ ?>
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
                    'url':'ajax-ls-customer-list.php'
                },
                'columns': [
					{ data: 'ed_no' },
					{ data: 'cust_id' },
					{ data: 'hosted_date' },
					{ data: 'renewal_date' },
					{ data: 'years' },						
					{ data: 'amount' },	
					{ data: 'name' },
				    { data: 'mobile' },
					{ data: 'email' },
					{ data: 'company' },		 
					{ data: 'login_link' },	
					{ data: 'status' },					
					 <?php if($edit_cus == 1 || $del_cus == 1){ ?>
					{ data: 'actions' },
					 <?php } ?>
                ],
				 'columnDefs': [ {
					'targets': [], // column index (start from 0)
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
        window.location.href='customers?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}customers` SET `delete_status` = 1 WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Customer has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "customers"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='customers?edit_id='+id;
	     
}
</script>			  
			  <?php
if(isset($_GET['edit_id'])){
	
	$sql = "SELECT * FROM {$prefix}customers WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_customer').modal('show');
		});
		</script>";
	}		
?>

<?php

if(isset($_POST['ls_update_submit'])){

	
	  if(!empty($_FILES['photo']['name'])) //new image uploaded
	{
	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
	$sql = "UPDATE `{$prefix}customers` SET   
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	`login_link` = '".$_POST['login_link']."', `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',   `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."', `photo` = '$target_file' WHERE id = '".$_POST['id']."' ";
	mysqli_query($conn, $sql);	
	echo '<script> alert("Learn Sphere customer details has been updated.")</script>';
	}
	else{
		$sql = "UPDATE `{$prefix}customers` SET  
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	`login_link` = '".$_POST['login_link']."', `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',  `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."' WHERE id = '".$_POST['id']."' ";	
		mysqli_query($conn, $sql);	
echo '<script> alert("Learn Sphere customer details has been updated.")</script>';
		
	}
}
?>

<!-- Edit customer modal starts -->			  
<div class="modal fade" id="edit_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Learn Sphere Customer - <?php echo $row['cust_id']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
				  <div class="form-group row">
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" value="<?php echo $row['name']; ?>"  placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
	<input type="number" min="0" class="form-control" value="<?php echo $row['mobile']; ?>"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
					 
					  <div class="form-group row"> 
					  	<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<?php if($row['status']==1){?>
							<option value="1" selected>Active</option>
							<option value="0" >Inactive</option>
							<?php }elseif($row['status']==0){?>
							<option value="1" >Active</option>
							<option value="0" selected>Inactive</option>
							<?php } ?>										
						</select>
						</div>				              
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  value="<?php echo $row['website']; ?>" name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					<div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" value="<?php echo $row['email']; ?>"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" value="<?php echo $row['company']; ?>" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>	
					 
					 
					    <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_1']; ?>" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_2']; ?>" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" value="<?php echo $row['zip_code']; ?>"  placeholder="ZIP code" name="zip_code" >
						</div>
					
						<div class="col-sm-9">
						   Login link: <span class="mand">*</span>
	<input type="text"  class="form-control" value="<?php echo $row['login_link']; ?>"  placeholder="Eg: https://name.domainname.com" name="login_link" required>
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span> (m-d-y)
		<input type="date" class="form-control" value="<?php echo $row['hosted_date']; ?>" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span> (m-d-y)
	 <input type="date" class="form-control" value="<?php echo $row['renewal_date']; ?>" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
 <input type="number" min="0" class="form-control" value="<?php echo $row['amount']; ?>" placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
	 <input type="text" class="form-control" value="<?php echo $row['remarks']; ?>" name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>				  
								 
					 
					   <div class="form-group row">
					   <div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control" value="<?php echo $row['years']; ?>" placeholder="Years" name="years">
							</div>
					    <div class="col-sm-9">
					   Company logo: (200px X 200px)
		<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">				
			             </div>	
						

						<div class="col-sm-6">
						<br>&nbsp;
						<?php if(!$row["photo"]){?>
				<img class="img-xs rounded-circle" src="customer-logos/1default.jpg" alt="" />
				<?php } else { ?>
				<img class="img-xs rounded-circle hover_big" src="<?php echo $row['photo']; ?>" alt="" /> <?php } ?>	
						</div>
					 </div>
				
               
                    <button type="submit" name="ls_update_submit" class="btn btn-info mr-2">Update</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     

<!--   Learn Sphere ends |  Website starts -->

<?php } elseif($_SESSION['pid'] == 6){ 


if(isset($_POST['web_submit'])){
	
	$cust_id = $_POST['cust_id'];
	$pro_id = $_POST['pro_id'];
	$website = $_POST['website'];
	$name = ucwords(strtolower($_POST['name']));
	$company = $_POST['company'];
	$mobile = $_POST['mobile'];
	$email = strtolower($_POST['email']);
	$address_1 = $_POST['address_1'];
	$address_2 = $_POST['address_2'];
	$zip_code = $_POST['zip_code'];	
	$status = $_POST['status'];
	$login_link = $_POST['login_link'];	
	$hosted_date = $_POST['hosted_date'];
	$renewal_date = $_POST['renewal_date'];
	$years = $_POST['years'];
	$amount = $_POST['amount'];	
	$remarks = $_POST['remarks'];

		 
	if(!empty($_FILES['photo']['name'])) //new image uploaded
	{	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`, `pro_id`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`, `photo`) VALUES
	('$cust_id', '$pro_id', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks', '$target_file')";
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a Website customer.")</script>';
	}
	else{		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`,  `pro_id`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`) VALUES
	('$cust_id', '$pro_id', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks')";
	
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a Website customer.")</script>';
		}
}
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($add_cus == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_customer" class="btn btn-inverse-info">+ Add Website Customer</button>
                </div>            
			</div> <?php } ?>
			  
   <?php 
	$sql23 = "SELECT cust_id  FROM {$prefix}customers where pro_id = 6 order by cust_id desc";
	$result23 = mysqli_query($conn, $sql23); 
	if(mysqli_num_rows($result23) > 0){
	$row23 = mysqli_fetch_assoc($result23);	
	$cust_id = $row23['cust_id'];
	$new_cust_id = $cust_id+1;
	}	
	else{
	$new_cust_id = 1001;	
	}
 ?>			  
			  <!-- Add customer modal starts -->			  
<div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Website Customer - <?php echo $new_cust_id; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
                  						 
		<input type="text" class="form-control" id="cust_id"  name="cust_id" value="<?php echo $new_cust_id; ?>" hidden required>
		<input type="number" name="pro_id" value="6" hidden required>
							
					<div class="form-group row">
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" id="name" placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
					     <input type="number" min="0" class="form-control" id="mobile"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
		
					 <div class="form-group row"> 
					<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<option value="">Select status</option>							
							<option value="1">Active</option>
							<option value="0">Inactive</option>										
						</select>
						</div>
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					 <div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" id="email"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" id="company" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>		
					 					 
					   <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" id="address_1" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" id="address_2" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" id="zip_code"  placeholder="ZIP code" name="zip_code" >
						</div>
						
						<div class="col-sm-9">
						  Login link: <span class="mand">*</span>
						<input type="text"  class="form-control"   placeholder="Eg: https://name.domainname.com"  name="login_link" required>
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span>
							 <input type="date" class="form-control" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span>
							 <input type="date" class="form-control" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
					    <input type="number" min="0" class="form-control"  placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
							 <input type="text" class="form-control"  name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>
						<div class="form-group row">
						<div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control"  placeholder="Years" name="years">
							</div>
							<div class="col-sm-9">
						   Company logo: (200px X 200px)
							<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">  
							</div>
							
						 </div>
						
                    <button type="submit" name="web_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add customer modal ends -->



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$sqlQuery = "SELECT * FROM {$prefix}customers where  pro_id = 6 and delete_status = 0";
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						<h4 class="card-title">Website customer list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table">
							  <thead>
								<tr>
								  <th>#</th>
								  <th>Customer ID</th>
								  <th>Hosted On</th>
								  <th>Renewal</th>
								  <th>Years</th>
								  <th>Amount</th>
								  <th>Name</th>								    
								  <th>Mobile</th>
								  <th>Email</th>
								  <th>Company</th>
								  <th>Login Link</th>
								  <th>Status</th>
								  <?php if($edit_cus == 1 || $del_cus == 1){ ?>
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
                    'url':'ajax-web-customer-list.php'
                },
                'columns': [
					{ data: 'ed_no' },
					{ data: 'cust_id' },
					{ data: 'hosted_date' },
					{ data: 'renewal_date' },
					{ data: 'years' },						
					{ data: 'amount' },	
					{ data: 'name' },
				    { data: 'mobile' },
					{ data: 'email' },
					{ data: 'company' },		 
					{ data: 'login_link' },	
					{ data: 'status' },					
					 <?php if($edit_cus == 1 || $del_cus == 1){ ?>
					{ data: 'actions' },
					 <?php } ?>
                ],
				 'columnDefs': [ {
					'targets': [], // column index (start from 0)
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
        window.location.href='customers?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}customers` SET `delete_status` = 1 WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Customer has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "customers"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='customers?edit_id='+id;
	     
}
</script>			  
			  <?php
if(isset($_GET['edit_id'])){
	
	$sql = "SELECT * FROM {$prefix}customers WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_customer').modal('show');
		});
		</script>";
	}		
?>

<?php

if(isset($_POST['web_update_submit'])){
	
	  if(!empty($_FILES['photo']['name'])) //new image uploaded
	{
	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
	$sql = "UPDATE `{$prefix}customers` SET   
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	`login_link` = '".$_POST['login_link']."', `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',   `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."', `photo` = '$target_file' WHERE id = '".$_POST['id']."' ";
	mysqli_query($conn, $sql);	
	echo '<script> alert("Website customer details has been updated.")</script>';
	}
	else{
		$sql = "UPDATE `{$prefix}customers` SET  
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	`login_link` = '".$_POST['login_link']."', `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',  `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."' WHERE id = '".$_POST['id']."' ";	
		mysqli_query($conn, $sql);	
echo '<script> alert("Website customer details has been updated.")</script>';
		
	}
}
?>

<!-- Edit customer modal starts -->			  
<div class="modal fade" id="edit_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Website Customer - <?php echo $row['cust_id']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
				  <div class="form-group row">
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" value="<?php echo $row['name']; ?>"  placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
	<input type="number" min="0" class="form-control" value="<?php echo $row['mobile']; ?>"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
					 
					  <div class="form-group row"> 
					  	<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<?php if($row['status']==1){?>
							<option value="1" selected>Active</option>
							<option value="0" >Inactive</option>
							<?php }elseif($row['status']==0){?>
							<option value="1" >Active</option>
							<option value="0" selected>Inactive</option>
							<?php } ?>										
						</select>
						</div>				              
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  value="<?php echo $row['website']; ?>" name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					<div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" value="<?php echo $row['email']; ?>"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" value="<?php echo $row['company']; ?>" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>	
					 
					 
					    <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_1']; ?>" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_2']; ?>" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" value="<?php echo $row['zip_code']; ?>"  placeholder="ZIP code" name="zip_code" >
						</div>
					
						<div class="col-sm-9">
						   Login link: <span class="mand">*</span>
	<input type="text"  class="form-control" value="<?php echo $row['login_link']; ?>"  placeholder="Eg: https://name.domainname.com" name="login_link" required>
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span> (m-d-y)
		<input type="date" class="form-control" value="<?php echo $row['hosted_date']; ?>" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span> (m-d-y)
	 <input type="date" class="form-control" value="<?php echo $row['renewal_date']; ?>" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
 <input type="number" min="0" class="form-control" value="<?php echo $row['amount']; ?>" placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
	 <input type="text" class="form-control" value="<?php echo $row['remarks']; ?>" name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>				  
								 
					 
					   <div class="form-group row">
					   <div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control" value="<?php echo $row['years']; ?>" placeholder="Years" name="years">
							</div>
					    <div class="col-sm-9">
					   Company logo: (200px X 200px)
		<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">				
			             </div>	
						

						<div class="col-sm-6">
						<br>&nbsp;
						<?php if(!$row["photo"]){?>
				<img class="img-xs rounded-circle" src="customer-logos/1default.jpg" alt="" />
				<?php } else { ?>
				<img class="img-xs rounded-circle hover_big" src="<?php echo $row['photo']; ?>" alt="" /> <?php } ?>	
						</div>
					 </div>
				
               
                    <button type="submit" name="web_update_submit" class="btn btn-info mr-2">Update</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     

<!--    Website ends  -->

<?php }  elseif($_SESSION['pid'] == 7){ 


if(isset($_POST['other_submit'])){
	
	$cust_id = $_POST['cust_id'];
	$pro_id = $_POST['pro_id'];
	$website = $_POST['website'];
	$name = ucwords(strtolower($_POST['name']));
	$company = $_POST['company'];
	$mobile = $_POST['mobile'];
	$email = strtolower($_POST['email']);
	$address_1 = $_POST['address_1'];
	$address_2 = $_POST['address_2'];
	$zip_code = $_POST['zip_code'];	
	$status = $_POST['status'];
	$hosted_date = $_POST['hosted_date'];
	$renewal_date = $_POST['renewal_date'];
	$years = $_POST['years'];
	$amount = $_POST['amount'];	
	$remarks = $_POST['remarks'];

		 
	if(!empty($_FILES['photo']['name'])) //new image uploaded
	{	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`, `pro_id`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`,   `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`, `photo`) VALUES
	('$cust_id', '$pro_id', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',    '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks', '$target_file')";
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a  customer.")</script>';
	}
	else{		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`,  `pro_id`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`) VALUES
	('$cust_id', '$pro_id', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',    '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks')";
	
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a  customer.")</script>';
		}
}
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($add_cus == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_customer" class="btn btn-inverse-info">+ Add  Customer</button>
                </div>            
			</div> <?php } ?>
			  
   <?php 
	$sql23 = "SELECT cust_id  FROM {$prefix}customers where pro_id = 7 order by cust_id desc";
	$result23 = mysqli_query($conn, $sql23); 
	if(mysqli_num_rows($result23) > 0){
	$row23 = mysqli_fetch_assoc($result23);	
	$cust_id = $row23['cust_id'];
	$new_cust_id = $cust_id+1;
	}	
	else{
	$new_cust_id = 1;	
	}
 ?>			  
			  <!-- Add customer modal starts -->			  
<div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New  Customer - <?php echo $new_cust_id; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
                  						 
		<input type="text" class="form-control" id="cust_id"  name="cust_id" value="<?php echo $new_cust_id; ?>" hidden required>
		<input type="number" name="pro_id" value="7" hidden required>
							
					<div class="form-group row">
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" id="name" placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
					     <input type="number" min="0" class="form-control" id="mobile"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
		
					 <div class="form-group row"> 
					<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<option value="">Select status</option>							
							<option value="1">Active</option>
							<option value="0">Inactive</option>										
						</select>
						</div>
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					 <div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" id="email"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" id="company" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>		
					 					 
					   <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" id="address_1" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" id="address_2" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" id="zip_code"  placeholder="ZIP code" name="zip_code" >
						</div>
						
															 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span>
							 <input type="date" class="form-control" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span>
							 <input type="date" class="form-control" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
					    <input type="number" min="0" class="form-control"  placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
							 <input type="text" class="form-control"  name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>
						<div class="form-group row">
						<div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control"  placeholder="Years" name="years">
							</div>
							<div class="col-sm-9">
						   Company logo: (200px X 200px)
							<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">  
							</div>
							
						 </div>
						
                    <button type="submit" name="other_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add customer modal ends -->



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$sqlQuery = "SELECT * FROM {$prefix}customers where  pro_id = 7 and delete_status = 0";
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						<h4 class="card-title">Customer list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table">
							  <thead>
								<tr>
								  <th>#</th>
								  <th>Customer ID</th>
								  <th>Hosted On</th>
								  <th>Renewal</th>
								  <th>Years</th>
								  <th>Amount</th>
								  <th>Name</th>								    
								  <th>Mobile</th>
								  <th>Email</th>
								  <th>Company</th>
								  <th>Status</th>
								  <?php if($edit_cus == 1 || $del_cus == 1){ ?>
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
                    'url':'ajax-other-customer-list.php'
                },
                'columns': [
					{ data: 'ed_no' },
					{ data: 'cust_id' },
					{ data: 'hosted_date' },
					{ data: 'renewal_date' },
					{ data: 'years' },						
					{ data: 'amount' },	
					{ data: 'name' },
				    { data: 'mobile' },
					{ data: 'email' },
					{ data: 'company' },	
					{ data: 'status' },					
					 <?php if($edit_cus == 1 || $del_cus == 1){ ?>
					{ data: 'actions' },
					 <?php } ?>
                ],
				 'columnDefs': [ {
					'targets': [], // column index (start from 0)
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
        window.location.href='customers?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}customers` SET `delete_status` = 1 WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Customer has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "customers"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='customers?edit_id='+id;
	     
}
</script>			  
			  <?php
if(isset($_GET['edit_id'])){
	
	$sql = "SELECT * FROM {$prefix}customers WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_customer').modal('show');
		});
		</script>";
	}		
?>

<?php

if(isset($_POST['other_update_submit'])){
	
	  if(!empty($_FILES['photo']['name'])) //new image uploaded
	{
	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
	$sql = "UPDATE `{$prefix}customers` SET   
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	 `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',   `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."', `photo` = '$target_file' WHERE id = '".$_POST['id']."' ";
	mysqli_query($conn, $sql);	
	echo '<script> alert("Customer details has been updated.")</script>';
	}
	else{
		$sql = "UPDATE `{$prefix}customers` SET  
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	 `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',  `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."' WHERE id = '".$_POST['id']."' ";	
		mysqli_query($conn, $sql);	
echo '<script> alert("Customer details has been updated.")</script>';
		
	}
}
?>

<!-- Edit customer modal starts -->			  
<div class="modal fade" id="edit_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit  Customer - <?php echo $row['cust_id']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
				  <div class="form-group row">
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" value="<?php echo $row['name']; ?>"  placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
	<input type="number" min="0" class="form-control" value="<?php echo $row['mobile']; ?>"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
					 
					  <div class="form-group row"> 
					  	<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<?php if($row['status']==1){?>
							<option value="1" selected>Active</option>
							<option value="0" >Inactive</option>
							<?php }elseif($row['status']==0){?>
							<option value="1" >Active</option>
							<option value="0" selected>Inactive</option>
							<?php } ?>										
						</select>
						</div>				              
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  value="<?php echo $row['website']; ?>" name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					<div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" value="<?php echo $row['email']; ?>"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" value="<?php echo $row['company']; ?>" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>	
					 
					 
					    <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_1']; ?>" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_2']; ?>" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" value="<?php echo $row['zip_code']; ?>"  placeholder="ZIP code" name="zip_code" >
						</div>
					
																 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span> (m-d-y)
		<input type="date" class="form-control" value="<?php echo $row['hosted_date']; ?>" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span> (m-d-y)
	 <input type="date" class="form-control" value="<?php echo $row['renewal_date']; ?>" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
 <input type="number" min="0" class="form-control" value="<?php echo $row['amount']; ?>" placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
	 <input type="text" class="form-control" value="<?php echo $row['remarks']; ?>" name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>				  
								 
					 
					   <div class="form-group row">
					   <div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control" value="<?php echo $row['years']; ?>" placeholder="Years" name="years">
							</div>
					    <div class="col-sm-9">
					   Company logo: (200px X 200px)
		<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">				
			             </div>	
						

						<div class="col-sm-6">
						<br>&nbsp;
						<?php if(!$row["photo"]){?>
				<img class="img-xs rounded-circle" src="customer-logos/1default.jpg" alt="" />
				<?php } else { ?>
				<img class="img-xs rounded-circle hover_big" src="<?php echo $row['photo']; ?>" alt="" /> <?php } ?>	
						</div>
					 </div>
				
               
                    <button type="submit" name="other_update_submit" class="btn btn-info mr-2">Update</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     

<!--    Other ends and iPro starts  -->

<?php } elseif($_SESSION['pid']== 8){
	
	
	
// Function to create folder structure
function createCustomerFolders($cust_id) {
    $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/test'; // Update path as needed
    $customerDir = $baseDir . '/' . $cust_id;
    $subfolders = ['clients', 'estimations', 'logos', 'projects', 'staffs', 'sub', 'sup'];

    if (!file_exists($baseDir)) {
        mkdir($baseDir, 0777, true);
    }

    if (!file_exists($customerDir)) {
        mkdir($customerDir, 0777, true);
    }

    foreach ($subfolders as $subfolder) {
        $subfolderPath = $customerDir . '/' . $subfolder;
        if (!file_exists($subfolderPath)) {
            mkdir($subfolderPath, 0777, true);
        }
    }
}

if(isset($_POST['ipro_submit'])){
	
	$cust_id = $_POST['cust_id'];
	$pro_id = $_POST['pro_id'];
	$ver = $_POST['ver'];
	$website = $_POST['website'];
	$name = ucwords(strtolower($_POST['name']));
	$company = $_POST['company'];
	$mobile = $_POST['mobile'];
	$email = strtolower($_POST['email']);
	$address_1 = $_POST['address_1'];
	$address_2 = $_POST['address_2'];
	$zip_code = $_POST['zip_code'];	
	$status = $_POST['status'];
	$login_link = 'https://ipro.com';	
	$hosted_date = $_POST['hosted_date'];
	$renewal_date = $_POST['renewal_date'];
	$years = $_POST['years'];
	$amount = $_POST['amount'];	
	$remarks = $_POST['remarks'];
		 
	if(!empty($_FILES['photo']['name'])) //new image uploaded
	{	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`, `pro_id`, `ver`, `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`, `photo`) VALUES
	('$cust_id', '$pro_id', '$ver', '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks', '$target_file')";
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added an iPro customer.")</script>';
	}
	else{		
	$sql2 ="INSERT INTO `{$prefix}customers`(`cust_id`, `pro_id`, `ver`,  `website`, `name`, `company`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`,  `status`, `login_link`,  `hosted_date`, `renewal_date`, `years`, `amount`,  `remarks`) VALUES
	('$cust_id', '$pro_id', '$ver',  '$website', '$name', '$company', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$status',   '$login_link', '$hosted_date', '$renewal_date', '$years', '$amount',  '$remarks')";
	
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added an iPro customer.")</script>';
		}
	
if($ver == 1 || $ver == 2 || $ver == 3){	
	 createCustomerFolders($cust_id);
}
}
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($add_cus == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_customer" class="btn btn-inverse-info">+ Add i Pro Customer</button>
                </div>            
			</div><?php } ?>
			  
   <?php 
	$sql23 = "SELECT cust_id  FROM {$prefix}customers  where pro_id = 8 order by cust_id desc";
	$result23 = mysqli_query($conn, $sql23); 
	if(mysqli_num_rows($result23) > 0){
	$row23 = mysqli_fetch_assoc($result23);	
	$cust_id = $row23['cust_id'];
	$new_cust_id = $cust_id+1;
	}	
	else{
	$new_cust_id = 28112024;	
	}
 ?>			  
			  <!-- Add customer modal starts -->			  
<div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New i Pro Customer - <?php echo $new_cust_id; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
                  						 
		<input type="text" class="form-control" id="cust_id"  name="cust_id" value="<?php echo $new_cust_id; ?>" hidden required>
	<input type="number" name="pro_id" value="1" hidden required>
							
					<div class="form-group row">
					<div class="col-sm-3">
					   Ver: <span class="mand">*</span>
                        <select required  name="ver"  id="ver" class="select_dropdown" style="width:100%">
							<option value="">Select ver</option>
							<option value="1">Enterprise Basic V 1.4.7</option>
							<option value="2">Enterprise Starter V 2.4.7</option>
							<option value="3">Enterprise Advanced V 3.4.7</option>							
							<option value="4">Premium Basic V 1.4.7</option>
							<option value="5">Premium Starter V 2.4.7</option>
							<option value="6">Premium Advanced V 3.4.7</option>
						</select>
					  </div>
					 <div class="col-sm-5">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" id="name" placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-4">
					  Mobile: <span class="mand">*</span>
					     <input type="number" min="0" class="form-control" id="mobile"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
		
					 <div class="form-group row"> 
					<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<option value="">Select status</option>							
							<option value="1">Active</option>
							<option value="0">Inactive</option>										
						</select>
						</div>
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					 <div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" id="email"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" id="company" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>		
					 					 
					   <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" id="address_1" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" id="address_2" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" id="zip_code"  placeholder="ZIP code" name="zip_code" >
						</div>
						
						<div class="col-sm-9">
						   
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span>
							 <input type="date" class="form-control" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span>
							 <input type="date" class="form-control" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
					    <input type="number" min="0" class="form-control"  placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
							 <input type="text" class="form-control"  name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>
						<div class="form-group row">
						<div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control"  placeholder="Years" name="years">
							</div>
							<div class="col-sm-9">
						   Company logo: (200px X 200px)
							<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">  
							</div>
							
						 </div>
						
                    <button type="submit" name="ipro_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add customer modal ends -->



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$sqlQuery = "SELECT * FROM {$prefix}customers where delete_status = 0 and pro_id = 8";
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						  <h4 class="card-title">i Pro customer list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table">
							  <thead>
								<tr>
								  <th>#</th>
								  <th>Customer ID</th>	
								  <th>Version</th>
								  <th>Hosted On</th>
								  <th>Renewal</th>
								  <th>Years</th>
								  <th>Amount</th>
								  <th>Name</th>								    
								  <th>Mobile</th>
								  <th>Email</th>
								  <th>Company</th>
								  <th>Login Link</th>
								  <th>Status</th>
								  <?php if($edit_cus == 1 || $del_cus == 1){ ?>
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
                    'url':'ajax-ipro-customer-list.php'
                },
                'columns': [
					{ data: 'ed_no' },
					{ data: 'cust_id' },
				    { data: 'ver' },
					{ data: 'hosted_date' },
					{ data: 'renewal_date' },
					{ data: 'years' },						
					{ data: 'amount' },	
					{ data: 'name' },
				    { data: 'mobile' },
					{ data: 'email' },
					{ data: 'company' },		 
					{ data: 'login_link' },	
					{ data: 'status' },	
					 <?php if($edit_cus == 1 || $del_cus == 1){ ?>
					{ data: 'actions' },
					 <?php } ?>
                ],
				 'columnDefs': [ {
					'targets': [], // column index (start from 0)
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
        window.location.href='customers?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}customers` SET `delete_status` = 1 WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Customer has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "customers"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='customers?edit_id='+id;
	     
}
</script>			  

<?php
if(isset($_GET['edit_id'])){
	
	$sql = "SELECT * FROM {$prefix}customers WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_customer').modal('show');
		});
		</script>";
	}		
?>

<?php

if(isset($_POST['ipro_update_submit'])){
	
	$chk_id = $_POST['id'];

	
	  if(!empty($_FILES['photo']['name'])) //new image uploaded
	{
	 
	$target_dir = "customer-logos/";
    $target_file = $target_dir .rand(). basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $orig_image = imagecreatefromjpeg($target_file);
	$image_info = getimagesize($target_file); 
	$width_orig  = $image_info[0]; // current width as found in image file
	$height_orig = $image_info[1]; // current height as found in image file
	$width = 200; // new image width
	$height = 200; // new image height
	$destination_image = imagecreatetruecolor($width, $height);	
	imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// This will just copy the new image over the original at the same filePath.
	imagejpeg($destination_image, $target_file, 100);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
	$sql = "UPDATE `{$prefix}customers` SET  `ver` = '".$_POST['ver']."', 
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	 `hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',   `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."', `photo` = '$target_file' WHERE id = '".$_POST['id']."' ";
	mysqli_query($conn, $sql);	
	echo '<script> alert("iPro customer details has been updated.")</script>';
	}
	else{
		$sql = "UPDATE `{$prefix}customers` SET  `ver` = '".$_POST['ver']."', 
	`website` = '".$_POST['website']."', `name` = '".ucwords(strtolower($_POST['name']))."', `company` = '".$_POST['company']."',
	`mobile` = '".$_POST['mobile']."',	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."', 
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."',  `status` = '".$_POST['status']."', 
	`hosted_date` = '".$_POST['hosted_date']."', `renewal_date` = '".$_POST['renewal_date']."',  `years` = '".$_POST['years']."', `amount` = '".$_POST['amount']."', `remarks` = '".$_POST['remarks']."' WHERE id = '".$_POST['id']."' ";	
		mysqli_query($conn, $sql);	
echo '<script> alert("iPro customer details has been updated.")</script>';
		
	}
 
}

$versions = [
    1 => 'Enterprise  Basic V 1.4.7',
    2 => 'Enterprise Starter V 2.4.7',
    3 => 'Enterprise Advanced V 3.4.7',
    4 => 'Premium Basic V 1.4.7',
    5 => 'Premium Starter V 2.4.7',
    6 => 'Premium Advanced V 3.4.7'
];
?>

<!-- Edit customer modal starts -->			  
<div class="modal fade" id="edit_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Customer - <?php echo $row['cust_id']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="customers" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
				  <div class="form-group row">
					<div class="col-sm-3">
					   Ver : <span class="mand">*</span>
                        <select required  name="ver"  id="ver" class="select_dropdown" style="width:100%">
							<?php foreach ($versions as $key => $version): ?>
				<option value="<?php echo $key; ?>" <?php echo ($row['ver'] == $key) ? 'selected' : ''; ?>>
				<?php echo $version; ?>
				</option>
				<?php endforeach; ?>											
						</select>
					  </div>
					 <div class="col-sm-5">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" value="<?php echo $row['name']; ?>"  placeholder="Name"  name="name" required>
					  </div>					  
                      <div class="col-sm-4">
					  Mobile: <span class="mand">*</span>
	<input type="number" min="0" class="form-control" value="<?php echo $row['mobile']; ?>"  placeholder="Mobile" name="mobile" required>
					  </div>				 
					 </div>
					 
					  <div class="form-group row"> 
					  	<div class="col-sm-3">	
						Status: <span class="mand">*</span>
						 <select required  name="status"  id="status" class="select_dropdown" style="width:100%">
							<?php if($row['status']==1){?>
							<option value="1" selected>Active</option>
							<option value="0" >Inactive</option>
							<?php }elseif($row['status']==0){?>
							<option value="1" >Active</option>
							<option value="0" selected>Inactive</option>
							<?php } ?>										
						</select>
						</div>				              
                      <div class="col-sm-9">
					  Website:
                        <input type="text" class="form-control"  value="<?php echo $row['website']; ?>" name="website" placeholder="Website address">
					  </div>
					   </div>
					   
					<div class="form-group row">
					<div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" value="<?php echo $row['email']; ?>"  name="email" placeholder="Email" required>
					  </div>					 
					 <div class="col-sm-6">
						Company : <span class="mand">*</span>
						 <input type="text" class="form-control" value="<?php echo $row['company']; ?>" placeholder="Company name"  name="company" required>
						</div>					  
					 </div>	
					 
					 
					    <div class="form-group row">
					    <div class="col-sm-6">
						Address line 1 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_1']; ?>" placeholder="Address line 1"  name="address_1" >
						</div>
					    <div class="col-sm-6">
						Address line 2 : 
						 <input type="text" class="form-control" value="<?php echo $row['address_2']; ?>" placeholder="Address line 2"  name="address_2">
						</div>					   															  
						</div>
						<div class="form-group row">
						 <div class="col-sm-3">
					   ZIP code:
                        <input type="number" min="0" class="form-control" value="<?php echo $row['zip_code']; ?>"  placeholder="ZIP code" name="zip_code" >
						</div>
					
						<div class="col-sm-9">
						   Login link: <span class="mand">*</span>
	<input type="text"  class="form-control" value="<?php echo $row['login_link']; ?>" placeholder="Eg: https://name.ipro.com"   readonly>
						  </div>										 
						 </div>
						 <div class="form-group row">
						   <div class="col-sm-4">
							Hosted on: <span class="mand">*</span> (m-d-y)
		<input type="date" class="form-control" value="<?php echo $row['hosted_date']; ?>" id="hosted_date"  name="hosted_date" required>
						  </div>
							<div class="col-sm-4">
							Next renewal: <span class="mand">*</span> (m-d-y)
	 <input type="date" class="form-control" value="<?php echo $row['renewal_date']; ?>" id="renewal_date"  name="renewal_date" required>
							</div>
							<div class="col-sm-4">
							Amount: <span class="mand">*</span>
 <input type="number" min="0" class="form-control" value="<?php echo $row['amount']; ?>" placeholder="Yearly amount" name="amount" required>
							</div>
						  </div>
						  <div class="form-group row">
						   <div class="col-sm-12">
							Remarks: 
	 <input type="text" class="form-control" value="<?php echo $row['remarks']; ?>" name="remarks"  placeholder="Remarks if any">
						  </div>
							</div>				  
								 
					 
					   <div class="form-group row">
					   <div class="col-sm-3">
							Total years: 
					    <input type="number" min="0" class="form-control" value="<?php echo $row['years']; ?>" placeholder="Years" name="years">
							</div>
					    <div class="col-sm-9">
					   Company logo: (200px X 200px)
		<input type="file"  class="form-control"  value="" name="photo" id="photo" accept="image/x-png, image/jpeg">				
			             </div>	
						

						<div class="col-sm-6">
						<br>&nbsp;
						<?php if(!$row["photo"]){?>
				<img class="img-xs rounded-circle" src="customer-logos/1default.jpg" alt="" />
				<?php } else { ?>
				<img class="img-xs rounded-circle hover_big" src="<?php echo $row['photo']; ?>" alt="" /> <?php } ?>	
						</div>
					 </div>
				
               
                    <button type="submit" name="ipro_update_submit" class="btn btn-info mr-2">Update</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     

<!-- i Pro Ends -->

<?php } ?>

 <?php require('footer.php'); ?>