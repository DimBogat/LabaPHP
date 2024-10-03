<?php

namespace App\Model;

class Country
{
    private string $shortName;
    private string $fullName;
    private string $isoAlpha2;
    private string $isoAlpha3;
    private int $isoNumeric;
    private int $population;
    private float $square;

    public function __construct(
        string $shortName,
        string $fullName,
        string $isoAlpha2,
        string $isoAlpha3,
        int $isoNumeric,
        int $population,
        float $square
    ) {
        $this->shortName = $shortName;
        $this->fullName = $fullName;
        $this->isoAlpha2 = $isoAlpha2;
        $this->isoAlpha3 = $isoAlpha3;
        $this->isoNumeric = $isoNumeric;
        $this->population = $population;
        $this->square = $square;
    }

    public function getShortName(): string
    {
        return $this->shortName;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getIsoAlpha2(): string
    {
        return $this->isoAlpha2;
    }

    public function getIsoAlpha3(): string
    {
        return $this->isoAlpha3;
    }

    public function getIsoNumeric(): int
    {
        return $this->isoNumeric;
    }

    public function getPopulation(): int
    {
        return $this->population;
    }

    public function getSquare(): float
    {
        return $this->square;
    }
}