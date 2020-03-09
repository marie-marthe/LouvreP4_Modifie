<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $visitDate;

    /**
     * @ORM\Column(type="decimal", precision=2, scale=1)
     */
    private $visitDuration;

    /**
     * @ORM\Column(type="integer")
     */
    private $ticketsNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisitDate(): ?\DateTimeInterface
    {
        return $this->visitDate;
    }

    public function setVisitDate(\DateTimeInterface $visitDate): self
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    public function getVisitDuration(): ?string
    {
        return $this->visitDuration;
    }

    public function setVisitDuration(string $visitDuration): self
    {
        $this->visitDuration = $visitDuration;

        return $this;
    }

    public function getTicketsNumber(): ?int
    {
        return $this->ticketsNumber;
    }

    public function setTicketsNumber(int $ticketsNumber): self
    {
        $this->ticketsNumber = $ticketsNumber;

        return $this;
    }
}
