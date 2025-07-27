<?php

namespace App\Entity;

use App\Repository\RealisationImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: RealisationImageRepository::class)]
#[Vich\Uploadable]
class RealisationImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 350)]
    private ?string $url = null;

    #[Vich\UploadableField(mapping: 'realisationImage', fileNameProperty: 'url')]
    private ?File $urlImage = null;

    public function getUrlImage(): ?File
    {
        return $this->urlImage;
    }

    public function setUrlImage(?File $urlImage): static
    {
        $this->urlImage = $urlImage;
        return $this;
    }

    #[ORM\ManyToOne(inversedBy: 'realisationImages')]
    private ?Realisation $realisation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getRealisation(): ?Realisation
    {
        return $this->realisation;
    }

    public function setRealisation(?Realisation $realisation): static
    {
        $this->realisation = $realisation;

        return $this;
    }
}
