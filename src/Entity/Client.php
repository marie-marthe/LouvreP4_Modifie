<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{

    const TYPE_HALF_DAY = 0;
    const TYPE_FULL_DAY = 1;
    const NB_TICKET_MAX_DAY = 1000;

    const LIMITED_HOUR_TODAY = 16;



    const IS_VALID_INIT = [];
    const IS_VALID_WITH_TICKET = [];
    const IS_VALID_WITH_CUSTOMER = [];
    const IS_VALID_WITH_BOOKINGCODE = [];


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastName;

    /**
     * @ORM\Column(name="birthday", type="date")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $country;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reduc;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $prices;
    

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Command", inversedBy="id_command")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $idcommand;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getReduc(): ?bool
    {
        return $this->reduc;
    }

    public function setReduc(bool $reduc): self
    {
        $this->reduc = $reduc;

        return $this;
    }

    public function getPrices(): ?string
    {
        return $this->prices;
    }

    public function setPrices(string $prices): self
    {
        $this->prices = $prices;

        return $this;
    }
    

    public function getIdCommand(): ?Command
    {
        return $this->idcommand;
    }

    public function setIdCommand(?Command $idcommand): string
    {
        $this->idcommand = $idcommand;

        return $this;
    }

}
