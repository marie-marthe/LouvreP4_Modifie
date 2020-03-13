<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BilletRepository")
 */
class Billet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservation", inversedBy="reduction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $reduction;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservation", inversedBy="date_reservation")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="datetime")
     */
    private $date_billet;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?Reservation
    {
        return $this->price;
    }

    public function setPrice(?Reservation $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getReduction(): ?int
    {
        return $this->reduction;
    }

    public function setReduction(int $reduction): self
    {
        $this->reduction = $reduction;

        return $this;
    }

    public function getDateBillet(): ?Reservation
    {
        return $this->date_billet;
    }

    public function setDateBillet(?Reservation $date_billet): self
    {
        $this->date_billet = $date_billet;

        return $this;
    }
}
