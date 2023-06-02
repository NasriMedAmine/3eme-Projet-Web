<?php

namespace App\Entity;

use App\Repository\WinnerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WinnerRepository::class)
 */
class Winner
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nameTournament;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nameWinner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTournament(): ?string
    {
        return $this->nameTournament;
    }

    public function setNameTournament(?string $nameTournament): self
    {
        $this->nameTournament = $nameTournament;

        return $this;
    }

    public function getNameWinner(): ?string
    {
        return $this->nameWinner;
    }

    public function setNameWinner(?string $nameWinner): self
    {
        $this->nameWinner = $nameWinner;

        return $this;
    }
}
