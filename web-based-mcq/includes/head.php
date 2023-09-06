<?php
require_once('./config/config.php');
require_once('./functions/functions.php');
require_once('./functions/public_functions.php');

if ($requireAuthentication && !(logged_in())){
    header('location: login.php');
    exit;
}
 if(isAdmin()) {
    require_once('./functions/admin_functions.php');
 }
 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,200&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@800&display=swap" rel="stylesheet">
    <title>MatheMania - <?=$pageName?></title>

    <!--icon scout cdn link-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/additional_styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<body class="<?=$pageName?>">


    <!--header section starts-->
   <?php if($pageName === 'login' || $pageName === 'signup') : ?>
    <?php else : ?>
    <nav>
        <img src="images/mathmania.png" alt="">
        <div class="navigation">
            <ul>
                <?php if(!logged_in()): ?>
                <li><a href="index.php">Home</a></li>
                <?php endif ?>
                <?php if(isAdmin()): ?>
                    <li><a href="modules.php">Modules</a></li>
                    <li><a href="students.php">Students</a></li>
                    <li><a href="results.php">Results</a></li>
                    <li><a href="quizzes.php">Quizzes</a></li>
                <?php endif ?>
                <?php if(isStudent()): ?>
                    <li><a href="student_quizzes.php">Quiz</a></li>
                    <li>
                    <a href="modules_student.php">Modules</a>
                    <!--<ul class="dropdown">
                        <?php foreach (getModules(false) as $key => $module)  : ?>
                            <li><a href="student_revision_details.php?subject_id=<?=$module['id']?>"><?=$module['name']?></a></li>
                        <?php endforeach ?>
                       </ul>-->
                    </li>
                    <li><a href="student_results.php">Feedback</a></li>
                <?php endif ?>
                
                
                <?php if(!logged_in()): ?>
                    <li><a href="signup.php">Register</a></li>
                        <li><a href="login.php">Login</a></li>
                <?php endif ?>
                <?php if(logged_in()): ?>
                    <li><a href="logout.php">Logout</a></li>
               
                    <li>
                        <a href="#"><i class="uil uil-bars"></i></a>
                        <ul class="dropdown3">
                            <li><a href="#">Notifications</a></li>
                            <li><a href="#">Security</a></li>
                            <li><a href="#">Insights</a></li>
                            <li><a href="#">Favourites</a></li>
                            <li><a href="#">Discovery</a></li>
                            <li><a href="#">Shop</a></li>
                        </ul>
                    </li>
                <?php endif ?>
            </ul>

        </div>
    </nav>
<?php endif ?>