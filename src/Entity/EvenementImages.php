<?php

namespace App\Entity;

use App\Repository\EvenementImagesRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: EvenementImagesRepository::class)]
#[Vich\Uploadable]
class EvenementImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $name = null;

    #[Vich\UploadableField(mapping: 'eventImage', fileNameProperty: 'name')]
    private ?File $nameImage = null;

    public function getNameImage(): ?File
    {
        return $this->nameImage;
    }

    public function setNameImage(?File $nameImage): static
    {
        $this->nameImage = $nameImage;
        return $this;
    }



    #[ORM\ManyToOne(inversedBy: 'evenementImages')]
    private ?Evenement $evenement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): static
    {
        $this->evenement = $evenement;

        return $this;
    }
}
