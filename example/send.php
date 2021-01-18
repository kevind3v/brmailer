<?php

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/../src/Config.php";

use BrBunny\BrMailer\BrMailer;

$email = new BrMailer();

$email->bootstrap(
    "Here is the subject",
    "This is the HTML message body <b>in bold!</b>",
);

//Destination address
$email->addAddress("joe@example.net", "Joe User");
$email->addAddress("jhow@example.com");

//Add Attachment in E-mail
$email->attach("./file.pdf", "Foto Email");


if ($email->send()) {
    echo "Success Send";
} else {
    echo $email->fail()->getMessage();
}
