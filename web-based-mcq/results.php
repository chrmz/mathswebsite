<?php 
$pageName = "quiz_results";
$requireAuthentication = true;
include_once './includes/head.php';
if(!isAdmin()) {
    header('location: not_allowed.php');
    exit;
}

$results = getStudentsQuizResult(); 

?>

<section>
    <div class="container">
    <?php if (is_null( $results)) : ?>
        <h1> Could not get results for this quiz</h1>
    <?php else : ?>
        <table class="styled-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Quiz Name</th>
                <th>Difficulty</th>
                <th>Outcome</th>
                <th>Grade / Percentage</th>
                <th>FeedbackS</th>
                <th>Add Feedback</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $key => $result) : ?>
                <tr>
                        <td><?=$result->student?></td>
                        <td><?=$result->quiz_name?></td>
                        <td><?=$result->difficulty?></td>
                        <td><?=$result->result?></td>
                        <td><?=$result->grade?> / <?=ceil($result->grade_percentage)?>%</td>
                        <td><?=$result->number_of_feedbacks?> <a href="feedbacks.php?quizId=<?=$result->quiz_id?>&userId=<?=$result->user_id?>"> show all</a></td>
                        <td><a href="add_feedback.php?quizId=<?=$result->quiz_id?>&userId=<?=$result->user_id?>"> Add</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
            

        </table>

    <?php endif ?>
</section>







<?php 
    include_once './includes/footer.php'
?>