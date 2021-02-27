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

_To begin using BrMailer we need to configure the email data. Put constant `BRMAILER` in your project's configuration file and change the values according to your preference. To learn more visit [Component PHPMailer](https://packagist.org/packages/phpmailer/phpmailer)_

Para começar a usar o BrMailer precisamos configurar os dados do e-mail. Coloque constante `BRMAILER` no arquivo de configuração do seu projeto e mude os valores de acordo com sua preferência. Para saber mais visite [Componente PHPMailer](https://packagist.org/packages/phpmailer/phpmailer)

```php
<?php

define("BRMAILER", [
   "host" => "mail.host.com",
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
```

##### Bootstrap

_To send email to just one recipient, add the destination email as a parameter in the `bootstrap()` function. However, you can add it with the `addAddress()` function or both together._

Para enviar e-mail para apenas um destinatário, adicione o e-mail de destino como parâmetro da função `bootstrap()`. No entanto, você pode adicioná-lo com a função `addAddress()` ou os ambos juntos.

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use BrBunny\BrMailer\BrMailer;

$email = new BrMailer();

// (string Subject, string Body, string RecipientAddress, string RecipientName)
$email->bootstrap(
    "Here is the subject",
    "This is the message body",
    "van@example.com", // E-mail is Optional
    "Van User" // Name is Optional
);
```

##### Template

_Now you can assemble your html email template using BrPlates, create the template using the `template()` method. For more details access the sample folder and see how it works or visit [BrPlates](https://packagist.org/packages/brbunny/brplates)._

Agora você pode montar seu template de e-mail html usando BrPlates, basta criar o template usando o método `template()`. Para mais detalhes acesse a pasta de exemplo e veja como funciona ou visite [BrPlates](https://packagist.org/packages/brbunny/brplates).

```php
<?php

$template = $email->template("./theme")->renderTemplate("_theme", [
    "title" => "E-mail",
    "company" => "BrBunny"
]);

$email->bootstrap(
    "Here is the subject",
    $template
);
```

##### AddAddress

_If you do not enter email as a parameter in the bootstrap function, you must use the `addAddress()` function._

Se você não inserir email como um parâmetro na função bootstrap, você deve usar a função `addAddress()`.

```php
<?php

$email->addAddress("joe@example.net", "Joe User");
$email->addAddress("jhow@example.com"); // Name is optional
```

##### AddCC

_If you use the `addAddress()` or `addCC()` function to add more than one recipient, they will know who received the message._

Caso use função `addAddress()` ou `addCC()` para adicionar mais de um destinatário, os mesmos terão conhecimento de quem recebeu a mensagem.

```php
<?php

$email->addCC("joe@example.net", "Joe User");
$email->addCC("jhow@example.com"); // Name is optional
```

##### AddBCC

_The `addBCC()` function sends the email to more than one person, without one knowing that the other is receiving the same message._

A função `addBCC()` envia o e-mail para mais de uma pessoa, sem que uma saiba que a outra está recebendo a mesma mensagem.

```php
<?php

$email->addBCC("joe@example.net", "Joe User");
$email->addBCC("jhow@example.com"); // Name is optional
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
