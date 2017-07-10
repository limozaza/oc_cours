<?php

namespace OC\PlatformBundle\Form;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $pattern = 'D%';

        $builder
            ->add('date', DateTimeType::class)
            ->add('title', TextType::class)
            ->add('author', TextType::class)
            ->add('content', TextareaType::class)
            ->add('published', CheckboxType::class,
                [
                    'required'=>false
                ]
            )
            ->add('image', ImageType::class)
            ->add('categories',EntityType::class, [
                'class' => 'OC\PlatformBundle\Entity\Category',
                'choice_label' => 'name',
                'multiple'=> true,
                'expanded' => true,
                'query_builder'=> function(CategoryRepository $repository) use ($pattern){
                    return $repository->getLikeQueryBuilder($pattern);
                }
            ])
            ->add('save', SubmitType::class);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event){
                /**
                 * @var $advert Advert
                 */
                $advert = $event->getData();
                if(null === $advert){
                    return;
                }
                if(!$advert->getPublished() || null === $advert->getId()){
                    $event->getForm()->add('published', CheckboxType::class,['required'=>false]);
                }else{
                    $event->getForm()->remove('published');
                }
            }
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\PlatformBundle\Entity\Advert'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_platformbundle_advert';
    }


}
