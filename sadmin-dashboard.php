<?php 
session_start();
$role_id = $_SESSION['role_id'];

require('sheader.php');
require('sadmin-sidebar.php');

$user_id = $_SESSION['user_id'];

$sql2 ="DELETE FROM {$prefix}logins WHERE id NOT IN (SELECT id FROM (SELECT id FROM {$prefix}logins ORDER BY id DESC LIMIT 250) x ); ";
    $result_up = mysqli_query($conn, $sql2);

$today_date = date('Y-m-d');
$today_date_plus_30 = date('Y-m-d', strtotime('+30 day', strtotime($today_date)));
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome to RT Management System</h3>
                  <h6 class="font-weight-normal mb-0">All systems are running smoothly! </h6>
                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                    <button class="btn btn-sm btn-light bg-white " type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                     <i class="mdi mdi-calendar"></i> Today ( <?php echo date('d-M-Y'); ?> )
                    </button>                  
                  </div>
                 </div>
                </div>
              </div>
            </div>
          </div>
		  
		  		  
		  <div class="row">
			    <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title mb-0">Renewals</p>
                  <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                      <thead>
                        <tr>
						  <th>#</th>
						  <th>Days Left</th>
                          <th>Product</th>
						  <th>Name & Organization</th>				
						  <th>Mobile</th>
						  <th>Amount</th> 
                          <th>Renewal Date</th>                                                 
						  
                        </tr>  
                      </thead>
                      <tbody>
					  <?php
				$sql31 = "SELECT *,  DATEDIFF(renewal_date, '$today_date') AS days_left   FROM {$prefix}customers  inner join {$prefix}products on {$prefix}products.id = {$prefix}customers.pro_id where  delete_status = 0 ORDER BY     days_left ASC";
				$result31 =  mysqli_query($conn, $sql31);
					if(mysqli_num_rows($result31)>0){
						$serial = 0;
				while($row31 = mysqli_fetch_assoc($result31)){
					 $renewal_dat = new DateTime($row31['renewal_date']);
					$today_dat = new DateTime($today_date);
					$days_left = $today_dat->diff($renewal_dat);
					$left = (int) $days_left->format('%r%a');
					$serial++;
				?>
				
                        <tr>						
						  <td><?php echo $serial; ?></td>
						   <?php if($left >= 31){ ?>
     <td class="font-weight-medium"><div class="badge badge-success"><?php echo $left.' days'; ?></div></td>
	 <?php } else if ($left < 31 && $left > 5){ ?>
	 <td class="font-weight-medium"><div class="badge badge-warning"><?php echo $left.' days'; ?></div></td>
	 <?php } elseif($left <= 5){?>
	 <td class="font-weight-medium"><div class="badge badge-danger"><?php echo $left.' days'; ?></div></td>
	 <?php } ?>
                          <td><?php echo $row31["p_name"]; ?></td>
						  <td><a href="customers?pid=<?php echo $row31["pro_id"]; ?> "><?php echo $row31["name"].' | '.$row31["company"]; ?></a></td>
						  <td><a href="tel:<?php echo $row31["mobile"]; ?> "><?php echo $row31["mobile"]; ?></a></td>						  
                          <td class="font-weight-bold"><?php echo $row31["amount"]; ?></td>   
						  <td><?php echo  date('d-m-Y', strtotime($row31['renewal_date'])); ?></td>	
	 
                        </tr>
					<?php }} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
		   </div>
	  
	  
	    
        </div>
        <!-- content-wrapper ends -->
		
		
		
		
 <?php

    if(isset($_POST['profile_submit'])){
	 $name = $_POST['name'];
	 $mobile = $_POST['mobile'];
	 $email = $_POST['email'];
	 $address_1 = $_POST['address_1'];
	 $address_2 = $_POST['address_2'];
	 $zip_code = $_POST['zip_code'];
		 
	  if(!empty($_FILES['photo']['name'])) //new image uploaded
	{
	 
	$target_dir = "user-photos/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
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
	}

    $image=basename( $_FILES["photo"]["name"],".jpg");
	
	
	    $sql2 ="UPDATE `{$prefix}users` SET `name` = '$name', `mobile` = '$mobile', `address_1` = '$address_1', `address_2` = '$address_2',
		`zip_code` = '$zip_code', `photo` = '$target_file' WHERE `{$prefix}users`.`email` = '$email'";
		
		$result_up = mysqli_query($conn, $sql2);		
		echo '<script> alert("You have successfully updated the profile.")</script>';	 
       
	}
	else{
	  $sql2 ="UPDATE `{$prefix}users` SET `name` = '$name', `mobile` = '$mobile', `address_1` = '$address_1', `address_2` = '$address_2',   `zip_code` = '$zip_code'  WHERE `{$prefix}users`.`email` = '$email'";		
		$result_up = mysqli_query($conn, $sql2); 
      
		
	echo '<script> alert("You have successfully updated  the profile.")</script>';		
		}
		
	}



   if(isset($_POST['password_submit'])){
		$email = $_SESSION['email'];
		$oldpassword = md5($_POST['oldpassword']);
		
		$sql = "SELECT email, password from {$prefix}users where email='$email'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0 ){
			while($row = mysqli_fetch_assoc($result))
			{		
				
				if ($oldpassword !=  $row['password'])
				{//echo $row['password'];
					echo '<script> alert("Old password doesn\'t match with the current password.")</script>';
					
				}
				else {
					 $password = md5($_POST['npassword']);
					 				 
					 $sql2 = "UPDATE  `{$prefix}users` SET `password` = '$password'  WHERE `{$prefix}users`.`email` = '$email'";
					 $result2 = mysqli_query($conn, $sql2);
					 
					echo '<script> alert("You have successfully changed the password.")</script>';
				}			
			}			
		}
	}
	
	
	
if(isset($_POST['support_submit'])){
	
	 $support_no = $_POST['support_no'];
	 $content = $_POST['content'];

	  $sql2 ="UPDATE `{$prefix}support` SET `support_no` = '$support_no', `content` = '$content' WHERE id = 1 ";		
	$result_up = mysqli_query($conn, $sql2); 
      
		
	echo '<script> alert("You have successfully updated  support details.")</script>';		
		
		
	}
		
?>
 <?php require('footer.php'); ?>