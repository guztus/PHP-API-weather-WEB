<?php declare(strict_types=1);

namespace App;

class Location
{
    private float $latitude;
    private float $longitude;
    private string $name;

    public function __construct(string $name, float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}