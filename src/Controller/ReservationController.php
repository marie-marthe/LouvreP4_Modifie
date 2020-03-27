<?php


namespace App\Controller;




use App\Entity\Booking;
use App\Entity\Client;
use App\Form\ClientsType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\BookingType;




class ReservationController extends AbstractController
{


    /**
     * @Route("/reservation", name="reservation")
     * @param Request $request
     * @param CommandManager $commandManager
     * @return RedirectResponse|Response
     */

    public function client (Request $request, CommandManager $commandManager) {


        $clients = $commandManager->getCurrentVisit();

        $client= $this -> createForm(ClientsType::class, $clients);

        $client->handleRequest($request);

        if($client->isSubmitted() && $client->isValid()) {

            $commandManager->computerPrice($clients);

            return $this->redirectToRoute('home'); // si tout est ok retourne à la page "home"
        }

        return $this->render('home/create.html.twig',array('form'=>$client->createView(), 'client' => $client)

        );
    }


    /**
     * @Route("/form", name="form")
     * @param Request $request
     * @param CommandManager $commandManager
     * @return Response
     * @throws Exception
     */
    public function ticket (Request $request, CommandManager $commandManager)
    {

        $booking = $commandManager->initVisit();

        $ticket= $this -> createForm(BookingType::class, $booking);

        $ticket->handleRequest($request);

        if($ticket->isSubmitted() && $ticket->isValid()) {

            $commandManager->generateTickets($booking);

            return $this->redirectToRoute('reservation'); // si tout est ok retourne à la page "home"
        }


        return $this->render('order/orderForm.html.twig',array('ticket'=>$ticket->createView(), 'booking' => $booking)

        );
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


}
