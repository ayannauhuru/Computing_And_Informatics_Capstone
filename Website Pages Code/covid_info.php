<html>

<head>

<link rel="stylesheet" href="style.css">

</head>
<header>
    <div class= "head1">Covid</div>
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
<h1>Country Date Cases </h1>

<?php

  $servername ="sql5.freemysqlhosting.net";
  $username ="sql5475001";
  $password= "EkPC5F21V8";
  $dbname ="sql5475001";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$covid_table = "SELECT Country, Date, Cases FROM Covid";
$covid_result = $conn->query($covid_table);

if ($covid_result->num_rows > 0) {
  // output data of each row
  while($covid_row = $covid_result->fetch_assoc()) {
    echo $covid_row["Country"]. " " . $covid_row["Date"]. " ". $covid_row["Cases"] . "<br>". "<br>";
  }
} else {
  echo "0 Covid Cases";
}
$conn->close();

?>

</body>

</html>

