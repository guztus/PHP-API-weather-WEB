<?php declare(strict_types=1);

use Carbon\Carbon;

use App\Weather;
use App\ApiClient;

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$city = $_GET['city'];
if (count((array)$city) == 0) {
    $city = 'Riga';
}

$apiConnection = new ApiClient($_ENV['API_KEY']);
$weatherNow = $apiConnection->getWeatherNow($city);
$weatherForecast = $apiConnection->getWeatherForecast($city);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Weather report</title>
</head>

<body style="background-color:#d8e9e4">
<header>
    <nav>
        <a href="/?city=Riga"> Riga </a> | <a href="/?city=Vilnius"> Vilnius </a> | <a href="/?city=Tallinn">
            Tallinn </a> |
        <a
                href="/?city=London"> London </a> | <a href="/?city=Tokyo"> Tokyo </a>
    </nav>
</header>

<div>
    <br>
    <form action="/" method="get" validate="validate">
        <label for="city">
            City:
        </label>
        <input id="city" type="text" name="city" placeholder="City name" size="30" required>
        <input type="submit" value="Get weather">
    </form>
</div>

<div style="display:flex; gap:10px">
    <span style="font-size: 2em; font-weight: bold; margin-top: 12px"><?= $city; ?>
    </span>
    <div style="width: 60px">
        <img src="https://openweathermap.org/img/wn/<?= $weatherNow->getWeatherImageId(); ?>@2x.png"
             alt="<?= $weatherNow->getWeatherDescription(); ?>"
             style="width: 100%">
    </div>
</div>

<div>
    <p>
        The temperature now is <?= $weatherNow->getTemperature(); ?>°C and humidity is
        at <?= $weatherNow->getHumidity(); ?>%
    <p>
</div>

<div>
    <div>
        <h3>Weather for next 5 days: </h3>
    </div>
    <div>
        <table border="1" cellpadding="10">
            <th>
                Day

            </th>
            <th>
                Weather
            </th>
            <th>
                Time
            </th>
            <th>
                Temperature
            </th>
            <th>
                Humidity
            </th>
            <?php foreach ($weatherForecast as $nextThreeHours): ?>
                <?php
                $weatherForecast = new Weather($city, $nextThreeHours['main']['temp'], $nextThreeHours['main']['humidity'], $nextThreeHours['main']['feels_like'], $nextThreeHours['weather'][0]['description'], $nextThreeHours['weather'][0]['icon']);
                $unixCode = $nextThreeHours['dt'];
                $day = Carbon::parse($unixCode)->toDateTime()->format('D');
                $hour = Carbon::parse($unixCode)->toDateTime()->format('H'); ?>
                <?php if ($hour == 00): ?>
                    <tr>
                        <th>
                            Day

                        </th>
                        <th>
                            Weather
                        </th>
                        <th>
                            Time
                        </th>
                        <th>
                            Temperature
                        </th>
                        <th>
                            Humidity
                        </th>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td>
                        <?= $day; ?>
                    </td>
                    <td>
                        <img src="https://openweathermap.org/img/wn/<?= $weatherForecast->getWeatherImageId(); ?>@2x.png"
                             alt="<?= $weatherForecast->getWeatherDescription(); ?>" width="30">
                    </td>
                    <td>
                        <?= $hour; ?>
                    </td>
                    <td>
                        <?= $weatherForecast->getTemperature(); ?>°C
                    </td>
                    <td>

                        <?= $weatherForecast->getHumidity(); ?>%
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
</body>
</html>