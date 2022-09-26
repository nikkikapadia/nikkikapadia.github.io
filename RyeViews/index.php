<?php
//include url and base path
include("path.php");
//connect to database, access methods db.php
include(ROOT_PATH . "/app/database/db.php");
//include(ROOT_PATH . '/app/database/connect.php');

?>

<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="refresh" content="300">
    <title>RyeViews</title>
    <!-- all of the stylesheets and outside sources (google fonts, bootstrap, and our own stylesheet)-->
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
    <!-- title area -->
    <div class="title-card" style="background-image: url('assets/images/ryerson.jpg')">
    <!-- <div class="title-card" style="background: linear-gradient(rgba(0, 0, 50, 0.5), rgba(0, 0, 50,0.5)), url('assets/images/ryerson.jpg'); background-position: center;"> -->
      <img src="assets/images/RyeViews4.png" alt="RyeViews Logo" class="center">
      <!-- <h1>RyeViews</h1> -->
    </div>
    <!-- navigation -->
    <nav class="nav">
      <a href="index.php" class="nav-link selected">Home</a>
      <a href="food.php" class="nav-link">Food</a>
      <a href="study.php" class="nav-link">Study Spaces</a>
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

   <div class="row">
     <!-- column of cards for top places in each category -->
      <div class="largecol">

        <!-- top restaurant card -->
        <div class="card">
          <div class="card-header">
            Top Restaurant
          </div>
          <div class="card-body">
            <?php
              $command = "SELECT * FROM `restaurants`";
              $result = $conn->query($command);
              $highestRating = 0;
              $name = "";
              // goes through each restaurant and checks for the highest rated restaurant
              while ($row = mysqli_fetch_row($result)) {
                $command2 = "SELECT * FROM `reviews` WHERE `name` LIKE '$row[1]' AND `type` LIKE 'Food'";
                $reviews = $conn->query($command2);
                $num = 0;
                $sum = 0;
                // calculates average review
                while ($review = mysqli_fetch_row($reviews)) {
                  $num = $num+1;
                  $sum = $sum + $review[4];
                }
                if ($num != 0) {
                  if ($sum/$num > $highestRating) {
                    $highestRating = $sum/$num;
                    $name = $row[1];
                  }
                }
              }
                $reviews->close();
                $command = "SELECT * FROM `restaurants` WHERE name LIKE '$name'";
                $result = $conn->query($command);
                //extracting reataurant info
                while ($row = mysqli_fetch_row($result)) {
                  // puts the image
                  if ($row[2] == "") {
                ?>
                  <img src="fooddef.jpg" class="main" style="height: 40%; width:40%;">
                <?php
              } else {
                ?>
               <img src=<?php echo $row[2]; ?> class="main" style="height: 40%; width:40%;">
            <?php }?>
            <!-- put the info of the restaurant -->
            <h5 class="card-title"><?php echo $row[1]; ?></h5>
            <p class="card-text"> <b>Rating: </b> <?php printf ("%.2f",$highestRating); ?>
            <br><?php echo $row[3] ?> </p>
            <a href="foodex.php?id=<?php echo $row[0];  ?>" class="btn btn-primary">Go To Page</a>
            <?php
              }
            ?>
          </div>
        </div>

        <!-- top study space card -->
        <div class="card">
          <div class="card-header">
            Top Study Space
          </div>
          <div class="card-body">
            <?php
              $command = "SELECT * FROM `studyspaces`";
              $result = $conn->query($command);
              $highestRating = 0;
              $name = "";
              // finds study space with highest average review
              while ($row = mysqli_fetch_row($result)) {
                $command2 = "SELECT * FROM `reviews` WHERE `name` LIKE '$row[1]' AND `type` LIKE 'Study Spaces'";
                $reviews = $conn->query($command2);
                $num = 0;
                $sum = 0;
                while ($review = mysqli_fetch_row($reviews)) {
                  $num = $num+1;
                  $sum = $sum + $review[4];
                }
                if ($num != 0) {
                  if ($sum/$num > $highestRating) {
                    $highestRating = $sum/$num;
                    $name = $row[1];
                  }
                }
              }
                $reviews->close();
                $command = "SELECT * FROM `studyspaces` WHERE name LIKE '$name'";
                $result = $conn->query($command);
                // extracts info for highest rated study space
                while ($row = mysqli_fetch_row($result)) {
                  if ($row[2] == "") {
                ?>
                  <img src="studydef.jpg" class="main" style="height: 40%; width:40%;">
                <?php
              } else {
                ?>
               <img src=<?php echo $row[2]; ?> class="main" style="height: 40%; width:40%;">
            <?php }?>
            <!-- name, rating and description printed out -->
            <h5 class="card-title"><?php echo $row[1]; ?></h5>
            <p class="card-text"> <b>Rating: </b> <?php printf ("%.2f",$highestRating); ?>
            <br><?php echo $row[3] ?> </p>
            <a href="studyex.php?id=<?php echo $row[0];  ?>" class="btn btn-primary">Go To Page</a>
            <?php
              }
            ?>
          </div>
        </div>

        <!-- card for top movie -->
        <div class="card">
          <div class="card-header">
            Top Movie
          </div>
          <div class="card-body">
            <?php
              $command = "SELECT * FROM `movies`";
              $result = $conn->query($command);
              $highestRating = 0;
              $name = "";
              // goes through each movie and calculates rating for each to find the highest rated movie
              while ($row = mysqli_fetch_row($result)) {
                $command2 = "SELECT * FROM `reviews` WHERE `name` LIKE '$row[1]' AND `type` LIKE 'Movies'";
                $reviews = $conn->query($command2);
                $num = 0;
                $sum = 0;
                // calculating rating
                while ($review = mysqli_fetch_row($reviews)) {
                  $num = $num+1;
                  $sum = $sum + $review[4];
                }
                if ($num != 0) {
                  if ($sum/$num > $highestRating) {
                    $highestRating = $sum/$num;
                    $name = $row[1];
                  }
                }
              }
                $reviews->close();
                $command = "SELECT * FROM `movies` WHERE name LIKE '$name'";
                $result = $conn->query($command);
                // prints info for top rated movie
                while ($row = mysqli_fetch_row($result)) {
                  if ($row[2] == "") {
                ?>
                  <img src="moviesdef.jpg" class="main" style="height: 40%; width:40%;">
                <?php
              } else {
                ?>
               <img src=<?php echo $row[2]; ?> class="main" style="height: 40%; width:40%;">
            <?php }?>
            <h5 class="card-title"><?php echo $row[1]; ?></h5>
            <p class="card-text"> <b>Rating: </b> <?php printf ("%.2f",$highestRating); ?>
            <br><?php echo $row[3] ?> </p>
            <a href="moviesex.php?id=<?php echo $row[0];  ?>" class="btn btn-primary">Go To Page</a>
            <?php
              }
            ?>
          </div>
        </div>

        <!-- card for top shopping spot -->
        <div class="card">
          <div class="card-header">
            Top Shopping Spot
          </div>
          <div class="card-body">
            <?php
              $command = "SELECT * FROM `shopping`";
              $result = $conn->query($command);
              $highestRating = 0;
              $name = "";
              // goes through each shopping spot to find the highest rated one
              while ($row = mysqli_fetch_row($result)) {
                $command2 = "SELECT * FROM `reviews` WHERE `name` LIKE '$row[1]' AND `type` LIKE 'Shopping'";
                $reviews = $conn->query($command2);
                $num = 0;
                $sum = 0;
                // calculates ratings and finds highest rating
                while ($review = mysqli_fetch_row($reviews)) {
                  $num = $num+1;
                  $sum = $sum + $review[4];
                }
                if ($num != 0) {
                  if ($sum/$num > $highestRating) {
                    $highestRating = $sum/$num;
                    $name = $row[1];
                  }
                }
              }
                $reviews->close();
                $command = "SELECT * FROM `shopping` WHERE name LIKE '$name'";
                $result = $conn->query($command);
                // gets info for highest rated shopping spot
                while ($row = mysqli_fetch_row($result)) {
                  if ($row[2] == "") {
                ?>
                  <img src="shoppingdef.jpg" class="main" style="height: 40%; width:40%;">
                <?php
              } else {
                ?>
               <img src=<?php echo $row[2]; ?> class="main" style="height: 40%; width:40%;">
            <?php }?>
            <h5 class="card-title"><?php echo $row[1]; ?></h5>
            <p class="card-text"> <b>Rating: </b> <?php printf ("%.2f",$highestRating); ?>
            <br><?php echo $row[3] ?> </p>
            <a href="shoppingex.php?id=<?php echo $row[0];  ?>" class="btn btn-primary">Go To Page</a>
            <?php
              }
            ?>
          </div>
        </div>

      </div>

    <!-- small right column for the latest review and google maps -->
      <div class="smallcol">
        <!-- latest review side card -->
        <div class="card border-secondary mb-3">
          <div class="card-body text-secondary">
            
            <?php
            // gets the latest review
            $command = "SELECT * FROM `reviews` ORDER BY `reviews`.`date_created` DESC";
            $result = $conn->query($command);
            $row = mysqli_fetch_row($result);
            ?>
            <!-- prints out the info for the latest review -->
            <h5 class="card-title">Check out the Latest Review!</h5>
            <p class="card-text"> <b><?php echo $row[2]; ?> </b> </p>
            <p class="card-text"> <b>Rating:</b> <?php printf("%d", $row[4]); ?> <br>
            <?php echo $row[5]; ?>  <br> <i>-<?php echo $row[3]; ?></i> </p>
          </div>
        </div>
        <!-- card for the integrated google maps API -->
        <div class="card border-secondary mb-3">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2886.5438230600375!2d-79.3809903850329!3d43.65765847912117!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89d4cb35431c1395%3A0xe8ed8bd69125d6f4!2sRyerson%20University!5e0!3m2!1sen!2sca!4v1606882054690!5m2!1sen!2sca" width="" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
      </div>
      </div>
   </div>
    <!-- Copyright footer -->
    <footer><em>Copyright &#169; RyeViews 2020</em></footer>
  </body>
</html>
