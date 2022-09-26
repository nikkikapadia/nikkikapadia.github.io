<?php include("path.php"); ?>

<?php include(ROOT_PATH . "/app/controllers/users.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Login and Registration</title>
	<link rel="stylesheet" type="text/css" href="assets/css/loginstyle.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

	<div class="container">
		<div class="login-box">
			<div class="row">

				<div class="col-md-6 login-left">
					<h2>Login Here</h2>
					<form action="login.php" method="post">
						<div class="form-group">
						    <!--if the login is not validated, errors will get displayed -->
						    <?php include(ROOT_PATH . "/app/helpers/loginError.php"); ?>
							<label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="login-btn" class="btn btn-primary">Login</button>
            </form>
        </div>

        <div class="col-md-6 login-right">
            <h2>Register Here</h2>
            <form action="login.php" method="post">
                <div class="form-group">
                    <!--if the registration is not validated, errors will get displayed -->
                    <?php include(ROOT_PATH . "/app/helpers/registrationError.php"); ?>
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo $username; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" value="<?php echo $password; ?>" class="form-control">
                </div>
                <button type="submit" name="register-btn" class="btn btn-primary">Register</button>
            </form>
        </div>

        </div>
        </div>
    </div>

</body>
</html>
