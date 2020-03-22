<?php

namespace App\Controller;


use App\Entity\Client;
use App\Entity\Command;
use App\Services\PublicHolidaysService;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class CommandController
 * @package App\Controller
 *
 */

class CommandController extends AbstractController
{
    /**
     * @var SessionInterface
     * @param SessionInterface $session
     * @param PublicHolidaysService $publicHolidaysService
     * @param ValidatorInterface $validator
     */

    private $session;
    private $publicHolidaysService;
    private $validator;


    public function __construct(SessionInterface $session, PublicHolidaysService $publicHolidaysService, ValidatorInterface $validator)
    {
        $this->session = $session;
        $this->publicHolidaysService = $publicHolidaysService;
        $this->validator = $validator;
    }


    // Page 2 - Order
    // Retourne le nombre de tickets en fonction du $nbticket demandé

    /**
     * @param Command $command
     * @return Command
     */

    public function generateTickets(Command $command)
    {
        for($i= 1; $i<=$command->getNbTicket(); $i++)
        {
            $command->addIdCommand(new Command());
        }

        return $command;
    }

    // Page 3 - Identification des visiteurs
    // Calcule le prix de chaque billet en fonction de l'âge et du type de billet

    /**
     * @param Client $client
     * @return int
     * @throws \Exception
     */
    public function computerTicketPrice(Client $client)
    {
        $birthday = $client->getBirthday();
        $command = $client->getIdCommand();
        $today = new \DateTime();
        $age = date_diff($birthday, $today)->y;

        $discount = $command->getReduc();

        /*
         * Exemple
         * Comment mieux trouver le bon prix en fonction de l'âge
         *
         *
         *
        //Trouver le bon tarif
        if($age < Ticket::AGE_CHILD){ // Bébé
            $price = Ticket::PRICE_FREE;

        }elseif($age < Ticket::AGE_ADULT){ //Enfant
            $price = Ticket::PRICE_CHILD;
        }elseif ($age < Ticket::AGE_SENIOR){ // Adulte/Normal
            $price = Ticket::PRICE_ADULT;
        }else{ // Senior
            $price = Ticket::PRICE_SENIOR;
        }

        // Verifier reduction
        if($ticket->getDiscount() === true && $price > Ticket::PRICE_DISCOUNT ){
            $price = Ticket::PRICE_DISCOUNT;
        }

        //Appliquer coeff journée/demi journée
        if($ticket->getVisit()->getType() === Visit::TYPE_HALF_DAY){
            $price = $price * Ticket::HALF_DAY_COEFF;
        }

        */


        if ($command->getDemijournee() == Client::TYPE_FULL_DAY)
        {
            if ($age >= Command::MAX_AGE_CHILD && $age < Command::MIN_AGE_SENIOR) {
                $prices = Command::FULL_DAY_PRICE;

                if ($age >= Command::MAX_AGE_CHILD && $age < Command::MIN_AGE_SENIOR && $discount == true){
                    $prices = Command::FULL_DAY_DISCOUNT;
                }

            } elseif ($age >= Command::MIN_AGE_SENIOR) {
                $prices = Command::FULL_DAY_SENIOR;
            } elseif ($age >= Command::MIN_AGE_CHILD && $age < Command::MAX_AGE_CHILD) {
                $prices = Command::FULL_DAY_CHILD;
            } else {
                $prices = Command::FREE_TICKET;
            }
        }

        elseif ($command->getDemijournee() == Client::TYPE_HALF_DAY)
        {
            if ($age >= Command::MAX_AGE_CHILD && $age < Command::MIN_AGE_SENIOR) {
                $prices = Command::HALF_DAY_PRICE;

                if ($age >= Command::MAX_AGE_CHILD && $age < Command::MIN_AGE_SENIOR && $discount == true){
                    $prices = Command::HALF_DAY_DISCOUNT;
                }

            } elseif ($age >= Command::MIN_AGE_SENIOR) {
                $prices = Command::HALF_DAY_SENIOR;
            } elseif ($age >= Command::MIN_AGE_CHILD && $age < Command::MAX_AGE_CHILD) {
                $prices = Command::HALF_DAY_CHILD;
            } else {
                $prices = Command::FREE_TICKET;
            }
        }

        $client->setPrices($prices);
        return $prices;
    }


    //Page 3 - Identification
    // Calcule le prix total de la visite
    /**
     * @param Command $command
     * @return int
     */
    public function computerPrice(Command $command)
    {
        $total = 0;

        foreach ($command->getIdCommand() as $client) {
            $priceClient = $this->computerPrice($client);
            $total += $priceClient;
        }

        $command->setTotal($total);
        return $total;

    }


}