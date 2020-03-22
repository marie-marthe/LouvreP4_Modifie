<?php

namespace App\Controller;


use App\Entity\Client;
use App\Entity\Command;
use App\Form\ClientsType;
use App\Form\CommandType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;

class HomeController extends AbstractController

{

    /**
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


    /**
     * recieve the mail with POST (from form in home), and redirect to reservation if the mail is unknown, or propose menu that propose to check existing reservations made with the email, or make a new reservation with that email. If the visitor want to change the mail, he can do so using the navbar.
     *
     * @Route("/home", name="home")
     * @param $request
     * @return RedirectResponse|Response
     */

    public function form ( Request $request ) {

        $command = new Command();


        $forms= $this -> createForm(CommandType::class, $command);

        $forms->handleRequest($request);

        if($forms->isSubmitted() && $forms->isValid()) {

            return $this->redirectToRoute('reservation'); // si tout est ok retourne à la page "reservation"
        }

        return $this->render('home/home.html.twig',[
            'form'=>$forms->createView()

        ]);
    }

}


