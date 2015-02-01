<?php require_once('vendor/autoload.php');

$sendgrid = new SendGrid('YOUR_SENDGRID_USERNAME', 'YOUR_SENDGRID_PASSWORD');
$email = new SendGrid\Email();
$email
	->addTo('navarajh@gmail.com')
    ->setFrom('me@bar.com')
    ->setSubject('Subject goes here')
    ->setText('Hello World!')
    ->setHtml('<strong>Hello World!</strong>');

$sendgrid->send($email);

var_dump($sendgrid);

?>
