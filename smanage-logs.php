<?php 
session_start();
$role_id = $_SESSION['role_id'];
$user_id = $_SESSION['user_id'];

require('sheader.php');
require('sadmin-sidebar.php');




	$sql2 ="DELETE FROM {$prefix}logins WHERE id NOT IN (SELECT id FROM (SELECT id FROM {$prefix}logins ORDER BY id DESC LIMIT 250) x ); ";
    $result_up = mysqli_query($conn, $sql2);
		
	
?>

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
            			  



<script src="jquery-3.3.1.min.js"></script>	
<script src="DataTables/datatables.min.js"></script>
	  

<?php
$sqlQuery = "SELECT * FROM {$prefix}logins";
$result = mysqli_query($conn, $sqlQuery);
$totalRecords = mysqli_num_rows($result);
if($totalRecords ==1) {$record =  "record"; }
else{$record =  "records";}
?>
			<div class="row for_overflow">
					<div class="col-lg-12 grid-margin stretch-card">
					  <div class="card for_box_shadow">
						<div class="card-body">
						  <h4 class="card-title">User login list of <?php echo $totalRecords .' '. $record; ?> in descending order </h4>
						  <div class="table-responsive">
							<table  class="table table-striped" id="pro_table">
							  <thead>
								<tr>
								  <th>#</th>								
								  <th>Email</th>
								  <th>Date</th>  
								  <th>IP Address</th>								
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
            $('#pro_table').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'ajax-login-list.php'
                },
                'columns': [
					{ data: 'ed_no' },
					{ data: 'email' }, 
                    { data: 'date' }, 
					{ data: 'ip' }, 				
                ],
				 'columnDefs': [ {
					'targets': [0,1,2,3], // column index (start from 0)
					'orderable': false, // set orderable false for selected columns
				 }]
            });
        });
 </script>	




<?php require('footer.php'); ?>