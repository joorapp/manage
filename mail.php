<?php
    use PHPMailer\PHPMailer;
    use PHPMailer\Exception;

    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
try
{
    $email = new PHPMailer(TRUE);
    $email->isSMTP();
    $email->SMTPDebug = 2;
    $email->SMTPAuth = TRUE;
    $email->SMTPAutoTLS = FALSE;
    $email->SMTPSecure = "tls";
    $email->Host = "smtpout.secureserver.net";
    $email->Port = 80;
    $email->Username = "info@ebacpro.com";
    $email->Password = "Processing@7";

    $email->setFrom("info@ebacpro.com", "Name");
    $email->addAddress("krish.flwd@gmail.com", "Name");
    $email->isHTML(TRUE);
    $email->Body = "My HTML Code";
    $email->Subject = "My Subject";
    $email->send();
}
catch (Exception $e)
{
    // $email->ErrorInfo;
}
?>