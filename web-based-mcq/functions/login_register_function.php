<?php




function login($username, $password) {
    global $conn;
    $errors = array();
    $username = esc($username);
    $password = esc($password);

    if (empty($username)) { array_push($errors, "Username required"); }
    if (empty($password)) { array_push($errors, "Password required"); }
    if (empty($errors)) {

        $sql = "SELECT * FROM users WHERE email='$username'  LIMIT 1";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // get id of created user
            $reg_user_id = mysqli_fetch_assoc($result)['id']; 
            $user =  getUserById($reg_user_id);
            if (password_verify($password, $user['password']))
            {
             
                    // put logged in user into session array
                    $_SESSION['user'] = $user; 

                    // if user is admin, redirect to admin area
                    if ($_SESSION['user']['role'] === "Admin")
                    {
                        // $_SESSION['message'] = "You are now logged in";
                        // redirect to admin area
                        header('location: modules.php');
                        exit(0);
                    } else {
                        $_SESSION['message'] = "You are now logged in";
                        // redirect to student area
                        header('location: student_quizzes.php');				
                        exit(0);
                    }

            }
            else
            {
            array_push($errors, 'Wrong credentials');
            }
        } else {
            array_push($errors, 'Wrong credentials');
        }
    }

    return $errors;
}



function register($firstName, $lastName, $email, $password_1, $password_2) {
	$errors = array();

    $firstName = esc($firstName);
    $lastName = esc($lastName);
    $email = esc($email);
    $password_1 = esc($password_1);
    $password_2 = esc($password_2);

    // form validation: ensure that the form is correctly filled
    if (empty($firstName)) {  array_push($errors, "Uhmm...We gonna need your first name"); }
    if (empty($lastName)) {  array_push($errors, "Uhmm...We gonna need your last name"); }
    if (empty($email)) { array_push($errors, "Oops.. Email is missing"); }
    if (empty($password_1)) { array_push($errors, "uh-oh you forgot the password"); }
    if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match");}

    // Ensure that no user is registered twice. 
    // the email and usernames should be unique
    $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";

    global $conn;
    
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = password_hash($password_1, PASSWORD_DEFAULT);//encrypt the password before saving in the database
        $query = "INSERT INTO users (first_name, last_name, email, password, `role`) 
                    VALUES('$firstName', '$lastName', '$email', '$password', 'Student')";
        mysqli_query($conn, $query);

        // get id of created user
        $reg_user_id = mysqli_insert_id($conn); 

        // put logged in user into session array
        $_SESSION['user'] = getUserById($reg_user_id);

    
        header('location: student_quizzes.php');				
        exit(0);
        
    } else {
        return $errors;
    }
	
}


function getUserById($id){
	global $conn;
	$sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_assoc($result);

	return $user; 
}
