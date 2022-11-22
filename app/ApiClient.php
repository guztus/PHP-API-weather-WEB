<?php declare(strict_types=1);

namespace App;

class ApiClient
{
    private string $apiKey;
    private const API_URL = "https://api.openweathermap.org/";

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getWeatherForecast(string $locationName): array
    {
        $location = $this->getLocation($locationName);

        $weatherForecast = json_decode(file_get_contents(self::API_URL . "/data/2.5/forecast?lat={$location->getLatitude()}&lon={$location->getLongitude()}&appid={$this->apiKey}&units=metric"), true);
        $forecast = new WeatherForecast(
            $weatherForecast['list']
        );
        return $forecast->listAll();
    }

    public function getWeatherNow(string $locationName): ?Weather
    {
        $location = $this->getLocation($locationName);
        $weatherRequest = json_decode(file_get_contents(self::API_URL . "/data/2.5/weather?lat={$location->getLatitude()}&lon={$location->getLongitude()}&appid={$this->apiKey}&units=metric"), true);
        return new Weather(
            $location->getName(),
            $weatherRequest['main']['temp'] ?? -90,
            $weatherRequest['main']['humidity'] ?? -90,
            $weatherRequest['main']['feels_like'] ?? -90,
            $weatherRequest['weather'][0]['description'] ?? "10d",
            $weatherRequest['weather'][0]['icon'] ?? "10d",
        );
    }

    private function getLocation(string $city): ?Location
    {
        $locationRequest = json_decode(file_get_contents(self::API_URL . "/geo/1.0/direct?q={$city}&limit=1&appid={$this->apiKey}"), true);

        return new Location(
            $city,
            (float)$locationRequest[0]['lat'] ?? -90,
            (float)$locationRequest[0]['lon'] ?? -90
        );
    }
}