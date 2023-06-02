<?php

namespace App\Entity;

use App\Repository\InTournamentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InTournamentRepository::class)
 */
class InTournament
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
    private $idUser;

    /**
     * @ORM\Column(type="integer")
     */
    private $idTournament;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdTournament(): ?int
    {
        return $this->idTournament;
    }

    public function setIdTournament(int $idTournament): self
    {
        $this->idTournament = $idTournament;

        return $this;
    }
}
