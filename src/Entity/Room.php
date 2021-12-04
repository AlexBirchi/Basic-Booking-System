<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Property::class, inversedBy="rooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $property;

    /**
     * @ORM\ManyToOne(targetEntity=RoomType::class, inversedBy="rooms")
     */
    private $roomType;

    /**
     * @ORM\Column(type="smallint")
     */
    private $adultsCapacity;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $childrenCapacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $basePrice;

    /**
     * @ORM\ManyToMany(targetEntity=Facility::class, inversedBy="rooms")
     */
    private $facilities;

    /**
     * @ORM\OneToMany(targetEntity=RoomBeds::class, mappedBy="room", orphanRemoval=true)
     */
    private $roomBeds;

    public function __construct()
    {
        $this->facilities = new ArrayCollection();
        $this->roomBeds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getRoomType(): ?RoomType
    {
        return $this->roomType;
    }

    public function setRoomType(?RoomType $roomType): self
    {
        $this->roomType = $roomType;

        return $this;
    }

    public function getAdultsCapacity(): ?int
    {
        return $this->adultsCapacity;
    }

    public function setAdultsCapacity(int $adultsCapacity): self
    {
        $this->adultsCapacity = $adultsCapacity;

        return $this;
    }

    public function getChildrenCapacity(): ?int
    {
        return $this->childrenCapacity;
    }

    public function setChildrenCapacity(?int $childrenCapacity): self
    {
        $this->childrenCapacity = $childrenCapacity;

        return $this;
    }

    public function getBasePrice(): ?int
    {
        return $this->basePrice;
    }

    public function setBasePrice(int $basePrice): self
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    /**
     * @return Collection|Facility[]
     */
    public function getFacilities(): Collection
    {
        return $this->facilities;
    }

    public function addFacility(Facility $facility): self
    {
        if (!$this->facilities->contains($facility)) {
            $this->facilities[] = $facility;
        }

        return $this;
    }

    public function removeFacility(Facility $facility): self
    {
        $this->facilities->removeElement($facility);

        return $this;
    }

    /**
     * @return Collection|RoomBeds[]
     */
    public function getRoomBeds(): Collection
    {
        return $this->roomBeds;
    }

    public function addRoomBed(RoomBeds $roomBed): self
    {
        if (!$this->roomBeds->contains($roomBed)) {
            $this->roomBeds[] = $roomBed;
            $roomBed->setRoom($this);
        }

        return $this;
    }

    public function removeRoomBed(RoomBeds $roomBed): self
    {
        if ($this->roomBeds->removeElement($roomBed)) {
            // set the owning side to null (unless already changed)
            if ($roomBed->getRoom() === $this) {
                $roomBed->setRoom(null);
            }
        }

        return $this;
    }
}
