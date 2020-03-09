<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstNameVisitor;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastNameVisitor;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdayVisitor;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reduction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstNameVisitor(): ?string
    {
        return $this->firstNameVisitor;
    }

    public function setFirstNameVisitor(string $firstNameVisitor): self
    {
        $this->firstNameVisitor = $firstNameVisitor;

        return $this;
    }

    public function getLastNameVisitor(): ?string
    {
        return $this->lastNameVisitor;
    }

    public function setLastNameVisitor(string $lastNameVisitor): self
    {
        $this->lastNameVisitor = $lastNameVisitor;

        return $this;
    }

    public function getBirthdayVisitor(): ?\DateTimeInterface
    {
        return $this->birthdayVisitor;
    }

    public function setBirthdayVisitor(\DateTimeInterface $birthdayVisitor): self
    {
        $this->birthdayVisitor = $birthdayVisitor;

        return $this;
    }

    public function getReduction(): ?bool
    {
        return $this->reduction;
    }

    public function setReduction(bool $reduction): self
    {
        $this->reduction = $reduction;

        return $this;
    }
}
