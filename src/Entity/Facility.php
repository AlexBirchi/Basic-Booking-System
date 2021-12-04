<?php

namespace App\Entity;

use App\Repository\FacilityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacilityRepository::class)
 */
class Facility
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isRoomFacility;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPropertyFacility;

    /**
     * @ORM\ManyToMany(targetEntity=Property::class, mappedBy="facilities")
     */
    private $properties;

    /**
     * @ORM\ManyToMany(targetEntity=Room::class, mappedBy="facilities")
     */
    private $rooms;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
        $this->rooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsRoomFacility(): ?bool
    {
        return $this->isRoomFacility;
    }

    public function setIsRoomFacility(?bool $isRoomFacility): self
    {
        $this->isRoomFacility = $isRoomFacility;

        return $this;
    }

    public function getIsPropertyFacility(): ?bool
    {
        return $this->isPropertyFacility;
    }

    public function setIsPropertyFacility(?bool $isPropertyFacility): self
    {
        $this->isPropertyFacility = $isPropertyFacility;

        return $this;
    }

    /**
     * @return Collection|Property[]
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->addFacility($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->properties->removeElement($property)) {
            $property->removeFacility($this);
        }

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): self
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms[] = $room;
            $room->addFacility($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->rooms->removeElement($room)) {
            $room->removeFacility($this);
        }

        return $this;
    }
}
