<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Cocur\Slugify\Slugify;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 400)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'eventImage', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): static
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $evenementAt = null;

    #[ORM\Column(length: 255)]
    private ?string $theme = null;

    /**
     * @var Collection<int, EvenementImages>
     */
    #[ORM\OneToMany(targetEntity: EvenementImages::class, mappedBy: 'evenement', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $evenementImages;

    #[ORM\Column(length: 350)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->evenementImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEvenementAt(): ?\DateTime
    {
        return $this->evenementAt;
    }

    public function setEvenementAt(\DateTime $evenementAt): static
    {
        $this->evenementAt = $evenementAt;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return Collection<int, EvenementImages>
     */
    public function getEvenementImages(): Collection
    {
        return $this->evenementImages;
    }

    public function addEvenementImage(EvenementImages $evenementImage): static
    {
        if (!$this->evenementImages->contains($evenementImage)) {
            $this->evenementImages->add($evenementImage);
            $evenementImage->setEvenement($this);
        }

        return $this;
    }

    public function removeEvenementImage(EvenementImages $evenementImage): static
    {
        if ($this->evenementImages->removeElement($evenementImage)) {
            // set the owning side to null (unless already changed)
            if ($evenementImage->getEvenement() === $this) {
                $evenementImage->setEvenement(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function generateSlug(): void
    {

            $slugify = new Slugify();
            $slug = $slugify->slugify($this->title);

            $dateTime = new \DateTimeImmutable();
            $formattedDate = $dateTime->format('Y-m-d_H-i-s');

            $this->slug = $slug . '-' . $formattedDate;

    }
}
