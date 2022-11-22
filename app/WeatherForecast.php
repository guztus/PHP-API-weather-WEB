<?php declare(strict_types=1);

namespace App;

class WeatherForecast
{
    private array $weather = [];

    public function __construct(...$weather)
    {
        $this->weather = array_merge($this->weather, $weather);
    }

    public function listAll(): array
    {
        return $this->weather[0];
    }
}