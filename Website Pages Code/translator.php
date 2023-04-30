<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<header>
    <div class= "head1">Translator</div>
</header>

<body>

<div class= "menu">
    <a href= "home.php">Home</a>
    <a href= "weather.php">Weather</a>
    <a href= "covid_info.php">COVID-19 Information</a>
    <a href= "museums.php">Museums</a>
    <a href= "stadium_reviews.php">Stadium Reviews</a>
    <a href= "translator.php">Translator</a>
</div>



<?php

$servername = "sql5.freemysqlhosting.net";
$username = "sql5475001";
$password = "EkPC5F21V8";
$dbname = 'sql5475001';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$translations_table = "SELECT * FROM Translations";
$translations_result = $conn->query($translations_table);

if ($translations_result->num_rows > 0) {
    // output data of each row
    while($translations_row = $translations_result->fetch_assoc()) {
        echo $translations_row["german"]. "-> " . $translations_row["english"]. "<br>". "<br>";
    }
} else {
    echo "0 Translation results";
}
$conn->close();

?>

</body>

</html>
