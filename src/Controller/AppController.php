<?php


namespace App\Controller;


use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function demo(EntityManagerInterface $manager)
    {
        $cities = ['Lyon' , 'Paris', 'Marseille'];

        foreach ($cities as $city) {
            $manager->persist((new City())->setName($city));
        }

        $manager->flush();

        $form = $this->createFormBuilder()->add('cities', EntityType::class, [
            'label' => 'Ville',
            'class' => City::class,
            'choice_label' => 'name',
            'multiple' => true,
            'expanded' => false,
        ])->getForm()
        ;

        return $this->render('base.html.twig', ['form'=>$form->createView()]);
    }
}
