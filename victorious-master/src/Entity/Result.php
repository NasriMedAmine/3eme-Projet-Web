<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Result
 *
 * @ORM\Table(name="result")
 * @ORM\Entity
 */
class Result
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Result", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Win_Teams", type="string", length=50, nullable=false)
     */
    private $winTeams;

    /**
     * @var string
     *
     * @ORM\Column(name="Lose_Teams", type="string", length=50, nullable=false)
     */
    private $loseTeams;

    public function getIdResult(): ?int
    {
        return $this->id;
    }

    public function getWinTeams(): ?string
    {
        return $this->winTeams;
    }

    public function setWinTeams(string $winTeams): self
    {
        $this->winTeams = $winTeams;

        return $this;
    }

    public function getLoseTeams(): ?string
    {
        return $this->loseTeams;
    }

    public function setLoseTeams(string $loseTeams): self
    {
        $this->loseTeams = $loseTeams;

        return $this;
    }


}
