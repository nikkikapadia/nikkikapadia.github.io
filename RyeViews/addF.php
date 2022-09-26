<?php
// starts session for username
session_start();
// includes php code that connects to the database
include("path.php");
include(ROOT_PATH . '/app/database/connect.php');

// assigns all variables that were submitted in the form and fixes things that could cause a problem
$name = ucwords($_POST['name']);        // makes first letter of each word upper case
$nameFix = str_replace("'", "&rsquo;",$name);   // replaces apostrophe with html character
$img = $_POST['image'];
$desc = $_POST['description'];
$descFix = str_replace("'", "&rsquo;",$desc);
$loc = ucwords($_POST['location']);
$phone = $_POST['number'];
$website = $_POST['website'];

// tries to find the name of the restaurant in the database
$s = "SELECT * FROM `restaurants` WHERE `name` = '$nameFix'";
$result = $conn->query($s);
$num = mysqli_num_rows($result);

// if restaurant in the database it will put an error number in the query string and go back to food page
if ($num == 1){
  header("Location: food.php?error=1");
}
else{
    $reg = "INSERT INTO `restaurants` (name, imgurl, description, location, phone, website)
    VALUES ('$nameFix', '$img', '$descFix', '$loc', '$phone', '$website')";
    // if restaurant successfully put in database it goes back to food page
    if ($conn->query($reg) === TRUE) {
      header("Location: food.php");
    // if there was an error there will be an error number in query string to show message on food page
    } else {
      header("Location: food.php?error=2");
    }
}

$conn->close();
?>
