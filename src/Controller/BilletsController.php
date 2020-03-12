<?php


namespace App\Controller;


use App\Entity\Reservation;
use Doctrine\DBAL\Types\DateType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class BilletsController extends AbstractController
{

    // Récupère l'ensembles des articles dans la base de donnée
    // pour les afficher sur la page home.html.twig

    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        $repo = $this->getDoctrine()->getRepository(Reservation::class);

        $reservations = $repo->findAll();

        return $this->render('order/home.html.twig', [
            'title' => 'BilletController',
            'reservations'=> $reservations
        ]);
    }

    // Récupère l'article sélectionné dans la base de donnée
    // pour les afficher sur la page home.html.twig

    /**
     * @Route("/billeterie/{id}", name="billeterie")
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $repo= $this->getDoctrine()->getRepository(Reservation::class);

        $reservation = $repo->find($id);

        return $this->render('order/index.html.twig', [
            'reservation' => $reservation
        ]);
    }


    /**
     * @Route("/billet", name="billet")
     */
    public function index()
    {
        return $this->render('order/index.html.twig', [
            'nom' => 'Bienvenue ici les amis !!',
            'age'=> 31
        ]);
    }


    // Pour les afficher sur la page userForm.html.twig

    /**
     * @Route("/reservation", name="reservation")
     * @return Response
     */

    public function create() {
        $reservation = new Reservation();

        $form = $this   ->createFormBuilder($reservation)

                        ->add('nom', TextType::class, [
                            'attr'=> [
                                'placeholder'=> " Entrer votre Nom",
                                'class'=> 'form-control'
                            ]
                        ])
                        ->add('prenom', TextType::class, [
                            'attr'=> [
                                'placeholder'=> " Entrer votre Prenom",
                                'class'=> 'form-control'
                            ]
                        ])
                        ->add('email', TextType::class, [
                            'attr'=> [
                                'placeholder'=> " Entrer votre Email",
                                'class'=> 'form-control'
                            ]
                        ])
                        ->add('Valider',SubmitType::class, array('label'=> 'Valider'))
                        ->getForm();

        return $this->render('order/create.html.twig',[
            'form'=>$form->createView()

            ]);


    }

}