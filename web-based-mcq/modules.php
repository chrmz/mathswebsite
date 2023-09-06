<?php 
$pageName = "modules";
$requireAuthentication = true;
include_once './includes/head.php';
if(!isAdmin()) {
    header('location: not_allowed.php');
    exit;
}
?>

<section id="quiz-features">
        <h1>Modules</h1>
        <div class="fea-base">
           

            <?php foreach (getModules(false) as $key => $module) : ?>
                <div class="fea-box mb">
                <img src="./images/<?=$module['logo']?>" alt="">
                <h3><a href="subjects.php?moduleId=<?= $module['id'] ?>"><?= $module['name'] ?></a></h3>
                <p> <?=count( $module['subjects'])?> subjects<?=(count( $module['subjects']) == 1?'' : '')?></p>
                <a  href="add_subject.php?moduleId=<?=$module['id']?>" class="add-module mb" >Add subject</a> 
            </div>
            <?php endforeach ?>

           
        </div>
    </section>
<section>

</section>
<?php 
    include_once './includes/footer.php'
?>