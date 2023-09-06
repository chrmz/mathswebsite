<?php 
$pageName = "quiz_results";
$requireAuthentication = true;
include_once './includes/head.php';
$feedbacks = null;

if(isset($_GET['userId']) && isset($_GET['quizId'])  ){
    $feedbacks = getFeedbacks($_GET['quizId'],  $_GET['userId']);
}



?>

<section>
    <div class="container">
    <?php if (is_null( $feedbacks) || count($feedbacks) == 0) : ?>
        <h1>No feed back</h1>
        <?php else : ?>
            <h1>Feeback for student <?= $feedbacks[0]->student?> and quiz <?=  $feedbacks[0]->quiz?> </h1>
       
            <?php foreach ($feedbacks as $key => $feedback) : ?>
               <p style="border : 1px solid lightgray; margin: 20px 0"><?= $feedback->feedback?></p>
            <?php endforeach ?>

    <?php endif ?>
</section>







<?php 
    include_once './includes/footer.php'
?>