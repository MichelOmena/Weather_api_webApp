<?php
require_once 'inc/config.php';
require_once  'inc/api.php';

$city = 'Aveiro'; // Depois criar um script para usar uma API de geolocalizacao e através do IP do usuario saber a região e dizer o tempo naquela localidade
if(isset($_GET['city'])){
    $city = $_GET['city'];
}
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
$current['info'] = 'right now:';
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
    $forecast_day['condition_icon'] = $day['day']['condition']['icon'];
    $forecast_day['max_temp'] = $day['day']['maxtemp_c'];
    $forecast_day['min_temp'] = $day['day']['mintemp_c'];
    $forecast[] = $forecast_day;
}

function city_selected($city, $selected_city){
    if($city == $selected_city){
        return 'selected';
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--local bootstrap link-->
    <link href="./assets/styles/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container-fluid mt-5">
    <div class="row justify-content-center mt-5">
        <div class="col-10 p-5 bg-light text-black">


            <div class="row">
                <div class="col-9">
                    <h3>City Time <strong><?= $location['name'] ?></strong></h3>
                    <p class="my-2">Region: <?= $location['region'] ?> | <?= $location['country'] ?> | <?= $location['current_time'] ?> | Previsão para <strong><?= $days ?></strong> dias</p>
                </div>
                <div class="col-3 text-end">
                    <select class="form-select">
                        <option value="Aveiro" <?= city_selected('Lisbon', $city) ?>>Aveiro</option>
                        <option value="Copenhagen"<?= city_selected('Copenhagen', $city)?>>Copenhagen</option>
                        <option value="Stockholm"<?= city_selected('Stockholm', $city)?>>Stockholm</option>
                        <option value="Malta"<?= city_selected('Malta', $city) ?>>Malta</option>
                        <option value="Munich"<?= city_selected('Munich', $city) ?>>Munich</option>
                        <option value="Luanda"<?= city_selected('Luanda', $city) ?>>Luanda</option>
                        <option value="Madrid" <?= city_selected('Madrid', $city) ?>>Madrid</option>
                        <option value="Bern" <?= city_selected('Bern', $city) ?>>Bern</option>
                        <option value="Prague" <?= city_selected('Prague', $city) ?>>Prague</option>
                        <option value="Paris" <?= city_selected('Paris', $city)?>>Paris</option>
                        <option value="Oslo" <?= city_selected('Oslo', $city)?>>Oslo</option>
                        <option value="London" <?= city_selected('London', $city)?>>London</option>
                    </select>
                </div>
            </div>
       
            <hr>

            <!-- current -->
             <?php 
             $weather_info = $current;
             include 'inc/weather_info.php';
             ?>
             <!--forecast-->
             <?php foreach($forecast as $day) : ?>
             <?php 
                $weather_info = $day;
                include 'inc/weather_info.php';
             ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        const select = document.querySelector('select');
        select.addEventListener('change', (e) =>{
            const city = e.target.value;
            window.location.href = `index.php?city=${city}`;
        })
    </script>
</body>
</html>

