<?php
// starts username session
session_start();
// includes code to connect to the database
include("path.php");
include(ROOT_PATH . '/app/database/connect.php');

// gets all of the values from the form and formats them appropriately
$name = ucwords($_POST['name']);
$nameFix = str_replace("'", "&rsquo;",$name);
$img = $_POST['image'];
$desc = $_POST['description'];
$descFix = str_replace("'", "&rsquo;",$desc);
$loc = ucwords($_POST['theatre']);
$website = $_POST['website'];

// tries to find the movie in the database
$s = "SELECT * FROM `movies` WHERE `name` = '$nameFix'";
$result = $conn->query($s);
$num = mysqli_num_rows($result);

// if it finds the movie it goes back to movies page with error message
if ($num == 1){
  header("Location: movies.php?error=1");
}
else{
    $reg = "INSERT INTO `movies` (name, imgurl, description, theatre, website)
    VALUES ('$nameFix', '$img', '$descFix', '$loc', '$website')";
    // if inserted successfully it goes back to movies page
    if ($conn->query($reg) === TRUE) {
      header("Location: movies.php");
    // otherwise goes to movies page with error message
    } else {
      header("Location: movies.php?error=2");
    }
}

$conn->close();
?>
