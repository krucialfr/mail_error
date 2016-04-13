<?php

// Inclusion de la librairie
require("mail.error.lib.php")

// Appel de la librairie
$email = 'Example@Gmail.fr';
$email = mail_detect_erreur($email);
echo $email;

// Affiche Example@gmail.com
	
?>