<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResTournament
 *
 * @ORM\Table(name="res_tournament", indexes={@ORM\Index(name="pk_Id_User", columns={"Id_User"})})
 * @ORM\Entity
 */
class ResTournament
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Res", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Pseudo", type="string", length=30, nullable=false)
     */
    private $pseudo;

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



    /**
     * @var int
     *
     * @ORM\Column(name="Id_User", type="integer")
     */
    private $idUser;

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }
 

    public function getIdRes(): ?int
    {
        return $this->id;
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

 


}
