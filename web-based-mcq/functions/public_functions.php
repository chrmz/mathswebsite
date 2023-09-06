<?php

 

function getModule($moduleId){
    global $conn;
    $sql = "Select * from modules where id = $moduleId";
    $result = mysqli_query($conn, $sql);
	$module = mysqli_fetch_assoc($result);
    if(is_null($module)) return null;
	$module['subjects'] = getSubjectForModules($moduleId);
	return $module;
}


function getModules(bool $popular = true){
    global $conn;

   
    $sql = "Select * from modules ";
    $sql .= $popular ? " where popular is true" : '';
    $result = mysqli_query($conn, $sql);
	$modules = array();
	while ($module = $result->fetch_assoc()) {
	   $module['subjects'] = getSubjectForModules($module['id']);
       $modules[] = $module;
	}

	return $modules;
}



function getQuizzes(){
    global $conn;
    $sql = "select qz.*, ifnull((SELECT Count(1) FROM quiz where difficulty = qz.name), 0) as quizzes from quizzes qz";
    $result = mysqli_query($conn, $sql);
	$quizzes = array();
	while ($q = $result->fetch_assoc()) {
       $quizzes[] = $q;
	}

	return $quizzes;
}

function getSubjectForModules($moduleId){
    global $conn;
    $sql = "Select * from subject where module_id = $moduleId";
    $result = mysqli_query($conn, $sql);
	$subjects = array();
	while ($subject = $result->fetch_assoc()) {
       $subjects[] = $subject;
	}
	return $subjects;
}


function getQuiz($quizId, $includeAnswers = false){
    global $conn;
    $result = mysqli_query($conn,"Select * from quiz where id = $quizId");
	$quiz = mysqli_fetch_assoc($result);
    if(is_null($quiz)) return null;
	$quiz['questions'] = getQuestionsForQuiz($quizId,  $includeAnswers);
    $quiz['timeLimit'] = getTimeLimitForQuiz($quiz['id']);
	return $quiz;
}

function  trackUserQuiz($quizId, $questionOffset,  $userId) {
    global $conn;
    $result = mysqli_query($conn,"Select * from user_quiz_track where user_id = $userId and quiz_id = $quizId and question_offset = $questionOffset");
	$track = mysqli_fetch_assoc($result);

    if(is_null($track)) {
       mysqli_query($conn, "INSERT INTO user_quiz_track (`user_id`, `quiz_id`, `question_offset`)  VALUES ( $userId, $quizId, $questionOffset)");
       $id = mysqli_insert_id($conn);
       $result = mysqli_query($conn, "Select * from user_quiz_track where id = $id");
       return  mysqli_fetch_assoc($result);
     
    } 

    return $track;
}


function  markStudentResult($quizId, $userId) {
    global $conn;

    $quizQuestions = getQuestionsForQuiz($quizId, true);
   
    $wrongQuestions = [];
    $correctQuestions = [];

    $answeredQuestions = [];
    foreach ($quizQuestions as $key => $question) {
        $questionId = $question['id'];
        $correctAnswers =array();
        foreach ( $question['answers'] as $key => $answer) {
            if($answer['correct'] == true) {
                $correctAnswers[] = $answer['id'];
            }
        }

        $result = mysqli_query($conn,"Select * from user_quiz_track where user_id = $userId and quiz_id = $quizId and question_id = $questionId");
        $track =  mysqli_fetch_assoc($result);
        $useranswers = (is_null($track['answers'])) ? [] : explode(",", $track['answers']);
        $correct = null;
        if($correctAnswers != $useranswers ) {
            $wrongQuestions[]  = $question;
            $correct = 'false';
        } else {
            $correctQuestions[]  = $question;
            $correct= 'true';
        }
        $aa = implode(",",  $useranswers);
        mysqli_query($conn,  "INSERT INTO student_quiz_results (`user_id`, `quiz_id`, `question_id`, `answers_selected`, `correct`) values ($userId, $quizId , $questionId, '$aa',  $correct )");
    }


    $answeredQuestions["wrong"] = $wrongQuestions;
    $answeredQuestions["correctAnswers"] =  sizeof($correctQuestions);
    $answeredQuestions["totalQuestions"] = sizeof($quizQuestions);
    return $answeredQuestions;
}

function getStudentsQuizResult() {
    global $conn;
    $sql = "Select * FROM students_result_view";
    $result = mysqli_query($conn, $sql);
    $quizResults = array();
    while ($res = $result->fetch_object()) {
        $quizResults[] = $res;
    }

    return $quizResults;
}

function getCurrentSessionStudentQuizResult() {
    global $conn;
    $studentId =  $_SESSION['user']['id'];
    $sql = "Select * FROM students_result_view where user_id = $studentId";
    $result = mysqli_query($conn, $sql);
    $quizResults = array();
    while ($res = $result->fetch_object()) {
        $quizResults[] = $res;
    }

    return $quizResults;
}

