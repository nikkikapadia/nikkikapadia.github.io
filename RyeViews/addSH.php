<?php
// starts user session
session_start();
// includes code that connects to the database
include("path.php");
include(ROOT_PATH . '/app/database/connect.php');

// assigns variables with values from form and formats them appropriately
$name = ucwords($_POST['name']);
$nameFix = str_replace("'", "&rsquo;",$name);
$img = $_POST['image'];
$desc = $_POST['description'];
$descFix = str_replace("'", "&rsquo;",$desc);
$loc = ucwords($_POST['location']);
$website = $_POST['website'];

// tries to find the shopping space in the database
$s = "SELECT * FROM `shopping` WHERE `name` = '$nameFix'";
$result = $conn->query($s);
$num = mysqli_num_rows($result);

// if found shopping spot in database it goes to shopping page with error
if ($num == 1){
  header("Location: shopping.php?error=1");
}
else{
    $reg = "INSERT INTO `shopping` (name, imgurl, description, location, website)
    VALUES ('$nameFix', '$img', '$descFix', '$loc', '$website')";
    // if successfully inserted into database goes to the shopping page
    if ($conn->query($reg) === TRUE) {
      header("Location: shopping.php");
    // otherwise it returns to shopping page with an error
    } else {
      header("Location: shopping.php?error=2");
    }
}

$conn->close();
?>
