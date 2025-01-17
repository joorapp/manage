<?php
require('db_config.php');
//************************************** Marketing email*************************************** 

if(isset($_POST['marketing_submit']))
{
//$email_list = explode(PHP_EOL, $_POST['email_id']);

$email_list = explode(',', $_POST['email_id']);
$num_emails = count($email_list);

$to = $_POST['email_id'];


$strSubject="The solution is here. Discover the new way to do more of what you love without limits.";
$message = file_get_contents('marketing-template.php'); 
//$message=str_replace('{{firstname}}', $firstname, $message);

$headers = 'MIME-Version: 1.0'."\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
//$headers .= "Bcc: p@gmail.com\r\n";
$headers .= "From: EBAC PRO <info@ebacpro.com>";

$mail_sent=mail($to, $strSubject, $message, $headers); 

if($mail_sent){
 	
	for($i=0;$i<$num_emails-1;$i++){  
	
	$date_time =  date('Y-m-d H:i:s', strtotime($_POST['date_time'])); 
	$email_id = $email_list[$i];
		
	$sql2 = "INSERT INTO {$prefix}mark_templates (`date_time`, `email_id`, `sent`)
	VALUES ('$date_time', '$email_id', '1')";
    $result_up = mysqli_query($conn, $sql2);
	 }
	
echo "<script>alert('Marketing email sent successfully'); window.location='smarketing.php';exit();</script>";
}
else{
echo "<script>alert('Sorry. Email not send'); window.location='smarketing.php';exit();</script>";
}
}


//************************************** After sales email*****************************************


if(isset($_POST['sales_submit']))
{
extract($_POST); 
$to="$email"; 
$strSubject="Your EBAC PRO  account is live. Now you can start growing your business.";
$message = file_get_contents('sales-template.php'); 
$message = str_replace('{{business_name}}', $business_name, $message);
$message = str_replace('{{login_link}}', $login_link, $message);
$headers = 'MIME-Version: 1.0'."\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
//$headers .= "Bcc: p@gmail.com\r\n";
$headers .= "From: EBAC PRO <info@ebacpro.com>";

$mail_sent=mail($to, $strSubject, $message, $headers); 
if($mail_sent){
	$cust_id = $cust_id;
	$date_time =  date('Y-m-d H:i:s', strtotime($_POST['date_time'])); 
	$email = $email;
	$business_name = $business_name;
	$login_link = 'https://'.$login_link.'.ebacpro.com';
		
	$sql2 ="INSERT INTO `{$prefix}sales_templates`
	(`cust_id`, `date_time`, `email`, `business_name`, `login_link`,  `sent`)
	VALUES('$cust_id', '$date_time', '$email', '$business_name', '$login_link', '1')";
    $result_up = mysqli_query($conn, $sql2);
echo "<script>alert('After sales email sent successfully !'); window.location='ssales.php';exit();</script>";
}
else{
echo "<script>alert('Sorry. Email not send'); window.location='ssales.php';exit();</script>";
}
}
?>
