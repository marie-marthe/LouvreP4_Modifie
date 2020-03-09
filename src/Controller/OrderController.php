<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Ticket;
use App\Services\CalculatePrice;
use App\Services\AuthorizedDate;
use App\Services\Stripe;
use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Ramsey\Uuid\Uuid;

class OrderController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('order/home.html.twig', [
            'title' => 'OrderController',
        ]);
    }

    /**
     * @Route("/horaires", name="horaires")
     * @param AuthorizedDate $authorizedDate
     * @return Response
     */
    public function showOpeningHours(AuthorizedDate $authorizedDate){
        return $this->render('order/showOpeningHours.html.twig', [
            'title'     => 'Ouverture',
            'ouverture' => $authorizedDate->openingHour,
            'fermeture' => $authorizedDate->closingHour
        ]);
    }

    /**
     * @Route("/tarifs", name="tarifs")
     * @param CalculatePrice $calculatePrice
     * @return Response
     */
    public function showPrice(CalculatePrice $calculatePrice){
        return $this->render('order/showPrice.html.twig', [
            'title' => 'Tarifs',
            'fullPriceChild'     => $calculatePrice->fullPriceChild,
            'halfPriceChild'     => $calculatePrice->halfPriceChild,
            'fullPriceNormal'    => $calculatePrice->fullPriceNormal,
            'halfPriceNormal'    => $calculatePrice->halfPriceNormal,
            'fullPriceSenior'    => $calculatePrice->fullPriceSenior,
            'halfPriceSenior'    => $calculatePrice->halfPriceSenior,
            'fullPriceReduction' => $calculatePrice->fullPriceReduction,
            'halfPriceReduction' => $calculatePrice->halfPriceReduction
        ]);
    }

    /**
     * @Route("/billeterie", name="billeterie")
     * @param Request $request
     * @param SessionInterface $session
     * @param $task
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function order(Request $request, SessionInterface $session, $task)
    {
        $order = new Order();

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        $this->uuid = Uuid::uuid4();
    
        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            $order = $session->get('uuid');
            $session->set('uuid', $order);
            
            return $this->redirectToRoute('visitors_designation');
        }
    
        return $this->render('order/orderForm.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/commande", name="commande")
     * @param Request $request
     * @param SessionInterface $session
     * @param $task
     * @return RedirectResponse|Response
     */
    public function visitorsDesignation(Request $request, SessionInterface $session, $task){
               
        $ticket = new Ticket();
        
        if($session->get('uuid')){
            $ticket = $session->get('uuid');
        }

        $form = $this->create(TicketType::class, $ticket);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $ticket = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

           // $ticket = $session->get('ticket', []);
            $session->set('uuid', $ticket);
            
            return $this->redirectToRoute('identification');
        }
    
        return $this->render('order/ticketForm.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("identification", name="identification")
     * @param Request $request
     * @param SessionInterface $session
     */
    public function userDesignation(Request $request, SessionInterface $session){

    }
}
