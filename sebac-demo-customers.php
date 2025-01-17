<?php 
session_start();
$role_id = $_SESSION['role_id'];
$user_id = $_SESSION['user_id'];

if ($role_id == 1) {
    require('sa-permission.php');
    require('sheader.php');
    require('sadmin-sidebar.php');
} elseif ($role_id == 2) {
    require('m-permission.php');
    require('mheader.php');
    require('manager-sidebar.php');    
} elseif ($role_id == 3) {
    require('am-permission.php');
    require('aheader.php');
    require('accountm-sidebar.php');    
} elseif ($role_id == 4) {
    require('cro-permission.php');
    require('croheader.php');
    require('cro-sidebar.php');    
} elseif ($role_id == 5) {
    require('mar-permission.php');
    require('marheader.php');
    require('marketer-sidebar.php');    
}

$servername = "localhost";
$username = "epe_ebacpro_2023";
$password = "epe_ebacpro_2023";
$dbname = "epe_ebacpro_2023";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$today = date('Y-m-d');

if(isset($_POST['demo_user_submit'])){
	
	
	$cust_id = '16082001';
	$full_name = ucwords(strtolower($_POST['full_name']));
	$mobile = $_POST['mobile'];
	$email = $_POST['email'];
	$address_1 = $_POST['address_1'];
	$address_2 = $_POST['address_2'];
	$zip_code = $_POST['zip_code'];
	$password = md5($_POST['password']);
	$last_pass = $_POST['password'];
	$role_id = 1;
	$status = 1;
	$u_added_date = $today;
	$login_link = 'https://enterprise.ebacpro.com';
	$next_ren = $_POST['next_ren'];	
	$remarks = $_POST['remarks'];	
	
	$sql8 = "select * from v3_demo_customers where (email = '$email' || mobile = '$mobile') and delete_status = 0 ";
	$res8 =  mysqli_query($conn, $sql8);
	if(mysqli_num_rows($res8) > 0){
		echo '<script> alert("A customer with this email or mobile already exists! Please use another one.")</script>'; 
	}else{
	
	$sql2 ="INSERT INTO `v3_demo_customers`(`cust_id`, `full_name`, `mobile`, `email`, `address_1`, `address_2`, `zip_code`, `password`, `last_pass`, `role_id`, `status`, `u_added_date`, `login_link`, `next_ren`, `remarks`) VALUES
	('$cust_id', '$full_name', '$mobile', '$email', '$address_1', '$address_2', '$zip_code', '$password', '$last_pass', '$role_id',	'$status', '$u_added_date', '$login_link', '$next_ren', '$remarks')";
    $result_up = mysqli_query($conn, $sql2);
		
	echo '<script> alert("You have successfully added a Demo customer.")</script>';
	}
}

?>

<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($add_demo_cust == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_demo" class="btn btn-inverse-info">+ Add Demo Customer</button>
                </div>            
			</div><?php } ?>
			  
		  
			  <!-- Add demo customer modal starts -->			  
<div class="modal fade" id="add_demo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:900px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Demo Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="sebac-demo-customers" method="post" enctype="multipart/form-data">
				  
				   <div class="form-group row">                      
                      <div class="col-sm-6">
					  Full name : <span class="mand">*</span>
                        <input type="text" class="form-control" name="full_name" placeholder="Full name" required>
					  </div>
					    <div class="col-sm-6">
					  Mobile : <span class="mand">*</span>
                        <input type="text" class="form-control" name="mobile" placeholder="Mobile" required>
					  </div>
					 </div>
					 					 
					<div class="form-group row">                      
                      <div class="col-sm-6">
					  Email : <span class="mand">*</span>
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
					  </div>
					    <div class="col-sm-6">
					  Company name : <span class="mand">*</span>
                        <input type="text" class="form-control" name="address_1" placeholder="Company name" required>
					  </div>
					 </div>
					 
					 
					 <div class="form-group row">                      
                      <div class="col-sm-6">
					  Address 2 : 
                        <input type="text" class="form-control" name="address_2" placeholder="Address 2">
					  </div>
					    <div class="col-sm-6">
					  Password :  <span class="mand">*</span>
                        <input type="password" min="6" class="form-control" name="password" placeholder="Password" required>
					  </div>
					 </div>
					 
					 <div class="form-group row">                   
					    <div class="col-sm-6">
					  ZIP code : 
                        <input type="number" class="form-control" name="zip_code" placeholder="ZIP Code">
					  </div>
					   <div class="col-sm-6">
					   Next renewal : <span class="mand">*</span> (mm / dd / yy)
                        <input type="date"  class="form-control" id="next_ren"  name="next_ren" value="<?php echo $today_date; ?>"  required>
					  </div>
					 </div>
							
					   
					 <div class="form-group row"> 
					   <div class="col-sm-12">
						Remarks :
						 <input type="text" class="form-control" id="remarks" placeholder="Remarks if any"  name="remarks" >
						</div>
					 </div>		
										
                    <button type="submit" name="demo_user_submit" class="btn btn-info mr-2">Save</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Add demo customer modal ends -->

