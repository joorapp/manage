<?php 
session_start();
$role_id = $_SESSION['role_id'];

require('croheader.php');
require('cro-permission.php');
require('cro-sidebar.php');

$user_id = $_SESSION['user_id'];

$today_date = date('Y-m-d');
$today_date_plus_30 = date('Y-m-d', strtotime('+30 day', strtotime($today_date)));

$sql2 ="DELETE FROM {$prefix}logins WHERE id NOT IN (SELECT id FROM (SELECT id FROM {$prefix}logins ORDER BY id DESC LIMIT 250) x ); ";
    $result_up = mysqli_query($conn, $sql2);
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
		  
<?php if($dashboard == 0){ ?>

<div class="row">
	<div class="col-md-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
	<img src="images/rt.png" alt="Real Technologies" style="display:block; margin:0 auto; width:100%; height:auto;">
			</div>
		</div>
	</div>
 </div>

<?php	} else{ ?>		  		  
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
					$left = $days_left->format('%R%a days');
					$serial++;
				?>
				
                        <tr>						
						  <td><?php echo $serial; ?></td>
						   <?php if($left >= 31){ ?>
     <td class="font-weight-medium"><div class="badge badge-success"><?php echo $left; ?></div></td>
	 <?php } else if ($left < 31 && $left > 5){ ?>
	 <td class="font-weight-medium"><div class="badge badge-warning"><?php echo $left; ?></div></td>
	 <?php } elseif($left <= 5){?>
	 <td class="font-weight-medium"><div class="badge badge-danger"><?php echo $left; ?></div></td>
	 <?php } ?>
                          <td><?php echo $row31["p_name"]; ?></td>
						  <td><?php echo $row31["name"].' | '.$row31["company"]; ?></td>
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
<?php } ?>  
	  
	    
        </div>
        <!-- content-wrapper ends -->
		
		
		

 <?php require('footer.php'); ?>