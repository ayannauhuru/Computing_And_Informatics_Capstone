<!doctype html>
<html>

</head>
<link rel="stylesheet" href="style.css">
<header>
    <div class= "head1">Current Weather in Berlin</div>
</header>
<!-- Horizontal Menu Navigation Bar -->
<div class= "menu">
    <a href= "index.php">Home</a>
    <a href= "weather.php">Weather</a>
    <a href= "covid_info.php">COVID-19 Information</a>
    <a href= "museums.php">Museums</a>
    <a href= "stadium_reviews.php">Stadium Reviews</a>
    <a href= "translator.php">Translator</a>
</div>
<body>

<?php

  $servername ="sql5.freemysqlhosting.net";
  $username ="sql5475001";
  $password= "EkPC5F21V8";
  $dbname ="sql5475001";

  $currentTime=time();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$current_weather_table = "SELECT Name, Value FROM CurrentWeather";
$current_weather_result = $conn->query($current_weather_table);

$current_temp_value = "SELECT Value From CurrentWeather WHERE name='Temperature'";
$current_temp_result = $conn->query($current_temp_value);
$current_temp_row = $current_temp_result->fetch_assoc();

$current_humidity_value = "SELECT Value From CurrentWeather WHERE name='Humidity'";
$current_humidity_result = $conn->query($current_humidity_value);
$current_humidity_row = $current_humidity_result->fetch_assoc();

$current_wind_value = "SELECT Value From CurrentWeather WHERE name='Wind Speed'";
$current_wind_result = $conn->query($current_wind_value);
$current_wind_row = $current_wind_result->fetch_assoc();

$current_description_value = "SELECT Value From CurrentWeather WHERE name='Description'";
$current_description_result = $conn->query($current_description_value);
$current_description_row = $current_description_result->fetch_assoc();

$current_icon_value = "SELECT Value From CurrentWeather WHERE name='Icon'";
$current_icon_result = $conn->query($current_icon_value);
$current_icon_row = $current_icon_result->fetch_assoc();
?>

<div class="report-container">

        <div class="time">
            <div><?php echo date("l g:i a", $currentTime); ?></div>
            <div><?php echo date("jS F, Y",$currentTime); ?></div>
            <div><?php echo ucwords($current_description_row["Value"]); ?></div>
        </div>
        <div class="weather-forecast">
            <img
                src="http://openweathermap.org/img/wn/<?php echo $current_icon_row['Value']; ?>.png"
                class="weather-icon" /> <?php echo $current_temp_row['Value']; ?>°C<span>
        </div>
        <div class="time">
            <div>Humidity: <?php echo $current_humidity_row['Value']; ?> %</div>
            <div>Wind: <?php echo $current_wind_row['Value']; ?> km/h</div>
        </div>
    </div>

</body>

</html>
