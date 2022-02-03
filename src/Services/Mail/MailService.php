<?php
namespace App\Services\Mail;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;


class MailService implements MailServiceInterface
{

    private MailerInterface $mailer;
    private LoggerInterface $loggerInterface;
    public function __construct(MailerInterface $mailer ,  LoggerInterface $loggerInterface)
    {
        $this -> loggerInterface = $loggerInterface;
        $this -> mailer = $mailer;
    }

    /**
     * @param string $user_mail
     * @param string $subject
     * @param string $code
     * @throws \SendGrid\Mail\TypeException
     */
    public function sendMail(string $user_mail,  string $subject,string $code): void
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("chapristimailpro@gmail.com", "equipe esport");
        $email->setSubject($subject);
        $email->addTo($user_mail, $user_mail);
        $email->addContent(
            "text/html", "<strong><a href='${code}'>verif account</a></strong>"
        );
        $sendgrid = new \SendGrid("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");
        try {
            $response = $sendgrid->send($email);
            //print $response->statusCode() . "\n";
            //print_r($response->headers());
            //print $response->body() . "\n";
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

}