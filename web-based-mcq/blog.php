<?php 
$requireAuthentication = false;
$pageName = "home";
include_once './includes/head.php';
$modules = getModules();
?>

    <!--Home-->
    <section id="home">
        <h2>About Us</h2>

    </section>

     <!--subject section-->

    <!--features-->
    
    <section id="features">
        <h1>Top Courses</h1>
        <p>Welcome to our MatheMania page. This is a stie where you can persue all types of maths quizzes. We beleive that this will boost your intelligence in the world of Mathematics.</p>
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