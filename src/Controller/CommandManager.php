<?php

namespace App\Controller;


use App\Entity\Client;
use App\Entity\Booking;
use App\Services\PublicHolidaysService;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\throwException;


/**
 * Class CommandController
 * @package App\Controller
 *
 */

class CommandManager
{

    const SESSION_ID_CURRENT_VISIT = "booking";

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

    /**
     * Page 2 - Order
     * Initialisation de la visite et de la session
     * Création de l'objet Visit
     * @return Booking
     * @throws \Exception
     */
    public function initVisit()
    {
        $booking = new Booking();
        $this->whichVisitDay($booking);
        $this->session->set(self::SESSION_ID_CURRENT_VISIT,$booking);

        return $booking;
    }


    /**
     *
     * Retourne la visite en cours dans la session
     * $validateBy sert à appeler la constante de classe visit
     * @return Booking|mixed
     */
    public function getCurrentVisit()
    {
        return $this->session->get(self::SESSION_ID_CURRENT_VISIT);
    }



    /**
     * Page 2 - Order
     * Retourne le nombre de tickets en fonction du $nbticket demandé
     * @param Booking $booking
     * @return booking
     */

    public function generateTickets(Booking $booking)
    {
        for($i= 1; $i<=$booking->getNbTicket(); $i++)
        {
            $booking->addClient(new Client());
        }

        return $booking;
    }

    /**
     * Page 2 - Order
     * Affichage dans le datepicker sur la page Order
     * @param Booking $booking
     * @return \DateTime
     * @throws \Exception
     */
    public function whichVisitDay( Booking $booking)
    {
        date_default_timezone_set('Europe/Paris');
        $hour = date("H");
        $today = date("w");
        $tomorrow = date('w', strtotime('+1 day'));
        $publicHolidays = $this->publicHolidaysService->getPublicHolidaysOnTheseTwoYears();


        if($hour > Booking::LIMITED_HOUR_TODAY || $today == 0 || $today == 2 || $today == $publicHolidays) {
            $visitDate = (new \DateTime())->modify('+ 1 days');

            if($tomorrow  == 0 || $tomorrow == 2 || $tomorrow == $publicHolidays) {
                $visitDate = (new \DateTime())->modify('+ 2 days');
            }
        }
        else {
            $visitDate = (new \DateTime());
        }

        $booking->setDateVisite($visitDate);
        return $visitDate;
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
        $booking = $client->getBooking();
        $today = new \DateTime();
        $age = date_diff($birthday, $today)->y;

        $discount = $client->getReduc();

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


        if ($booking->getDemijournee() == Client::TYPE_FULL_DAY)
        {
            if ($age >= Booking::MAX_AGE_CHILD && $age < Booking::MIN_AGE_SENIOR) {
                $prices = Booking::FULL_DAY_PRICE;

                if ($age >= Booking::MAX_AGE_CHILD && $age < Booking::MIN_AGE_SENIOR && $discount == true){
                    $prices = Booking::FULL_DAY_DISCOUNT;
                }

            } elseif ($age >= Booking::MIN_AGE_SENIOR) {
                $prices = Booking::FULL_DAY_SENIOR;
            } elseif ($age >= Booking::MIN_AGE_CHILD && $age < Booking::MAX_AGE_CHILD) {
                $prices = Booking::FULL_DAY_CHILD;
            } else {
                $prices = Booking::FREE_TICKET;
            }
        }

        elseif ($booking->getDemijournee() == Client::TYPE_HALF_DAY)
        {
            if ($age >= Booking::MAX_AGE_CHILD && $age < Booking::MIN_AGE_SENIOR) {
                $prices = Booking::HALF_DAY_PRICE;

                if ($age >= Booking::MAX_AGE_CHILD && $age < Booking::MIN_AGE_SENIOR && $discount == true){
                    $prices = Booking::HALF_DAY_DISCOUNT;
                }

            } elseif ($age >= Booking::MIN_AGE_SENIOR) {
                $prices = Booking::HALF_DAY_SENIOR;
            } elseif ($age >= Booking::MIN_AGE_CHILD && $age < Booking::MAX_AGE_CHILD) {
                $prices = Booking::HALF_DAY_CHILD;
            } else {
                $prices = Booking::FREE_TICKET;
            }
        }

        $client->setPrices($prices);
        return $prices;
    }



    /**
     * Page 3 - Identification
     * Calcule le prix total de la visite
     * @param Booking $booking
     * @return int
     */
    public function computerPrice(Booking $booking)
    {
        $total = 0;

        foreach ($booking->getClients() as $client) {
            $pricesClient = $this->computerPrice($client);
            $total += $pricesClient;
        }

        $booking->setTotal($total);
        return $total;

    }


}