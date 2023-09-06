<?php


function sanitize($data){
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn,$data);
}

/* * * * * * * * * * * * * * * * * * * * *
* - Escapes form submitted value, hence, preventing SQL injection
* * * * * * * * * * * * * * * * * * * * * */
function esc(String $value){
    // bring the global db connect object into function
    global $conn;
    // remove empty space sorrounding string
    $val = trim($value); 
    $val = mysqli_real_escape_string($conn, $value);
    return $val;
}


function logged_in()
{
  return (isset($_SESSION['user']));
}

function isStudent() {
    return logged_in() && $_SESSION['user']['role'] === 'Student';
}

function isAdmin() {
    return logged_in() && $_SESSION['user']['role'] ===  'Admin';
}

function empty_or_null($var)
{
    return empty($var) || is_null($var);
}