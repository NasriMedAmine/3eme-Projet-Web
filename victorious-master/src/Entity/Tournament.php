<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Exception;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use JetBrains\PhpStorm\Internal\TentativeType;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Tournament
 *
 * @ORM\Table(name="tournament")
 * @ORM\Entity
 */
class Tournament implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Tournament", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")

     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Tournament_Name", type="string", length=20, nullable=false)
     * @Groups ("Tournamentlist")
     */
    private $tournamentName;

    /**
     * @var string
     *
     * @ORM\Column(name="Managers", type="string", length=50, nullable=false)
     * @Groups ("Tournamentlist")
     */
    private $managers;

    /**
     * @var string
     *
     * @ORM\Column(name="Team", type="string", length=50, nullable=false)
     * @Groups ("Tournamentlist")
     */
    private $team;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ("Tournamentlist")
     */
    private $code;

    /**
     * @ORM\Column(name="name_Game",type="string", length=255)
     * @Groups ("Tournamentlist")
     */
    private $nameGame;

    /**
     * @ORM\Column(name="type",type="string", length=255)
     * @Groups ("Tournamentlist")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups ("Tournamentlist")
     */
    private $Winner;

    public function getIdTournament(): ?int
    {
        return $this->id;
    }

    public function getTournamentName(): ?string
    {
        return $this->tournamentName;
    }

    public function setTournamentName(string $tournamentName): self
    {
        $this->tournamentName = $tournamentName;

        return $this;
    }

    public function getManagers(): ?string
    {
        return $this->managers;
    }

    public function setManagers(string $managers): self
    {
        $this->managers = $managers;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNameGame(): ?string
    {
        return $this->nameGame;
    }

    public function setNameGame(string $nameGame): self
    {
        $this->nameGame = $nameGame;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getWinner(): ?string
    {
        return $this->Winner;
    }

    public function setWinner(?string $Winner): self
    {
        $this->Winner = $Winner;

        return $this;
    }


//    public function serialize()
//    {
//        return  array(
//            'id' => $this->id,
//            'tournamentName' => $this->tournamentName,
//            'managers' => $this->managers,
//            'code' => $this->code,
//            'type' => $this->type,
//            'team' => $this->team,
//            'Winner' => $this->Winner,
//            'nameGame' => $this->nameGame,
//        );
//    }
//
//    public function unserialize($data)
//    {
//        // TODO: Implement unserialize() method.
//    }

    public function jsonSerialize(): mixed
    {
        return  array(
            'id' => $this->id,
            'tournamentName' => $this->tournamentName,
            'managers' => $this->managers,
            'code' => $this->code,
            'type' => $this->type,
            'team' => $this->team,
            'Winner' => $this->Winner,
            'nameGame' => $this->nameGame,
        );
    }
}
