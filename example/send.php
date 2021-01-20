<?php

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/Config.php";

use BrBunny\BrMailer\BrMailer;

$email = new BrMailer();

$email->bootstrap(
    "Here is the subject",
    "This is the HTML message body <b>in bold!</b>",
    "van@example.com", //is Optional
    "Van User" //is Optional
);

//Destination address
$email->addAddress("joe@example.net", "Joe User"); //Name is Optional
$email->addCC("jhow@example.com", "Jhow User"); //Name is Optional
$email->addBCC("gui@example.net", "Gui User"); //Name is Optional

//Add Attachment in E-mail
$email->attach("./file.pdf", "Foto Email");


if ($email->send()) {
    echo "Success Send";
} else {
    echo $email->fail()->getMessage();
}
