<?php

namespace App\Entity;

use App\Repository\RoomBedsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomBedsRepository::class)
 */
class RoomBeds
{
    public const BED_SINGLE = 'single';
    public const BED_DOUBLE = 'double';
    public const BED_MATRIMONIAL = 'matrimonial';
    public const BED_BUNK_SINGLE = 'bunk single';
    public const BED_BUNK_DOUBLE = 'bunk single';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Room::class, inversedBy="roomBeds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $room;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getBed(): ?string
    {
        return $this->bed;
    }

    public function setBed(string $bed): self
    {
        $this->bed = $bed;

        return $this;
    }
}
