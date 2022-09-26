<?php
// include files that contain database helper functions, and 
// functions to validate user registration and login
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/validateUser.php");

// initialize array that will contain error messages for registration and login
$errors = array();
$lErrors = array();

// initialize user variables
$username = '';
$password = '';
$lusername = '';
$lpassword = '';
$table = 'usertable';

// creates session variables
function loginUser($user)
{
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['message'] = 'Successfully logged in';
    $_SESSION['type'] = 'success';
    header('location: ' . BASE_URL . '/index.php' );
    exit();
}

// User registration
if (isset($_POST['register-btn']))
{   // populates errors array with validation errors
    $errors = validateUser($_POST);
    // if no errors, log the user in
    if (count($errors) === 0)
    {
        unset($_POST['register-btn']);
        // password  gets hashed
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // user is created, then passed into the $user variable
        $user_id = create($table, $_POST);
        $user = selectOne($table, ['user_id' => $user_id]);

        loginUser($user);
    }
    // if errors exist, repopulate the field with information provided by
    // the user. This will help reduce frustration in filling out fields
    else
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
    }
}

// User login
if (isset($_POST['login-btn']))
{
    $errors = validateLogin($_POST);

    if (count($lErrors) === 0)
    {
        $user = selectOne($table, ['username' => $_POST['username']]);
        // if a user exists and password matches hashed password, login
        if ($user && password_verify($_POST['password'], $user['password']))
        {

            loginUser($user);
        }
        else
        {
            array_push($lErrors, 'Wrong credentials');
        }
    }

    $lusername = $_POST['username'];
    $lpassword = $_POST['password'];
}
