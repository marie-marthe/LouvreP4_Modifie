<?php


namespace App\Controller;


use App\Entity\Reservation;
use Doctrine\DBAL\Types\DateType;
use Doctrine\Persistence\ObjectManager;
use Exception;
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


    // Pour afficher un formulaire sur la page userForm.html.twig

    /**
     * @Route("/reservation", name="reservation")
     * @param Request $request
     * @param ObjectManager $manager
     * @return RedirectResponse|Response
     * @throws Exception
     */

    public function create( Request $request ) {
        $reservation = new Reservation();

        $form = $this   ->createFormBuilder($reservation)

                        ->add('nom')
                        ->add('prenom')
                        ->add('email')
                        ->getForm();


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $reservation->setDate_Reservation(new\DateTime());
            $reservation->setTitre("Musée du Louvre");
            $reservation->setImage("http://placeholder.it/350x130");


            $manager->persist($reservation);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        dump($reservation);

        return $this->render('order/create.html.twig',[
            'form'=>$form->createView()

            ]);


    }

}