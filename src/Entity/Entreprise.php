<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "Le nom de l'entreprise doit faire au moins {{ limit }} caractères.")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     */
    private $activite;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(pattern = "#^[1-9][0-9]{0,2}( ?bis)? #", message = "Le numéro de rue semble incorrect")
     * @Assert\Regex(pattern = "#boulevard|rue|impasse|allée|place|route|voie#", message = "Le type de route/voie semble incorrect")
     * @Assert\Regex(pattern = "# [0-9]{5} #", message = "Il semble y avoir un problème avec le code postal.")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Url
     */
    private $URLsite;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="entreprise")
     */
    private $stages;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getURLsite(): ?string
    {
        return $this->URLsite;
    }

    public function setURLsite(string $URLsite): self
    {
        $this->URLsite = $URLsite;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }
}
