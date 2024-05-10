<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]

class TravelEarlyBooking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: false)]
    private bool $nextYear = true;

    #[ORM\Column(nullable: false)]
    private int $dayTravelStart;

    #[ORM\Column(nullable: false)]
    private int $monthTravelStart;

    #[ORM\Column(nullable: false)]
    private int $dayTravelEnd;

    #[ORM\Column(nullable: false)]
    private int $monthTravelEnd;

    #[ORM\OneToMany(mappedBy: 'travel', targetEntity: DiscountEarlyBooking::class)]
    private Collection $discounts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isNextYear(): bool
    {
        return $this->nextYear;
    }

    public function setNextYear(bool $nextYear): void
    {
        $this->nextYear = $nextYear;
    }

    public function getDayTravelStart(): int
    {
        return $this->dayTravelStart;
    }

    public function setDayTravelStart(int $dayTravelStart): void
    {
        $this->dayTravelStart = $dayTravelStart;
    }

    public function getDayTravelEnd(): int
    {
        return $this->dayTravelEnd;
    }

    public function setDayTravelEnd(int $dayTravelEnd): void
    {
        $this->dayTravelEnd = $dayTravelEnd;
    }

    public function getMonthTravelStart(): int
    {
        return $this->monthTravelStart;
    }

    public function setMonthTravelStart(int $monthTravelStart): void
    {
        $this->monthTravelStart = $monthTravelStart;
    }

    public function getMonthTravelEnd(): int
    {
        return $this->monthTravelEnd;
    }

    public function setMonthTravelEnd(int $monthTravelEnd): void
    {
        $this->monthTravelEnd = $monthTravelEnd;
    }

    public function getDiscounts(): Collection
    {
        return $this->discounts;
    }

    public function setDiscounts(Collection $discounts): void
    {
        $this->discounts = $discounts;
    }
}
