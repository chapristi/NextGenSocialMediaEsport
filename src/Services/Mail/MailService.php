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
     * @param string $body
     * @param string $subject
     * @param array $params
     * Possibility to send an email
     */
    public function sendMail(string $user_mail, string $body, string $subject, array $params): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address("chapristimailpro@gmail.com"))
            ->to($user_mail)
            ->subject($subject)
            ->htmlTemplate($body)
            ->context($params)
        ;
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this -> loggerInterface->error("Un problème est survenu lors de l'envoi d'email", [
                'exception' => $e,
            ]);
        }
    }

}