<?php
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location:../../index');
    exit;
}

date_default_timezone_set('Asia/Kolkata');
$cookie_name = "loggedout";   // In footer JS function
$cookie_value = -1;
setcookie($cookie_name, $cookie_value);  

$today_date = date('Y-m-d');
$today_date_plus_5 = date('Y-m-d', strtotime('+5 day', strtotime($today_date)));
$today_date_plus_1 = date('Y-m-d', strtotime('+1 day', strtotime($today_date)));

//print_r($today_date_plus_1);
//exit;
?>
<?php
require ("db_config.php");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if not logged in
    header("Location: index");
    exit();
}

$email = $_SESSION['email'];


	$result= mysqli_query($conn, "SELECT *, {$prefix}users.id as user_id FROM `{$prefix}users` 	WHERE email = '$email';");								  
	if(mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
	$user_id = $row['user_id'];
	}
	
	$_SESSION['user_id'] = $user_id;
?>


<?php
	$sql77 = "SELECT count(id) as total_count,
	COUNT(CASE WHEN status_id = 1 THEN 1 END) AS call_count,
	COUNT(CASE WHEN status_id = 2 THEN 1 END) AS meet_count,
	COUNT(CASE WHEN status_id = 3 THEN 1 END) AS follow_count,
	COUNT(CASE WHEN status_id = 4 THEN 1 END) AS demo_count,
	COUNT(CASE WHEN status_id = 5 THEN 1 END) AS converted_count,
	COUNT(CASE WHEN status_id = 6 THEN 1 END) AS nil_count
	FROM  {$prefix}enquiries";
	$res77 = mysqli_query($conn, $sql77);
	if(mysqli_num_rows($res77) > 0){
	$row77 = mysqli_fetch_array($res77);
	$total_count = $row77['total_count'];
	$call_count = $row77['call_count'];
	$meet_count = $row77['meet_count'];
	$follow_count = $row77['follow_count'];
	$demo_count = $row77['demo_count'];
	$converted_count = $row77['converted_count'];
	$nil_count = $row77['nil_count'];
	}	
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>RT Management System</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>
<body>
<script type="text/javascript">
function logout()
{
     if(confirm('Are you sure you want to logout from this session?'))
     {
        window.location.href='logout';
     }
}
</script>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="javascript:void(0);"><img src="images/logo.png" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="javascript:void(0);"><img src="images/logo-mini.png" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
    
        <ul class="navbar-nav navbar-nav-right">  
          <li class="nav-item nav-profile dropdown">
<a class="link" href="scall-sheet"><button type="button" class="btn btn-primary call_sheet">Call Sheet - <?php echo $call_count; ?></button></a>
<a class="link for_comp" href="smeet-sheet"><button type="button" class="btn btn-secondary call_sheet">Meeting - <?php echo $meet_count; ?></button></a>
<a class="link for_comp" href="sfollow-sheet"><button type="button" class="btn btn-info call_sheet">Follow Up - <?php echo $follow_count; ?></button></a>
<a class="link for_comp" href="sdemo-sheet"><button type="button" class="btn btn-warning call_sheet">Using Demo - <?php echo $demo_count; ?></button></a>
<a class="link for_comp" href="sconverted-sheet"><button type="button" class="btn btn-success call_sheet">Converted - <?php echo $converted_count; ?></button></a>
<a class="link for_comp" href="snil-sheet"><button type="button" class="btn btn-danger call_sheet">Nil - <?php echo $nil_count; ?></button></a>
		 
		 
		
		
		  
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
			<?php if(!empty($row['photo'])){ ?>
              <img src="<?php echo $row['photo'];?>" alt="Profile"/>
			<?php } else{ ?>
			 <img src="user-photos/1default.jpg" alt="Profile"/>
			<?php } ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
			 <a class="dropdown-item" data-toggle="modal" data-target="#admin-profile">			 
              <i class="mdi mdi-face-profile  menu-icon"></i>
                Profile
              </a>
			   <a class="dropdown-item" data-toggle="modal" data-target="#admin-password">
              <i class="mdi mdi-onepassword  menu-icon"></i>
               Change Password
              </a>
			  <a class="dropdown-item" target="_blank"                                                                       href="https://drive.google.com/drive/folders/11Heig0O9HYpKP4S2iW_IL5ozlapXxScb?usp=drive_link">
              <i class="mdi mdi-file-tree  menu-icon"></i>
              RT Files
              </a>	
			 <a class="dropdown-item" data-toggle="modal" data-target="#support">			 
              <i class="mdi mdi-whatsapp   menu-icon"></i>
                Support
              </a>
			   <a class="dropdown-item" href="smanage-logs">
              <i class="mdi mdi-file-lock  menu-icon"></i>		  
                Log File 250
              </a>
              <a class="dropdown-item" id="logout" href="javascript:logout()">
              <i class="mdi mdi-power   menu-icon"></i>
                Logout
              </a>
            </div>
          </li>			  
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
	
	    <div class="container-fluid page-body-wrapper">
      <!-- partial -->
	  