function  createFeedback($quizId, $studentId, $feedback){
    global $conn;
    if(empty($feedback)) {
        return ['Feedback cannot be empty'];
    }

    mysqli_query($conn,  "INSERT INTO quiz_result_feedback (`user_id`, `quiz_id`, `feedback`) values ($studentId, $quizId ,'$feedback')");

}


function  getFeedbacks($quizId, $studentId){
    global $conn;
    
    $sql = "Select 
	b.*,
    concat(u.first_name, ' ', u.last_name) as student,
    q.name as quiz
    from quiz_result_feedback b 
    join quiz q on q.id = b.quiz_id
    join users  u on u.id = b.user_id
    where b.user_id =  $studentId and b.quiz_id=$quizId ";

    $result = mysqli_query($conn, $sql);
    $feedbacks = array();
    while ($answer = $result->fetch_object()) {
        $feedbacks[] = $answer;
    }
    return $feedbacks;
}


function getStudentQuizResult($quizId, $studentId) {
    global $conn;
    $sql = "Select * FROM students_result_view WHERE  quiz_id = $quizId and user_id = $studentId limit 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_object($result);
   
}

function resetStudetQuizResult($quizId, $studentId) {
    global $conn;
    mysqli_query($conn, "DELETE FROM student_quiz_results WHERE  quiz_id = $quizId and user_id = $studentId");
}

function getTotalQuizQuestions($quizId) {
    if(is_null($quizId)) return 0;
    global $conn; 
    $result = mysqli_query($conn, "Select count(*) as num from quiz_questions where quiz_id = $quizId");
	return  mysqli_fetch_assoc($result)['num'];
}

function  updateUserQuizTrack($trackId, $questionId,  $questionOffset, $answerIds) {
    global $conn;
    $a = implode(",", $answerIds);

    mysqli_query($conn,"Update  user_quiz_track set question_id = '$questionId' , answers ='$a'  where id = $trackId");
    return ($questionOffset + 1);
}


function  updateUserQuizTrackTime($trackId, $time) {
    global $conn;
    mysqli_query($conn,"Update  user_quiz_track set time_left = $time  where id = $trackId");
}

function  getQuizQuestion($quizId ,  $questionOffset){
    global $conn;
    $result = mysqli_query($conn, "Select * from quiz_questions where quiz_id = $quizId limit 1 OFFSET $questionOffset");
	$question =   mysqli_fetch_assoc($result);

    $questionId = $question['id'];

    $sql = "Select id, answer from quiz_answers where quiz_question_id =  $questionId";
    $result = mysqli_query($conn, $sql);
    $answers = array();
    while ($answer = $result->fetch_assoc()) {
        $answers[] = $answer;
    }

    $question['answers'] = $answers;
    return $question;
}

function getQuizesByDifficulty($difficulty, $includeAnswers = false)
{
    global $conn;
    $sql = "Select * from quiz where difficulty = '$difficulty'";
    $result = mysqli_query($conn, $sql);
    $quizes = array();
    while ($quiz = $result->fetch_assoc()) {
        $quiz['questions'] = getQuestionsForQuiz($quiz['id'],  $includeAnswers);
        $quiz['timeLimit'] = getTimeLimitForQuiz($quiz['id']);
        $quizes[] = $quiz;
    }

    return $quizes;
}

function getTimeLimitForQuiz($quizId)
{
    global $conn;
    $sql = "Select SUM(quiz_time) AS time_limit from quiz_questions where quiz_id = $quizId";
    $result = mysqli_query($conn, $sql);
    $time = mysqli_fetch_assoc($result)['time_limit'];

    $minutes = floor($time / 60);
    $secoundsLeft = $time % 60;
    $minutes = $minutes < 10 ? '0' + $minutes : $minutes;
    if($secoundsLeft == 0 ) {
        return  $minutes. ' minutes';
    }
    $secoundsLeft = $secoundsLeft < 10? '0' + $secoundsLeft : $secoundsLeft;

    return $minutes.' minutes : '.  $secoundsLeft.' seconds';
}

function getQuestionsForQuiz($quizId,  $includeAnswers)
{
    global $conn;
    $sql = "Select * from quiz_questions where quiz_id = $quizId";
    $result = mysqli_query($conn, $sql);
    $questions = array();
    while ($question = $result->fetch_assoc()) {
        $question['answers'] = $includeAnswers ? getAnswersForQuizQuestion($question['id']) : [];
        $questions[] = $question;
    }

    return $questions;
}


function getAnswersForQuizQuestion($questionId)
{
    global $conn;
    $sql = "Select * from quiz_answers where quiz_question_id = $questionId";
    $result = mysqli_query($conn, $sql);
    $answers = array();
    while ($answer = $result->fetch_assoc()) {
        $answers[] = $answer;
    }

    return $answers;
}