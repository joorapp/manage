<?php 
session_start();
$role_id = $_SESSION['role_id'];
$user_id = $_SESSION['user_id'];

require('sheader.php');
require('sa-permission.php');
require('sadmin-sidebar.php');

$today_date_time = date('Y-m-d H:i');	
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<style>
.form-group{
	margin-bottom:0 ! important;
}
#cli_pro_1, #mat_ren_2, #staff_daily_3, #sup_sub_4{
 color:#fff;
 padding:15px 10px;
 margin-bottom:20px;
 }
#cli_pro_1{
background:#2db0ab ! important; 
 }
#mat_ren_2{
 background:#7a95c5 ! important;
 }
#staff_daily_3{
 background:#4eb992 ! important;
}
#sup_sub_4{
 background:#ca4eb7 ! important;
}
</style>

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row for_margin_bottom">
                <div class="col-12 col-xl-4 mb-4 mb-xl-0">               
				 <button type="button" data-toggle="modal" id="cli_pro_1" data-target="#enq_cus" class="btn btn-first-four">+ Dashboard / Enquiry / Customers - (13)</button>
				 <button type="button" data-toggle="modal" id="mat_ren_2" data-target="#misc_temp" class="btn btn-first-four">+  Incomes / Expenses / Templates - (15)</button>
				 <button type="button" data-toggle="modal" id="staff_daily_3" data-target="#ren_logins" class="btn btn-first-four">+ Renewals / Logins / Products - (5)</button>
		        </div>            
              </div>
			  
<?php
$sql2 = "select * from {$prefix}permissions where role_id = 2";
$res2 = mysqli_query($conn, $sql2);
if(mysqli_num_rows($res2) > 0){
	$row2 = mysqli_fetch_array($res2);
}

$sql3 = "select * from {$prefix}permissions where role_id = 3";
$res3 = mysqli_query($conn, $sql3);
if(mysqli_num_rows($res3) > 0){
	$row3 = mysqli_fetch_array($res3);
}

$sql4 = "select * from {$prefix}permissions where role_id = 4";
$res4 = mysqli_query($conn, $sql4);
if(mysqli_num_rows($res4) > 0){
	$row4 = mysqli_fetch_array($res4);
}


$sql5 = "select * from {$prefix}permissions where role_id = 5";
$res5 = mysqli_query($conn, $sql5);
if(mysqli_num_rows($res5) > 0){
	$row5 = mysqli_fetch_array($res5);
}
?>
		  
