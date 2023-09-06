<?php
$requireAuthentication = true;
$pageName = "add_quiz";
include_once './includes/head.php';
$errors =array();
if (!isAdmin()) {
    header('location: not_allowed.php');
    exit;
}

$quizName = '';
$quizDifficulty = null;
if (isset($_GET['difficulty'])) {
    $quizDifficulty = $_GET['difficulty'];
}

if(isset($_POST['difficulty']) && isset($_POST['submit'])) {
    $errors = createQuiz($_POST);
}
?>

<section>
    <?php if (is_null($quizDifficulty)): ?>
        <h1> You cannot create a quiz with an invalid difficulty level </h1>
    <?php else: ?>
        <form method="post" class="form lg"
            action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?difficulty=' . $_GET['difficulty'] ?>">


            <div class="container">
                <?php foreach ($errors as $key => $error): ?>
                    <p style="color : #ff000">
                        <?= $error ?>
                    </p>
                <?php endforeach ?>

                <div class="form-group linear">
                    <div>
                    <input id="quiz-name" type="text" placeholder="Quiz name" name="name" value="<?= $quizName ?>" required />
                </div>
                    <input type="hidden" name="difficulty" value="<?= $_GET['difficulty'] ?>" />
                    <button id="add-question-button" type="button" class="min-button success d-none" >Add a question</button>
                </div>
               
                <div id="questions-container" class="d-none">
                </div>

                <div class="form-group">
                    <button id="create-quiz-button" type="submit" class="btn-submit  d-none" name="submit" >Create quiz</button>
                </div>

            </div>
        </form>
    <?php endif ?>
</section>

<?php
include_once './includes/footer.php'
    ?>