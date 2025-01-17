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

$today_date_time = date("Y-m-d H:i:s");
?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
			<?php	if($send_mar_temp == 1){	?>
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" data-target="#add_mark" class="btn btn-inverse-info">+ Send Marketing Template</button>
                </div>            
			</div> <?php } ?>
			  
		  
			  <!-- Send Marketing modal starts -->			  
<div class="modal fade" id="add_mark" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:900px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Marketing Template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="email" method="post" enctype="multipart/form-data">
<input type="datetime-local"  hidden class="form-control" name="date_time" value="<?php echo $today_date_time; ?>" required>	
					
					 <div class="form-group row">                      
						  <div class="col-sm-12">
						  Type or copy/paste email id(s) separated by comma: <span class="mand">*</span>
						   <textarea name="email_id" id="emails" class="form-control email_dupli" rows="20" ></textarea>
						  </div>
					  </div>			  
										
   <button type="submit" name="marketing_submit" id="send_btn" class="btn btn-info mr-2">Send</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!--  Send marketing modal ends -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php

// retrieve list of emails from the database
$query = "SELECT email_id FROM {$prefix}mark_templates where delete_status = 0";
$result = $conn->query($query);
$emails = array();
while ($row = $result->fetch_assoc()) {
    $emails[] = $row['email_id'];
}

// convert array to JSON for use in JavaScript
$json_emails = json_encode($emails);
?>


<script>
//------------------- To remove emails from textarea that is already in the database
// retrieve list of emails from PHP-generated JSON
var emails = <?php echo $json_emails; ?>;

// create function to remove existing emails from textarea
function removeExistingEmails() {
    // get current value of textarea
    var textarea = document.getElementById("emails");
    var value = textarea.value;
    
    // split value into array of individual email addresses
    var emailArray = value.split(/[\s,]+/);
    
    // loop through email array and remove existing emails
    for (var i = 0; i < emailArray.length; i++) {
        var email = emailArray[i];
        if (emails.indexOf(email) !== -1) {
            emailArray.splice(i, 1);
            i--;
        }
    }
    
    // join remaining email addresses back into a string
    var updatedValue = emailArray.join(", ");
    
    // set value of textarea to updated string of email addresses
    textarea.value = updatedValue;
}

// add event listener to trigger function on textarea input
var textarea = document.getElementById("emails");
textarea.addEventListener("input", removeExistingEmails);




//------------- To remove duplicate emails from textarea 
$(document).ready(function() {
    $('#emails').on('input', function() {	
	
 const textarea = document.getElementById("emails");
const emailArray = textarea.value.split(",");
const uniqueEmailArray = [];

emailArray.forEach((email) => {
  const trimmedEmail = email.trim().replace(/\s/g, '');
  if (uniqueEmailArray.indexOf(trimmedEmail) === -1) {
    uniqueEmailArray.push(trimmedEmail);
  }
});

const uniqueEmailString = uniqueEmailArray.join(",");
textarea.value = uniqueEmailString;

});
});
</script>



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  
<?php
$sqlQuery = "SELECT * FROM {$prefix}mark_templates where delete_status = 0";
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>


			  <div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						  <h4 class="card-title">Marketing template list of <?php echo $totalRecords .' '. $record; ?> </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="dept_table">
							  <thead>
								<tr>
								  <th>#</th>
								  <th>Date & Time</th>								  
								  <th>Email ID</th>								    
								  <th>Sent</th>
								  <th>Responded</th>
								  <th>To Follow Up</th>
								  <th>Converted</th>
								  <?php if($edit_mar_temp == 1 || $del_mar_temp == 1){ ?>
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
                    'url':'ajax-marketing-list.php'
                },
                'columns': [
					{ data: 'id' },
					{ data: 'date_time' },
				    { data: 'email_id' },
					{ data: 'sent' },
					{ data: 'responded' },				
					{ data: 'to_follow_up' },
					{ data: 'converted' },
					<?php if($edit_mar_temp == 1 || $del_mar_temp == 1){ ?>
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
        window.location.href='smarketing?delete_id='+id;
     }
}
</script>

<?php
if(isset($_GET['delete_id']))
	{   
	 $del = $_GET['delete_id'];
	$sql = "UPDATE `{$prefix}mark_templates` set delete_status = 1  WHERE id = '$del' ";
	mysqli_query($conn, $sql);
	 
	 echo '<script> alert("Marketing details has been successfully deleted.")</script>';
	 echo '<script type="text/javascript">
	window.location.href = "smarketing"
	</script>'; 
	} 
?>


<script type="text/javascript">
function edit_id(id)
{
    window.location.href='smarketing?edit_id='+id;
	     
}
</script>			  
			  <?php
if(isset($_GET['edit_id'])){
	$sql = "SELECT * FROM {$prefix}mark_templates WHERE id = '".$_GET['edit_id']."' ";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);		
		}
		echo "<script type='text/javascript'>
		$(document).ready(function(){
		$('#edit_mark').modal('show');
		});
		</script>";
			}		
?>

<?php

if(isset($_POST['marketing_update_submit'])){
	
	$sql = "UPDATE `{$prefix}mark_templates` SET    `sent` = '".$_POST['sent']."',  `responded` = '".$_POST['responded']."',
	`to_follow_up` = '".$_POST['to_follow_up']."', `converted` = '".$_POST['converted']."' WHERE id = '".$_POST['id']."'";
	mysqli_query($conn, $sql);	
echo '<script> alert("Marketing details has been updated.")</script>';

}
?>

<!-- Edit Marketing modal starts -->			  
<div class="modal fade" id="edit_mark" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:700px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Marketing Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="smarketing" method="post" enctype="multipart/form-data">
				  <input type="number" value="<?php echo $row['id']; ?>" name="id" hidden />
				  
					<div class="form-group row">			
					 <div class="col-sm-6">
					   Date & time:
<input type="datetime"  class="form-control" name="date_time" 
 value="<?php echo date('d-m-Y g:i:s A', strtotime($row['date_time'])); ?>"  required readonly>
					  </div>					  
                      <div class="col-sm-6">
					  Email id: 
<input type="email"  class="form-control"  value="<?php echo $row['email_id']; ?>"  name="email_id" required readonly>
					  </div>				 
					 </div>
		
					 <div class="form-group row">                      
                      <div class="col-sm-3">
						Sent: <span class="mand">*</span>
          <input type="number" min="0" class="form-control"  value="<?php echo $row['sent']; ?>" name="sent" required>
					  </div>
					  <div class="col-sm-3">
						Responded: <span class="mand">*</span>
       <input type="number" min="0" class="form-control"  value="<?php echo $row['responded']; ?>" name="responded" required>
					  </div>
					  <div class="col-sm-3">
						To follow up: <span class="mand">*</span>
     <input type="number" min="0" class="form-control"  value="<?php echo $row['to_follow_up']; ?>" name="to_follow_up" required>
					  </div>
					  <div class="col-sm-3">
						Converted: <span class="mand">*</span>
      <input type="number" min="0" class="form-control"  value="<?php echo $row['converted']; ?>" name="converted" required>
					  </div>
					   </div>					
				
               
                    <button type="submit" name="marketing_update_submit" class="btn btn-info mr-2">Update</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     

<!--  Edit Marketing modal ends -->


 <?php require('footer.php'); ?>