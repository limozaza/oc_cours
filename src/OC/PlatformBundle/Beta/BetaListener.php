<?php
/**
 * Created by PhpStorm.
 * User: zakaria
 * Date: 18/07/17
 * Time: 16:11
 */

namespace OC\PlatformBundle\Beta;


use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class BetaListener
{
    protected $betaHTML;
    protected $endDate;

    public function __construct(BetaHTMLAdder $betaHTML, $endDate)
    {
        $this->betaHTML = $betaHTML;
        $this->endDate = new \DateTime($endDate);
    }

    public function processBeta(FilterResponseEvent $event){

        if(!$event->isMasterRequest()){
            return;
        }
        $remainigDays = $this->endDate->diff(new \DateTime())->days;

        dump($remainigDays);

        if($remainigDays <= 0){
            return;
        }
        // Ici on appelera la méthode
        // $this->betaHTML->addBeta()
        $response = $this->betaHTML->addBeta($event->getResponse(),$remainigDays);
        $event->setResponse($response);
    }
}