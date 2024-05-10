<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]

class DiscountEarlyBooking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'discounts')]
    private ?TravelEarlyBooking $travel = null;

    #[ORM\Column(nullable: false)]
    private int $monthPaymentStart;

    #[ORM\Column(nullable: false)]
    private int $monthPaymentEnd;

    #[ORM\Column(nullable: true)]
    private ?float $discount = null;

    #[ORM\Column(nullable: true)]
    private ?float $maxDiscount = null;

    #[ORM\Column(nullable: false)]
    private bool $nextYear = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonthPaymentStart(): int
    {
        return $this->monthPaymentStart;
    }

    public function setMonthPaymentStart(int $monthPaymentStart): void
    {
        $this->monthPaymentStart = $monthPaymentStart;
    }

    public function getMonthPaymentEnd(): int
    {
        return $this->monthPaymentEnd;
    }

    public function setMonthPaymentEnd(int $monthPaymentEnd): void
    {
        $this->monthPaymentEnd = $monthPaymentEnd;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): void
    {
        $this->discount = $discount;
    }

    public function getMaxDiscount(): ?float
    {
        return $this->maxDiscount;
    }

    public function setMaxDiscount(?float $maxDiscount): void
    {
        $this->maxDiscount = $maxDiscount;
    }

    public function getTravel(): ?TravelEarlyBooking
    {
        return $this->travel;
    }

    public function setTravel(?TravelEarlyBooking $travel): void
    {
        $this->travel = $travel;
    }

    public function isNextYear(): bool
    {
        return $this->nextYear;
    }

    public function setNextYear(bool $nextYear): void
    {
        $this->nextYear = $nextYear;
    }
}
