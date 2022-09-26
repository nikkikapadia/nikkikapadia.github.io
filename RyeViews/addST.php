<?php
// starts user session
session_start();
// includes code to connect
include("path.php");
include(ROOT_PATH . '/app/database/connect.php');

// assigning values from form to variables and adjusting appropriately
$name = ucwords($_POST['name']);
$nameFix = str_replace("'", "&rsquo;",$name);
$img = $_POST['image'];
$desc = $_POST['description'];
$descFix = str_replace("'", "&rsquo;",$desc);
$loc = ucwords($_POST['location']);
$website = $_POST['website'];

// looks for the name of the study spacec in the database
$s = "SELECT * FROM `studyspaces` WHERE `name` = '$nameFix'";
$result = $conn->query($s);
$num = mysqli_num_rows($result);
// if it is in the database already then it goes back to study page with an error
if ($num == 1){
  header("Location: study.php?error=1");
}
else{
    $reg = "INSERT INTO `studyspaces` (name, imgurl, description, location, website)
    VALUES ('$nameFix', '$img', '$descFix', '$loc', '$website')";
    // if successfully inputted into database it will go back to study page
    if ($conn->query($reg) === TRUE) {
      header("Location: study.php");
    // otherwise it will go to study page with an error
    } else {
      header("Location: study.php?error=2");
    }
}

$conn->close();
?>
