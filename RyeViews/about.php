<?php
//include url and base path
include("path.php");
//connect to database, access methods db.php
include(ROOT_PATH . "/app/database/db.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <title>About Us</title>
    <!-- stylesheets (google maps api, google fonts, bootstrap, and our own stylesheet -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <script src="assets/js/script.js"></script>
    <!-- title card -->
    <div class="title-card" style="background-image: url('assets/images/ryerson.jpg')">
      <img src="assets/images/RyeViews3.png" alt="RyeViews Logo" class="center">
      <!-- <h1>RyeViews</h1> -->
    </div>
    <!-- navigation bar -->
    <nav class="nav">
      <a href="index.php" class="nav-link">Home</a>
      <a href="food.php" class="nav-link">Food</a>
      <a href="study.php" class="nav-link">Study Spaces</a>
      <a href="movies.php" class="nav-link">Movies</a>
      <a href="shopping.php" class="nav-link">Shopping</a>
      <a href="about.php" class="nav-link selected">About Us</a>
      <!-- if not logged in, display login button. else display username and logout button -->
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
       <!-- column of information cards -->
      <div class="largecol">
          <!-- who are we card - explains who we are and why we made the website -->
        <div class="card">
          <div class="card-body">
            <h3>Who are we?</h3>
            <p class="card-text">Hello and welcome to RyeViews! Our names are Christian, Nikki, and Khushdip and we are hoping to improve your experience around Ryerson's campus. We are a group of students that are trying to make life a little easier for all the hardworking people at Ryerson. When we started our first year at Ryerson, there were so many things around campus that we didn't know about! With so many places to eat, things to do, and places to go in Downtown Toronto, it can be hard to choose what you want to do after your classes, especially for new students. This is why we made RyeViews.</p>
          </div>
        </div>
        <!-- what is RyeViews card - explains what is possible with RyeViews and its main purpose -->
        <div class="card">
          <div class="card-body">

            <h3>What is RyeViews?</h3>
            <p class="card-text">RyeViews is a website where people can share their reviews and experiences of different activities around Ryerson campus. Students and Faculty at Ryerson can see the top things to do in each category and explore many other options on each page. Users can make an account to post reviews and add some of their favourite places or activities. RyeViews isn't just for Ryerson, it is also for people who are situated around campus. Use RyeViews to help plan your campus visit!</p>
          </div>
        </div>
      </div>

        <!-- small column for contact and google maps cards -->
      <div class="smallcol">
        <!-- contact us card (note the phone number is fake... don't try to call it) -->
        <div class="card border-secondary mb-3">
          <div class="card-body text-secondary">
            <h5 class="card-title">Contact Us:</h5>
            <p class="card-text">Phone: (416)123-4567<br>Email: ryeviews@gmail.com</p>
          </div>
        </div>
        <!-- google maps card with scrollable google maps functionality -->
        <div class="card border-secondary mb-3">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2886.5438230600375!2d-79.3809903850329!3d43.65765847912117!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89d4cb35431c1395%3A0xe8ed8bd69125d6f4!2sRyerson%20University!5e0!3m2!1sen!2sca!4v1606882054690!5m2!1sen!2sca" width="" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>

      </div>
   </div>
    <!-- copyright footer -->
    <footer><em>Copyright &#169; RyeViews 2020</em></footer>
  </body>
</html>
