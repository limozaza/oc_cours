<?php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\AdvertSkill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1) {
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }
        $nbPerPage = 2;
        $listAdverts = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('OCPlatformBundle:Advert')
                        ->getAdverts($page, $nbPerPage);

        $nbPages = ceil(count($listAdverts) / $nbPerPage);

        // Si la page n'existe pas, on retourne une 404
        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $listAdverts = $listAdverts->getQuery()->getResult();


        // Mais pour l'instant, on ne fait qu'appeler le template
        return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts,
            'nbPages'     => $nbPages,
            'page'        => $page,
        ));
    }

    public function viewAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        //Advert
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

        if(null === $advert){
            throw new NotFoundHttpException("L'annonce d'id $id n'existe pas");
        }

        $listApplications = $em->getRepository("OCPlatformBundle:Application")
            ->findBy(['advert'=>$advert]);


        $listAdvertSkills = $em->getRepository('OCPlatformBundle:AdvertSkill')
            ->findBy(['advert'=>$advert]);


        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
            'advert' => $advert,
            'listApplications'=>$listApplications,
            'listAdvertSkills'=>$listAdvertSkills
        ));
    }

    public function addAction(Request $request)
    {

        // La gestion d'un formulaire est particulière, mais l'idée est la suivante :
        $advert = new Advert();
        $advert->setDate(new \DateTime());
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $advert);

        $formBuilder
            ->add('date',DateType::class)
            ->add('title',TextType::class)
            ->add('content',TextareaType::class)
            ->add('author',TextType::class)
            ->add('published',CheckboxType::class,[
                'required'=> false
            ])
            ->add('save',SubmitType::class);

        $form = $formBuilder->getForm();


        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($advert);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
                return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
            }
        }

        return $this->render('OCPlatformBundle:Advert:add.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

        if(null === $advert){
            throw new NotFoundHttpException("L'annonce d'id $id n'existe pas.");
        }

        // Même mécanisme que pour l'ajout
        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

            return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }



        return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
            'advert' => $advert
        ));

    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        if(null === $advert){
            throw new NotFoundHttpException("L'annonce d'id $id n'existe pas.");
        }

        foreach ($advert->getCategories() as $category){
            $advert->removeCategory($category);
        }
        $em->flush();

        return $this->render('OCPlatformBundle:Advert:delete.html.twig');
    }


    public function menuAction($limit)
    {
        $em = $this->getDoctrine()->getManager();

        $listAdverts =  $em->getRepository('OCPlatformBundle:Advert')->findBy(
            [],
            ['date'=>'desc'],
            $limit,
            0
        );


        return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
            'listAdverts' => $listAdverts
        ));
    }


    public function purge($days, Request $request){
        $purge = $this->get('oc_platform.purger.advert');
        $purge->purge($days);
        return $this->redirectToRoute('oc_platform_home');
    }
}
