<?php

// Replace this with your own email address
$siteOwnersEmail = 'hola@prticular.io';


if($_POST) {

   $name = trim(stripslashes($_POST['contactName']));
   $email_contact = trim(stripslashes($_POST['contactEmail']));
   $subject = trim(stripslashes($_POST['contactSubject']));
   $contact_message = trim(stripslashes($_POST['contactMessage']));

   // Check Name
	if (strlen($name) < 2) {
		$error['name'] = "Please enter your name.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email_contact)) {
		$error['email'] = "Please enter a valid email address.";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['message'] = "Please enter your message. It should have at least 15 characters.";
	}
   // Subject
	if ($subject == '') { $subject = "Contact Form Submission"; }

	// Using sendgrid
	require_once("sendgrid/sendgrid-php.php");

	$email = new \SendGrid\Mail\Mail();
	$email->setFrom("$siteOwnersEmail", "Prticular Mail");
	$email->setSubject("Contact form from sngular event");
	$email->addTo("$siteOwnersEmail", "Example User");
	//$email->addContent("text/html", "Msg received from: $email\nSubject: $subject\nMsg: $contact_message");
	$email->addContent("text/plain", "Msg received from: $email_contact\nSubject: $subject\nMsg: $contact_message");
	$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
	try {
			$response = $sendgrid->send($email);
			print "Contact form sent! Thank you for contact us. We will answer you soon :)";
			return true;
	} catch (Exception $e) {
			echo 'Caught exception: '. $e->getMessage() ."\n";
	}

}

?>
