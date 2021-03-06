<?php

namespace App\Entity;

use App\Repository\RoomBedsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomBedsRepository::class)
 */
class RoomBeds
{
    public const BED_SINGLE = 'Single bed';
    public const BED_TWO_SINGLE = 'Two single beds';
    public const BED_DOUBLE = 'Double bed';
    public const BED_MATRIMONIAL = 'Matrimonial bed';
    public const BED_SINGLE_BUNK = 'Single bunk bed';
    public const BED_DOUBLE_BUNK = 'Double bunk bed';
    public const BED_EXTENSIBLE = 'Extensible sofa';

    public const BEDS_ARRAY = [
        self::BED_SINGLE => self::BED_SINGLE,
        self::BED_TWO_SINGLE => self::BED_TWO_SINGLE,
        self::BED_DOUBLE => self::BED_DOUBLE,
        self::BED_MATRIMONIAL => self::BED_MATRIMONIAL,
        self::BED_SINGLE_BUNK => self::BED_SINGLE_BUNK,
        self::BED_DOUBLE_BUNK => self::BED_DOUBLE_BUNK,
        self::BED_EXTENSIBLE => self::BED_EXTENSIBLE
    ];

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
