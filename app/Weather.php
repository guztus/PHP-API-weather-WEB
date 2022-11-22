<?php declare(strict_types=1);

namespace App;

class Weather
{
    private float $temperature;
    private string $locationName;
    private int $humidity;
    private float $feelsLike;
    private string $weatherDescription;
    private string $weatherImageId;

    public function __construct(string $locationName, float $temperature, int $humidity, float $feelsLike, string $weatherDescription, string $weatherImageId)
    {
        $this->locationName = $locationName;
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->feelsLike = $feelsLike;
        $this->weatherDescription = $weatherDescription;
        $this->weatherImageId = $weatherImageId;
    }

    public function getLocationName(): string
    {
        return $this->locationName;
    }

    public function getTemperature(): float
    {
        return round($this->temperature, 1);
    }

    public function getHumidity(): float
    {
        return $this->humidity;
    }

    public function getFeelsLike(): float
    {
        return $this->feelsLike;
    }

    public function getWeatherDescription(): string
    {
        return $this->weatherDescription;
    }

    public function getWeatherImageId(): string
    {
        return $this->weatherImageId;
    }
}