<?php 
$requireAuthentication = true;
$pageName = "template";
include_once './includes/head.php';
// uncomment and delete below if you want to grant this page to only admins
// if(!isAdmin()) {
//     header('location: not_allowed.php');
//     exit;
// }


// uncomment and delete above if you want to grant this page to only students
// if(!isStudent()) {
//     header('location: not_allowed.php');
//     exit;
// }
?>


<?php 
    include_once './includes/footer.php'
?>