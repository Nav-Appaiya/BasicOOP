<?php

$userName = 'gebruikersnaam';
$passWord = 'wachtwoord';

print 'incorrect: ' . base64_encode($userName) . "<br>\n";
print 'correct: ' . base64_encode($userName . ':' . $passWord) . "<br>\n";

?>