<?php

require __DIR__ . "/../vendor/autoload.php";

use BrBunny\BrMailer\BrMailer;

$email = new BrMailer();

$email->bootstrap(
    "Subject E-mail",
    "<p>Hello <b>Word</b>!</p>",
);

//Destination address
$email->addAddress("you@example.com", "You Name");
$email->addAddress("you@example.com");

//Add Attachment in E-mail
$email->attach("./file.pdf", "Foto Email");


if ($email->send()) {
    echo "Success Send";
} else {
    echo $email->fail()->getMessage();
}
