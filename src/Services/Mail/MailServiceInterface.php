<?php
namespace App\Services\Mail;

interface MailServiceInterface
{
    public function sendMail(string $user_mail,string $body,string $subject, array $params);
}