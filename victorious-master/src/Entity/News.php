<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class News implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_News", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups ("newslist")
     */
    private $id;

    /**
     * @var \DateTime
     *@Assert\NotBlank
     * @Assert\Type("\DateTime")
     * @ORM\Column(name="Date_Debut", type="date")
     * @Groups ("newslist")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Groups ("newslist")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Groups ("newslist")
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Image", type="text", length=255)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="news_images", fileNameProperty="image")
     * @var File|null
     */
    private $imageFile;





    public function getIdNews(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
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

    public function jsonSerialize(): array
    {
        return  array(
            'id' => $this->id,
            'dateDebut' => $this->dateDebut,
            'title' => $this->title,
            'description' => $this->description
        );
    }



}
