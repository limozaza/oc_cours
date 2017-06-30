<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends Controller
{
    public function indexAction($page)
    {
        $content = $this->get('templating')->render('OCPlatformBundle:Advert:index.html.twig',['name' => "Boufares"]);
        return new Response($content);
    }

    public function viewAction($id)
    {
        return new Response("L'annace d'id $id");
    }

    public function viewSlugAction($slug,$year,$format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au
            slug '".$slug."', créée en ".$year." et au format ".$format."."
        );
    }
}
