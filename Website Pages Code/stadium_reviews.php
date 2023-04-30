<html>

<head>
<link rel="stylesheet" href="style.css">

</head>

<body>

    <!-- Header Section -->
    <header>
        <div class= "head1">Stadium Reviews</div>
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

$stadiumReviews_table = "SELECT * FROM stadiumReviews";
$stadiumReviews_result = $conn->query($stadiumReviews_table);

if ($stadiumReviews_result) {
  // output data of each row
  while($stadiumReview_row = $stadiumReviews_result->fetch_assoc()) {
    echo "Stadium: ". "<br>". "&#9".  $stadiumReview_row["name"]. " - ". $stadiumReview_row["formatted_address"]. "<br>". "Rating: ". $stadiumReview_row["rating"]. "<br>". $stadiumReview_row["text"]. "<br>".
    "Reviewer: ". $stadiumReview_row["author_name"]. "<br>". "<br>";
  }
} else {
  echo "0 Stadium Reviews Submissions";
}
$conn->close();

?>

</body>

</html>

