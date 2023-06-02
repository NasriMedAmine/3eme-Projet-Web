<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="noti")
 * @ORM\Entity(repositoryClass=NotificationRepository::class)
 */
class Notification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id",type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="player_name",type="string", length=255, nullable=true)
     */
    private $player_name;

    /**
     * @var string
     *@ORM\Column(name="team_name",type="string", length=255, nullable=true)
     */
    private $team_Name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getplayer_name(): ?string
    {
        return $this->player_name;
    }

    public function setplayer_name(string $player_name): self
    {
        $this->player_name = $player_name;

        return $this;
    }
    public function __toString() {
        return $this->player_name;
    }

    public function getteam_name(): ?string
    {
        return $this->team_Name;
    }

    public function setteam_name(string $team_Name): self
    {
        $this->team_Name = $team_Name;

        return $this;
    }
}
