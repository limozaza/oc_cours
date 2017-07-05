<?php
/**
 * Created by PhpStorm.
 * User: zakaria
 * Date: 05/07/17
 * Time: 23:34
 */

namespace OC\PlatformBundle\Email;


use OC\PlatformBundle\Entity\Application;

class ApplicationMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNewNotification(Application $application){
        $message = new \Swift_Message('Nouvelle condidature','vous avez recu une nouvelle candidature.');
        $message->addTo($application->getAdvert()->getAuthor())
            ->addFrom('admin@zaza.fr');
        $this->mailer->send($message);
    }
}