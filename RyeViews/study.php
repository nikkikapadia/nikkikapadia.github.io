<?php
// starts session
session_start();
// includes code that connects to the database
include("path.php");
include(ROOT_PATH . '/app/database/connect.php');

// checks if there is an error variable
if (isset($_GET["error"])) {
  $error = $_GET["error"];
} else {
  $error = 0;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <title>Study</title>
    <!-- stylesheets (internal and external) -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <script src="assets/js/script.js"></script>

    <?php
        //error if study space is already on the website
        if ($error == 1) {
          echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert">
          The study space you entered is already on the website
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        // error if there was a problem putting study space into the database
        } elseif ($error == 2) {
          echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert">
          Could not add study space
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        }
     ?>
    <!-- title card -->
    <div class="title-card" style="background-image: url('assets/images/study.jpg')">
      <h1>Study Spaces</h1>
    </div>
    <!-- navigation bar -->
    <nav class="nav">
      <a href="index.php" class="nav-link">Home</a>
      <a href="food.php" class="nav-link">Food</a>
      <a href="study.php" class="nav-link selected">Study Spaces</a>
      <a href="movies.php" class="nav-link">Movies</a>
      <a href="shopping.php" class="nav-link">Shopping</a>
      <a href="about.php" class="nav-link">About Us</a>
      <?php if (isset($_SESSION['username'])): ?>
        <a href="#" class="nav-link"><?php echo $_SESSION['username']; ?></a>
      <?php else: ?>
        <a href="login.php" class="nav-link">Login</a>
      <?php endif; ?>
      <?php if (isset($_SESSION['username'])): ?>
        <a href="<?php echo BASE_URL . '/logout.php' ?>" class="nav-link">Logout</a>
      <?php endif; ?>
    </nav>

    <!-- form to catch which study space is clicked and goes to the studyex page -->
    <form class="" name="page" action="studyex.php" method="post">

    <?php
    // gets study spaces in ascending order by name
      $command = "SELECT * FROM `studyspaces` ORDER BY `studyspaces`.`name` ASC";
      $result = $conn->query($command);
    // keeps track of the number of study cards put in
      $count = 0;
      while ($row = mysqli_fetch_row($result)) {
        $count = $count + 1;
        // puts specific classes depending on which number card they are for responsive reasons
        if ($count%4 == 1) {
          echo '<div class="card item one">';
        } elseif ($count%4 == 3) {
          echo '<div class="card item three">';
        } else {
          echo '<div class="card item">';
        }
        // puts image or default image depending on if it exits
        if ($row[2] == ""){
          echo '<img src="assets/images/studydef.jpg" class="card-img-top rye" alt="Ryerson Eats">';
        }
        else {
          printf('<img src="%s" class="card-img-top" alt="%s">', $row[2], $row[1]);
        }

        echo '<div class="card-body">';
        printf('<h5 class="card-title">%s</h5>',$row[1]);

        $command2 = "SELECT * FROM `reviews` WHERE `name` LIKE '$row[1]' AND `type` LIKE 'Study Spaces'";
        $reviews = $conn->query($command2);
        $num = 0;
        $sum = 0;
        // calculates average review of the study space
        while ($review = mysqli_fetch_row($reviews)) {
          $num = $num+1;
          $sum = $sum + $review[4];
        }
        //prints out rating or message if there is no rating
        if ($num == 0) {
          printf('<p class="card-text text-truncate"><b>Rating:</b> No rating yet<br>%s</p>', $row[3]);
        } else {
          printf('<p class="card-text text-truncate"><b>Rating:</b> %.2f/5<br>%s</p>', $sum/$num, $row[3]);
        }
        printf ('<button class="btn btn-primary" type="submit" name="id" value="%d">Check it Out!</button>', $row[0]);
        echo '</div></div>';

        }

        $reviews->close();
     ?>

    </form>

    <!-- clears formatting and puts text and button at the bottom of the page -->
    <p style="clear: both;">
      <br>
    <!-- aligns the content in the center and only displays the button option if a user is logged in -->
      <div style="text-align: center; <?php if (!isset($_SESSION['username'])) echo 'display: none;'?>">
          <hr>
        Can't find the study space you are looking for?
      </p>
         <!-- button to show form if it is clicked -->
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#add" aria-expanded="true" aria-controls="add">
          Add a Study Space
        </button>
      </div>


    <div class="collapse container" id="add">
      <div class="card card-body">
      <!-- form to add study space that goes to addST page (backend) -->
        <form class="" name="form" action="addST.php" method="post" onsubmit="return check()">
          <div class="form-group">
            <label for="name">Study Space Name</label>
            <input type="text" class="form-control" id="name" name="name"placeholder="">
          </div>
          <div class="form-group">
            <label for="image">Image Link</label>
            <input type="text" class="form-control" id="image" name="image" placeholder="">
          </div>
          <div class="form-group">
            <label for="review">Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="">
          </div>
          <div class="form-group">
            <label for="review">Website</label>
            <input type="text" class="form-control" id="website" name="website" placeholder="">
          </div>
          <div class="form-group">
            <label for="description">Study Space Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
          </div>
          <button class="btn btn-primary" type="submit">Submit</button>
        </form>

        <!-- javascript to validate form when inputting a restaurant -->
        <script type="text/javascript">
        function check() {
          var name = document.forms["form"]["name"].value;
          var descr = document.forms["form"]["description"].value;
          var loc = document.forms["form"]["location"].value;

          if (name == "" || descr == "" || loc == "") {
            alert("Name, Location, and Description required");
            return false;
          }

          return true;
        }

        </script>
      </div>
    </div>

    <footer><em>Copyright &#169; RyeViews 2020</em></footer>
  </body>
</html>
