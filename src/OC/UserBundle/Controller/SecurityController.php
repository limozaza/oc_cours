<?php

namespace OC\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            return $this->redirectToRoute('oc_platform_home');
        }

        // Le service authentication_utils permet de récupérer le nom d'utilisateur
        // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
        // (mauvais mot de passe par exemple)
        $authentificationUtils = $this->get('security.authentication_utils');
        return $this->render('OCUserBundle:Security:login.html.twig',[
            'last_username'=> $authentificationUtils->getLastUsername(),
            'error'=>$authentificationUtils->getLastAuthenticationError()
        ]);
    }
}
