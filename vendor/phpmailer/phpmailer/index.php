<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '..\..\autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

if ($_POST['btnContact']) {
  $email = filter_var($_POST['email_contact'], FILTER_SANITIZE_EMAIL);
  $message = $_POST['message'];
  $username = $_POST['first_name_contact'] . " " . $_POST['last_name_contact'];

  try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'gacanoviccc97@gmail.com';                     // SMTP username
    $mail->Password   = 'wtwc bsvl xtqm ulae';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom($email, $username);
    $mail->addAddress('markogacanovic111@gmail.com');     // Add a recipient
    $mail->addReplyTo($email, "Sample");

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Contact Request';
    $mail->Body    = $message;
    $mail->AltBody = $message;

    $mail->send();

    header("Location: ../../../index.php?page=thanks");
    exit(); 
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
