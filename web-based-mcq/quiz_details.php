<?php
$pageName = "quiz_details";
$requireAuthentication = true;
include_once './includes/head.php';
if (!isAdmin()) {
    header('location: not_allowed.php');
    exit;
}

$quizType = null;
if (isset($_GET['difficulty'])) {
    $quizType = getQuizesByDifficulty($_GET['difficulty'], true);
}

if (isset($_POST['delete-quiz'])) {
    deleteQuiz($_POST['quiz-id'], $_GET['difficulty']);
}
?>

<section>
    <div class="container">

        <?php if (is_null($quizType)): ?>
            <h1>Quiz type does is invalid</h1>
        <?php else: ?>
            <div>
                <a href="add_quiz.php?difficulty=<?= $_GET['difficulty'] ?>" class="add-module mb">Add a new Quiz</a>
            </div>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Topic</th>
                        <th>Total questions</th>
                        <th>Time limit</th>
                        <th>Show questions</th>
                        <th>Delete quiz</th>
                        <th>Edit quiz</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quizType as $key => $quiz): ?>
                        <tr>
                            <td>
                                <?= $quiz['name'] ?>
                            </td>
                            <td>
                                <?= sizeof($quiz['questions']) ?>
                            </td>
                            <td>
                                <?= ($quiz['timeLimit']) ?>
                            </td>
                            <td> <a href="admin_quiz_questions.php?quizid=<?= $quiz['id'] ?>">Questions</a></td>
                            <td><button id="removequiz"
                                    onclick="removeQuiz('<?= $quiz['name'] ?>','<?= $quiz['id'] ?>')" class="modal-toggle">Delete</button></td>
                            <!--<Remove Subject button>-->
                            <td> <a href="#">Edit</a></td>
                        </tr>
                    <?php endforeach ?>


                </tbody>
            </table>

            <div>
                <div id="modal" class="modal-content">
                    <div class="modal-header">
                        <span class="modal-close">&times;</span>
                        <h2>Modal Header</h2>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete <span id="quiz-name"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-close">Cancel</button>
                        <form method="post"
                            action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?difficulty=' . $_GET['difficulty'] ?>">
                            <input id="quiz-id" name="quiz-id" type="hidden" value="">
                            <button type="submit" name="delete-quiz">Remove Quiz</button>
                        </form>
                    </div>
                </div>

            </div>

        <?php endif ?>

    </div>


</section>

<?php  include_once './includes/footer.php'  ?>