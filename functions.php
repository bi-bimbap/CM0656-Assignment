<?php
include_once 'db/database_conn.php';
include 'email/PHPMailerAutoload.php';

function sendEmail($recipientEmail, $recipientName, $subject, $body, $url) {
  $mail = new PHPMailer;

  // Set mailer to use SMTP
  $mail->isSMTP();

  // Specify main SMTP servers
  $mail->Host = 'smtp.gmail.com';
  // Enable SMTP authentication
  $mail->SMTPAuth = true;

  // SMTP username
  $mail->Username = 'xene.lim@gmail.com';
  // SMTP password
  $mail->Password = 'Qn21022011';

  // Enable TLS encryption (gmail setting)
  $mail->SMTPSecure = 'tls';
  // TCP port to connect to (gmail setting)
  $mail->Port = 587;

  $mail->From = 'no-reply@gmail.com';
  $mail->FromName = 'Ima\'s Official Fanbase';

  // Add recipients
  $mail->addAddress($recipientEmail, $recipientName);

  $mail->isHTML(true);   // Set email format to HTML

  $mail->Subject = $subject;

  $message = file_get_contents($body);
  $message = str_replace('%subject%', $subject, $message);
  $message = str_replace('%name%', $recipientName, $message);
  $message = str_replace('%emailAddr%', $recipientEmail, $message);
  $message = str_replace('%link%', $url, $message);
  $mail->msgHTML($message);

  if(!$mail->send()) {
      //echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
      return false;
  } else {
      //echo 'Message has been sent';
      return true;
  }
}

function sendBidUpdateEmail($recipientEmail, $recipientName, $subject, $body, $url, $bidAmount, $auctionTitle) {
  $mail = new PHPMailer;

  // Set mailer to use SMTP
  $mail->isSMTP();

  // Specify main SMTP servers
  $mail->Host = 'smtp.gmail.com';
  // Enable SMTP authentication
  $mail->SMTPAuth = true;

  // SMTP username
  $mail->Username = 'xene.lim@gmail.com';
  // SMTP password
  $mail->Password = 'Qn21022011';

  // Enable TLS encryption (gmail setting)
  $mail->SMTPSecure = 'tls';
  // TCP port to connect to (gmail setting)
  $mail->Port = 587;

  $mail->From = 'no-reply@gmail.com';
  $mail->FromName = 'Ima\'s Official Fanbase';

  // Add recipients
  $mail->addAddress($recipientEmail, $recipientName);

  $mail->isHTML(true);   // Set email format to HTML

  $mail->Subject = $subject;

  $message = file_get_contents($body);
  $message = str_replace('%subject%', $subject, $message);
  $message = str_replace('%name%', $recipientName, $message);
  $message = str_replace('%emailAddr%', $recipientEmail, $message);
  $message = str_replace('%link%', $url, $message);
  $message = str_replace('%bidAmount%', $bidAmount, $message);
  $message = str_replace('%auctionTitle%', $auctionTitle, $message);
  $mail->msgHTML($message);

  if(!$mail->send()) {
      //echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
      return false;
  } else {
      //echo 'Message has been sent';
      return true;
  }
}

function checkUserStatus($conn, $userID) { //Check if user status is active
  $detailsSQL = "SELECT userStatus FROM user WHERE userID = ?";
  $stmt = mysqli_prepare($conn, $detailsSQL) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmt, "s", $userID);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $userStatus);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  return $userStatus;
}

//sendEmail("seahjm96@gmail.com", "Seah Jia-Min", 'Please Verify Your Email Address', 'email/notifier_verifyEmail.html', 'www.google.com');
?>
