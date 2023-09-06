<?php
function getAllStudents()
{
    global $conn;
    $sql = "Select * from users where role = 'Student'";
    $result = mysqli_query($conn, $sql);
    $students = array();
    while ($student = $result->fetch_assoc()) {
        // $module['subjects'] = getSubjectForModules($module['id']);
        $students[] = $student;
    }

    return $students;
}

function saveSubject($name, $moduleId, $file)
{
    global $conn;
    $target_dir = "documents/";
    $fileName = $file["name"];
    $target_file = $target_dir . basename($fileName);
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $sql = "INSERT INTO subject (module_id, name, document) values ($moduleId, '$name', '$fileName')";
        mysqli_query($conn, $sql);
        return array();
    } else {
        return array("Sorry, there was an error uploading your file.");
    }
}

function deleteSubject($subjectId)
{
    global $conn;
    $sql = "DELETE FROM subject where id = $subjectId";
    mysqli_query($conn, $sql);
}


function createQuiz($quizPostData)
{

    global $conn;

    if (isset($quizPostData['name']) && isset($quizPostData['difficulty'])) {
        $quizName = $quizPostData['name'];
        $difficulty = $quizPostData['difficulty'];
        $questions = $quizPostData['questions'];

        mysqli_query($conn, "INSERT INTO quiz (`name`, `difficulty`)  VALUES ('$quizName', '$difficulty')");
        $quizId = mysqli_insert_id($conn);

        foreach ($questions as $index => $question) {
            $time = (isset($quizPostData['time']) && isset($quizPostData['time'][$index])) ? $quizPostData['time'][$index] : 3;
            $time =  $time * 60;
            mysqli_query($conn, "INSERT INTO quiz_questions (`question`, `quiz_time`, `quiz_id`)  VALUES ('$question', '$time', $quizId)");
            $questionId = mysqli_insert_id($conn);

            $answerIndex ='answers-'.$index; 
            $correctsIndex ='corrects-'.$index.'-'; 
            $numberOfQuestionsIndex = 'numberOfanswers-'.$index;

            for ($i=0; $i < $quizPostData[$numberOfQuestionsIndex]; $i++) { 
                $correct  = isset($quizPostData[$correctsIndex.$i]) ? '1' : '0'; 
                $answer = $quizPostData[$answerIndex][$i];
                mysqli_query($conn, "INSERT INTO quiz_answers (`answer`, `correct`, `quiz_question_id`)  VALUES ('$answer', '$correct', $questionId)");
           
            } 
        }

        header('location: quiz_details.php?difficulty='.$difficulty);				
        exit(0);
    }

    return array("Could not create quiz. try again "); 
}

function deleteQuiz($quizId, $difficulty)
{
    global $conn;

     $sql = "DELETE FROM quiz_answers WHERE quiz_question_id in ( SELECT id FROM  quiz_questions WHERE quiz_id = $quizId )";

   mysqli_query($conn, $sql);

    $sql = "DELETE FROM quiz_questions WHERE quiz_id =  $quizId";
    mysqli_query($conn, $sql);

    $sql = "DELETE FROM QUIZ where id = $quizId";
    mysqli_query($conn, $sql);

    header('location: quiz_details.php?difficulty='.$difficulty);				
    exit(0);
}

