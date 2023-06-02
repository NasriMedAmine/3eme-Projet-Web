<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chat
 *
 * @ORM\Table(name="chat", indexes={@ORM\Index(name="Id_Bracket", columns={"Id_Bracket"})})
 * @ORM\Entity
 */
class Chat
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Chat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Message", type="string", length=50, nullable=false)
     */
    private $message;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_Bracket", type="integer", nullable=false)
     */
    private $idBracket;

    public function getIdChat(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getIdBracket(): ?int
    {
        return $this->idBracket;
    }

    public function setIdBracket(int $idBracket): self
    {
        $this->idBracket = $idBracket;

        return $this;
    }


}
