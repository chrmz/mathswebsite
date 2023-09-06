<?php
$pageName = "quiz";
$requireAuthentication = true;
include_once './includes/head.php';
if (!isAdmin()) {
    header('location: not_allowed.php');
    exit;
}
?>

<section id="quiz-features">
    <h1>Quizzes</h1>
    <div class="fea-base">
    <?php foreach (getQuizzes() as $key => $quiz) : ?>
        <div class="fea-box">
            <i class="fa-solid fa-user"></i>
            <img src="images/<?=$quiz['image']?>" alt="<?=$quiz['name']?>">
            <h3>
                <a href="quiz_details.php?difficulty=<?=$quiz['name']?>"><?=$quiz['name']?> - <?=$quiz['quizzes']?> quiz/quizzes</a>
            </h3>
        </div>
        <?PHP endforeach ?>
    </div>
</section>

<?php
include_once './includes/footer.php'
    ?>