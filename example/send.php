<?php

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/Config.php";

use BrBunny\BrMailer\BrMailer;

$email = new BrMailer();

//Message without HTML
$email->bootstrap(
    "Here is the subject",
    "This is the message body",
    "van@example.com", //is Optional
    "Van User" //is Optional
);

// Message with HTML
// Template HTML message [https://packagist.org/packages/brbunny/brplates]
$template = $email->template("./theme")->renderTemplate("_theme", [
    "title" => "E-mail",
    "company" => "BrBunny"
]);

$email->bootstrap(
    "Here is the subject",
    $template,
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
