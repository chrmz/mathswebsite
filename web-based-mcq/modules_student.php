<?php 
$pageName = "students";
$requireAuthentication = true;
include_once './includes/head.php';
if(!isStudent()) {
    header('location: not_allowed.php');
    exit;
}

?>


?>
<section id="quiz-features">
        <h1>Modules</h1>
        <div class="fea-base">
           

            <?php foreach (getModules(false) as $key => $module) : ?>
                <div class="fea-box mb">
                <img src="./images/<?=$module['logo']?>" alt="">
                <h3><a href="subjects_student.php?moduleId=<?= $module['id'] ?>"><?= $module['name'] ?></a></h3>
                <p> <?=count( $module['subjects'])?> subjects<?=(count( $module['subjects']) == 1?'' : '')?></p>
            </div>
            <?php endforeach ?>

           
        </div>
    </section>
<section>

</section>
<?php 
    include_once './includes/footer.php'
?>