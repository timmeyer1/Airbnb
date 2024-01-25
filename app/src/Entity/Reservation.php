<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\OneToMany(mappedBy: 'reservation_id', targetEntity: Ads::class)]
    private Collection $ads_id;

    public function __construct()
    {
        $this->ads_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * @return Collection<int, Ads>
     */
    public function getUserId(): Collection
    {
        return $this->ads_id;
    }

    public function addUserId(Ads $userId): static
    {
        if (!$this->ads_id->contains($userId)) {
            $this->ads_id->add($userId);
            $userId->setReservationId($this);
        }

        return $this;
    }

    public function removeUserId(Ads $userId): static
    {
        if ($this->ads_id->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getReservationId() === $this) {
                $userId->setReservationId(null);
            }
        }

        return $this;
    }
}
