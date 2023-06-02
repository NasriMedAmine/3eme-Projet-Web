<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity
 * @Vich\Uploadable
 */
 class Team implements \JsonSerializable
         {
             /**
              * @var int
              *
              * @ORM\Column(name="Id_Team", type="integer", nullable=false)
              * @ORM\Id
              * @ORM\GeneratedValue(strategy="IDENTITY")
              */
             private $id;
         
             /**
              * @var string
              *
              * @Assert\NotBlank
              * @ORM\Column(name="Team_Name", type="string", length=20, nullable=false)
              */
             private $teamName;
         
             /**
              * @var int
              * @Assert\NotBlank
              * @ORM\Column(name="Nb_Players", type="integer", nullable=false)
              */
             private $nbPlayers;
         
              
         
             /**
              * @var string
              *@ORM\ManyToMany(targetEntity="Player", inversedBy="teams")
              * @ORM\Column(name="Players", type="string", length=50, nullable=false)
              */
             private $players;
         
             /**
              * @var string
              *
              * @ORM\Column(name="Favorite_Games", type="string", length=100, nullable=false)
              */
             private $favoriteGames;
         
             /**
              * @var string
              *
              * @ORM\Column(name="Team_Desciption", type="string", length=500, nullable=false)
              */
             private $teamDesciption;
         
             /**
              * @var string
              *
              * @ORM\Column(name="Password", type="string", length=30, nullable=false)
              */
             private $password;
         
             /**
              * @var string
              *
              * @ORM\Column(name="Team_Mail", type="string", length=30, nullable=false)
              */
             private $teamMail;
         
             /**
              * @var string|null
              *
              * @ORM\Column(name="logo", type="text", length=16777215, nullable=true)
              */
             private $logo;
               /**
              * NOTE: This is not a mapped field of entity metadata, just a simple property.
              * 
              * @Vich\UploadableField(mapping="team_images", fileNameProperty="image")
              * 
              * @var File|null
              */
             private $imageFile;
      
             /**
              * @ORM\Column(name="tournaments_won",type="integer")
              */
             private $nb;
         
             public function getIdTeam(): ?int
             {
                 return $this->id;
             }
         
             public function getTeamName(): ?string
             {
                 return $this->teamName;
             }
         
             public function setTeamName(string $teamName): self
             {
                 $this->teamName = $teamName;
         
                 return $this;
             }
         
             public function getNbPlayers(): ?int
             {
                 return $this->nbPlayers;
             }
         
             public function setNbPlayers(int $nbPlayers): self
             {
                 $this->nbPlayers = $nbPlayers ;
         
                 return $this;
             }
            
             public function getPlayers(): ?string
             {
                 return $this->players;
             }
         
             public function setPlayers(string $players): self
             {
                 $this->players = $players;
         
                 return $this;
             }
         
             public function getFavoriteGames(): ?string
             {
                 return $this->favoriteGames;
             }
         
             public function setFavoriteGames(string $favoriteGames): self
             {
                 $this->favoriteGames = $favoriteGames;
         
                 return $this;
             }
         
             public function getTeamDesciption(): ?string
             {
                 return $this->teamDesciption;
             }
         
             public function setTeamDesciption(string $teamDesciption): self
             {
                 $this->teamDesciption = $teamDesciption;
         
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
         
             public function getTeamMail(): ?string
             {
                 return $this->teamMail;
             }
         
             public function setTeamMail(string $teamMail): self
             {
                 $this->teamMail = $teamMail;
         
                 return $this;
             }
         
             public function getLogo(): ?string
             {
                 return $this->logo;
             }
         
             public function setLogo(?string $logo): self
             {
                 $this->logo = $logo;
         
                 return $this;
             }
             public function addPlayer(Player $players): self
             {
                 if (!$this->players->contains($players)) {
                     $this->players[] = $players;
                     $players->setTeam($this);
                 }
         
                 return $this;
             }
             public function __toString() {
                 return $this->teamName;
             }
             
             public function setImageFile(?File $logo = null)
             {
                 $this->imageFile = $logo;
         
                 if (null !== $logo) {
                     // It is required that at least one field changes if you are using doctrine
                     // otherwise the event listeners won't be called and the file is lost
                     $this->updatedAt = new \DateTimeImmutable();
                 }
             }
         
             public function getImageFile()
             {
                 return $this->imageFile;
             }
         
             public function setImage(?string $logo): self
             {
                 $this->logo = $logo;
                 return $this;
             }
         
             public function getImage(): ?string
             {
                 return $this->logo;
             }
   
             public function getNb(): ?int
             {
                 return $this->nb;
             }

             public function setNb(int $nb): self
             {
                 $this->nb = $nb;

                 return $this;
             }

     public function jsonSerialize(): array
     {
         return  array(
             'id' => $this->id,
             'teamName' => $this->teamName,
             'nbPlayers' => $this->nbPlayers,
             'players' => $this->players,
             'favoriteGames' => $this->favoriteGames,
             '$teamDesciption' => $this->teamDesciption,

         );
     }
         }


