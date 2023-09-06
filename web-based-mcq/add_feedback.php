<?php
$requireAuthentication = true;
$pageName = "add_feedback";
include_once './includes/head.php';

if (!isAdmin()) {
    header('location: not_allowed.php');
    exit;
}


$subjectName = '';
$errors = array();
$quizResult = null;
if (isset($_GET['quizId']) && isset($_GET['userId'])) {
    $quizResult = getStudentQuizResult($_GET['quizId'], $_GET['userId']);
}



if (isset($_POST['submit']) && isset($_GET['quizId']) && isset($_GET['userId'])) {
    $errors = createFeedback($_GET['quizId'], $_GET['userId'], $_POST['feedback']);
    if(is_null($errors)) {
        header("location: results.php");
        exit;
    }
}



?>

<section>
    <?php if (is_null($quizResult)): ?>
        <h1> Could not find the student result to add feedback! </h1>
    <?php else: ?>
        <form method="post" class=" form"
            action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?quizId=' . $_GET['quizId']. '&userId='.$_GET['userId'] ?>"
            enctype="multipart/form-data">


            <div class="container">
                <?php foreach ($errors as $error): ?>
                    <p style="color : #ff000">
                        <?= $error ?>
                    </p>
                <?php endforeach ?>

            
                <div class="form-group">
                    <label for="">
                        Add feedback for <?=$quizResult->student?>
                    </label>
                    <textarea  name="feedback" class="answerField" rows="5"> </textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-submit" name="submit">Add</button>
                </div>

            </div>
        </form>
    <?php endif ?>
</section>

<?php
include_once './includes/footer.php'
    ?>