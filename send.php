<?php
 //Checks to see if the reCAPTHCA was solved correctly//
 require_once('recaptchalib.php');
 $privatekey = "YOUR_PRIVATE_KEY";
 $resp = recaptcha_check_answer ($privatekey,
                                 $_SERVER["REMOTE_ADDR"],
                                 $_POST["recaptcha_challenge_field"],
                                 $_POST["recaptcha_response_field"]);
 if (!$resp->is_valid) {
   // What happens when the CAPTCHA was entered incorrectly
   die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
        "(reCAPTCHA said: " . $resp->error . ")");
 }
//Convert the imput fields into php variables//
$field_name = $_POST['cf_name'];
$field_email = $_POST['cf_email'];
$field_email_request_choice_1 = $_POST['cf_email_request_choice_1'];
$field_email_request_choice_2 = $_POST['cf_email_request_choice_2'];
$radio_button = $_POST['cf_radio_button'];
$drop_down_item = $_POST['cf_drop_down'];
$ip_address = $_POST['cf_ip_address'];

//Where to send the application email to (admin's email)//
$mail_to = 'email@example.com';
//Subject of the sent email//
$subject = 'Application for Email Address from '.$field_name;

//Body of the email//
$body_message = 'From: '.$field_name."\n";
$body_message .= 'E-mail: '.$field_email."\n";
$body_message .= 'First choice of email: '.$field_email_request_choice_1."\n";
$body_message .= 'Second choice of email: '.$field_email_request_choice_2."\n";
$body_message .= "Did the person agree: ".$radio_button."\n";
$body_message .= "Selected domain: ".$drop_down_item."\n";
$body_message .= "IP Address: ".$ip_address;

//Headers of the email (the from and reply-to parts)//
$headers = 'From: no-reply@morbidentree.com'."\r\n";
$headers .= 'Reply-To: '.$field_email."\r\n";

//Sends the email//
$mail_status = mail($mail_to, $subject, $body_message, $headers);

//Returns a message to the applicant if the email gets sent and redirects them back to the application//
if ($mail_status) { ?>
	<script language="javascript" type="text/javascript">
		alert('Thank you for applying. You will be contacted you shortly.');
		window.location = 'http://example.com/apply.php';
	</script>
<?php
}
else { ?>
//Returns an error to the applicant if the email doesn't send and redirects them back to the application//
	<script language="javascript" type="text/javascript">
		alert('Message failed. Please, send an email to admin@yoursite.com');
		window.location = 'http://example.com/apply.php';
	</script>
<?php
}
?>
