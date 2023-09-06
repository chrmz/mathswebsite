// const quizData = [
//     {
//         question: "Which of the following is an 'Improper' Fraction?",
//         a: "2/3",
//         b: "4/2",
//         c: "1 and 1/2",
//         d: "4/4",
//         correct: "b",
//     },

//     {
//         question: "Which of the following is a multiple of 12?",
//         a: "104",
//         b: "208",
//         c: "156",
//         d: "78",
//         correct: "c",
//     },
//     {question: 'hello',a:'a',b:'b',c:'c',d:'d',correct:'a',},
//     {question: 'bye',a:'a',b:'b',c:'c',d:'d',correct:'c',}
// ];



// const quiz = document.getElementById('quiz')
// const answerEls = document.querySelectorAll('.answer')
// const questionEl = document.getElementById('question')
// const a_text = document.getElementById('a_text')
// const b_text = document.getElementById('b_text')
// const c_text = document.getElementById('c_text')
// const d_text = document.getElementById('d_text')
// const submitBtn = document.getElementById('submit')
// const points = document.getElementById('score')



// let currentQuiz = 0
// let score = 0
// let quizindex = 0
// let limit = quizData.length
// let quizorder = []
// function generateRandomOrder(){
//     let pquizorder = []
//     while (pquizorder.length < limit){
//         i = Math.floor(Math.random() * quizData.length);
//         //console.log(pquizorder, i, pquizorder.includes(i))
//         if(!(pquizorder.includes(i))){
//             pquizorder.push(i)
//         }
//     }
//     return pquizorder
    
// }

//     quizorder = generateRandomOrder()
//     quizindex = quizorder[currentQuiz]
//     console.log(quizorder)


// loadQuiz()

// function loadQuiz() {
//     deselectAnswer()

//     const currentQuizData = quizData[quizindex]

//     questionEl.innerText = currentQuizData.question
//     a_text.innerText = currentQuizData.a
//     b_text.innerText = currentQuizData.b
//     c_text.innerText = currentQuizData.c
//     d_text.innerText = currentQuizData.d
// }

// function deselectAnswer() {
//     answerEls.forEach(answerEl => answerEl.checked = false)
// }

// function getSelected() {
//     let answer
//     answerEls.forEach(answerEl => {
//         if(answerEl.checked) {
//             answer = answerEl.id
//         }
//     })
//     return answer
// }


// submitBtn.addEventListener('click', () => {
//     const answer = getSelected()
//     if(answer) {
//         if(answer === quizData[quizindex].correct) {
//             score++
//         }
//         currentQuiz++

//         quizindex = quizorder[currentQuiz]


//         if(currentQuiz < quizData.length) {
//             loadQuiz()
//         } else {
//             quiz.innerHTML = `
//             <h6>You answered ${score}/${quizData.length} questions correctly</h6>

//             <button onclick="location.reload()">Reload</button>
//             <button onclick="location.check()">Check Answers</button>  
//             `
//         }
//     }
// })

(function() {
    if($('#countDown').length) {
   
       setInterval(function() {
        const currentSeconds =  $('#countDown').data('time');
        const timeLeft = currentSeconds - 1;
        const trackId = $('#trackId').val();
       
        if(timeLeft > 0) {
            $('#countDown').data('time', timeLeft);
            let minutes = Math.floor(currentSeconds / 60);
            let secoundsLeft = currentSeconds % 60;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            secoundsLeft = secoundsLeft < 10? '0' + secoundsLeft : secoundsLeft;

            $('#countDown').html(minutes + ':' + secoundsLeft);
            fetch("student_time_track_api.php", {
                method: 'POST',
                headers : {
                    "Content-Type" : "application/json",
                },
                body : JSON.stringify({
                    trackId : trackId,
                    timeLeft : timeLeft
                })
            })
        } else {
            $('#countDown').html('Your time is up');
            $("input").attr('disabled', 'disabled');
        }
       }, 1000)
    }
 })();

const fileInput = document.getElementById("upload");
if( typeof(fileInput) != 'undefined' && fileInput != null) {
    fileInput.onchange = function (e) {
    var preview = document.getElementById("result");
    var filename = e.target.files[0].name;
    preview.innerHTML = `<p>${filename}</p>`;
    };
}

