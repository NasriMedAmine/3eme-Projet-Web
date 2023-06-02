<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bracket
 *
 * @ORM\Table(name="bracket")
 * @ORM\Entity
 */
class Bracket
{
    /**
     * @var string
     *
     * @ORM\Column(name="Team_Name", type="string", length=20, nullable=false)
     */
    private $teamName;

    /**
     * @var string
     *
     * @ORM\Column(name="Team", type="string", length=50, nullable=false)
     */
    private $team;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \Chat
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Chat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Bracket", referencedColumnName="Id_Bracket")
     * })
     */
    private $id;

    public function getTeamName(): ?string
    {
        return $this->teamName;
    }

    public function setTeamName(string $teamName): self
    {
        $this->teamName = $teamName;

        return $this;
    }

    public function getTeam(): ?string
    {
        return $this->team;
    }

    public function setTeam(string $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdBracket(): ?Chat
    {
        return $this->id;
    }

    public function setIdBracket(?Chat $idBracket): self
    {
        $this->id = $idBracket;

        return $this;
    }


}
