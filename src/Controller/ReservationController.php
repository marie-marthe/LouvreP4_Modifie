<?php


namespace App\Controller;




use App\Entity\Client;
use App\Form\ClientsType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CommandType;




class ReservationController extends AbstractController
{


    /**
     * @Route("/reservation", name="reservation")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws Exception
     */

    public function form( Request $request ) {

        $client = new Client();


        $form= $this -> createForm(ClientsType::class, $client);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            dump($client);

            //return $this->redirectToRoute('home'); // si tout est ok retourne à la page "home"
        }

        return $this->render('home/create.html.twig',[
            'form'=>$form->createView()

        ]);
    }



    // pour les afficher sur la page payment.html.twig

    /**
     * @Route("/payment", name="payment")
     */
    public function payment()
    {

        return $this->render('reservation/payment.html.twig');
    }

    // pour les afficher sur la page payment.html.twig

    /**
     * @Route("/form", name="form")
     */
    public function ticket()
    {

        return $this->render('order/showOpeningHours.html.twig');
    }



}
