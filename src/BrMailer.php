<?php

namespace BrBunny\BrMailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * BrMailer Class
 * @author Kevin S. Siqueira <kevinsiqueira.dev@gmail.com>
 * @package BrBunny\BrMailer
 */
class BrMailer
{
    use BrMailerTrait;

    /** @var \stdClass */
    private $data;
    /** @var PHPMailer */
    private $mail;
    /** @var Exception */
    private $fail;


    public function __construct()
    {
        if (!defined('BRMAILER')) {
            die('Use of undefined constant BRMAILER - class ' . __CLASS__);
        }
        $this->mail = new PHPMailer(true);
        $this->data = new \stdClass();
        //CONFIGURATION
        $this->mail->isSMTP();
        $this->SMTPDebug = BRMAILER['options']['smtp_debug'] ?? 0;
        $this->mail->setLanguage(BRMAILER['options']['language'] ?? "br");
        $this->mail->isHTML(BRMAILER['options']['is_html'] ?? true);
        $this->mail->SMTPAuth = BRMAILER['options']['auth'];
        $this->mail->SMTPSecure = BRMAILER['options']['secure'];
        $this->mail->CharSet = BRMAILER['options']['charset'] ?? "utf-8";

        //AUTH
        $this->mail->Host = BRMAILER['host'];
        $this->mail->Port = BRMAILER['port'];
        $this->mail->Username = BRMAILER['user'];
        $this->mail->Password = BRMAILER['passwd'];
    }

    /**
     * @return PHPMailer
     */
    public function mail(): PHPMailer
    {
        return $this->mail;
    }

    public function data()
    {
        return $this->data;
    }

    /**
     * @return Exception|null
     */
    public function fail(): ?Exception
    {
        return $this->fail;
    }
}
