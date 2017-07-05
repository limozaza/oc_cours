<?php
/**
 * Created by PhpStorm.
 * User: zakaria
 * Date: 06/07/17
 * Time: 00:03
 */

namespace OC\PlatformBundle\DoctrineListener;


use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use OC\PlatformBundle\Email\ApplicationMailer;
use OC\PlatformBundle\Entity\Application;

class ApplicationCreationListener
{
    /**
     * @var ApplicationMailer
     */
    private $applicationMailer;

    public function __construct(ApplicationMailer $applicationMailer)
    {
        $this->applicationMailer = $applicationMailer;
    }

    public function postPersist(LifecycleEventArgs $args){
        $entity = $args->getObject();
        if(!$entity instanceof  Application){
            return;
        }
        $this->applicationMailer->sendNewNotification($entity);
    }
}