<!-- Set dashboard, enquiry, customers, customer payments permission modal starts -->			  
<div class="modal fade" id="enq_cus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:900px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Manager [M] --- Accounts Manager [AM] --- CRO [CRO] --- Marketer [MR]</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="smanage-permissions" method="post" enctype="multipart/form-data">
            
			<div class="per_head">     						 
				<div class="form-group row">			
				   <div class="col-sm-8">MODULES / FUNCTIONS / FEATURES</div>
				   <div class="col-sm-1">M</div>
					<div class="col-sm-1">AM</div>
					<div class="col-sm-1">CRO</div>
					<div class="col-sm-1">MR</div>
				 </div>
			 </div> 
			 
			 
			 <div class="two_bg">
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">1. Dashboard</div>
<?php $isChecked = ($row2['dashboard'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="dashboard" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['dashboard'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="dashboard" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['dashboard'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="dashboard" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['dashboard'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="dashboard" id="role5"  value="5" <?php echo $isChecked; ?> ></div>         	 </div>
			 </div>
			 
			 <div class="one_bg">
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">2. Enquiries - Add enquiry</div>
<?php $isChecked = ($row2['add_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_enq" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['add_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_enq" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['add_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_enq" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['add_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_enq" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">3. Enquiries - Edit enquiry</div>
<?php $isChecked = ($row2['edit_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_enq" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['edit_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_enq" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['edit_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_enq" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['edit_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_enq" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">4. Enquiries - View enquiry</div>
<?php $isChecked = ($row2['view_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_enq" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['view_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_enq" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['view_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_enq" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['view_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_enq" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">5. Enquiries - Delete enquiry</div>
<?php $isChecked = ($row2['del_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_enq" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['del_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_enq" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['del_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_enq" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['del_enq'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_enq" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			 </div>
			 
			 
			  <div class="two_bg">
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">6. Customers - Add customer</div>
<?php $isChecked = ($row2['add_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_cus" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['add_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_cus" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['add_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_cus" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['add_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_cus" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">7. Customers - Edit customer</div>
<?php $isChecked = ($row2['edit_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_cus" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['edit_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_cus" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['edit_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_cus" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['edit_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_cus" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">8. Customers - View customer</div>
<?php $isChecked = ($row2['view_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_cus" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['view_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_cus" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['view_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_cus" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['view_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_cus" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">9. Customers - Delete customer</div>
<?php $isChecked = ($row2['del_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_cus" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['del_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_cus" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['del_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_cus" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['del_cus'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_cus" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			 </div>
			 
			 
			<div class="one_bg">
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">10. Customer Payments - Add payment</div>
<?php $isChecked = ($row2['add_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_cus_pay" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['add_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_cus_pay" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['add_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_cus_pay" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['add_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_cus_pay" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">11. Customer Payments - Edit payment</div>
<?php $isChecked = ($row2['edit_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_cus_pay" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['edit_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_cus_pay" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['edit_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_cus_pay" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['edit_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_cus_pay" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">12. Customer Payments - View payment</div>
<?php $isChecked = ($row2['view_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_cus_pay" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['view_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_cus_pay" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['view_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_cus_pay" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['view_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_cus_pay" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">13. Customer Payments - Delete payment</div>
<?php $isChecked = ($row2['del_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_cus_pay" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['del_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_cus_pay" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['del_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_cus_pay" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['del_cus_pay'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_cus_pay" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			 </div>
			 

			
				<p>&nbsp;</p>		
             <button class="btn btn-info" data-dismiss="modal">Close</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!-- Set dashboard, enquiry, customers, customer payments permission modal  ends -->





<!-- Set Incomes / Expenses / Templates permission modal starts -->			  
<div class="modal fade" id="misc_temp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:900px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Manager [M] --- Accounts Manager [AM] --- CRO [CRO] --- Marketer [MR]</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="smanage-permissions" method="post" enctype="multipart/form-data">
            
			<div class="per_head">     						 
				<div class="form-group row">			
				   <div class="col-sm-8">MODULES / FUNCTIONS / FEATURES</div>
				   <div class="col-sm-1">M</div>
					<div class="col-sm-1">AM</div>
					<div class="col-sm-1">CRO</div>
					<div class="col-sm-1">MR</div>
				 </div>
			 </div> 
			 
			 
			
			 <div class="one_bg">
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">1. Misc Incomes - Add income</div>
<?php $isChecked = ($row2['add_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_misc_inc" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['add_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_misc_inc" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['add_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_misc_inc" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['add_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_misc_inc" id="role5"  value="5" <?php echo $isChecked; ?> ></div>         	 </div>
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">2. Misc Incomes - Edit income</div>
<?php $isChecked = ($row2['edit_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_misc_inc" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['edit_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_misc_inc" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['edit_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_misc_inc" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['edit_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_misc_inc" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">3. Misc Incomes - View income</div>
<?php $isChecked = ($row2['view_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_misc_inc" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['view_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_misc_inc" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['view_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_misc_inc" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['view_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_misc_inc" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">4. Misc Incomes - Delete income</div>
<?php $isChecked = ($row2['del_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_misc_inc" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['del_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_misc_inc" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['del_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_misc_inc" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['del_misc_inc'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_misc_inc" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
	
			 </div>
			 
			 
			  <div class="two_bg">
			  		
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">5. Misc Expenses - Add expense</div>
<?php $isChecked = ($row2['add_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_misc_exp" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['add_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_misc_exp" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['add_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_misc_exp" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['add_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_misc_exp" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">6. Misc Expenses - Edit expense</div>
<?php $isChecked = ($row2['edit_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_misc_exp" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['edit_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_misc_exp" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['edit_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_misc_exp" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['edit_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_misc_exp" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">7. Misc Expenses - View expense</div>
<?php $isChecked = ($row2['view_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_misc_exp" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['view_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_misc_exp" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['view_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_misc_exp" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['view_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_misc_exp" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">8. Misc Expenses - Delete expense</div>
<?php $isChecked = ($row2['del_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_misc_exp" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['del_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_misc_exp" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['del_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_misc_exp" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['del_misc_exp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_misc_exp" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
		</div>
			
			
			 
			 
			<div class="one_bg">
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">9. Send Templates - Send marketing template</div>
<?php $isChecked = ($row2['send_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="send_mar_temp" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['send_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="send_mar_temp" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['send_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="send_mar_temp" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['send_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="send_mar_temp" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">10. Send Templates - Edit marketing template</div>
<?php $isChecked = ($row2['edit_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_mar_temp" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['edit_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_mar_temp" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['edit_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_mar_temp" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['edit_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_mar_temp" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">11. Send Templates - View marketing template</div>
<?php $isChecked = ($row2['view_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_mar_temp" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['view_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_mar_temp" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['view_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_mar_temp" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['view_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_mar_temp" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">12. Send Templates - Delete marketing template</div>
<?php $isChecked = ($row2['del_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_mar_temp" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['del_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_mar_temp" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['del_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_mar_temp" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['del_mar_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_mar_temp" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			 </div>
			 
			 
			 	  <div class="two_bg">
			  		
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">13. Send Templates - Send sales template</div>
<?php $isChecked = ($row2['send_sal_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="send_sal_temp" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['send_sal_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="send_sal_temp" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['send_sal_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="send_sal_temp" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['send_sal_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="send_sal_temp" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">14. Send Templates - View sales template</div>
<?php $isChecked = ($row2['view_sal_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_sal_temp" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['view_sal_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_sal_temp" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['view_sal_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_sal_temp" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['view_sal_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_sal_temp" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">15. Send Templates - Delete sales template</div>
<?php $isChecked = ($row2['del_sal_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_sal_temp" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['del_sal_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_sal_temp" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['del_sal_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_sal_temp" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['del_sal_temp'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_sal_temp" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
		</div>
			 

			
				<p>&nbsp;</p>		
             <button class="btn btn-info" data-dismiss="modal">Close</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!-- Set Incomes / Expenses / Templates permission modal  ends -->



<!-- Set renewals, logins, products permission modal starts -->			  
<div class="modal fade" id="ren_logins" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:900px ! important;">
    <div class="modal-content modal-bg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Manager [M] --- Accounts Manager [AM] --- CRO [CRO] --- Marketer [MR]</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>		
      </div>
	 
      <div class="modal-body padding-lr0">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
                <div class="card-body">           
                  <form class="forms-sample" action="smanage-permissions" method="post" enctype="multipart/form-data">
            
			<div class="per_head">     						 
				<div class="form-group row">			
				   <div class="col-sm-8">MODULES / FUNCTIONS / FEATURES</div>
				   <div class="col-sm-1">M</div>
					<div class="col-sm-1">AM</div>
					<div class="col-sm-1">CRO</div>
					<div class="col-sm-1">MR</div>
				 </div>
			 </div> 
			 
			 
			
			 <div class="one_bg">
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">1. Renewals - Update renewal</div>
<?php $isChecked = ($row2['renewals'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="renewals" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['renewals'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="renewals" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['renewals'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="renewals" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['renewals'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="renewals" id="role5"  value="5" <?php echo $isChecked; ?> ></div>         	 </div>

			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">2. Last Logins - View last login</div>
<?php $isChecked = ($row2['last_logins'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="last_logins" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['last_logins'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="last_logins" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['last_logins'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="last_logins" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['last_logins'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="last_logins" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
		</div>
			
			<div class="two_bg">
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">3. Manage Products - Add product</div>
<?php $isChecked = ($row2['add_pro'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_pro" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['add_pro'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_pro" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['add_pro'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_pro" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['add_pro'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_pro" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">4. Manage Products - Edit product</div>
<?php $isChecked = ($row2['edit_pro'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_pro" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['edit_pro'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_pro" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['edit_pro'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_pro" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['edit_pro'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_pro" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			
				 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">5. Manage Products - View product</div>
<?php $isChecked = ($row2['view_pro'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_pro" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['view_pro'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_pro" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['view_pro'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_pro" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['view_pro'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_pro" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>	
	
			 </div>
			 
			 
			 
			  <div class="one_bg">
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">6. Demo Customers - Add demo customer</div>
<?php $isChecked = ($row2['add_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_demo_cust" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['add_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_demo_cust" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['add_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_demo_cust" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['add_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="add_demo_cust" id="role5"  value="5" <?php echo $isChecked; ?> ></div>         	 </div>

			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">7. Demo Customers - Edit demo customer</div>
<?php $isChecked = ($row2['edit_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_demo_cust" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['edit_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_demo_cust" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['edit_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_demo_cust" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['edit_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="edit_demo_cust" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">8. Demo Customers - Del demo customer</div>
<?php $isChecked = ($row2['del_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_demo_cust" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['del_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_demo_cust" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['del_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_demo_cust" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['del_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="del_demo_cust" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
			
			 <div class="form-group row">			
			 <div class="col-sm-8 per_sub">9. Demo Customers - View demo customer</div>
<?php $isChecked = ($row2['view_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_demo_cust" id="role2"  value="2" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row3['view_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_demo_cust" id="role3"  value="3" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row4['view_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_demo_cust" id="role4"  value="4" <?php echo $isChecked; ?> ></div>
 <?php $isChecked = ($row5['view_demo_cust'] == 1) ? 'checked' : ''; ?>
<div class="col-sm-1 per_data"><input type="checkbox" name="view_demo_cust" id="role5"  value="5" <?php echo $isChecked; ?> ></div>
			</div>
		</div>
			
				<p>&nbsp;</p>		
             <button class="btn btn-info" data-dismiss="modal">Close</button>
                  </form>
                </div>
              </div>
				 </div>				 
		    </div>
		</div>
       </div>
      </div>     
<!-- Set add_demo_cust, logins, products permission modal  ends -->









						  
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->

<script>
    $('input[type="checkbox"]').on('change', function () {
        var roleId = $(this).val();
        var isChecked = $(this).prop('checked');
		var name = this.name;
		
		//alert(roleId);
		//alert(isChecked);
		//alert(name);
		

        // Perform AJAX request
        $.ajax({
            type: 'POST',
            url: 'sajax-permission.php', // 
            data: {
                roleId: roleId,
                isChecked: isChecked,
				name: name
            },
            success: function (response) {
                $('#result').html(response);
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });
</script>


 <?php require('footer.php'); ?>