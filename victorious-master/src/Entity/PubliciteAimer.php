<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PubliciteAimer
 *
 * @ORM\Table(name="publicite_aimer", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_publicite", columns={"id_publicite"})})
 * @ORM\Entity(repositoryClass="App\Repository\PubliciteAimerRepository")
 */
class PubliciteAimer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pub_aimer", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \Publicite
     *
     * @ORM\ManyToOne(targetEntity="Publicite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_publicite", referencedColumnName="id_publicite")
     * })
     */
    private $idPublicite;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="Id")
     * })
     */
    private $idUser;

    public function getIdPubAimer(): ?int
    {
        return $this->id;
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

    public function getIdPublicite(): ?Publicite
    {
        return $this->idPublicite;
    }

    public function setIdPublicite(?Publicite $idPublicite): self
    {
        $this->idPublicite = $idPublicite;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


}
