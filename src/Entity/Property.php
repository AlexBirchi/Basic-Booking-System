<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=PropertyRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Property
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity=Location::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity=PropertyType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $propertyType;

    /**
     * @ORM\Column(type="integer")
     */
    private $likes;

    /**
     * @ORM\ManyToMany(targetEntity=Facility::class, inversedBy="properties")
     */
    private $facilities;

    /**
     * @ORM\OneToMany(targetEntity=Room::class, mappedBy="property", orphanRemoval=true)
     */
    private $rooms;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    public function __construct()
    {
        $this->facilities = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getPropertyType(): ?PropertyType
    {
        return $this->propertyType;
    }

    public function setPropertyType(?PropertyType $propertyType): self
    {
        $this->propertyType = $propertyType;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    /**
     * @ORM\PrePersist
     */
    public function initializeLikes()
    {
        $this->likes = 0;
    }

    public function incrementLikes()
    {
        $this->likes += 1;
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
            $room->setProperty($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->rooms->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getProperty() === $this) {
                $room->setProperty(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?UserInterface
    {
        return $this->owner;
    }

    public function setOwner(?UserInterface $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
