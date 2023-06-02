<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Games
 *
 * @ORM\Table(name="games")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Games
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Game", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *@Assert\NotBlank
     * @ORM\Column(name="Game_Name", type="string", length=100, nullable=false)
     */
    private $gameName;

    /**
     * @var string
     *@Assert\NotBlank
     * @ORM\Column(name="Description", type="string", length=500, nullable=false)
     */
    private $description;

    /**
     * @var string
     *@Assert\NotBlank
     * @ORM\Column(name="News", type="string", length=2000, nullable=false)
     */
    private $news;

    /**
     * @var \DateTime
     *@Assert\NotBlank
     * @ORM\Column(name="News_Date", type="date")
     */
    private $newsDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Image", type="text", length=255)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="games_images", fileNameProperty="image")
     * @var File|null
     */
    private $imageFile;

    public function getIdGame(): ?int
    {
        return $this->id;
    }

    public function getGameName(): ?string
    {
        return $this->gameName;
    }

    public function setGameName(string $gameName): self
    {
        $this->gameName = $gameName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNews(): ?string
    {
        return $this->news;
    }

    public function setNews(string $news): self
    {
        $this->news = $news;

        return $this;
    }

    public function getNewsDate(): ?\DateTimeInterface
    {
        return $this->newsDate;
    }

    public function setNewsDate(\DateTimeInterface $newsDate): self
    {
        $this->newsDate = $newsDate;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }


    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

}