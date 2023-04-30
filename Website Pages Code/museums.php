<html>
    <head>
<link rel="stylesheet" href="style.css">
</head>


<body>

    <!-- Header Section -->
    <header>
        <div class= "head1">Museums</div>
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

$sql = "SELECT row_names, name, formatted_address, rating, user_ratings_total FROM BerlinMuseums";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["row_names"]. ": " . $row["name"]. " " . $row["formatted_address"]. " " . $row["rating"]. " "
. $row["user_ratings_total"]. "<br>". "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();

?>

</body>

</html>
