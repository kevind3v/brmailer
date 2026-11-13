<?php

namespace BrBunny\BrMailer;

use BrBunny\BrPlates\BrPlates;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

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
     * @param string|null $recipient
     * @param string|null $recipientName
     * @return BrMailer
     */
    public function bootstrap(
        string $subject,
        string $body,
        ?string $recipient = null,
        ?string $recipientName = null
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
     * @return BrMailer
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
     * @return string
     */
    public function renderTemplate(string $theme, ?array $data = []): string
    {
        return $this->template->render($theme, $data ?? []);
    }

    /**
     * @param string $path
     * @param string|null $fileName
     * @return BrMailer
     */
    public function attach(string $path, ?string $fileName = null): BrMailer
    {
        $this->data->attach[$path] = $fileName;
        return $this;
    }

    /**
     * @param string $recipient
     * @param string|null $recipientName
     * @return BrMailer
     */
    public function addAddress(string $recipient, ?string $recipientName = null): BrMailer
    {
        $this->data->address[$recipient] = $recipientName;
        return $this;
    }

    /**
     * @param string $recipient
     * @param string|null $recipientName
     * @return void
     */
    public function addCC(string $recipient, ?string $recipientName = null)
    {
        $this->data->cc[$recipient] = $recipientName;
    }

    /**
     * @param string $recipient
     * @param string|null $recipientName
     * @return void
     */
    public function addBCC(string $recipient, ?string $recipientName = null)
    {
        $this->data->bcc[$recipient] = $recipientName;
    }

    /**
     * @param string $from
     * @param string $fromName
     * @param string|null $replyTo
     * @param string|null $replyToName
     * @return boolean
     */
    public function send(
        string $from = BRMAILER['from']['address'],
        string $fromName = BRMAILER['from']['name'],
        ?string $replyTo = null,
        ?string $replyToName = null
    ): bool {
        try {
            if (
                count(get_object_vars($this->data)) == 0
            ) {
                throw new Exception("Error!! Empty data");
            }

            $this->mail->Subject = (string)$this->data->subject;
            $this->mail->Body = $this->data->body;
            if ($this->mail->ContentType === PHPMailer::CONTENT_TYPE_TEXT_HTML) {
                $this->mail->AltBody = $this->mail->html2text(
                    $this->data->body,
                    fn(string $html): string => $this->htmlToText($html)
                );
            }

            if ($replyTo === null && !empty($this->config['reply']['address'])) {
                $replyTo = $this->config['reply']['address'];
                $replyToName = $replyToName ?? ($this->config['reply']['name'] ?? null);
            }

            if ($replyTo) {
                $this->mail->addReplyTo($replyTo, $replyToName ?? '');
            }
            
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
    }

    /**
     * Converts HTML to plain text keeping link URLs ("text: URL")
     * @param string $html
     * @return string
     */
    private function htmlToText(string $html): string
    {
        $charset = $this->mail->CharSet;
        $html = preg_replace('/<(head|title|style|script)[^>]*>.*?<\/\1>/si', '', $html);
        $html = preg_replace_callback(
            '/<a\s[^>]*?href\s*=\s*(["\'])(.*?)\1[^>]*>(.*?)<\/a>/si',
            function (array $m) use ($charset): string {
                // Entities stay encoded here; the final html_entity_decode handles them once
                $href = trim($m[2]);
                $text = trim(strip_tags($m[3]));
                $plainText = trim(html_entity_decode($text, ENT_QUOTES, $charset));
                $plainUrl = html_entity_decode($href, ENT_QUOTES, $charset);
                return ($plainText === '' || $plainText === $plainUrl) ? $href : "{$text}: {$href}";
            },
            $html
        );
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES, $charset);
        $text = implode("\n", array_map('trim', preg_split('/\R/u', $text)));
        return trim(preg_replace('/\n{3,}/', "\n\n", $text));
    }
}
