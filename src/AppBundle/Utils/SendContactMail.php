<?php

namespace AppBundle\Utils;


use AppBundle\Entity\Contact;

class SendContactMail
{
    private $mailer;
    private $templating;
    private $mailer_user;

    public function __construct(\Swift_Mailer $mailer, $templating, $mailer_user)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->mailer_user = $mailer_user;
    }

    public function sendContactMail(Contact $contact)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Nouveau message de contact')
            ->setFrom($contact->getEmail())
            ->setTo($this->mailer_user)
            ->setBody(
                $this->templating->render(
                    'Emails/_contact.html.twig',
                    array('contact' => $contact)
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}