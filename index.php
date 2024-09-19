<?php
require_once 'inc/config.php';
require_once  'inc/api.php';

$city = 'Lisbon'; // Depois criar um script para usar uma API de geolocalizacao e através do IP do usuario saber a região e dizer o tempo naquela localidade
$days = 5;

$results = Api::get($city, $days);

if($results['status'] == 'error'){
    echo $results['message'];
    exit;
}
$data = json_decode($results['data'], true);

// location data
$location = [];
$location['name'] = $data['location']['name'];
$location['region'] = $data['location']['region'];
$location['country'] = $data['location']['country'];
$location['current_time'] = $data['location']['localtime'];

//current weather data
$current = [];
$current['info'] = 'right now';
$current['temperature'] = $data['current']['temp_c']; 
$current['condition'] = $data['current']['condition']['text'];
$current['condition_icon'] = $data['current']['condition']['icon'];
$current['wind_speed'] = $data['current']['wind_kph'];

//forecast weather data
$forecast = [];
foreach($data['forecast']['forecastday'] as $day){
    $forecast_day = [];
    $forecast_day['info'] = null;
    $forecast_day['date'] = $day['date'];
    $forecast_day['condition'] = $day['day']['condition']['text'];
    $forecast_day['condition'] = $day['day']['condition']['icon'];
    $forecast_day['max_temp'] = $day['day']['maxtemp_c'];
    $forecast_day['min_temp'] = $day['day']['mintemp_c'];
    $forecast[] = $forecast_day;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">"
</head>
<body class="bg-dark text-white">
    <div class="row justify-content-center mt-5">
        <div class="col-10 p-5 bg-light text-black">
            <h3>City Time <strong><?= $city ?></strong></h3>
            <hr>

            <!-- current -->
             <?php 
             $weather_info = $current;
             include 'inc/weather_info.php';
             ?>
             <?php ?>
             <?php ?>
             <?php ?>
        </div>

    </div>
</body>
</html>

