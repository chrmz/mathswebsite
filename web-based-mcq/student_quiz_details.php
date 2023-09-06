<?php
$pageName = "quiz_details";
$requireAuthentication = true;
include_once './includes/head.php';
if(!isStudent()) {
    header('location: not_allowed.php');
    exit;
}

$quizType = null;
if (isset($_GET['difficulty'])) {
    $quizType = getQuizesByDifficulty($_GET['difficulty']);
}
?>

<section>
    <div class="container">

        <?php if (is_null($quizType)): ?>
            <h1>Quiz type does is invalid</h1>
        <?php else: ?>
         
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Topic</th>
                        <th>Total questions</th>
                        <th>Time limit</th>
                        <th>Start quiz</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quizType as $key => $quiz): ?>
                        <tr>
                            <td>
                                <?= $quiz['name']?>
                            </td>
                            <td>
                                <?= sizeof($quiz['questions']) ?>
                            </td>
                            <td>
                                <?= ($quiz['timeLimit']) ?>
                            </td>
                            <td> <a href="start.php?quizid=<?= $quiz['id']?>">Start</a></td>
                            
                        </tr>
                    <?php endforeach ?>


                </tbody>
            </table>
        <?php endif ?>

    </div>


</section>