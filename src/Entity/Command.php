<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandRepository")
 */
class Command
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
     */
    private $nbTicket;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="idcommand")
     *
     */
    private $id_command;



    public function __construct()
    {
        $this->id_command = new ArrayCollection();
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
    public function getIdCommand(): Collection
    {
        return $this->id_command;
    }

    public function addIdCommand(Client $idCommand): Command
    {
        if (!$this->id_command->contains($idCommand)) {
            $this->id_command[] = $idCommand;
            $idCommand->setIdcommand($this);
        }

        return $this;
    }

    public function removeIdCommand(Client $idCommand): self
    {
        if ($this->id_command->contains($idCommand)) {
            $this->id_command->removeElement($idCommand);
            // set the owning side to null (unless already changed)
            if ($idCommand->getIdcommand() === $this) {
                $idCommand->setIdcommand(null);
            }
        }

        return $this;
    }
}
