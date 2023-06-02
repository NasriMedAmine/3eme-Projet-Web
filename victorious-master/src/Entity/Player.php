<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Player
 *
 * @ORM\Table(name="player")
 * @ORM\Entity
 */
class Player implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Player", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="Level", type="integer", nullable=false)
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="Pseudo", type="string", length=30, nullable=false)
     */
    private $pseudo;

    /**
     * @var string
     *@ORM\ManyToMany(targetEntity="Team", mappedBy="players")
     * @ORM\Column(name="Teams", type="string", length=50, nullable=false)
     */
    private $teams;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=30, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="Mail", type="string", length=30, nullable=false)
     */
    private $mail;

    public function getIdPlayer(): ?int
    {
        return $this->id;
    }
    public function getid(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getTeams(): ?string
    {
        return $this->teams;
    }

    public function setTeams(string $teams): self
    {
        $this->teams = $teams;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }
    public function jsonSerialize(): array
    {
        return  array(
            'id' => $this->id,
            'pseudo' => $this->pseudo,
            'mail' => $this->mail,



        );
    }

}