<?php

namespace App\Entity;

use App\Repository\RealisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Cocur\Slugify\Slugify;

#[ORM\Entity(repositoryClass: RealisationRepository::class)]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
class Realisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 350)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $client = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $projetAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'realisations')]
    private ?RealisationCategory $category = null;

    /**
     * @var Collection<int, RealisationImage>
     */
    #[ORM\OneToMany(targetEntity: RealisationImage::class, mappedBy: 'realisation', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $realisationImages;

    #[ORM\Column(length: 350)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->realisationImages = new ArrayCollection();
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

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getProjetAt(): ?\DateTime
    {
        return $this->projetAt;
    }

    public function setProjetAt(\DateTime $projetAt): static
    {
        $this->projetAt = $projetAt;

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

    public function getCategory(): ?RealisationCategory
    {
        return $this->category;
    }

    public function setCategory(?RealisationCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, RealisationImage>
     */
    public function getRealisationImages(): Collection
    {
        return $this->realisationImages;
    }

    public function addRealisationImage(RealisationImage $realisationImage): static
    {
        if (!$this->realisationImages->contains($realisationImage)) {
            $this->realisationImages->add($realisationImage);
            $realisationImage->setRealisation($this);
        }

        return $this;
    }

    public function removeRealisationImage(RealisationImage $realisationImage): static
    {
        if ($this->realisationImages->removeElement($realisationImage)) {
            // set the owning side to null (unless already changed)
            if ($realisationImage->getRealisation() === $this) {
                $realisationImage->setRealisation(null);
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
