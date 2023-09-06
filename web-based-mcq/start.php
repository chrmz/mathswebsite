<?php
$pageName = "start";
$requireAuthentication = true;
include_once './includes/head.php';


$quiz = null;
if (isset($_GET['quizid'])) {
    $quiz = getQuiz($_GET['quizid'], true);
}
?>

<section id="start-home">
    <?php if (is_null($quiz)): ?>
        <h1>Quiz does not exists</h1>
    <?php else: ?>
        <h2>Start Quiz - <?= $quiz['name'] ?> </h2>
        <p>
            Prepare for your test, as you will be time limited when asnwering these questions.
        </p>
        <p>
           Difficulty :  <?= $quiz['difficulty'] ?>
        </p>
        <p>
           Total time needed :  <?= $quiz['timeLimit'] ?>
        </p>
        <div class="btn">
            <a class="blue" href="student_quiz_questions.php?quizid=<?= $quiz['id'] ?>&question=0">Attempt Quiz</a>
            <a class="red" href="student_quiz_details.php?difficulty=<?= $quiz['difficulty'] ?>">Go Back</a>
        </div>
    <?php endif ?>
</section>

<?php
include_once './includes/footer.php'
    ?>