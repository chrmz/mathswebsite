<?php 
$requireAuthentication = false;
$pageName = "home";
include_once './includes/head.php';
$modules = getModules();
?>

    <!--Home-->
    <section id="home">
        <h2>Develop Your Knowledge in Mathematics!</h2>
        <p>
            Mathematics is the most well-renowned subject for educational learners; it is the best subject to enhance your problem solving skills
            and working out multiple equations. Every career jobs involve maths as it builds vital work in the sciences, finance, business, manufacturing,
            engineering and communication industry. The main purpose of this website is to ensure all leaners understand every form of maths so they can gain
            better knowledge, which would help them with exams, courses and careers.
        </p>
        
        <div class="btn">
            <a class= "blue" href="blog.php">Learn More</a>
            <a class= "red" href="login.php">Get Started</a>

        </div>
    </section>

     <!--subject section-->

     <section id="subjects">
        <h1>Popular Modules</h1>
        <div class="container">
        <div class="fea-base">
            <?php foreach ($modules as $key => $module) : ?>
                <div class="fea-box">
                <img src="./images/<?=$module['logo']?>" alt="">
                <h3><?= $module['name'] ?></h3>
                <p> <?=count( $module['subjects'])?> subjects<?=(count( $module['subjects']) == 1?'' : 's')?></p>
            </div>
            <?php endforeach ?>
             
        </div>
        </div>
     </section>
  

    <!--features-->
    
    <section id="features">
        <h1>Top Courses</h1>
        <p>Learn our best courses on how we were able to create a website</p>
        <div class="fea-base">
            <div class="fea-box">
            <i class="fa-solid fa-user"></i>
            <img src="images/web development.webp" alt="">
            <h3>Web Development</h3>
            <p>The main building block for creating a website.</p>
            </div>

            <div class="fea-box">
                <i class="fa-solid fa-user"></i>
                <img src="images/software engineer.jpg" alt="">
                <h3>Software Engineer</h3>
                <p>Maintain applications to solve real-world problems.</p>
             </div>

             <div class="fea-box">
                    <i class="fa-solid fa-user"></i>
                    <img src="images/computing.jpeg" alt="">
                    <h3>Computer Science</h3>
                    <p>Develop your skill and knowledgein markup, styling and programming languages</p>
                    </div>
        </div>
    </section>


<?php 
    include_once './includes/footer.php'
?>