<?php
$cookie_name = "loggedout"; 
$cookie_value = 1;
setcookie($cookie_name, $cookie_value);
unset($_COOKIE[$cookie_name]);

session_start();
require ("db_config.php");



if(isset($_POST['submit'])){
	
	$email =   htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);
	
	$email = mysqli_real_escape_string($conn, $email) ;
	$password = mysqli_real_escape_string($conn, md5($password));

	$_SESSION['email'] = $email;
	
	$row="";
	
	
    $sql =  "SELECT id, email,  password, role_id, status, delete_status FROM {$prefix}users WHERE email='$email' AND password='$password' AND delete_status=0";
	$result = mysqli_query($conn, $sql);
	
	if(mysqli_num_rows($result) > 0)
	{
	$row = mysqli_fetch_assoc($result);
     if($row['status'] == 1){
		
		if($row['role_id'] == 1){
		header("Location: sadmin-dashboard");
		}elseif($row['role_id'] == 2){
		header("Location: manager-dashboard");
		}elseif($row['role_id'] == 3){
		header("Location: accountm-dashboard");
		}elseif($row['role_id'] == 4){
		header("Location: cro-dashboard");	
		}elseif($row['role_id'] == 5){
		header("Location: marketer-dashboard");	
		}
		
		$_SESSION['role_id'] = $row['role_id'];
		

	//Code for user log details starts
	
		date_default_timezone_set('Asia/Kolkata');
		$date = date('Y-m-d H:i');	
		$ip=$_SERVER['REMOTE_ADDR'];
		
		mysqli_query($conn,"insert into {$prefix}logins(email, date, ip) values('".strtolower($_SESSION['email'])."', '$date', '$ip')"); 
		
		mysqli_query($conn,"delete t1 FROM {$prefix}logins t1 INNER  JOIN {$prefix}logins t2 WHERE   t1.id < t2.id AND   t1.email = t2.email AND t1.date = t2.date AND  t1.ip = t2.ip");
	
	 
	//Code for user log details - ends
	
	 }else{
		echo '<div class="alert alert-info" style="	z-index: 999;	text-align: center;	margin: 0;">
		<strong>Error ! </strong>Your account is Inactive! Please contact Administrator.</div>';	
		exit; 
	 }
	}	
	else{
		
		echo '<div class="alert alert-info" style="	z-index: 999;	text-align: center;	margin: 0;">
		<strong>Error ! </strong> Please enter valid Email address & Password !</div>';	
		exit;
	}
mysqli_close($conn);	 
}

if(!empty($_POST["remember"])) {
	setcookie ("email",$_POST["email"],time() +  (86400 * 30));
	setcookie ("password",$_POST["password"],time() +  (86400 * 30));
	echo "";
} else {
	setcookie("email","");
	setcookie("password","");
	echo "";
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
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="images/logo.png" alt="EBAC PRO">
              </div>
              <h4>Company Management</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" action="index" method="post">
                <div class="form-group">
                  <input type="email" value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; } ?>" name="email" required class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" name="password" required class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" type="submit" name="submit">SIGN IN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" name="remember" class="form-check-input">
                    Remember me
                    </label>
                  </div>
                </div>
              
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
