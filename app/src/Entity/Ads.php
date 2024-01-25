<?php

namespace App\Entity;

use App\Repository\AdsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdsRepository::class)]
class Ads
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $sleeping = null;

    #[ORM\Column]
    private ?int $size = null;

    #[ORM\ManyToOne]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'user_id')]
    private ?Reservation $reservation_id = null;

    #[ORM\ManyToMany(targetEntity: Equipment::class, inversedBy: 'ads')]
    private Collection $equipment_id;

    #[ORM\OneToMany(mappedBy: 'ads', targetEntity: Image::class)]
    private Collection $image;

    #[ORM\ManyToOne(inversedBy: 'ads')]
    private ?Type $typeId = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    public function __construct()
    {
        $this->equipment_id = new ArrayCollection();
        $this->image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getSleeping(): ?int
    {
        return $this->sleeping;
    }

    public function setSleeping(int $sleeping): static
    {
        $this->sleeping = $sleeping;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getReservationId(): ?Reservation
    {
        return $this->reservation_id;
    }

    public function setReservationId(?Reservation $reservation_id): static
    {
        $this->reservation_id = $reservation_id;

        return $this;
    }

    /**
     * @return Collection<int, Equipment>
     */
    public function getEquipmentId(): Collection
    {
        return $this->equipment_id;
    }

    public function addEquipmentId(Equipment $equipmentId): static
    {
        if (!$this->equipment_id->contains($equipmentId)) {
            $this->equipment_id->add($equipmentId);
        }

        return $this;
    }

    public function removeEquipmentId(Equipment $equipmentId): static
    {
        $this->equipment_id->removeElement($equipmentId);

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): static
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setAds($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAds() === $this) {
                $image->setAds(null);
            }
        }

        return $this;
    }

    public function getTypeId(): ?Type
    {
        return $this->typeId;
    }

    public function setTypeId(?Type $typeId): static
    {
        $this->typeId = $typeId;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }
}
