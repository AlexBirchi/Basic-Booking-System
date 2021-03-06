<?php

namespace App\Entity;

use App\Repository\PropertyTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PropertyTypeRepository::class)
 */
class PropertyType
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
    private $hasMultipleRooms;

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

    public function getHasMultipleRooms(): ?bool
    {
        return $this->hasMultipleRooms;
    }

    public function setHasMultipleRooms(?bool $hasMultipleRooms): self
    {
        $this->hasMultipleRooms = $hasMultipleRooms;

        return $this;
    }
}
