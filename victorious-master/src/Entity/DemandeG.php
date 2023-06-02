<?php

namespace App\Entity;

use App\Repository\DemandeGRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeGRepository::class)
 */
class DemandeG
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idDemandeG;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idUser;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomSociete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseSociete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codeTVA;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeDemandeur;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $valide;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdDemandeG(): ?int
    {
        return $this->idDemandeG;
    }

    public function setIdDemandeG(int $idDemandeG): self
    {
        $this->idDemandeG = $idDemandeG;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(?int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getNomSociete(): ?string
    {
        return $this->nomSociete;
    }

    public function setNomSociete(?string $nomSociete): self
    {
        $this->nomSociete = $nomSociete;

        return $this;
    }

    public function getAdresseSociete(): ?string
    {
        return $this->adresseSociete;
    }

    public function setAdresseSociete(?string $adresseSociete): self
    {
        $this->adresseSociete = $adresseSociete;

        return $this;
    }

    public function getCodeTVA(): ?string
    {
        return $this->codeTVA;
    }

    public function setCodeTVA(?string $codeTVA): self
    {
        $this->codeTVA = $codeTVA;

        return $this;
    }

    public function getTypeDemandeur(): ?string
    {
        return $this->typeDemandeur;
    }

    public function setTypeDemandeur(?string $typeDemandeur): self
    {
        $this->typeDemandeur = $typeDemandeur;

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(?bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }
}
