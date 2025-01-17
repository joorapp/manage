      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
		   <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">              
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal"><?php echo $row['name'];?></h5>
                  <span style="color:#ea445a">CRO</span>
                </div>
              </div>
            </div>
          </li>		
          <li class="nav-item dash">
            <a class="nav-link" href="cro-dashboard">
              <i class="mdi mdi-view-dashboard menu-icon"></i>
              <span class="menu-title">Dashboard </span>
            </a>
          </li>			
			 <?php if($add_enq == 0 && $edit_enq == 0 && $view_enq == 0 && $del_enq == 0){ } else{ ?>
		  	<li class="nav-item dash">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic2">
              <i class="mdi mdi-comment-account-outline  menu-icon"></i>
              <span class="menu-title">Enquiry Statuses - <?php echo $total_count; ?></span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic2">
              <ul class="nav flex-column sub-menu">
		<li class="nav-item"> <a class="nav-link" href="scall-sheet">Call Sheet - <?php echo $call_count; ?></a></li>  
		<li class="nav-item"> <a class="nav-link" href="smeet-sheet">Meeting - <?php echo $meet_count; ?></a></li>             
		<li class="nav-item"> <a class="nav-link" href="sfollow-sheet">Follow Up - <?php echo $follow_count; ?></a></li>
		<li class="nav-item"> <a class="nav-link" href="sdemo-sheet">Using Demo - <?php echo $demo_count; ?></a></li>
		<li class="nav-item"> <a class="nav-link" href="sconverted-sheet">Converted - <?php echo $converted_count; ?></a></li>
		<li class="nav-item"> <a class="nav-link" href="snil-sheet">Nil - <?php echo $nil_count; ?></a></li>				
              </ul>
            </div>
			 </li><?php } ?>
		  	<?php
			$sql62 = "SELECT *, count({$prefix}customers.id) as cus_count from {$prefix}customers inner join  {$prefix}products on  {$prefix}products.id =   {$prefix}customers.pro_id  where {$prefix}customers.delete_status = 0";
			$res62 = mysqli_query($conn, $sql62);
			if(mysqli_num_rows($res62) > 0){
			$row62 = mysqli_fetch_assoc($res62);
			$cus_count = $row62['cus_count']; 
			}
			?>
		 <?php if($add_cus == 0 && $edit_cus == 0 && $view_cus == 0 && $del_cus == 0){ } else{ ?>
		  <li class="nav-item dash">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic3" aria-expanded="false" aria-controls="ui-basic3">
              <i class="mdi mdi-account-convert   menu-icon"></i>
              <span class="menu-title">Customers  - <?php echo $cus_count; ?></span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic3">
              <ul class="nav flex-column sub-menu">
	<?php
	$sql90 = "SELECT p.*, COUNT(c.pro_id) as pro_id_count
          FROM {$prefix}products p
          LEFT JOIN {$prefix}customers c ON p.id = c.pro_id
           where c.delete_status = 0 GROUP BY p.id";
	$res90 = mysqli_query($conn, $sql90);
	if(mysqli_num_rows($res90) > 0){
	while($row90 = mysqli_fetch_assoc($res90)){ 
	?>
		<li class="nav-item"> <a class="nav-link" href="customers?pid=<?php echo $row90['id']; ?>"><?php echo $row90['p_name']; ?> - <?php echo $row90['pro_id_count']; ?></a></li> 
	<?php } } ?>		
					
              </ul>
            </div>
		 </li>	<?php } ?>	
		 
		<?php if($add_cus_pay == 0 && $edit_cus_pay == 0 && $view_cus_pay == 0 && $del_cus_pay == 0){ } else{ ?>
		<li class="nav-item dash">
           <a class="nav-link" href="scustomer-payments">
              <i class="mdi  mdi-cash-multiple menu-icon"></i>
              <span class="menu-title">Customer Payments</span>
            </a>
          </li><?php } ?>
		<?php if($add_misc_inc == 0 && $edit_misc_inc == 0 && $view_misc_inc == 0 && $del_misc_inc == 0){ } else{ ?>
		  <li class="nav-item dash">
           <a class="nav-link" href="smanage-incomes">
              <i class="mdi  mdi-cash-100 menu-icon"></i>
              <span class="menu-title">Misc Incomes</span>
            </a>
		</li><?php } ?>
		<?php if($add_misc_exp == 0 && $edit_misc_exp == 0 && $view_misc_exp == 0 && $del_misc_exp == 0){ } else{ ?>
		   <li class="nav-item dash">
           <a class="nav-link" href="smanage-expenses">
              <i class="mdi  mdi-cash  menu-icon"></i>
              <span class="menu-title">Misc Expenses</span>
            </a>
		</li><?php } ?>	
		 <?php if($send_mar_temp == 0 && $edit_mar_temp == 0 && $view_mar_temp == 0 && $del_mar_temp == 0 
		 && $send_sal_temp == 0  && $view_sal_temp == 0 && $del_sal_temp == 0){ } else{ ?>
		<li class="nav-item dash">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="mdi mdi-email-outline  menu-icon"></i>
              <span class="menu-title">Send Templates</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
			  <?php if($send_mar_temp == 0 && $edit_mar_temp == 0 && $view_mar_temp == 0 && $del_mar_temp == 0){ } else{ ?>
			  <li class="nav-item"> <a class="nav-link" href="smarketing">EBAC Marketing</a></li><?php } ?>
			  <?php if($send_sal_temp == 0  && $view_sal_temp == 0 && $del_sal_temp == 0){ } else{ ?>
			  <li class="nav-item"> <a class="nav-link" href="ssales">EBAC After Sales</a></li><?php } ?> 
              </ul>
            </div>
		 </li><?php } ?>
		 <?php if($renewals == 0){ } else{ ?>
		 <li class="nav-item dash">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic4" aria-expanded="false" aria-controls="ui-basic4">
              <i class="mdi mdi-calendar  menu-icon"></i>
              <span class="menu-title">Renewals </span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic4">
              <ul class="nav flex-column sub-menu">
		<li class="nav-item"> <a class="nav-link" href="sebac-ren-dates">EBAC PRO</a></li> 				
              </ul>
            </div>
		 </li><?php } ?>
		  <?php if($last_logins == 0){ } else{ ?>
		  <li class="nav-item dash">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic5" aria-expanded="false" aria-controls="ui-basic5">
              <i class="mdi  mdi-login-variant  menu-icon"></i>
              <span class="menu-title">Last Logins </span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic5">
              <ul class="nav flex-column sub-menu">
		<li class="nav-item"> <a class="nav-link" href="sebac-logins">EBAC PRO</a></li> 				
              </ul>
            </div>
          </li><?php } ?>
		   <?php if($add_demo_cust == 0 && $view_demo_cust == 0 && $del_demo_cust == 0){ } else{ ?>
		  <li class="nav-item dash">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic7" aria-expanded="false" aria-controls="ui-basic7">
              <i class="mdi  mdi-av-timer  menu-icon"></i>
              <span class="menu-title">Demo Customers </span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic7">
              <ul class="nav flex-column sub-menu">
		<li class="nav-item"> <a class="nav-link" href="sebac-demo-customers">EBAC PRO</a></li> 				
              </ul>
            </div>
          </li> <?php } ?>
		    <?php if($add_pro == 0 && $edit_pro == 0 && $view_pro == 0){ } else{ ?>
		   <li class="nav-item dash">
           <a class="nav-link" href="smanage-products">
              <i class="mdi mdi-puzzle   menu-icon"></i>
              <span class="menu-title">Manage Products</span>
            </a>
			</li>	<?php } ?>
		
		 <li class="nav-item dash">
            <a class="nav-link" id="logout" href="javascript:logout()">		
              <i class="mdi mdi-logout   menu-icon"></i>
              <span class="menu-title">Log Out</span>
            </a>
          </li>
		</ul>
      </nav>
      <!-- partial -->
	  