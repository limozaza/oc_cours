<?php

namespace OC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('OCCoreBundle:Core:index.html.twig');
    }

    public function contactAction(Request $request){
        $session = $request->getSession();
        $session->getFlashBag()->add('info', 'Message flash : La page de contact n’est pas encore disponible, merci de revenir plus tard.');
        return $this->redirectToRoute('oc_core_home');
    }
}
