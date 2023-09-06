<?php 
$pageName = "quiz";
$requireAuthentication = true;
include_once './includes/head.php';
if(!isStudent()) {
    header('location: not_allowed.php');
    exit;
}

$results = getCurrentSessionStudentQuizResult();
?>

<section>
    <div class="container">
    <?php if (is_null( $results)) : ?>
        <h1> Could not get results for this quiz</h1>
    <?php else : ?>
        <table class="styled-table">
        <thead>
            <tr>
                <th>Quiz Name</th>
                <th>Difficulty</th>
                <th>Score</th>
                <th>Grade / Percentage</th>
                <th>Feedbacks</th>
              
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $key => $result) : ?>
                <tr>
                        <td><?=$result->quiz_name?></td>
                        <td><?=$result->difficulty?></td>
                        <td><?=$result->result?></td>
                        <td><?=$result->grade?> / <?=ceil($result->grade_percentage)?>%</td>
                        <td><?=$result->number_of_feedbacks?> <a href="feedbacks.php?quizId=<?=$result->quiz_id?>&userId=<?=$result->user_id?>"> show all</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
            

        </table>

    <?php endif ?>
</section>



<?php 
    include_once './includes/footer.php'
?>