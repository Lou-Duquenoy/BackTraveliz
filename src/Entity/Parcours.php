<?php

namespace App\Entity;

use App\Repository\ParcoursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParcoursRepository::class)]
class Parcours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: "parcours")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    #[ORM\Column(length: 255)]
    private ?string $destination = null;

    #[ORM\Column(length: 255)]
    private ?string $origin = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gareDepart = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gareArrivee = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $aeroportDepart = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $aeroportArrivee = null;

    #[ORM\Column(length: 255)]
    private ?string $checkinTime = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dateDepart = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dateArrivee = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dateRetour = null;

    #[ORM\Column(length: 255)]
    private ?string $terminal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $longitude = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getGareDepart(): ?string
    {
        return $this->gareDepart;
    }

    public function setGareDepart(string $gareDepart): self
    {
        $this->gareDepart = $gareDepart;

        return $this;
    }

    public function getGareArrivee(): ?string
    {
        return $this->gareArrivee;
    }

    public function setGareArrivee(string $gareArrivee): self
    {
        $this->gareArrivee = $gareArrivee;

        return $this;
    }

    public function getAeroportDepart(): ?string
    {
        return $this->aeroportDepart;
    }

    public function setAeroportDepart(string $aeroportDepart): self
    {
        $this->aeroportDepart = $aeroportDepart;

        return $this;
    }

    public function getAeroportArrivee(): ?string
    {
        return $this->aeroportArrivee;
    }

    public function setAeroportArrivee(string $aeroportArrivee): self
    {
        $this->aeroportArrivee = $aeroportArrivee;

        return $this;
    }

    public function getDateDepart(): ?string
    {
        return $this->dateDepart;
    }

    public function setDateDepart(string $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }
    public function getDateArrivee(): ?string
    {
        return $this->dateArrivee;
    }

    public function setDateArrivee(string $dateArrivee): self
    {
        $this->dateArrivee = $dateArrivee;

        return $this;
    }
    public function getDateRetour(): ?string
    {
        return $this->dateRetour;
    }

    public function setDateRetour(string $dateRetour): self
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    public function getTerminal(): ?string
    {
        return $this->terminal;
    }

    public function setTerminal(string $terminal): self
    {
        $this->terminal = $terminal;

        return $this;
    }

    public function getCheckinTime(): ?string
    {
        return $this->checkinTime;
    }

    public function setCheckinTime(string $checkinTime): self
    {
        $this->checkinTime = $checkinTime;

        return $this;
    }
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

}
