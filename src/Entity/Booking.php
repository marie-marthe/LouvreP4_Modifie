<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{


    const FULL_DAY_PRICE = 16;
    const FULL_DAY_DISCOUNT = 10;
    const FULL_DAY_SENIOR = 12;
    const FULL_DAY_CHILD = 8;
    const FREE_TICKET = 0;

    const HALF_DAY_PRICE = 8;
    const HALF_DAY_DISCOUNT = 5;
    const HALF_DAY_SENIOR = 6;
    const HALF_DAY_CHILD = 4;

    const MIN_AGE_CHILD = 4;
    const MAX_AGE_CHILD = 12;
    const MIN_AGE_SENIOR = 60;


    const IS_VALID_INIT = [];
    const IS_VALID_WITH_TICKET = [];
    const IS_VALID_WITH_CUSTOMER = [];
    const IS_VALID_WITH_BOOKINGCODE = [];

    const TYPE_HALF_DAY = 0;
    const TYPE_FULL_DAY = 1;
    const NB_TICKET_MAX_DAY = 1000;

    const LIMITED_HOUR_TODAY = 16;

    /*
     * Exemples
     * Comment mieux nommer les constantes
     *
    const AGE_CHILD = 4;
    const AGE_ADULT = 12;
    const AGE_SENIOR = 60;

    const PRICE_ADULT = 16;
    const PRICE_DISCOUNT = 10;
    const PRICE_SENIOR = 12;
    const PRICE_CHILD = 8;
    const PRICE_FREE = 0;

    const PRICE_HALF_DAY_COEFF = 0.5;
    */

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="date")
     */
    private $dateVisite;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateReservation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $demijournee;


    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $total;

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $nbTicket;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="booking", orphanRemoval=true)
     */
    private $clients;


    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->dateVisite;
    }

    public function setDateVisite(\DateTimeInterface $dateVisite): self
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getDemijournee(): ?bool
    {
        return $this->demijournee;
    }

    public function setDemijournee(bool $demijournee): self
    {
        $this->demijournee = $demijournee;

        return $this;
    }


    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getNbTicket(): ?int
    {
        return $this->nbTicket;
    }

    public function setNbTicket(int $nbTicket): self
    {
        $this->nbTicket = $nbTicket;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setBooking($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getBooking() === $this) {
                $client->setBooking(null);
            }
        }

        return $this;
    }


}
