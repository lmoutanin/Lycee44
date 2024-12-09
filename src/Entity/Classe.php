<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(pattern: "/^[A-Z]{3}[1-2]$/", message: "3 lettres majuscules et un chiffre .")]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $niveau = null;

    #[ORM\Column]
    private ?int $effectif_actuel = null;

    #[ORM\Column]
    private ?int $effectif_max = null;

    /**
     * @var Collection<int, Etudiant>
     */
    #[ORM\OneToMany(targetEntity: Etudiant::class, mappedBy: 'classe')]
    private Collection $etudiants;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
    }

   





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



    public function __toString()
    {
        return $this->libelle;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): static
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants->add($etudiant);
            $etudiant->setClasse($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): static
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getClasse() === $this) {
                $etudiant->setClasse(null);
            }
        }

        return $this;
    }
 
 
}
