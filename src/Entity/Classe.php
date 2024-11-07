<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $niveau = null;

    #[ORM\Column]
    private ?int $effectif_actuel = null;

    #[ORM\Column]
    private ?int $effectif_max = null;

    #[ORM\OneToOne(mappedBy: 'classe', cascade: ['persist', 'remove'])]
    private ?Etudiant $etudiant = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getEffectifActuel(): ?int
    {
        return $this->effectif_actuel;
    }

    public function setEffectifActuel(int $effectif_actuel): static
    {
        $this->effectif_actuel = $effectif_actuel;

        return $this;
    }

    public function getEffectifMax(): ?int
    {
        return $this->effectif_max;
    }

    public function setEffectifMax(int $effectif_max): static
    {
        $this->effectif_max = $effectif_max;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(Etudiant $etudiant): static
    {
        // set the owning side of the relation if necessary
        if ($etudiant->getClasse() !== $this) {
            $etudiant->setClasse($this);
        }

        $this->etudiant = $etudiant;

        return $this;
    }
}
