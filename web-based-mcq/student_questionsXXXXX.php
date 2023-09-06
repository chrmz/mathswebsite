<?php 
$pageName = "questions";
$requireAuthentication = true;
    include_once './includes/head.php'
?>

<section class="questions">
    
<div class="quiz-container" id="quiz">
        <div class="quiz-header">
            <h2 id="question">Question Text</h2>
            <ul>
                <li>
                    <input type="radio" name="answer" id="a" class="answer">
                    <label for="a" id="a_text">Answer</label>
                </li>

                <li>
                    <input type="radio" name="answer" id="b" class="answer">
                    <label for="b" id="b_text">Answer</label>
                </li>

                <li>
                    <input type="radio" name="answer" id="c" class="answer">
                    <label for="c" id="c_text">Answer</label>
                </li>

                <li>
                    <input type="radio" name="answer" id="d" class="answer">
                    <label for="d" id="d_text">Answer</label>
                </li>

            </ul>
        </div>

        <button id="submit">Submit</button>
       
    </div>

    <!--scoreboard section-->
    <div id="scoreboard">
        <img src="" alt="">
        <h2 id="score title">Your Score</h2>
        <h2 id="score"></h2>
        <button type="button"
        id="score-btn">Back to Quiz</button>
        <button id="button"
        id="check-answer">Check Answers</button>

    </div>

    <!--answers section-->
    <div id="answerBank">
        <h2>Answers: </h2>
        <ol type="1" id="answers">

        </ol>
        <button type="button" id="score-btn"
        onclick="backToQuiz">Back to Quiz</button>
    </div>
</section>

<?php 
    include_once './includes/footer.php'
?>