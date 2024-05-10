<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class Travel
{
    private ?float $basicCost = null;

    private ?\DateTime $dateStart = null;

    private ?\DateTime $dateBirth = null;

    private ?\DateTime $datePayment = null;

    private ?float $fullCost;


    public function getBasicCost(): ?float
    {
        return $this->basicCost;
    }

    public function setBasicCost(?float $basicCost): void
    {
        $this->basicCost = $basicCost;
    }

    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(?\DateTime $dateStart): void
    {
        $this->dateStart = $dateStart;
    }

    public function getDateBirth(): ?\DateTime
    {
        return $this->dateBirth;
    }

    public function setDateBirth(?\DateTime $dateBirth): void
    {
        $this->dateBirth = $dateBirth;
    }

    public function getDatePayment(): ?\DateTime
    {
        return $this->datePayment;
    }

    public function setDatePayment(?\DateTime $datePayment): void
    {
        $this->datePayment = $datePayment;
    }

    public function getFullCost(): ?float
    {
        return $this->fullCost;
    }

    public function setFullCost(?float $fullCost): void
    {
        $this->fullCost = $fullCost;
    }
}
