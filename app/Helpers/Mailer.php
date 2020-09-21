<?php


namespace App\Helpers;

use stdClass;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

/**
 * Class Mailer
 * @package App\Support
 */
class Mailer
{
    /**
     * @var PHPMailer
     */
    private $email;

    /**
     * @var stdClass
     */
    private $data;

    /**
     * @var Exception
     */
    private $error;


    const HOST = 'smtp.hostinger.com.br';
    const PORT = '587';
    const USER = 'contact@cashlakay.com';
    const PASSWORD = 'MJcode2019';
    const FROM_NAME = 'Top Recharge';
    const FROM_EMAIL = 'fedletpierre15@gmail.com';


    public function __construct()
    {
        $this->email = new PHPMailer();
        $this->data = new stdClass();

        $this->email->isSMTP();
        $this->email->isHTML();
        $this->email->setLanguage('fr');

        $this->email->SMTPAuth = true;
        $this->email->SMTPSecure = 'tls';
        $this->email->CharSet = 'utf-8';
        $this->email->Host = self::HOST;
        $this->email->Port = self::PORT;
        $this->email->Username = self::USER;
        $this->email->Password = self::PASSWORD;
    }

    public function add(string $subject, string $body, string $recipientName, string $recipientEmail): Mailer
    {
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->recipient_name = $recipientName;
        $this->data->recipient_email = $recipientEmail;
        return $this;
    }

    public function attach(string $filePath, string $fileName): Mailer
    {
        $this->data->attach[$filePath] = $fileName;
        return $this;
    }

    public function send():bool
    {
        try {
            return $this->getMessage();
        }catch (Exception $e){
            $this->error = $e;
            return false;
        }
    }

    public function getMessage()
    {
        $this->email->Subject = $this->data->subject;
        $this->email->msgHTML($this->data->body);
        $this->email->addAddress($this->data->recipient_email,$this->data->recipient_name);
        $this->email->setFrom(self::FROM_EMAIL, self::FROM_NAME);
        if(!empty($this->data->attach)){
            foreach ($this->data->attach as $path => $name){
                $this->email->addAttachment($path,$name);
            }
        }
        $this->email->send();
        return true;
    }

    public function error():?Exception
    {
        return $this->error;
    }
}
