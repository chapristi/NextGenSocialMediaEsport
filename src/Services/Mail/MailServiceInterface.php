<?php
namespace App\Services\Mail;

interface MailServiceInterface
{
    public function sendMail(string $user_mail,string $subject,string $body, array $params);
}