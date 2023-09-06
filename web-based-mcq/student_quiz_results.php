<?php 
$pageName = "students";
$requireAuthentication = true;
include_once './includes/head.php';
if(!isStudent()) {
    header('location: not_allowed.php');
    exit;
}

$results = null;
if (isset($_GET['quizid'])) {
    $results = markStudentResult($_GET['quizid'], $_SESSION['user']['id']);
}


?>
<section>
    <div class="container">
    <?php if (is_null( $results)) : ?>
        <h1> Could not get results for this quiz</h1>
    <?php else : ?>
    <table class="styled-table">
    <thead>
        <tr>
            <th>Total questions</th>
            <th>Total Correct Mark</th>
            <th>Total Wrong Mark</th>
            <th>Wrong Questions</th>
            </tr>
    </thead>
        <tbody>
            <tr>
                <td>
                    <?= $results ['totalQuestions']?>
                </td>
                <td>
                <?= ($results ['correctAnswers']) ?>  
                </td>
                <td>
                    <?= sizeof($results ['wrong']) ?>  
                </td>
                <td>
                    <h1 style="color:red">You got these questions wrong</h1>
                    <ol>
                        <?php foreach ($results['wrong'] as $key => $wrong) : ?>
                        <li style="color:red"><?=$wrong['question']?></li> 
                        <?php endforeach ?>
                    </ol>
                </td>
            </tr>
        </tbody>
    </table>
        <?php endif ?>
    </div>
    </section>
<?php 
    include_once './includes/footer.php'
?>