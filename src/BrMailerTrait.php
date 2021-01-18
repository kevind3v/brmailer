<?php

namespace BrBunny\BrMailer;

use PHPMailer\PHPMailer\PHPMailer;
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
        string $recipientName = null,
        string $recipient = null
    ): BrMailer {
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->recipient = $recipient;
        $this->data->recipientName = $recipientName;
        return $this;
    }

    /**
     * @param string $path
     * @param string $fileName
     * @return BrMailer
     */
    public function attach(string $path, string $fileName): BrMailer
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
                throw new Exception("Verifique os dados");
            }

            $this->mail->Subject = (string)$this->data->subject;
            $this->mail->Body = $this->data->body;

            $this->mail->addReplyTo($replyTo, $replyToName);
            $this->mail->setFrom($from, $fromName);

            if (!empty($this->data->address)) {
                if ($this->data->recipient) {
                    $this->mail->addAddress($this->data->recipient, $this->data->recipientName);
                }
                foreach ($this->data->address as $address => $name) {
                    $this->mail->addAddress($address, $name);
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
