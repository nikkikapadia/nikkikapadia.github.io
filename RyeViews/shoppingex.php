<?php
session_start();
//include url and base path
include("path.php");
//connect to database, access methods db.php
include(ROOT_PATH . '/app/database/connect.php');

//error checking for add review form
if (isset($_GET["error"])) {
  $error = $_GET["error"];
} else {
  $error = 0;
}

//id determines which shop info appears on page
if (isset($_GET["id"])) {
  $id = $_GET["id"];
} else {
  $id = $_POST['id'];
}

//extract shop info from shopping table depending on id
$command = "SELECT * FROM `shopping` WHERE id=$id";
$result = $conn->query($command);
$shop = mysqli_fetch_row($result);

 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1.0, minimum-scale=1.0, maximum-scale=1.0">
     <title> <?php echo $shop[1]; ?> </title>
     <!-- stylesheets (google maps api, google fonts, bootstrap, and our own stylesheet -->
     <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
     <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
   </head>
   <body>
     <script src="script.js"></script>
    <!-- error processing if review/post was not made -->
     <?php
     if ($error == 1) {
       echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert">
       Could not add post
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
       </button>
       </div>';
     }
     ?>
    <!-- title card -->
     <div class="title-card" style="background-image: url('assets/images/shopping.jpg')">
       <h1>Shopping</h1>
     </div>
     <!-- navigation bar -->
     <nav class="nav">
       <a href="index.php" class="nav-link">Home</a>
       <a href="food.php" class="nav-link">Food</a>
       <a href="study.php" class="nav-link">Study Spaces</a>
       <a href="movies.php" class="nav-link">Movies</a>
       <a href="shopping.php" class="nav-link selected">Shopping</a>
       <a href="about.php" class="nav-link">About Us</a>
       <!-- if not logged in, display login button. else display username and logout button -->
       <?php if (isset($_SESSION['username'])): ?>
         <a href="#" class="nav-link"><?php echo $_SESSION['username']; ?></a>
       <?php else: ?>
         <a href="login.php" class="nav-link">Login</a>
       <?php endif; ?>
     </nav>

<!-- extract shop info from shopping table and display it on page -->
 <div class="container">
   <?php
      $command = "SELECT * FROM `shopping` WHERE id=$id";
      $result = $conn->query($command);
      $name;
      while ($row = mysqli_fetch_row($result)) {
        echo "<br>";
        printf ("<h2>%s</h2>", $row[1]);
        $string = "SELECT * FROM `reviews` WHERE type LIKE 'Shopping' AND name Like '$row[1]'";
        $name = $row[1];
        $reviews = $conn->query($string);
        $num = 0;
        $sum = 0;
        while($rate = mysqli_fetch_row($reviews)) {
          $sum = $sum + $rate[4];
          $num = $num + 1;
        }
        if ($num == 0) {
          echo "<p><b>Rating:</b> No rating yet</p>";
        } else {
          printf ("<p>Rating: %.2f/5</p>", $sum/$num);
        }

        if ($row[2] == "") {
          echo '<img src="assets/images/shoppingdef.jpg" alt="Picture of Shopping Centre" style="width: 375px; height: 275px;">';
        } else {
          echo "<img src='$row[2]' alt='Picture of Shopping Centre' style='width: 375px; height: 275px;'>";
        }


        printf ('<br><br> <p><b>About:</b>
        %s
        </p>', $row[3]);

        printf ('<p><b>Location:</b>
          %s
        </p>', $row[4]);

        printf ('<p><b>Contact:</b><br>
          <a href="%s" target="_blank">%s Website</a>
        </p>', $row[5], $row[1]);
      }

      echo '<hr>
      <h3>Reviews</h3>';

    ?>

    <!-- form for submitting a review. visible only to visitors who are logged in -->
    <div class="card card-body" style="<?php if (!isset($_SESSION['username'])) echo 'display: none;'?>">
     <form class="" name="form" action="post_submit.php" method="post" class="post">
       <label class="heading">Write Your Post:</label>
       <div class="form-group">
         <label for="rating">Rating (out of 5)</label>
         <input type="number" min="1" max="5" id="rating" name="rating" class="form-control" required>
       </div>
       <div class="form-group">
         <label for="body">Body</label>
         <textarea id="body" name="body" class="form-control" rows="4" cols="75" required></textarea>
       </div>
       <div class="form-group" style="display: none;">
         <input type="text" id="type" name="type" value="Shopping" class="form-control" required></input>
       </div>
       <?php printf('<button class="btn btn-primary" type="submit" name="name" value="%s">Submit</button>', htmlspecialchars($name)) ?>
     </form>
   </div>

    <!-- extract and display reviews made for this shop -->
   <?php

   $command = "SELECT * FROM `reviews` WHERE  type LIKE 'Shopping' AND name LIKE '$name'";
   $test = $conn->query($command);

   while($row = mysqli_fetch_row($test)) {
     echo '<div class="card">';
     echo '<div class="card-body">';
     printf('<h4>Rating: %d/5</h4>', $row[4]);
     printf('<i>%s</i>', $row[3]);
     echo '<br> <br>';
     printf('<p>%s</p>', $row[5]);
     echo '</div>';
     echo '</div>';
   }

    ?>


 </div>

    <!-- copyright footer -->
     <footer><em>Copyright &#169; RyeViews 2020</em></footer>
   </body>
 </html>

<!-- close database connections -->
 <?php
$result->close();
$reviews->close();
$test->close();
  ?>
