# BRMAILER @BrBunny

[![Maintainer](https://img.shields.io/badge/maintainer-@kevind3v-blue.svg?style=flat-square)](https://github.com/kevind3v)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/brbunny/brmailer.svg?style=flat-square)](https://packagist.org/packages/brbunny/brmailer)
[![Latest Version](https://img.shields.io/github/release/kevind3v/brmailer.svg?style=flat-square)](https://github.com/kevind3v/brmailer/releases/)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/kevind3v/brmailer/blob/main/LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/brbunny/brmailer.svg?style=flat-square)](https://packagist.org/packages/brbunny/brmailer)

BrMailer is a component for handling emails using PHPMAILER.

#### Installation

BrMailer is available through Composer:

```sh
"brbunny/brmailer": "1.0.*"
```

or run

```sh
composer require brbunny/brmailer
```

#### Documentation

For more details on how to use BrMailer, see the example folder with details in the component directory

##### Configuration

_To begin using BrMailer we need to configure the email data. Put constant BRMAILER in your project's configuration file and change the values according to your preference. To learn more visit [Component PHPMailer](https://packagist.org/packages/phpmailer/phpmailer)_

Para começar a usar o BrMailer precisamos configurar os dados do e-mail. Coloque constante BRMAILER no arquivo de configuração do seu projeto e mude os valores de acordo com sua preferência. Para saber mais visite [Componente PHPMailer](https://packagist.org/packages/phpmailer/phpmailer)

```php
<?php

define("BRMAILER", [
    "host" => "mail.host.com",
    "port" => "587",
    "user" => "user@example.com",
    "passwd" => "secret",
    "from" => [
       "name" => "From Name",
       "address" => "from@example.com",
    ],
    "reply" => {
       "name" => "Reply Name",
       "address" => "info@example.com",
    }
    "options" => [
       "language" => "br", // Set Language Email
       "smtp_debug" => 0, // Enable verbose debug output
       "is_html" => true, // Set email format to HTML
       "auth" => true, // Enable SMTP authentication
       "secure" => "tls or ssl", // Enable TLS encryption
       "charset" => "utf-8" // Set email charset
    ]
]);
```

##### Bootstrap

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use BrBunny\BrMailer\BrMailer;

$email = new BrMailer();

// (string Subject, string Body, string RecipientAddress, string RecipientName)
$email->bootstrap(
    "Here is the subject",
    "This is the HTML message body <b>in bold!</b>",
);
```

##### AddAddress

```php
<?php

// Destination address
$email->addAddress("joe@example.net", "Joe User");
$email->addAddress("jhow@example.com"); // Name is optional
```

##### Attachment

```php
<?php

// Add Attachment in E-mail
$email->attach("/tmp/image.jpg", "Image");
$email->attach("/tmp/file.pdf"); // Name is optional
```

##### Send E-mail

```php
<?php

// string $from, string $fromName, string $replyTo, string $replyToName
if($email->send()){
   // Message success
   echo "Success Send";
}else{
   // Get message error
   echo $email->fail()->getMessage();
}
```

### Credits

- [Kevin S. Siqueira](https://github.com/kevind3v) (Developer of this library)
- [PHPMailer](https://packagist.org/packages/phpmailer/phpmailer) (Lib to send E-mail)

### License

The MIT License (MIT). Please see [License File](https://github.com/kevind3v/brmailer/blob/main/LICENSE) for more information.
