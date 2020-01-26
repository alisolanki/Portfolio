<?php

require_once('PHPMailer-5.2-stable/PHPMailerAutoload.php');

//part 1

//    $name = trim(stripslashes($_POST['contactName']));
//    $email = trim(stripslashes($_POST['contactEmail']));
//    $subject = trim(stripslashes($_POST['contactSubject']));
//    $contact_message = trim(stripslashes($_POST['contactMessage']));
if(isset($_POST['submit'])){
    $name = $_POST['contactName'];
    $email = $_POST['contactEmail'];
    $subject = $_POST['contactSubject'];
    $contact_message = $_POST['contactMessage'];

   // Check Name
	if (strlen($name) < 1) {
		$error['name'] = "Please enter your name.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Please enter a valid email address.";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['message'] = "Please enter your message. It should have at least 20 characters.";
	}
   // Subject
	if ($subject == '') { $subject = "Contact Form Submission"; }


   // Set Message
   	$message .= "Email from: " . $name . "<br />";
	$message .= "Email address: " . $email . "<br />";
   	$message .= "Message: <br />";
   	$message .= $contact_message;
   	$message .= "<br /> ----- <br /> This email was sent from alisolanki.gq site's contact form. <br />";

    echo $message;
   // Set From: header
   $from =  $name . " <" . $email . ">";

   // Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
 	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


   if (!$error) {

       //part 2

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '465';
        $mail->isHTML();
        $mail->Username = 'llol3776@gmail.com';
        $mail->Password = 'rhzbkppfxfiwlmpc';
        $mail->SetFrom('admin@alisolanki.gq');
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AddAddress($email);

        $mail->Send();

		// if ($mail->Send() == true) { 
        //     echo "OK"; 
        // }else{ 
        //         echo "Something went wrong. Please try again.";
        // }
		
 	} # end if - no validation error

 	else {

 		$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
 		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
 		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
		
		echo $response;
 	} # end if - there was a validation error
}
?>