<script type="text/javascript">
function delete_id(id)
{
     if(confirm('Are you sure you want to delete this record?'))
     {
        window.location.href='sebac-demo-customers?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `v3_demo_customers` set delete_status = 1  WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Demo customer details has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "sebac-demo-customers"
	</script>'; 
	} 
?>

<?php
// Query from a single table
$sql = "SELECT c.id, c.full_name, c.mobile, c.email, c.address_1, c.last_pass, c.next_ren, c.u_added_date,
           DATEDIFF(c.next_ren, CURDATE()) AS days_left, 
           (SELECT MAX(l.date) FROM v3_demo_logins l WHERE l.email = c.email) AS last_login
    FROM v3_demo_customers c
    WHERE c.delete_status = 0 AND c.role_id = 1
    ORDER BY c.id ASC";

$finalResult = $conn->query($sql);

if ($finalResult === false) {
    echo "Error executing query: " . $conn->error;
} elseif ($finalResult->num_rows > 0) {
    $totalCount = $finalResult->num_rows;
    echo "<div class='row for_margin_bottom'>
                    <div class='col-12 col-xl-8 mb-4 mb-xl-0'></div>
                  </div>
                  <div class='row'>
                    <div class='col-lg-12 grid-margin stretch-card'>
                      <div class='card for_box_shadow'>
                        <div class='card-body'>
                          <h4 class='card-title'>EBAC PRO demo customer list of $totalCount records</h4>
                          <div class='table-responsive'>
                            <table class='table table-striped'>
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Full Name</th>
                                  <th>Mobile</th>
                                  <th>Email / Username</th>
                                  <th>Company</th>
								  <th>Added Date</th>
                                  <th>Demo Date</th>
                                  <th>Days Left</th>
								  <th>Last Login</th>
								  <th>Password</th>";
								 if($del_demo_cust == 1){
								  echo "<th>Actions</th>";
								  }
                                echo "</tr>
                              </thead>
                              <tbody>";

    $serialNo = 1;
    while ($row = $finalResult->fetch_assoc()) {
        // Format 'next_ren' to d-m-Y
        $nextRenFormatted = date("d-m-Y", strtotime($row['next_ren']));
        // Handle expired records
        $daysLeft = ($row['days_left'] < 0) ? 'Expired' : $row['days_left'] . ' days';
        $rowStyle = ($row['days_left'] < 0) ? "style='color:red;'" : "";

        echo "<tr $rowStyle>
                <td>{$serialNo}</td>
                <td>{$row['full_name']}</td>
                <td>{$row['mobile']}</td>
                <td>{$row['email']}</td>
                <td>{$row['address_1']}</td>
				<td>".date('d-m-Y', strtotime($row['u_added_date']))."</td>
                
                <td>
                    <input type='text' value='{$nextRenFormatted}' onchange='updateNextRen({$row['id']}, \"{$row['next_ren']}\", this.value, this.parentElement.parentElement)'  style='width: 120px;'>
                </td>
                <td>{$daysLeft}</td>
				<td>".date('d-m-Y h:i a', strtotime($row['last_login']))."</td>
				<td>{$row['last_pass']}</td>";
				if ($del_demo_cust == 1) {
				echo "<td><a  href=\"javascript:delete_id('".$row['id']."')\"><i class=\"mdi mdi-delete-forever\"></i></a></td>";
				}
              echo "</tr>";
        $serialNo++;
    }

    echo "</tbody></table></div></div></div></div>";
} else {
    echo "";
}

$conn->close();

?>
  			  
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateNextRen(id, currentNextRen, newValue, row) {
    $.ajax({
        url: 'update-demo-ren.php',
        type: 'post',
        data: { id: id, table_name: 'v3_demo_customers', next_ren: newValue },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Calculate and format "Days Left"
                const daysLeft = response.days_left < 0 ? 'Expired' : response.days_left + ' days';
                
                // Update the "Days Left" column in the table row
                $(row).find('td:nth-child(8)').text(daysLeft);
                
                // Optionally, update the next_ren field's value to formatted date
                $(row).find('input[type="text"]').val(newValue);
                
                alert('Demo date updated successfully!');
            } else {
                alert('Error: ' + response.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Status:', status);
            console.error('Error:', error);
            console.error('Response:', xhr.responseText);
            alert('Failed to update Next Renewal: ' + xhr.responseText);
        }
    });
}
</script>

<?php require('footer.php'); ?>