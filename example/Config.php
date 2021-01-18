<?php

define("BRMAILER", [
   "host" => "host.example.com",
   "port" => "587",
   "user" => "user@example.com",
   "passwd" => "secret",
   "from" => [
      "name" => "From Name",
      "address" => "from@example.com"
   ],
   "reply" => [
      "name" => "Reply Name",
      "address" => "info@example.com"
   ],
   "options" => [
      "language" => "br", // Set Language Email
      "smtp_debug" => 0, // Enable verbose debug output
      "is_html" => true, // Set email format to HTML
      "auth" => true, // Enable SMTP authentication
      "secure" => "tls or ssl", // Enable TLS encryption
      "charset" => "utf-8" // Set email charset
   ]
]);
