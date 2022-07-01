<?php

namespace BrBunny\BrMailer;

use BrBunny\BrPlates\BrPlates;
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
    /** @var BrPlates */
    private $template;
    /** @var mixed  */
    private $config;

    public function __construct($config = BRMAILER)
    {
        if (!$config) {
            die('Use of undefined config class ' . __CLASS__);
        }
        
        $this->mail = new PHPMailer(true);
        $this->data = new \stdClass();
        //CONFIGURATION
        $this->mail->isSMTP();
        $this->SMTPDebug = $this->config['options']['smtp_debug'] ?? 0;
        $this->mail->setLanguage($this->config['options']['language'] ?? "br");
        $this->mail->isHTML($this->config['options']['is_html'] ?? true);
        $this->mail->SMTPAuth = $this->config['options']['auth'];
        $this->mail->SMTPSecure = $this->config['options']['secure'];
        $this->mail->CharSet = $this->config['options']['charset'] ?? "utf-8";

        //AUTH
        $this->mail->Host = $this->config['host'];
        $this->mail->Port = $this->config['port'];
        $this->mail->Username = $this->config['user'];
        $this->mail->Password = $this->config['passwd'];
    }

    /**
     * @return PHPMailer
     */
    public function mail(): PHPMailer
    {
        return $this->mail;
    }

    public function getTemplate(): BrPlates
    {
        return $this->template;
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