<!-- Admin My profile modal starts -->			  
<div class="modal fade" id="admin-profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:600px;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
			  <div class="card-body">
				<form class="forms-sample" action="sadmin-dashboard" method="post" enctype="multipart/form-data">			  
				  <div class="form-group row">				 
                        <div class="col-sm-12">
            <input type="text" class="form-control" required value="<?php echo $row['name']; ?>" id="name" name="name" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">                       
                        <div class="col-sm-12">
                          <input type="email" readonly class="form-control" value="<?php echo $row['email']; ?>" id="email" name="email" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">                      
                        <div class="col-sm-12">
                          <input type="text" class="form-control" required value="<?php echo $row['mobile']; ?>" id="mobile"  name="mobile" placeholder="Mobile number">
                        </div>
                      </div>
                       <div class="form-group row">
                         <div class="col-sm-12">
                          <input type="text"  class="form-control" required value="<?php echo $row['address_1']; ?>" id="address_1" name="address_1" placeholder="Company name">
                        </div>
                      </div>
					    <div class="form-group row">
                         <div class="col-sm-12">
                          <input type="text" class="form-control" required value="<?php echo $row['address_2']; ?>" id="address_2" name="address_2" placeholder="Address">
                        </div>
                      </div>
					    <div class="form-group row">
                         <div class="col-sm-12">
                          <input type="number" class="form-control" min="0" required value="<?php echo $row['zip_code']; ?>" id="zip_code" name="zip_code" placeholder="ZIP Code">
                        </div>
                      </div>
					    <div class="form-group row">
							<label for="exampleInputMobile" class="col-sm-6 col-form-label">Photo: (Max size: 200px X 200px)</label>
							<div class="col-sm-6">
							<input type="file" class="form-control"  value="<?php echo $row['photo'];?>" name="photo" id="photo" accept="image/x-png, image/jpeg"> 
							</div>
							
					    </div>	
							
					    <div class="form-group row">
							<div class="col-sm-4">
							<?php if(!empty($row['photo'])){ ?>
							<img src="<?php echo $row['photo'];?>" alt="Profile" width="100px" />&nbsp; 
							<?php } else{ ?>
							<img src="user-photos/1default.jpg" alt="Profile" width="100px" />
							<?php } ?> &nbsp; 
							</div>
						 <div class="col-sm-8">
							<p>&nbsp;</p>
							 <button type="submit" name="profile_submit" class="btn btn-info mr-2">Update</button>
							<button class="btn btn-light" data-dismiss="modal">Cancel</button>							
							</div>
						</div>
                    					   
				   </div>				
				 </form>				 
				 </div>           
		    </div>
		</div>
       </div>
      </div>     
    </div>
<!-- Admin My profile modal ends -->



<script type="text/javascript">
 function validate(){
	var a = document.getElementById("npassword").value;
	var b = document.getElementById("repeatpassword").value;
			
	if (a!=b)  {
	   alert("New password & repeat password do not match.");
	   return false;
	}
 }	
  </script>	

<!-- Admin change password  modal starts -->			  
<div class="modal fade" id="admin-password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
			  <div class="card-body">
				<form class="forms-sample" action="sadmin-dashboard" method="post" onSubmit = "return validate();">			  
				  <div class="form-group row">						 
                        <div class="col-sm-12">
                          <input type="password" class="form-control"  required minlength="6" id="oldpassword" name="oldpassword" placeholder="Current password">
                        </div>
					</div>
					 <div class="form-group row">
						 <div class="col-sm-12">
                          <input type="password" class="form-control"  required minlength="6" id="npassword" name="npassword" placeholder="New password">
                        </div>
					</div>
						 <div class="form-group row">
						 <div class="col-sm-12">
                          <input type="password" class="form-control"  required  minlength="6" id="repeatpassword" name="repeatpassword" placeholder="Repeat password">
                        </div>
						</div>
                     
                    <div class="float-right">
					 <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<button type="submit" name="password_submit" class="btn btn-info mr-2">Update</button>	
					</div>					   
				   </div>				
				 </form>
				 </div> 
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
	  
<!-- Admin change password modal ends -->	
	  
<?php
$sql78 = "select * from {$prefix}support where 1";
$res78 = mysqli_query($conn, $sql78);
$row78 = mysqli_fetch_array($res78);
$no = $row78['support_no'];
$timings = $row78['content'];
$icon = $row78['image'];
?>	  
	  
	  
<!-- Support modal starts -->			  
<div class="modal fade" id="support" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:600px;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Support no. & Timings</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
			  <div class="card-body">
				<form class="forms-sample" action="sadmin-dashboard" method="post" enctype="multipart/form-data">			  
	
                      <div class="form-group row">                      
                        <div class="col-sm-8">
                          <input type="text" class="form-control" required value="<?php echo $no; ?>"  name="support_no" placeholder="Support no">
                        </div>
						<div class="col-sm-4">
							<?php if(!empty($icon)){ ?>
							<img src="<?php echo $icon;?>" alt="whatsapp" width="25px" style="padding-top:10px;" />&nbsp; 
							<?php } else{ ?>
							<img src="customer-photos/1default.jpg" alt="Profile" width="25px" />
							<?php } ?> &nbsp; 
						</div>
                      </div>
                       <div class="form-group row">
                         <div class="col-sm-12">
                          <input type="text"  class="form-control" required value="<?php echo $timings; ?>"  name="content" placeholder="Timings">
                        </div>
                      </div>					 
					   
							
					    <div class="form-group row">
							
						 <div class="col-sm-8">
							<p>&nbsp;</p>
							 <button type="submit" name="support_submit" class="btn btn-info mr-2">Update</button>
							<button class="btn btn-light" data-dismiss="modal">Cancel</button>							
							</div>
						</div>
                    					   
				   </div>				
				 </form>				 
				 </div>           
		    </div>
		</div>
       </div>
      </div>     
    </div>
<!-- Support modal ends -->