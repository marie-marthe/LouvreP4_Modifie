<?php


namespace App\Controller;


use App\Entity\Reservation;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReservationType;



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
     * @return RedirectResponse|Response
     * @throws Exception
     */

    public function form( Request $request ) {

        $reservation = new Reservation();


        $form= $this -> createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $reservation->setDate_Reservation(new\DateTime());
            $reservation->setTitre("Musée du Louvre");
            $reservation->setImage("http://placeholder.it/350x130");


            //$manager->persist($reservation); // faire persister l'article
            //$manager->flush(); // lancer la requête

            return $this->redirectToRoute('home'); // si tout est ok retourne à la page "home"
        }

        return $this->render('order/create.html.twig',[
            'form'=>$form->createView()

            ]);




    }

}