function removeQuiz(quizName, quizId){
    document.getElementById("quiz-id").value = quizId;
    document.getElementById("quiz-name").innerHTML = quizName;
}

function removeSubject(subjectname, subjectId){
    document.getElementById("subject-id").value = subjectId;
    document.getElementById("subject-name").innerHTML = subjectname;
}


$("#questions-container").on('click', '.removeAnswer', function(){
    $(this).parent().remove();
    validateAndShowSubmitButton();
  });

  $("#questions-container").on('keyup', '.answerField', validateAndShowSubmitButton);
  $("#questions-container").on('keyup', '.questionField', validateAndShowSubmitButton);
  
  $('#quiz-name').keyup(function (){
    if($(this).val().length >= 3) {
        $('#add-question-button, #questions-container').removeClass('d-none');
    } else {
        $('#add-question-button, #questions-container').addClass('d-none');
    }
  });

$('#add-question-button').click(function() {
    
    const numberOfQuestions = $("#questions-container > span").length;

    $("#questions-container").append( ` 
        <span id="quiestion-container-${numberOfQuestions}" class="each-question-container">
        <h3 style="margin:10px 0">Add question ${numberOfQuestions +1} </h3>
        <div class="form-group">
            <label for="question-${numberOfQuestions}">Enter question:</label>
            <textarea id="question-${numberOfQuestions}" name="questions[]" class="questionField" > </textarea>
            
        </div>
    
        <div class="form-group">
            <label for="time-${numberOfQuestions}">Question time in minutes:</label>
            <input id="time-${numberOfQuestions}" type="number" placeholder="time" name="time[]" value="3" min="1" required />
        </div>
        <input type="hidden" id="numberOfanswers-${numberOfQuestions}" name="numberOfanswers-${numberOfQuestions}" value="0" />
        <button onClick="addAnswer('question-${numberOfQuestions}-answers-container', '${numberOfQuestions}')" type="button" class="min-button success" >Add an answer</button>

        <div id="question-${numberOfQuestions}-answers-container"></div>
    </span>`
    );

    validateAndShowSubmitButton();
  });

function addAnswer(containerId, questionId) {
    const numberOfAnswers = $(`#${containerId} > span`).length;
    const childContainerId =  `#${containerId}-question-${questionId}-answer`;
    $(`#numberOfanswers-${questionId}`).val(numberOfAnswers +1);
    $(`#${containerId}`).append( `
        <span id="${childContainerId}" class="all-answers-container">
            <div class="form-group">
                <label for=""question-${questionId}-answer-${numberOfAnswers}-truth">
                Check if is the correct answer: <input type="checkbox" id="${questionId}-answer-${numberOfAnswers}-truth" name="corrects-${questionId}-${numberOfAnswers}[]" />
                </label>
                <textarea id="${questionId}-answer-${numberOfAnswers}-text" name="answers-${questionId}[]" class="answerField"> </textarea>
            </div>
            <button type="button" class="min-button danger removeAnswer">Remove answer</button>

        </span>
    `);
}


function validateAndShowSubmitButton() {
  
    if( isAllAnswersFilledIn() && isEnoughAnswerSupplied() && isAllQuestionsFilledIn()) {
        $('#create-quiz-button').removeClass('d-none');
    } else {
        $('#create-quiz-button').addClass('d-none');
    }
}

function isEnoughAnswerSupplied() {
    let valid = false;
    $('.each-question-container').each(function (index) {
        if($(`#question-${index}-answers-container`).children().length < 2) {
            valid = false;
           return false;
        } else {
            valid = true;
        }
      });
     
      return valid;
}

function isAllAnswersFilledIn() {
    let valid = false;
    $('.answerField').each(function () {
        if($(this).val().length < 2) {
            valid = false;
            return false;
         } else {
             valid = true;
         }
      });
      return valid;
}

function isAllQuestionsFilledIn() {
    let valid = false;
    $('.questionField').each(function () {
        if($(this).val().length < 5) {
            valid = false;
            return false;
         } else {
             valid = true;
         }
      });
      return valid;
}