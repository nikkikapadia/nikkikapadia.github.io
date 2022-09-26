<?php

// validates user registration. If a certain field is empty, a corresponding
// error message will be pushed to the $errors array. 

function validateUser($user)
{


    $errors = array();

    if (empty($user['username']))
    {
        array_push($errors, 'Username is required');
    }

    if (empty($user['password']))
    {
        array_push($errors, 'Password is required');
    }

    $existingUser = selectOne('usertable', ['username' => $user['username']]);
    if (isset($existingUser))
    {
        array_push($errors, 'Username already exists');
    }

    return $errors;
}


// validates user login. If a certain field is empty, a corresponding
// error message will be pushed to the $lErrors array. 

function validateLogin($user)
{


    $lErrors = array();

    if (empty($user['username']))
    {
        array_push($lErrors, 'Username is required');
    }

    if (empty($user['password']))
    {
        array_push($lErrors, 'Password is required');
    }

    return $lErrors;
}
