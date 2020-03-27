<?php

namespace App\Controller;


use App\Entity\Booking;
use App\Form\BookingType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController

{

    /**
     * * Page 1 - Page d'accueil
     * clear the session and display the homepage
     *
     * @Route("/accueil", name="accueil")
     * @return Response
     */
    public function index()
    {
        $this->get('session')->clear();

        return $this->render('base.html.twig', [
            'index' => true
        ]);
    }


    /*
     *
     * Page 2 - Initialisation de la visite - choix de la date / du type de billet / du nb de billets
     * @Route("/home", name="home")
     * @param Request $request
     * @param Booking $booking
     * @param CommandController $CommandController
     * @return RedirectResponse|Response


    public function form (Request $request, Booking $booking, CommandController $CommandController) {



        $booking= $CommandController->initVisit();

        $form= $this -> createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $CommandController->generateTickets($booking);

            return $this->redirectToRoute('reservation'); // si tout est ok retourne à la page "reservation"
        }

        return $this->render('home/home.html.twig', array('form'=>$form->createView()));
    }*/

}


