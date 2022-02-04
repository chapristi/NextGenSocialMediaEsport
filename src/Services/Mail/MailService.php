<?php
namespace App\Services\Mail;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use \Mailjet\Resources;

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



        $mj = new \Mailjet\Client('5fa254dd87cf32f99fcf674d599d4c13','0acb9465ee7927239bfc570ab9782751',true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "louis@chapristi.tech",
                        'Name' => "chapristi"
                    ],
                    'To' => [
                        [
                            'Email' => "$user_mail",
                            'Name' => "$user_mail"
                        ]
                    ],
                    'Subject' => "$subject",
                    'TextPart' => "My first Mailjet email",
                    'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='$code'>verif account</a>!</h3><br />May the delivery force be with you!",

                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        //$response->success() && var_dump($response->getData());
    }

}