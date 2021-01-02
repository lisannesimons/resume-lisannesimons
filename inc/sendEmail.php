<?php

// Replace this with your own email address
$siteOwnersEmail = 'hello@lisannesimons.eu';

require_once "Mail.php";

if($_POST) {

    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // Check Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }
    // Check Email
    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
        $error['email'] = "Please enter a valid email address.";
    }
    // Check Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
    }
    // Subject
    if ($subject == '') { $subject = "Contact Form Submission"; }


    // Set Message
    $message = "Email from: " . $name . "<br />";
    $message .= "Email address: " . $email . "<br />";
    $message .= "Message: <br />";
    $message .= $contact_message;
    $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

    // Set From: header
    $from =  $name . " <" . $email . ">";

    // Email Headers
    $headers['From'] = $from;
    $headers['To'] = "hello@lisannesimons.eu";
    $headers['Reply-To'] = $email;
    $headers['MIME-Version'] = "1.0";
    $headers['Content-Type'] = "text/html; charset=ISO-8859-1";


    if (!isset($error)) {
	$smtp = Mail::factory('smtp', array ('host' => "tls://dennispotter.eu", 'port' => "465", 'auth' => true, 'username' => "hello@lisannesimons.eu", 'password' => "")); // Add password
	$mail = $smtp->send("hello@lisannesimons.eu", $headers, $message);
	
	if (PEAR::isError($mail)) {
		// Disable error messaging. This could reveal bugs in the server
		// echo("<p>" . $mail->getMessage() . "</p>");
		echo("Oops! Something went wrong");
	} else {
		echo("Message successfully sent!");
	}
        
    } # end if - no validation error

    else {

        $response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
        $response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
        $response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
        
        echo $response;

    } # end if - there was a validation error

}

?>
