<?php 
session_start();
$role_id = $_SESSION['role_id'];
$user_id = $_SESSION['user_id'];

require('sheader.php');
require('sa-permission.php');
require('sadmin-sidebar.php');

$today_date = date("Y-m-d");


if(isset($_POST['user_submit'])){
	
	$name = ucwords(strtolower($_POST['name']));	
	$mobile = $_POST['mobile'];
	$email = strtolower($_POST['email']);
	$address_1 = $_POST['address_1'];
	$address_2 = $_POST['address_2'];
	$zip_code = $_POST['zip_code'];
	$password =  md5($_POST['password']);
	$last_pass = $_POST['password'];
	$role_id = $_POST['role_id'];
	$status = $_POST['status'];

	$sql8 = "select * from {$prefix}users where (email = '$email' || mobile = '$mobile') and delete_status = 0 ";
	$res8 =  mysqli_query($conn, $sql8);
	if(mysqli_num_rows($res8) > 0){
		echo '<script> alert("An user with this email or mobile already exists! Please use another one.")</script>'; 
	}
	else{		 
	if(!empty($_FILES['photo']['name'])) //new image uploaded
	{	 
	$target_dir = "user-photos/";
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
	
		
	$sql2 ="INSERT INTO `{$prefix}users`(`name`,  `mobile`, `email`, `address_1`,  `address_2`, `zip_code`, `password`, `last_pass`, `role_id`, `status`, `photo`) VALUES
	('$name',  '$mobile', '$email', '$address_1', '$address_2',  '$zip_code',  '$password', '$last_pass', '$role_id', '$status', '$target_file')";
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a User.")</script>';
	}
	else{		
		$sql2 ="INSERT INTO `{$prefix}users`(`name`,  `mobile`, `email`, `address_1`,  `address_2`, `zip_code`, `password`, `last_pass`, `role_id`, `status`) VALUES
	('$name',  '$mobile', '$email', '$address_1', '$address_2',  '$zip_code',  '$password', '$last_pass', '$role_id',
	'$status')";
	
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a User.")</script>';
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
				 <button type="button" data-toggle="modal" data-target="#add_user" class="btn btn-inverse-info">+ Add User</button>
                </div>            
              </div>			  
		  
			  <!-- Add User modal starts -->			  
<div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="smanage-users" method="post" enctype="multipart/form-data">
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
                      <div class="col-sm-6">
					  Email: <span class="mand">*</span>
                        <input type="email" class="form-control" id="email"  name="email" placeholder="Email" required>
					  </div>
					   <div class="col-sm-6">
					  Set a password: <span class="mand">*</span>
                        <input type="password" class="form-control" id="password"  name="password" placeholder="Password" required>
					  </div>
					   </div>
					   
					  <div class="form-group row">                      
                     		   <?php 
					 $sql33 = "SELECT * FROM {$prefix}user_roles where id != 1 order by id ";
					 $result33 = mysqli_query($conn, $sql33); 													
					?>
					   <div class="col-sm-6">	
						User role : <span class="mand">*</span>
						 <select required  name="role_id"  id="role_id" class="select_dropdown" style="width:100%">
							<option value="">Select user role</option>
							<?php 
								if(mysqli_num_rows($result33) > 0){
								while($row33 = mysqli_fetch_assoc($result33)){ ?>
							<option value="<?php echo $row33['id']; ?>"><?php echo $row33['role_name']; ?></option>
							<?php }} ?>				
						</select>
					  </div>
					   <div class="col-sm-6">	
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
						Address line 1 : 
						 <input type="text" class="form-control"  placeholder="Address line 1"  name="address_1" >
						</div>
					 </div>
					 
					  <div class="form-group row"> 
					   <div class="col-sm-12">
						Address line 2 : 
						 <input type="text" class="form-control"  placeholder="Address line 2"  name="address_2" >
						</div>
					 </div>				 
					 					 
					   <div class="form-group row">
					    <div class="col-sm-6">
					   ZIP code: 
                        <input type="number" min="0" class="form-control" id="zip_code"  placeholder="ZIP code" name="zip_code" >
					  </div>	
					<div class="col-sm-6">
					   Photo: (200px X 200px)
				<input type="file"  class="form-control" onchange="return jpg_validation()" value="" name="photo" id="photo1" accept="image/jpeg">  
			            </div>										  
						</div>
						
                    <button type="submit" name="user_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add user modal ends -->



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
 $sqlQuery = "SELECT * FROM {$prefix}users where delete_status = 0 and id != 1";
 $result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						  <h4 class="card-title">User list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table2">
							  <thead>
								<tr>
								  <th>#</th>								 							  
								  <th>Name</th>								    
								  <th>Mobile</th>
								  <th>Email</th>
								  <th>User Role</th>
								  <th>Status</th>
								  <th>Photo</th>
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
            $('#dept_table2').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'sajax-user-list.php'
                },
                'columns': [
					{ data: 'ed_no' },
					{ data: 'name' },				   
					{ data: 'mobile' },
					{ data: 'email' },
					{ data: 'role_id' },	
					{ data: 'status' },					
					{ data: 'photo' },					
					{ data: 'actions' },
                ],
				 'columnDefs': [ {
					'targets': [6,7], // column index (start from 0)
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
        window.location.href='smanage-users?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}users` SET `delete_status` = 1 WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("User has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "smanage-users"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='smanage-users?edit_id='+id;
	     
}
</script>			  
			  <?php
if(isset($_GET['edit_id'])){
	
	$sql = "SELECT * FROM {$prefix}users WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_user').modal('show');
		});
		</script>";
			}		
?>

<?php

if(isset($_POST['user_update_submit'])){
	
	$chk_id = $_POST['id'];
	
		$sql8 = "select * from {$prefix}users where (email = '".$_POST['email']."' || mobile = '".$_POST['mobile']."') and delete_status = 0 
		 and id != '$chk_id'  ";
	$res8 =  mysqli_query($conn, $sql8);
	if(mysqli_num_rows($res8) > 0){
		echo '<script> alert("An user with this email or mobile already exists! Please use another one.")</script>'; 
	}
	else{
	
	  if(!empty($_FILES['photo']['name'])) //new image uploaded
	{
	 
	$target_dir = "user-photos/";
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
	
	$sql = "UPDATE `{$prefix}users` SET    `name` = '".ucwords(strtolower($_POST['name']))."',  `mobile` = '".$_POST['mobile']."',
	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."',
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."', `password` = '".md5($_POST['password'])."', `last_pass` = '".$_POST['password']."',
	`role_id` = '".$_POST['role_id']."',  `status` = '".$_POST['status']."', `photo` = '$target_file' WHERE id = '".$_POST['id']."'";
	mysqli_query($conn, $sql);	
echo '<script> alert("User details has been updated.")</script>';
	}
	else{
		$sql = "UPDATE `{$prefix}users` SET    `name` = '".ucwords(strtolower($_POST['name']))."',  `mobile` = '".$_POST['mobile']."',
	`email` = '".strtolower($_POST['email'])."', `address_1` = '".$_POST['address_1']."',
	`address_2` = '".$_POST['address_2']."', `zip_code` = '".$_POST['zip_code']."', `password` = '".md5($_POST['password'])."',  `last_pass` = '".$_POST['password']."',
	`role_id` = '".$_POST['role_id']."',  `status` = '".$_POST['status']."'  WHERE id = '".$_POST['id']."'";	
		mysqli_query($conn, $sql);	
echo '<script> alert("User details has been updated.")</script>';
		
	}
 }

}
?>

<!-- Edit User modal starts -->		
	  
<div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="smanage-users" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
				  
				  	 <div class="form-group row">			
					 <div class="col-sm-6">
					   Name: <span class="mand">*</span>
                        <input type="text"  class="form-control" value="<?php echo $row['name']; ?>" placeholder="Name"   name="name" required>
					  </div>					  
                      <div class="col-sm-6">
					  Mobile: <span class="mand">*</span>
		<input type="number" min="0" class="form-control" placeholder="Mobile" value="<?php echo $row['mobile']; ?>" id="mobile"  name="mobile" required>
					  </div>				 
					 </div>

					<div class="form-group row">                      
                      <div class="col-sm-6">
					  Email: 
                        <input type="email" class="form-control"  placeholder="Email" name="email" value="<?php echo $row['email']; ?>" readonly>
					  </div>
					<div class="col-sm-6">
					  Password: (Inorder to update)<span class="mand">*</span>
                        <input type="password" class="form-control" placeholder="Last password - <?php echo $row['last_pass']; ?> " name="password" value="" required>
					  </div>					  
					 </div>		
					<div class="form-group row">
							<?php
							$sql2 = "SELECT * FROM {$prefix}user_roles where id!=1 order by id";
							$result2 = mysqli_query($conn, $sql2)
							?>					
							<div class="col-sm-6">
							User role : <span class="mand">*</span>
							   <select required  name="role_id"  id="role_id" class="select_dropdown" style="width:100%">
								<option value="">Select user role</option>
								<?php if (mysqli_num_rows($result2) > 0) {
								while($row2 = mysqli_fetch_assoc($result2)) {
									$selected = "";
									if ($row2['id'] == $row['role_id'])
									$selected = "selected";							
									?>
							<option class="" value="<?php echo $row2['id'];  ?>" <?php echo $selected; ?>><?php echo $row2['role_name']; }} ?></option>
								</select>
								</div>					
						<div class="col-sm-6">
						Status : <span class="mand">*</span>
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
				</div>						
				
					 
					  <div class="form-group row">
						   <div class="col-sm-12">
							Address line 1 : 
 <input type="text" class="form-control" id="address"  value="<?php echo $row['address_1']; ?>"  placeholder="Address line 1" name="address_1" >
							</div>					
					  </div>

						<div class="form-group row">
						   <div class="col-sm-12">
							Address line 2 : 
 <input type="text" class="form-control" id="address"  value="<?php echo $row['address_2']; ?>"  placeholder="Address line 2" name="address_2" >
							</div>					
					  </div>		 
					 					  
					 
					   <div class="form-group row">
					    <div class="col-sm-6">
					   ZIP code:
      <input type="number" min="0" class="form-control" placeholder="ZIP code" id="zip_code" value="<?php echo $row['zip_code']; ?>"  name="zip_code" >
					  </div>
						   <div class="col-sm-6">
					   Photo: (200px X 200px)
			<input type="file"  class="form-control" onchange="return jpg_validation2()"  value="" name="photo" id="photo2" accept="image/jpeg"> 
						<br>
						<?php if(!$row["photo"]){?>
							<img class="img-xs rounded-circle" src="user-photos/1default.jpg" alt="" />
							<?php } else { ?>
							<img class="img-xs rounded-circle hover_big" src="<?php echo $row['photo']; ?>" alt="" /> <?php } ?>						
			             </div>
															  
					 </div>
				
               
                    <button type="submit" name="user_update_submit" class="btn btn-info mr-2">Update</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     

<!--  Edit User modal ends -->



<script>
function jpg_validation() {
	
	  var selectedFile = document.getElementById('photo1').files[0];
      var allowedTypes = ['image/jpeg'];

         if (!allowedTypes.includes(selectedFile.type)) {
            alert('Invalid file type. Please upload a jpg or jpeg file.');
            document.getElementById('photo1').value = '';
         }	
}

function jpg_validation2() {

 var selectedFile2 = document.getElementById('photo2').files[0];
     var allowedTypes2 = ['image/jpeg'];
         if (!allowedTypes2.includes(selectedFile2.type)) {
            alert('Invalid file type. Please upload a jpg or jpeg file.');
            document.getElementById('photo2').value = '';
         }
		 
}
	 
</script>


 <?php require('footer.php'); ?>