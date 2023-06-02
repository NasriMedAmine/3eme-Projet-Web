<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MessageReclam
 *
 * @ORM\Table(name="message_reclam")
 * @ORM\Entity
 */
class MessageReclam
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_reclam", type="integer", nullable=false)
     */
    private $idReclam;

    /**
     * @var int
     *
     * @ORM\Column(name="id_send", type="integer", nullable=false)
     */
    private $idSend;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", length=65535, nullable=false)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date = 'CURRENT_TIMESTAMP';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdReclam(): ?int
    {
        return $this->idReclam;
    }

    public function setIdReclam(int $idReclam): self
    {
        $this->idReclam = $idReclam;

        return $this;
    }

    public function getIdSend(): ?int
    {
        return $this->idSend;
    }

    public function setIdSend(int $idSend): self
    {
        $this->idSend = $idSend;

        return $this;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }


}
