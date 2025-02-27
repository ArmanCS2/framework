<?php

namespace App\Http\Services;

use System\Config\Config;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;


use Lib\PHPMailer\PHPMailer\PHPMailer as PHPMailer2;
use Lib\PHPMailer\PHPMailer\SMTP as SMTP2;
class MailService
{
    public function send($emailAddress, $subject, $body)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = Config::get('mail.SMTP.Host');                     //Set the SMTP server to send through
            $mail->SMTPAuth = Config::get('mail.SMTP.SMTPAuth');                                   //Enable SMTP authentication
            $mail->Username = Config::get('mail.SMTP.Username');                     //SMTP username
            $mail->Password = Config::get('mail.SMTP.Password');                               //SMTP password
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->SMTPSecure = 'tls';
            $mail->Port = Config::get('mail.SMTP.Port');                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(Config::get('mail.SMTP.setFrom.mail'), Config::get('mail.SMTP.setFrom.name'));
            $mail->addAddress($emailAddress);     //Add a recipient
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            //echo 'Message has been sent';
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
    public function sendMail($emailAddress, $subject, $body)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer2(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP2::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = MAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = SMTP_AUTH;                                   //Enable SMTP authentication
            $mail->Username   = MAIL_USERNAME;                     //SMTP username
            $mail->Password   = MAIL_PASSWORD;                               //SMTP password
            //$mail->SMTPSecure = PHPMailer2::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->SMTPSecure = 'tls';
            $mail->Port       = MAIL_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(SENDER_MAIL, SENDER_NAME);
            $mail->addAddress($emailAddress);     //Add a recipient
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            //echo 'Message has been sent';
            return true;
        } catch (Exception $e) {
            echo"Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
}