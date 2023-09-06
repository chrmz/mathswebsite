<?php
$pageName = "quiz_details";
$requireAuthentication = true;
include_once './includes/head.php';
if (!isAdmin()) {
    header('location: not_allowed.php');
    exit;
}

$quiz = null;
if (isset($_GET['quizid'])) {
    $quiz = getQuiz($_GET['quizid'], true);
}
?>

<section>
    <div class="container">

        <?php if (is_null($quiz)): ?>
            <h1>Quiz does not exists</h1>
        <?php else: ?>
            <h1>
                <?= $quiz['name'] ?>
            </h1>
         
            <h3>Difficulty :
                <?= $quiz['difficulty'] ?>
            </h3>
           
           
                <?php foreach ($quiz['questions'] as $key => $question): ?>
                    <div class="each-question-container">
                        <h3>
                          Q. &nbsp;  <?= $question['question'] ?> 
                        </h3>
                        <h4>
                          T. &nbsp;  <?= ($question['quiz_time']/60) ?> minutes
                        </h4>
                        <div class="">
                            <?php foreach ($question['answers'] as $key => $answer): ?>

                                <p style="color : #<?=$answer['correct'] ? '00ff00' : 'ff0000'?>"> Option <?=$key +1?>) &nbsp; <?=$answer['answer']?> </p>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endforeach ?>
           
        <?php endif ?>

    </div>


</section>

<?php 
    include_once './includes/footer.php'
?>