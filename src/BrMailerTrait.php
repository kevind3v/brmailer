<?php

namespace BrBunny\BrMailer;

use BrBunny\BrPlates\BrPlates;
use PHPMailer\PHPMailer\Exception;

/**
 * Trait Class
 * @author Kevin S. Siqueira <kevinsiqueira.dev@gmail.com>
 * @package BrBunny\BrMailer
 */
trait BrMailerTrait
{
    /**
     * @param string $subject
     * @param string $body
     * @param string $recipient
     * @param string $recipientName
     * @return BrMailer
     */
    public function bootstrap(
        string $subject,
        string $body,
        string $recipient = null,
        string $recipientName = null
    ): BrMailer {
        $this->data->subject = $subject;
        $this->data->body = $body;
        if ($recipient) {
            $this->addAddress($recipient, $recipientName);
        }
        return $this;
    }

    /**
     * @param string $path
     * @param string $ext
     */
    public function template(
        string $path,
        string $ext = "php"
    ): BrMailer {
        $this->template = new BrPlates($path, $ext);
        return $this;
    }

    /**
     * @param string $theme
     * @param array|null $data
     * @return BrPlates
     */
    public function renderTemplate(string $theme, ?array $data = []): string
    {
        return $this->template->render($theme, $data);
    }

    /**
     * @param string $path
     * @param string $fileName
     * @return BrMailer
     */
    public function attach(string $path, string $fileName = null): BrMailer
    {
        $this->data->attach[$path] = $fileName;
        return $this;
    }

    /**
     * @param string $recipient
     * @param string $recipientName
     * @return BrMailer
     */
    public function addAddress(string $recipient, string $recipientName = null): BrMailer
    {
        $this->data->address[$recipient] = $recipientName;
        return $this;
    }

    /**
     * @param string $recipient
     * @param string $recipientName
     * @return void
     */
    public function addCC(string $recipient, string $recipientName = null)
    {
        $this->data->cc[$recipient] = $recipientName;
    }

    /**
     * @param string $recipient
     * @param string $recipientName
     * @return void
     */
    public function addBCC(string $recipient, string $recipientName = null)
    {
        $this->data->bcc[$recipient] = $recipientName;
    }

    /**
     * @param string $from
     * @param string $fromName
     * @return boolean
     */
    public function send(
        string $from = BRMAILER['from']['address'],
        string $fromName = BRMAILER['from']['name'],
        string $replyTo = BRMAILER['reply']['address'],
        string $replyToName = BRMAILER['reply']['name']
    ): bool {
        try {
            if (
                count(get_object_vars($this->data)) == 0
            ) {
                throw new Exception("Error!! Empty data");
            }

            $this->mail->Subject = (string)$this->data->subject;
            $this->mail->Body = $this->data->body;

            $this->mail->addReplyTo($replyTo, $replyToName);
            $this->mail->setFrom($from, $fromName);

            if (!empty($this->data->address)) {
                foreach ($this->data->address as $address => $name) {
                    $this->mail->addAddress($address, $name);
                }
            }
            if (!empty($this->data->cc)) {
                foreach ($this->data->cc as $cc => $name) {
                    $this->mail->addCC($cc, $name);
                }
            }
            if (!empty($this->data->bcc)) {
                foreach ($this->data->bcc as $bcc => $name) {
                    $this->mail->addBCC($bcc, $name);
                }
            }
            if (!empty($this->data->attach)) {
                foreach ($this->data->attach as $path => $name) {
                    $this->mail->addAttachment($path, $name);
                }
            }

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            $this->fail = $e;
            return false;
        }

        return false;
    }
}
