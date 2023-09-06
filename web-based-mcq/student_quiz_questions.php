<?php
$pageName = "quiz_details";
$requireAuthentication = true;
include_once './includes/head.php';
if (!isStudent()) {
    header('location: not_allowed.php');
    exit;
}

if (isset($_POST['submit'])) {
    $totalQuizQuestion = getTotalQuizQuestions(isset($_GET['quizid']) ? $_GET['quizid'] : null);
    $questionIndex = (isset($_GET['question']) ? $_GET['question'] : 0);

    $answers = [];
    if (isset($_POST['answersId'])) {
        foreach ($_POST['answersId'] as $key => $answer) {
            if (isset($_POST['choices'][$answer])) {
                $answers[] = $answer;
            }
        }
    }
    updateUserQuizTrack($_GET['trackId'], $_GET['questionId'], $_GET['question'], $answers);

    if ($totalQuizQuestion == $questionIndex) {
        header('location: student_quiz_results.php?quizid=' . $_GET['quizid']);
        exit;
    } else {

        header('location:student_quiz_questions.php?quizid=' . $_GET['quizid'] . '&question=' . $_GET['question']);
        exit;
    }
}

$question = null;
if (isset($_GET['quizid']) && $_SESSION['user']) {
    $questionIndex = isset($_GET['question']) ? $_GET['question'] : 0;
    $track = trackUserQuiz($_GET['quizid'], $questionIndex, $_SESSION['user']['id']);
    $question = getQuizQuestion($_GET['quizid'], $track['question_offset']);
    $timeLeft = is_null($track['time_left']) ? $question['quiz_time'] : $track['time_left'];
}


?>

<section>
    <div class="container">

        <?php if (is_null($question)): ?>
            <h1>Quiz does not exists</h1>
        <?php else: ?>
            <form method="post" class="form lg"
                action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?quizid=' . $_GET['quizid'] . ' &question=' . ($questionIndex + 1) . '&trackId=' . $track['id'] . '&questionId=' . $question['id'] ?>">

                <div class="each-question-container">
                    <h3>
                        Q. &nbsp;
                        <?= $question['question'] ?>
                    </h3>
                    <h4>
                        Time left for this question <span id="countDown" data-time="<?= $timeLeft ?>"> </span>
                        <input type="hidden" name="timeLeft" value="<?= $timeLeft ?>" />
                        <input type="hidden" id="trackId" name="trackId" value="<?= ($track['id']) ?>" />
                    </h4>
                    <div class="">
                        <?php foreach ($question['answers'] as $key => $answer): ?>
                            <input type="checkbox" name="choices[<?= $answer['id'] ?>]" <?= $timeLeft == 1 ? "disabled='disabled'" : '' ?>> &nbsp; <?= $answer['answer'] ?> <br />
                            <input type="hidden" name="answersId[]" value="<?= $answer['id'] ?>" />
                        <?php endforeach ?>
                    </div>
                    <div>
                        <?php if ($questionIndex > 0): ?>
                            <a href="student_quiz_questions.php?quizid=<?= $_GET['quizid'] ?>&question=<?= ($questionIndex - 1) ?>"
                                class="min-button info">Prev </a>
                        <?php endif ?>
                        <button class="min-button success" type="submit" name="submit">Next</button>
                    </div>
                </div>
            </form>
        <?php endif ?>

    </div>


</section>

<?php
include_once './includes/footer.php'
    ?>