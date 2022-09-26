<?php

session_start();
//include url and base path
include("path.php");
//connect to database, access methods db.php
include(ROOT_PATH . '/app/database/connect.php');

//set username to Guest unless logged in
$username = 'Guest';
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
}
//set these variables based on form submission
//types are: Food, Movies, Shopping, Study Spaces
$type = $_POST['type'];
//name of restaurant/movie/shop/study space
$name = $_POST['name'];
//rating and body of review, if body includes apostrophe, replace with &rsquo;
$rating = $_POST['rating'];
$body = $_POST['body'];
$bodyFix = str_replace("'", "&rsquo;",$body);
//date of review submission
$date = date("Y-m-d H:i:s");

//query to insert review
$reg = "INSERT INTO `reviews` (type, name, user, rating, review, date_created)
    VALUES ('$type', '$name', '$username', '$rating', '$bodyFix', '$date')";

//depending on type, query to extract from type table
if ($type == 'Food') {
  $command = "SELECT * FROM `restaurants` WHERE name = '$name'";
} elseif ($type == "Study Spaces") {
  $command = "SELECT * FROM `studyspaces` WHERE name LIKE '$name'";
} elseif ($type == "Movies") {
  $command = "SELECT * FROM `movies` WHERE name LIKE '$name'";
} elseif ($type == "Shopping") {
  $command = "SELECT * FROM `shopping` WHERE name LIKE '$name'";
}

$result = $conn->query($command);
//id variable declaration to store id of restaurant/movie/shop/study space
$id;
//assign id its value
while ($row = mysqli_fetch_row($result)) {
  $id = $row[0];
}

//insert review into reviews table and redirect back to relevant type page with relevant id
if ($conn->query($reg) === TRUE) {
  if ($type == 'Food') {
    header("Location: foodex.php?id=$id");
  } elseif ($type == "Study Spaces") {
    header("Location: studyex.php?id=$id");
  } elseif ($type == "Movies") {
    header("Location: moviesex.php?id=$id");
  } elseif ($type == "Shopping") {
    header("Location: shoppingex.php?id=$id");
  }
} else {
    //else redirect back to relevant type page with error
  if ($type == 'Food') {
    header("Location: foodex.php?error=1");
  } elseif ($type == "Study Spaces") {
    header("Location: studyex.php?error=1");
  } elseif ($type == "Movies") {
    header("Location: moviesex.php?error=1");
  } elseif ($type == "Shopping") {
    header("Location: shoppingex.php?error=1");
  }

}

//close database connection
$conn->close();

?>
