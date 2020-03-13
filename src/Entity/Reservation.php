<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Constraints\AllValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 4,
     *      max = 150,
     *      minMessage = "Votre nom doit contenir au moins 4 caractères",
     *      maxMessage = "Votre nom doit contenir ne doit pas contenir plus de 150 caractères")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\Length(
     *      min = 4,
     *      max = 150,
     *      minMessage = "Votre nom doit contenir au moins 4 caractères",
     *      maxMessage = "Votre nom doit contenir ne doit pas contenir plus de 150 caractères")
     */
    private $prenom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billet", mappedBy="price", orphanRemoval=true)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billet", mappedBy="date_billet", orphanRemoval=true)
     * @ORM\Column(type="datetime")
     */
    private $date_reservation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Email(
     *     message = "Votre email n'est pas valide.")
     */
    private $code_reservation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billet", mappedBy="price", orphanRemoval=true)
     */
    private $reduction;


    public function __construct()
    {
        $this->price = new ArrayCollection();
        $this->date_reservation = new ArrayCollection();
        $this->reduction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection|Billet[]
     */
    public function getPrice(): Collection
    {
        return $this->price;
    }

    public function setPrice(string $price)
    {
        $this->price = $price;

        return $this;
    }

    public function addPrice(Billet $price): self
    {
        if (!$this->price->contains($price)) {
            $this->price[] = $price;
            $price->setPrice($this);
        }

        return $this;
    }

    public function removePrice(Billet $price): self
    {
        if ($this->price->contains($price)) {
            $this->price->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getPrice() === $this) {
                $price->setPrice(null);
            }
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDateReservation(): ArrayCollection
    {
        return $this->date_reservation;
    }

    public function setDate_Reservation (DateTimeInterface $date_reservation) :self
    {
        $this->date_reservation = $date_reservation;

        return $this;
    }


    public function addDateReservation(Billet $dateReservation): self
    {
        if (!$this->date_reservation->contains($dateReservation)) {
            $this->date_reservation[] = $dateReservation;
            $dateReservation->setDateBillet($this);
        }

        return $this;
    }

    public function removeDateReservation(Billet $dateReservation): self
    {
        if ($this->date_reservation->contains($dateReservation)) {
            $this->date_reservation->removeElement($dateReservation);
            // set the owning side to null (unless already changed)
            if ($dateReservation->getDateBillet() === $this) {
                $dateReservation->setDateBillet(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCodeReservation(): ?int
    {
        return $this->code_reservation;
    }


    public function setCode_reservation(int $code_reservation)
    {
        $this-> code_reservation = $code_reservation;

        return$this;
    }

    public function setCodeReservation(int $code_reservation): self
    {
        $this->code_reservation = $code_reservation;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection|Billet[]
     */
    public function getReduction(): Collection
    {
        return $this->reduction;
    }

    public function setReduction(string $reduction)
    {
        $this->reduction = $reduction;

        return $this;
    }

    public function addReduction(Billet $reduction): self
    {
        if (!$this->reduction->contains($reduction)) {
            $this->reduction[] = $reduction;
            $reduction->setPrice($this);
        }

        return $this;
    }

    public function removeReduction(Billet $reduction): self
    {
        if ($this->reduction->contains($reduction)) {
            $this->reduction->removeElement($reduction);
            // set the owning side to null (unless already changed)
            if ($reduction->getPrice() === $this) {
                $reduction->setPrice(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Billet[]
     */
    public function getBillets(): Collection
    {
        return $this->billets;
    }

    public function addBillet(Billet $billet): self
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setDateBillet($this);
        }

        return $this;
    }



}
